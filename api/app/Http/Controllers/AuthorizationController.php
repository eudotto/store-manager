<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseControler;

class AuthorizationController extends BaseControler
{
    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function makeToken(Request $request)
    {
        $this->validate($request, [
           'email' => 'required|email',
           'password' => 'required'
        ]);

        $data = $request->all();
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
