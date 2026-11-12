<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

uses(LazilyRefreshDatabase::class);

test('guests can only reach authentication pages and are redirected from private pages', function () {
    foreach (['/sportsmens', '/sportsmen', '/contact', '/dashboard'] as $path) {
        $this->get($path)->assertRedirect(route('login'));
    }

    $this->get('/login')->assertOk();
    $this->get('/register')->assertOk();
    $this->get('/forgot-password')->assertOk();
    $this->get('/reset-password/test-token')->assertOk();
});

test('guests opening the home route are redirected to login', function () {
    $this->get(route('home'))
        ->assertRedirect(route('login'));
});

test('authenticated visitors see the sportsmen homepage at the home route', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('home'))
        ->assertOk()
        ->assertViewIs('home')
        ->assertSee('href="'.route('home').'"', false);
});

test('authenticated users can access sportsmen and are redirected away from guest pages', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/sportsmens')
        ->assertOk()
        ->assertHeader('Cache-Control', 'no-cache, private');

    $this->get('/login')
        ->assertRedirect(route('sportsmens'));

    $this->get('/register')
        ->assertRedirect(route('sportsmens'));
});

test('registration creates and authenticates a user before redirecting to sportsmen', function () {
    $response = $this->post(route('register'), [
        'name' => 'Taylor Athlete',
        'email' => 'taylor@example.com',
        'password' => 'StrongPass123',
        'password_confirmation' => 'StrongPass123',
    ]);

    $response->assertRedirect(route('sportsmens'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'name' => 'Taylor Athlete',
        'email' => 'taylor@example.com',
    ]);

    expect(Hash::check('StrongPass123', User::where('email', 'taylor@example.com')->value('password')))->toBeTrue();
});

test('valid login authenticates the user and redirects to sportsmen', function () {
    $user = User::factory()->create();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('sportsmens'));
    $this->assertAuthenticatedAs($user);
});

test('logout destroys the session and prevents later access to sportsmen', function () {
    $this->actingAs(User::factory()->create());

    $this->post(route('logout'))
        ->assertRedirect(route('login'));

    $this->assertGuest();

    $this->get('/sportsmens')
        ->assertRedirect(route('login'));
});

test('forgot password sends the native reset notification', function () {
    Notification::fake();
    $user = User::factory()->create();

    $this->post(route('password.email'), [
        'email' => $user->email,
    ])->assertSessionHas('status');

    Notification::assertSentTo($user, ResetPassword::class);
});

test('a valid reset token updates the password and returns the user to login', function () {
    $user = User::factory()->create();
    $token = Password::createToken($user);

    $this->post(route('password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'ChangedPass123',
        'password_confirmation' => 'ChangedPass123',
    ])->assertRedirect(route('login'));

    expect(Hash::check('ChangedPass123', $user->refresh()->password))->toBeTrue();
    expect(Password::tokenExists($user, $token))->toBeFalse();
    $this->assertGuest();
});

test('test scenario c: authenticated user navigates from sportsmen to home via header home link', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $sportsmenResponse = $this->get('/sportsmens');
    $sportsmenResponse->assertOk()
        ->assertViewIs('sportsmens')
        ->assertSee('href="'.route('home').'"', false);

    $homeResponse = $this->get(route('home'));
    $homeResponse->assertOk()
        ->assertViewIs('home')
        ->assertSee('Avaliable Biographies:');
});

test('test scenario d: registering a new account authenticates and allows access to home page', function () {
    $response = $this->post(route('register'), [
        'name' => 'Athlete User',
        'email' => 'athlete@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect(route('sportsmens'));
    $this->assertAuthenticated();

    $homeResponse = $this->get(route('home'));
    $homeResponse->assertOk()
        ->assertViewIs('home');
});
