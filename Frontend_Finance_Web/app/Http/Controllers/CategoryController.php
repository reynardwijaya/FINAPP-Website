<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $user = Auth::user();
        $incomeCategories = $user->categories()->ofType('income')->get();
        $expenseCategories = $user->categories()->ofType('expense')->get();

        return view('categories.index', compact('incomeCategories', 'expenseCategories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('user_id', Auth::id())
                                ->where('type', request('type'));
                }),
            ],
            'type' => ['required', 'in:income,expense'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-F]{6}$/i'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $category = Auth::user()->categories()->create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'category' => $category,
                'message' => 'Category created successfully.'
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($category) {
                    return $query->where('user_id', Auth::id())
                                ->where('type', $category->type)
                                ->where('id', '!=', $category->id);
                }),
            ],
            'color' => ['required', 'string', 'regex:/^#[0-9A-F]{6}$/i'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $category->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'category' => $category,
                'message' => 'Category updated successfully.'
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        // Check if category has transactions
        if ($category->transactions()->exists()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with existing transactions.'
                ], 422);
            }
            return back()->with('error', 'Cannot delete category with existing transactions.');
        }

        $category->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.'
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Get categories for a specific type (income/expense).
     */
    public function getByType($type)
    {
        $categories = Auth::user()->categories()
            ->ofType($type)
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }
}
