<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->user = User::factory()->create(['is_admin' => false]);
});

it('admin can list users', function () {
    actingAs($this->admin)
        ->get('/admin/users')
        ->assertSuccessful()
        ->assertSee($this->user->name);
});

it('user listing is read-only — no create button', function () {
    actingAs($this->admin)
        ->get('/admin/users')
        ->assertSuccessful()
        ->assertDontSee('New user');
});

it('non-admin cannot access user admin panel', function () {
    actingAs($this->user)
        ->get('/admin/users')
        ->assertForbidden();
});
