<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

it('allows admin users to access admin-only routes', function () {
    Route::middleware(['auth', 'role:admin'])->get('/role-test', fn () => 'ok');

    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
        ->get('/role-test')
        ->assertOk();
});

it('blocks non-admin users from admin-only routes', function () {
    Route::middleware(['auth', 'role:admin'])->get('/role-test-2', fn () => 'ok');

    $user = User::factory()->create(['role' => 'penulis']);

    $this->actingAs($user)
        ->get('/role-test-2')
        ->assertForbidden();
});
