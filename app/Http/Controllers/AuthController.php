<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;


class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->all());
    }
}
