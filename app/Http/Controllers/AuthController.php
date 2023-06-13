<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        request()->headers->set("Accept", "application/json");
    }

    /**
     * Get the repository instance.
     *
     * @return \App\Repositories\AuthRepository
     */
    public function repo()
    {
        return new AuthRepository();
    }

    /**
     * Register
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->repo()->register($request->all());
            $token =  $user->createToken('Todo')->plainTextToken;
        }catch (\Exception $e) {
            return ResponseFormatter::error(null, $e->getMessage());
        }

        return ResponseFormatter::success([
            'user' => $user,
            'token' => $token
        ], 'User register successfully.');
    }

    /**
     * Login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
                $token =  auth()->user()->createToken('Todo')->plainTextToken;
            else
                return ResponseFormatter::error(null, 'Invalid credentials');
        }catch (\Exception $e) {
            return ResponseFormatter::error(null, $e->getMessage());
        }

        return ResponseFormatter::success([
            'user' => auth()->user(),
            'token' => $token
        ], 'User register successfully.');
    }
}
