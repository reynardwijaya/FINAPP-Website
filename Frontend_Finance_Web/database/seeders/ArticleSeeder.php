<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories first
        $categories = [
            'Financial Planning' => 'Learn about personal and business financial planning strategies.',
            'Investment' => 'Explore various investment opportunities and strategies.',
            'Financial Management' => 'Understand how to manage your finances effectively.',
            'Tax Planning' => 'Learn about tax strategies and optimization.',
        ];

        foreach ($categories as $name => $description) {
            Category::create([
                'name' => $name,
                'description' => $description,
                'slug' => Str::slug($name),
            ]);
        }

        // Create sample articles
        $articles = [
            [
                'title' => 'Getting Started with Financial Planning',
                'content' => '<h2>Introduction</h2><p>Financial planning is crucial for success. This guide will help you understand the basics of financial management and how to implement them.</p><h2>Key Points</h2><ul><li>Track your income and expenses</li><li>Set financial goals</li><li>Create a budget</li><li>Monitor cash flow</li></ul>',
                'category_id' => 1, // Financial Planning
                'author' => 'Admin User',
                'is_published' => true,
                'image_url' => 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'reading_time' => 5,
                'tags' => ['planning', 'finance', 'basics'],
            ],
            [
                'title' => 'Understanding Cash Flow Management',
                'content' => '<h2>What is Cash Flow?</h2><p>Cash flow is the movement of money in and out. Understanding and managing cash flow is essential for survival and growth.</p><h2>Tips for Better Cash Flow</h2><ul><li>Invoice promptly</li><li>Monitor expenses</li><li>Maintain emergency funds</li><li>Plan for seasonal fluctuations</li></ul>',
                'category_id' => 3, // Financial Management
                'author' => 'Admin User',
                'is_published' => true,
                'image_url' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'reading_time' => 6,
                'tags' => ['cash flow', 'management', 'finance'],
            ],
        ];

        foreach ($articles as $article) {
            Article::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'content' => $article['content'],
                'category_id' => $article['category_id'],
                'image_url' => $article['image_url'],
                'author' => $article['author'],
                'is_published' => $article['is_published'],
                'reading_time' => $article['reading_time'],
                'tags' => $article['tags'],
            ]);
        }
    }
} 