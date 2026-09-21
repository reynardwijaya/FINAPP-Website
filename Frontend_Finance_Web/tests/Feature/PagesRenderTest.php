<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Smoke test: setiap halaman harus dirender tanpa error.
 * Menjaga refactor tampilan tidak merusak view.
 */
class PagesRenderTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(): User
    {
        $user = User::create([
            'username' => 'tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
            'phone_number' => '081200000000',
        ]);
        $user->createDefaultCategories();

        return $user;
    }

    public function test_guest_pages_render(): void
    {
        foreach (['/', '/login', '/register'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_authenticated_pages_render_with_and_without_data(): void
    {
        $user = $this->makeUser();
        $this->actingAs($user);

        $urls = fn () => array_filter([
            '/dashboard',
            '/transactions',
            '/transactions/create',
            '/reports',
            '/analysis',
            '/analysis?type=yearly',
            '/articles',
            '/categories',
            '/categories/create',
            '/profile',
            '/profile/edit',
            '/settings',
        ]);

        // Keadaan kosong (empty state)
        foreach ($urls() as $url) {
            $this->get($url)->assertOk();
        }

        // Keadaan berisi data
        $income = Category::where('user_id', $user->id)->where('type', 'income')->first();
        $expense = Category::where('user_id', $user->id)->where('type', 'expense')->first();
        foreach ([[$income, 'income', 2500000], [$expense, 'expense', 800000]] as [$cat, $type, $amount]) {
            Transaction::create([
                'user_id' => $user->id,
                'type' => $type,
                'category_id' => $cat->id,
                'amount' => $amount,
                'description' => 'Contoh '.$type,
                'transaction_date' => now(),
            ]);
        }
        $article = Article::create([
            'title' => 'Mengatur Kas Usaha',
            'content' => '<p>Isi artikel.</p>',
            'category_id' => $income->id,
            'author' => 'Tim Finapp',
            'is_published' => true,
            'slug' => 'mengatur-kas-usaha',
            'reading_time' => 3,
            'tags' => ['kas', 'umkm'],
        ]);

        foreach ($urls() as $url) {
            $this->get($url)->assertOk();
        }
        $this->get('/articles/'.$article->id)->assertOk();

        // Kategori bawaan tidak bisa diedit (403), jadi pakai kategori buatan sendiri
        $custom = Category::create([
            'user_id' => $user->id,
            'name' => 'Kategori Saya',
            'type' => 'expense',
            'color' => '#8B5CF6',
            'icon' => 'fas fa-tag',
            'is_default' => false,
        ]);
        $this->get('/categories/'.$custom->id.'/edit')->assertOk();
    }
}
