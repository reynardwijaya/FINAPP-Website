<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Login/Register tampil sebagai drawer di landing page (bukan halaman terpisah).
 */
class AuthDrawerTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_has_closed_drawer_and_login_register_routes_open_it(): void
    {
        $this->get('/')->assertOk()->assertSee('data-auth-open=""', false);
        $this->get('/login')->assertOk()->assertSee('data-auth-open="login"', false)->assertSee('Perencanaan keuangan', false);
        $this->get('/register')->assertOk()->assertSee('data-auth-open="register"', false)->assertSee('Perencanaan keuangan', false);
    }

    public function test_failed_login_returns_to_landing_with_login_drawer_open_and_error(): void
    {
        User::create(['username' => 'a', 'email' => 'a@example.com', 'password' => bcrypt('password123'), 'phone_number' => '1']);

        $this->from('/')->followingRedirects()
            ->post('/login', ['_form' => 'login', 'email' => 'a@example.com', 'password' => 'salah'])
            ->assertOk()
            ->assertSee('data-auth-open="login"', false)
            ->assertSee('id="login-email-error"', false)
            ->assertDontSee('id="register-email-error"', false);
    }

    public function test_failed_register_reopens_register_drawer_with_old_input_and_own_errors(): void
    {
        $this->from('/')->followingRedirects()
            ->post('/register', ['_form' => 'register', 'username' => 'baru', 'email' => 'bukan-email', 'phone_number' => '1', 'password' => 'pendek', 'password_confirmation' => 'beda'])
            ->assertOk()
            ->assertSee('data-auth-open="register"', false)
            ->assertSee('id="register-email-error"', false)
            ->assertSee('value="bukan-email"', false)
            ->assertDontSee('id="login-email-error"', false);
    }

    public function test_logged_in_visitor_sees_dashboard_link_without_drawer(): void
    {
        $user = User::create(['username' => 'b', 'email' => 'b@example.com', 'password' => bcrypt('password123'), 'phone_number' => '1']);

        $this->actingAs($user)->get('/')->assertOk()->assertSee('Buka Beranda')->assertDontSee('data-auth-open', false);
    }
}
