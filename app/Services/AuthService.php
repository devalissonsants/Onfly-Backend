<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($request)
    {
        $credentials = [
            'email' => $request['username'],
            'password' => $request['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Usuário e/ou senha inválidos',
            ], 422);
        }

        $proxy = Request::create('oauth/token', 'POST', $request);
        return app()->handle($proxy);
    }
}
