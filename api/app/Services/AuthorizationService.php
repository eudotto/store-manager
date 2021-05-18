<?php

namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

class AuthorizationService
{
    public function authorization($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'error' => 'Not authorized'
            ], 401);
        }

        return [
            'access_token' => JWT::encode(
                ['email' => $user->email],
                env('JWT_KEY')
            )
        ];
    }
}
