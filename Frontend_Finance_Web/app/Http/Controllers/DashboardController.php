<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\FinancialAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get current month's transactions
        $currentMonth = Carbon::now()->startOfMonth();
        $transactions = Transaction::withoutGlobalScope('byUser')
            ->where('transactions.user_id', $user->id)
            ->whereMonth('transactions.transaction_date', $currentMonth->month)
            ->whereYear('transactions.transaction_date', $currentMonth->year)
            ->get();

        // Calculate monthly summary
        $monthlySummary = [
            'income' => $transactions->where('type', 'income')->sum('amount'),
            'expense' => $transactions->where('type', 'expense')->sum('amount'),
            'net' => $transactions->where('type', 'income')->sum('amount') - $transactions->where('type', 'expense')->sum('amount')
        ];

        // Compute totalIncome and totalExpenses (for example, using monthlySummary)
        $totalIncome = $monthlySummary['income'];
        $totalExpenses = $monthlySummary['expense'];

        // Compute savings rate (for example, (totalIncome – totalExpenses) / totalIncome, or zero if totalIncome is zero)
        $savingsRate = ($totalIncome > 0) ? (($totalIncome - $totalExpenses) / $totalIncome) * 100 : 0;

        // Compute monthly trends (for example, an array of monthly summaries for the last 6 months)
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; --$i) {
            $month = Carbon::now()->subMonths($i)->startOfMonth();
            $monthlyTransactions = Transaction::withoutGlobalScope('byUser')
                ->where('transactions.user_id', $user->id)
                ->whereMonth('transactions.transaction_date', $month->month)
                ->whereYear('transactions.transaction_date', $month->year)
                ->get();
            $monthlyTrends[$month->format('M Y')] = [
                'income' => $monthlyTransactions->where('type', 'income')->sum('amount'),
                'expense' => $monthlyTransactions->where('type', 'expense')->sum('amount'),
                'net' => $monthlyTransactions->where('type', 'income')->sum('amount') - $monthlyTransactions->where('type', 'expense')->sum('amount')
            ];
        }

        // Compute category distribution (for example, an array of category summaries (sum of amounts) for the current month)
        $categoryDistribution = Transaction::withoutGlobalScope('byUser')
            ->where('transactions.user_id', $user->id)
            ->whereMonth('transactions.transaction_date', $currentMonth->month)
            ->whereYear('transactions.transaction_date', $currentMonth->year)
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, categories.color as category_color, SUM(transactions.amount) as total')
            ->groupBy('transactions.category_id', 'categories.name', 'categories.color')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->category_name => $item->total];
            })
            ->toArray();

        // Get recent transactions
        $recentTransactions = Transaction::withoutGlobalScope('byUser')
            ->where('transactions.user_id', $user->id)
            ->with('category')
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();

        // Get category-wise summary
        $categorySummary = Transaction::withoutGlobalScope('byUser')
            ->where('transactions.user_id', $user->id)
            ->whereMonth('transactions.transaction_date', $currentMonth->month)
            ->whereYear('transactions.transaction_date', $currentMonth->year)
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, categories.color as category_color, transactions.type, SUM(transactions.amount) as total')
            ->groupBy('transactions.category_id', 'categories.name', 'categories.color', 'transactions.type')
            ->get();

        // Get latest financial analysis
        $latestAnalysis = FinancialAnalysis::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $totalBalance = $monthlySummary['net'];

        return view('dashboard', compact(
            'monthlySummary',
            'recentTransactions',
            'categorySummary',
            'latestAnalysis',
            'totalBalance',
            'totalIncome',
            'totalExpenses',
            'savingsRate',
            'monthlyTrends',
            'categoryDistribution'
        ));
    }
} 