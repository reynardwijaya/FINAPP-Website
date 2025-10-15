<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\FinancialAnalysis;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please log in to access this page.');
            }
            // Ensure analysisType is always defined with a default value
            $analysisType = $request->input('type', 'monthly');
            if (!in_array($analysisType, ['monthly', 'yearly'])) {
                $analysisType = 'monthly';
            }
            
            // Get transactions for analysis
            $query = Transaction::where('transactions.user_id', $user->id);
            
            if ($analysisType === 'monthly') {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
            } else {
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
            }
            
            $transactions = $query->whereBetween('transaction_date', [$startDate, $endDate])->get();
            
            // Calculate financial metrics
            $metrics = $this->calculateFinancialMetrics($transactions, $analysisType, $user);
            

            // Format category data for chart
            $categoryData = collect($metrics['category_distribution'])->map(function ($data, $categoryId) use ($user) {
                $category = $user->categories()->find($categoryId);
                return [
                    'category_name' => $category ? $category->name : 'Unknown',
                    'color' => $category ? $category->color : '#cccccc',
                    'total' => $data['total']
                ];
            })->values()->toArray();

            // Generate AI analysis
            $analysis = $this->generateAnalysis($metrics, $analysisType);

            // Get historical analyses
            $historicalAnalyses = FinancialAnalysis::where('user_id', $user->id)
                ->where('analysis_type', $analysisType)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('analysis.index', compact('metrics', 'analysis', 'historicalAnalyses', 'analysisType', 'categoryData'));
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error in AnalysisController@index: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'An error occurred while loading financial analysis: ' . $e->getMessage());
        }
    }

    private function calculateFinancialMetrics($transactions, $analysisType, $user)
    {
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        $netIncome = $totalIncome - $totalExpenses;

        // Calculate category-wise distribution
        $categoryDistribution = $transactions->groupBy('category_id')
            ->map(function ($items, $categoryId) {
                return [
                    'total' => $items->sum('amount')
                ];
            });

        // Calculate expense ratios
        $expenseRatio = $totalIncome > 0 ? ($totalExpenses / $totalIncome) * 100 : 0;

        // Additional financial ratios - normalized to percentages for better visualization
        $cashFlow = $totalIncome - $totalExpenses;
        $cashFlowRatio = $totalIncome > 0 ? ($cashFlow / $totalIncome) * 100 : 0;
        
        $operatingIncome = $totalIncome - $totalExpenses;
        $operatingMargin = $totalIncome > 0 ? ($operatingIncome / $totalIncome) * 100 : 0;
        
        // Calculate growth rate
        if ($analysisType === 'monthly') {
            $previousMonth = Carbon::now()->subMonth()->startOfMonth();
            $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        } else {
            $previousMonth = Carbon::now()->subYear()->startOfYear();
            $previousMonthEnd = Carbon::now()->subYear()->endOfYear();
        }

        $previousTransactions = Transaction::where('transactions.user_id', $user->id)
                                ->whereBetween('transaction_date', [$previousMonth, $previousMonthEnd])
                                ->get();
        $previousTotalIncome = $previousTransactions->where('type', 'income')->sum('amount');
        $previousTotalExpenses = $previousTransactions->where('type', 'expense')->sum('amount');
        $previousNetIncome = $previousTotalIncome - $previousTotalExpenses;

        // Calculate growth rate and cap it at 100% for visualization
        $growthRate = $previousNetIncome > 0 ? min(100, max(-100, (($netIncome - $previousNetIncome) / $previousNetIncome) * 100)) : 0;

        // Convert profitability index to percentage and cap at 100%
        $profitabilityIndex = $totalIncome > 0 ? min(100, max(0, ($netIncome / $totalIncome) * 100)) : 0;

        // Store raw values for tooltips
        $rawMetrics = [
            'cash_flow_ratio' => $cashFlowRatio,
            'operating_margin' => $operatingMargin,
            'growth_rate' => $growthRate,
            'profitability_index' => $profitabilityIndex
        ];

        return [
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_income' => $netIncome,
            'expense_ratio' => $expenseRatio,
            'cash_flow_ratio' => $cashFlowRatio,
            'operating_margin' => $operatingMargin,
            'growth_rate' => $growthRate,
            'profitability_index' => $profitabilityIndex,
            'raw_metrics' => $rawMetrics, // Store raw values for tooltips
            'category_distribution' => $categoryDistribution,
            'transaction_count' => $transactions->count(),
            'average_transaction' => $transactions->avg('amount'),
        ];
    }

    private function generateAnalysis($metrics, $analysisType)
    {
        // Generate analysis summary
        $summary = $this->generateSummary($metrics, $analysisType);
        
        // Generate recommendations
        $recommendations = $this->generateRecommendations($metrics);
        
        // Get related resources
        $relatedResources = $this->getRelatedResources($metrics);

        // Store the analysis
        $analysis = FinancialAnalysis::create([
            'user_id' => auth()->id(),
            'analysis_type' => $analysisType,
            'analysis_date' => now(),
            'financial_metrics' => $metrics,
            'analysis_summary' => $summary,
            'recommendations' => $recommendations,
            'related_resources' => $relatedResources,
        ]);

        return $analysis;
    }

    private function generateSummary($metrics, $analysisType)
    {
        $period = $analysisType === 'monthly' ? 'this month' : 'this year';
        
        $summary = "Based on your financial data for {$period}, ";
        
        if ($metrics['net_income'] > 0) {
            $summary .= "your business is generating a positive net income of Rp " . number_format($metrics['net_income'], 0, ',', '.') . ". ";
        } else {
            $summary .= "your business is currently operating at a loss of Rp " . number_format(abs($metrics['net_income']), 0, ',', '.') . ". ";
        }

        if ($metrics['expense_ratio'] < 70) {
            $summary .= "Your expense ratio of " . number_format($metrics['expense_ratio'], 1) . "% is healthy, indicating good cost management. ";
        } else {
            $summary .= "Your expense ratio of " . number_format($metrics['expense_ratio'], 1) . "% is high, suggesting room for cost optimization. ";
        }

        return $summary;
    }

    private function generateRecommendations($metrics)
    {
        $recommendations = [];

        if ($metrics['expense_ratio'] > 70) {
            $recommendations[] = "Consider reviewing your expenses to identify areas where costs can be reduced.";
        }

        if ($metrics['net_income'] < 0) {
            $recommendations[] = "Focus on increasing revenue through marketing and sales efforts.";
        }

        if ($metrics['transaction_count'] < 10) {
            $recommendations[] = "Work on increasing your customer base to improve transaction volume.";
        }

        // Add more recommendations based on metrics
        return $recommendations;
    }

    private function getRelatedResources($metrics)
    {
        $resources = [];

        if ($metrics['expense_ratio'] > 70) {
            $resources[] = [
                'type' => 'article',
                'title' => 'Cost Management Strategies for Small Businesses',
                'url' => '/articles/cost-management'
            ];
        }

        if ($metrics['net_income'] < 0) {
            $resources[] = [
                'type' => 'video',
                'title' => 'How to Increase Revenue for Your Small Business',
                'url' => 'https://youtube.com/watch?v=example'
            ];
        }

        return $resources;
    }
} 