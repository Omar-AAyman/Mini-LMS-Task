<?php

namespace App\Actions;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegisterUserAction
{
    /**
     * @param  array{name: string, email: string, password: string}  $data
     */
    public function __invoke(array $data): User
    {
        $lockKey = 'register_'.$data['email'];

        return Cache::lock($lockKey, 10)->block(5, function () use ($data) {
            return DB::transaction(function () use ($data) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);

                if ($user->email && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($user->email)->send(new WelcomeMail($user));
                } else {
                    Log::warning("Welcome email not sent to user ID {$user->id}. Invalid or missing email: '{$user->email}'");
                }

                return $user;
            });
        });
    }
}
