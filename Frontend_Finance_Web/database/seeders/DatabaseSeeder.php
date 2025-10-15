<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ArticleSeeder::class,
        ]);

        // Create sample user
        User::create([
            'username' => 'demo_user',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '081234567891',
        ]);

        // Create sample articles
        $articles = [
            [
                'title' => 'Getting Started with Financial Planning',
                'content' => '<h2>Introduction</h2><p>Financial planning is crucial for success. This guide will help you understand the basics of financial management and how to implement them.</p><h2>Key Points</h2><ul><li>Track your income and expenses</li><li>Set financial goals</li><li>Create a budget</li><li>Monitor cash flow</li></ul>',
                'category' => 'Financial Planning',
                'author' => 'Admin User',
                'is_published' => true,
            ],
            [
                'title' => 'Understanding Cash Flow Management',
                'content' => '<h2>What is Cash Flow?</h2><p>Cash flow is the movement of money in and out. Understanding and managing cash flow is essential for survival and growth.</p><h2>Tips for Better Cash Flow</h2><ul><li>Invoice promptly</li><li>Monitor expenses</li><li>Maintain emergency funds</li><li>Plan for seasonal fluctuations</li></ul>',
                'category' => 'Financial Management',
                'author' => 'Admin User',
                'is_published' => true,
            ],
            [
                'title' => 'Digital Marketing Strategies for UMKM',
                'content' => '<h2>Why Digital Marketing Matters</h2><p>In today\'s digital age, having an online presence is crucial for UMKM businesses. Learn how to leverage digital marketing to grow your business.</p><h2>Effective Strategies</h2><ul><li>Social media marketing</li><li>Content marketing</li><li>Email marketing</li><li>Local SEO</li></ul>',
                'category' => 'Marketing',
                'author' => 'Admin User',
                'is_published' => true,
            ],
            [
                'title' => 'Streamlining Business Operations',
                'content' => '<h2>Efficient Operations</h2><p>Learn how to optimize your business operations to reduce costs and improve efficiency.</p><h2>Key Areas</h2><ul><li>Inventory management</li><li>Process automation</li><li>Staff training</li><li>Quality control</li></ul>',
                'category' => 'Operations',
                'author' => 'Admin User',
                'is_published' => true,
            ],
            [
                'title' => 'Leveraging Technology for UMKM Growth',
                'content' => '<h2>Technology in Business</h2><p>Discover how technology can help your UMKM business grow and compete in the digital marketplace.</p><h2>Technology Solutions</h2><ul><li>Accounting software</li><li>E-commerce platforms</li><li>Customer management systems</li><li>Digital payment solutions</li></ul>',
                'category' => 'Technology',
                'author' => 'Admin User',
                'is_published' => true,
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
