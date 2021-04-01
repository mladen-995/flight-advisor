<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function login(string $username, string $password): string
    {
        $user = User::where('username', $username)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->tokens()->delete();
        return $user->createToken('Device')->plainTextToken;
    }

    public function register(array $attributes): void
    {
        User::create(array_merge($attributes, [
            'password' => Hash::make($attributes['password']),
            'role_id' => Role::find(Role::USER)->id
        ]));
    }
}
