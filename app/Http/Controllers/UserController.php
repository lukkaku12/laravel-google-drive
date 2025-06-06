<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $tokenData = $this->authService->login($request->only('email', 'password'));

        if (!$tokenData) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($tokenData, 200);
    }

    public function register(Request $request)
    {
        try {
            $data = $this->authService->register($request->all());

            return response()->json($data, 201);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
    }

    public function me()
    {
        return response()->json($this->authService->getMe(), 200);
    }

    public function logout()
    {
        $this->authService->logout();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function refresh()
    {
        $token = $this->authService->refresh();
        return response()->json($token, 200);
    }
}