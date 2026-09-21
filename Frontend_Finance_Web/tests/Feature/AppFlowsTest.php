<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\FinancialAnalysis;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Alur fitur yang benar-benar dipakai UI: auth, transaksi, kategori, profil,
 * kata sandi, filter laporan, pencarian artikel, dan analisis.
 * Tidak memanggil layanan eksternal (Go/Gemini).
 */
class AppFlowsTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $name = 'tester'): User
    {
        $user = User::create([
            'username' => $name,
            'email' => $name.'@example.com',
            'password' => bcrypt('password123'),
            'phone_number' => '081200000000',
        ]);
        $user->createDefaultCategories();

        return $user;
    }

    private function category(User $user, string $type): Category
    {
        return Category::where('user_id', $user->id)->where('type', $type)->firstOrFail();
    }

    private function transaction(User $user, string $type, float $amount = 100000): Transaction
    {
        return Transaction::create([
            'user_id' => $user->id,
            'type' => $type,
            'category_id' => $this->category($user, $type)->id,
            'amount' => $amount,
            'description' => 'Contoh',
            'transaction_date' => now(),
        ]);
    }

    public function test_guests_are_redirected_to_login_from_protected_pages(): void
    {
        foreach (['/dashboard', '/transactions', '/transactions/create', '/reports', '/analysis', '/articles', '/categories', '/profile', '/settings'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
    }

    public function test_register_login_and_logout(): void
    {
        $this->post('/register', [
            'username' => 'baru', 'email' => 'baru@example.com', 'phone_number' => '0812',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertRedirect('/login');
        $this->assertDatabaseHas('users', ['email' => 'baru@example.com']);

        $this->post('/login', ['email' => 'baru@example.com', 'password' => 'password123', 'remember' => '1'])
            ->assertRedirect();
        $this->assertAuthenticated();

        $this->post('/logout')->assertRedirect();
        $this->assertGuest();
    }

    public function test_register_validates_input(): void
    {
        $this->user('ada');
        $this->from('/register')->post('/register', [
            'username' => 'ada', 'email' => 'bukan-email', 'phone_number' => '',
            'password' => 'pendek', 'password_confirmation' => 'beda',
        ])->assertSessionHasErrors(['username', 'email', 'phone_number', 'password']);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $this->user();
        $this->from('/login')->post('/login', ['email' => 'tester@example.com', 'password' => 'salah'])
            ->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_transaction_create_validate_and_delete(): void
    {
        $user = $this->user();
        $this->actingAs($user);
        $category = $this->category($user, 'income');

        $this->post('/transactions', [
            'type' => 'income', 'category_id' => $category->id, 'amount' => 250000,
            'description' => 'Penjualan', 'transaction_date' => '2026-09-01',
        ])->assertRedirect('/transactions');
        $this->assertDatabaseHas('transactions', ['user_id' => $user->id, 'amount' => 250000, 'type' => 'income']);

        $this->from('/transactions/create')->post('/transactions', ['type' => 'lainnya', 'amount' => -5])
            ->assertSessionHasErrors(['type', 'category_id', 'amount', 'transaction_date']);

        $transaction = Transaction::where('user_id', $user->id)->first();
        $this->get('/transactions')->assertOk()->assertSee('Penjualan')->assertSee('Rp 250.000');

        $this->delete('/transactions/'.$transaction->id)->assertRedirect('/transactions');
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }

    public function test_user_cannot_delete_someone_elses_transaction(): void
    {
        $owner = $this->user('pemilik');
        $intruder = $this->user('penyusup');
        $transaction = $this->transaction($owner, 'expense');

        // Transaksi orang lain tersembunyi oleh global scope (404), dan tetap utuh.
        $this->actingAs($intruder)->delete('/transactions/'.$transaction->id)->assertNotFound();
        $this->assertDatabaseHas('transactions', ['id' => $transaction->id]);
    }

    public function test_categories_by_type_returns_only_own_categories_of_that_type(): void
    {
        $me = $this->user('saya');
        $other = $this->user('lain');
        Category::create(['user_id' => $other->id, 'name' => 'Rahasia', 'type' => 'income', 'color' => '#112233', 'is_default' => false]);

        $names = collect($this->actingAs($me)->getJson('/categories/type/income')->assertOk()->json())->pluck('name');
        $this->assertNotContains('Rahasia', $names);
        $this->assertTrue(collect($this->actingAs($me)->getJson('/categories/type/income')->json())->every(fn ($c) => $c['type'] === 'income'));
    }

    public function test_category_create_update_and_delete_guard(): void
    {
        $user = $this->user();
        $this->actingAs($user);

        $this->post('/categories', ['name' => 'Bahan baku', 'type' => 'expense', 'color' => '#F59E0B', 'icon' => 'fas fa-tag'])
            ->assertRedirect('/categories');
        $category = Category::where('name', 'Bahan baku')->firstOrFail();

        // nama sama pada jenis yang sama ditolak
        $this->from('/categories/create')->post('/categories', ['name' => 'Bahan baku', 'type' => 'expense', 'color' => '#F59E0B'])
            ->assertSessionHasErrors('name');
        // warna harus #RRGGBB
        $this->from('/categories/create')->post('/categories', ['name' => 'X', 'type' => 'expense', 'color' => 'merah'])
            ->assertSessionHasErrors('color');

        $this->put('/categories/'.$category->id, ['name' => 'Bahan baku utama', 'color' => '#22AA66', 'icon' => 'fas fa-coffee'])
            ->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Bahan baku utama', 'color' => '#22AA66']);

        // kategori yang dipakai transaksi tidak boleh dihapus
        Transaction::create(['user_id' => $user->id, 'type' => 'expense', 'category_id' => $category->id, 'amount' => 1000, 'transaction_date' => now()]);
        $this->delete('/categories/'.$category->id)->assertRedirect()->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);

        Transaction::query()->delete();
        $this->delete('/categories/'.$category->id)->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_default_category_cannot_be_edited(): void
    {
        $user = $this->user();
        $default = Category::where('user_id', $user->id)->where('is_default', true)->firstOrFail();
        $this->actingAs($user)->get('/categories/'.$default->id.'/edit')->assertForbidden();
    }

    public function test_profile_update_and_uniqueness(): void
    {
        $me = $this->user('saya');
        $this->user('lain');
        $this->actingAs($me);

        $this->put('/profile/update', ['username' => 'nama-baru', 'email' => 'baru@example.com'])->assertRedirect('/profile/edit');
        $this->assertDatabaseHas('users', ['id' => $me->id, 'username' => 'nama-baru', 'email' => 'baru@example.com']);

        $this->from('/profile/edit')->put('/profile/update', ['username' => 'lain', 'email' => 'baru@example.com'])
            ->assertSessionHasErrors('username');
    }

    public function test_profile_picture_upload(): void
    {
        Storage::fake('public');
        $me = $this->user();
        // PNG 1x1 asli (GD tidak wajib terpasang di mesin pengembang)
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
        $this->actingAs($me)->post('/profile/picture', ['profile_picture' => UploadedFile::fake()->createWithContent('foto.png', $png)])
            ->assertRedirect();
        $this->assertNotNull($me->fresh()->profile_picture);
        Storage::disk('public')->assertExists($me->fresh()->profile_picture);
    }

    public function test_password_change(): void
    {
        $me = $this->user();
        $this->actingAs($me);

        $this->from('/settings')->put('/settings/password', ['current_password' => 'salah', 'password' => 'passwordbaru1', 'password_confirmation' => 'passwordbaru1'])
            ->assertSessionHasErrors('current_password');

        $this->put('/settings/password', ['current_password' => 'password123', 'password' => 'passwordbaru1', 'password_confirmation' => 'passwordbaru1'])
            ->assertRedirect('/settings');
        $this->assertTrue(\Hash::check('passwordbaru1', $me->fresh()->password));
    }

    public function test_reports_filters_and_pagination_keep_the_query_string(): void
    {
        $me = $this->user();
        foreach (range(1, 12) as $i) {
            $this->transaction($me, 'expense', 1000 * $i);
        }
        $this->transaction($me, 'income', 999999);
        $this->actingAs($me);

        $response = $this->get('/reports?type=expense')->assertOk();
        $response->assertDontSee('999.999');
        $response->assertSee('type=expense', false)->assertSee('page=2', false);

        $this->get('/reports?type=income')->assertOk()->assertSee('999.999');
        $this->get('/reports?start_date=2999-01-01')->assertOk()->assertSee('Tidak ada transaksi yang cocok');
    }

    public function test_articles_search_and_tag_filter(): void
    {
        $me = $this->user();
        $category = $this->category($me, 'income');
        foreach ([['Mengatur kas usaha', ['kas']], ['Menabung untuk usaha', ['tabungan']]] as [$title, $tags]) {
            Article::create(['title' => $title, 'content' => '<p>isi</p>', 'category_id' => $category->id, 'author' => 'Tim',
                'is_published' => true, 'slug' => str($title)->slug(), 'reading_time' => 2, 'tags' => $tags]);
        }
        $this->actingAs($me);

        $this->get('/articles?search=Menabung')->assertOk()->assertSee('Menabung untuk usaha')->assertDontSee('Mengatur kas usaha');
        $this->get('/articles?tag=kas')->assertOk()->assertSee('Mengatur kas usaha')->assertDontSee('Menabung untuk usaha');
        $this->get('/articles?search=tidak-ada-hasil')->assertOk()->assertSee('Artikel tidak ditemukan');
    }

    public function test_dashboard_and_analysis_reflect_transactions(): void
    {
        $me = $this->user();
        $this->transaction($me, 'income', 2500000);
        $this->transaction($me, 'expense', 800000);
        $this->actingAs($me);

        $this->get('/dashboard')->assertOk()->assertSee('Rp 2.500.000')->assertSee('Rp 800.000')->assertSee('Rp 1.700.000');

        foreach (['monthly', 'yearly'] as $type) {
            $this->get('/analysis?type='.$type)->assertOk()->assertSee('Rp 2.500.000');
        }
        $this->assertGreaterThanOrEqual(2, FinancialAnalysis::where('user_id', $me->id)->count());
    }
}
