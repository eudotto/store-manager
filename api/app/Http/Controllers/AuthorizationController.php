<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthorizationService;
use App\Services\UserService;
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

        return (new AuthorizationService())->authorization($request->all());
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:5|max:30',
            'email' => 'required',
            'password' => 'required|min:5|max:30'
        ]);

        return (new UserService())->create($request);
    }
}
