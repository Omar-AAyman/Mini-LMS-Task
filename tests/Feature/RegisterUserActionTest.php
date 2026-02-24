<?php

use App\Actions\RegisterUserAction;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('registers a user and hashes the password', function () {
    Mail::fake();

    $action = new RegisterUserAction();
    $user = $action([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'secret123',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'name' => 'John Doe',
    ]);

    expect(Hash::check('secret123', $user->password))->toBeTrue();
});

it('queues a welcome email on registration', function () {
    Mail::fake();

    $action = new RegisterUserAction();
    $action([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'secret123',
    ]);

    Mail::assertQueued(WelcomeMail::class, function ($mail) {
        return $mail->hasTo('jane@example.com');
    });
});

it('throws exception if email is already taken', function () {
    User::factory()->create(['email' => 'duplicate@example.com']);

    $action = new RegisterUserAction();
    
    expect(fn() => $action([
        'name' => 'New User',
        'email' => 'duplicate@example.com',
        'password' => 'secret123',
    ]))->toThrow(QueryException::class);
});
