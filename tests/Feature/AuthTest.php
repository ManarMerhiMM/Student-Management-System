<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_form_is_accessible()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200)
            ->assertViewIs('auth.register');
    }

    public function test_login_form_is_accessible()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200)
            ->assertViewIs('auth.login');
    }

    public function test_user_can_register_and_login()
    {
        $userData = [
            'username'              => 'testuser',
            'email'                 => 'test@example.com',
            'password'              => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $this->post(route('register.attempt'), $userData)
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);

        $this->post(route('login.attempt'), [
            'email'    => 'test@example.com',
            'password' => 'Password123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    }

    public function test_deactivated_user_cannot_login()
    {
        $user = User::factory()->create(['is_deactivated' => true]);

        $this->post(route('login.attempt'), [
            'email'    => $user->email,
            'password' => 'password', // factory default
        ])->assertRedirect()
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_dashboard_is_accessible_to_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('dashboard'))
            ->assertStatus(200)
            ->assertViewIs('dashboard');
    }

    public function test_admin_can_view_user_list()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        User::factory(3)->create(['is_admin' => false]);

        $this->actingAs($admin)
            ->get(route('users.index'))
            ->assertStatus(200)
            ->assertSee(User::first()->username);
    }

    public function test_admin_can_deactivate_and_activate_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user  = User::factory()->create(['is_admin' => false]);

        // Deactivate user
        $this->actingAs($admin)
            ->post(route('users.deactivate', ['user' => $user->id]))
            ->assertRedirect();

        // Refresh user from DB immediately after action
        $user->refresh();

        $this->assertTrue($user->is_deactivated);

        // Activate user
        $this->actingAs($admin)
            ->post(route('users.activate', ['user' => $user->id]))
            ->assertRedirect();

        $user->refresh();

        $this->assertFalse($user->is_deactivated);
    }
}
