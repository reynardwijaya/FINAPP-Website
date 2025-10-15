<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('is_published', true)->with('category'); // Eager load category

        // Category filter
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Tag filter
        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search);
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(9);
        
        // Get distinct article categories from the Category model
        $categories = Category::where('type', 'article') // Assuming you have an article category type
                            ->withCount('articles') // Eager load the count of articles for each category
                            ->orderBy('name')
                            ->get();

        // Get all unique tags for the filter (remains the same as it's on the article model)
        $allTags = Article::where('is_published', true)
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->values();

        return view('articles.index', compact('articles', 'categories', 'allTags'));
    }

    public function show(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        // Eager load category for the current article
        $article->load('category');

        // Get related articles based on category and tags
        $relatedArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where(function($query) use ($article) {
                // Use the category_id for related articles
                if ($article->category_id) {
                    $query->orWhere('category_id', $article->category_id);
                }
                
                // Filter by tags
                if ($article->tags) {
                    foreach ($article->tags as $tag) {
                        $query->orWhereJsonContains('tags', $tag);
                    }
                }
            })
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }
} 