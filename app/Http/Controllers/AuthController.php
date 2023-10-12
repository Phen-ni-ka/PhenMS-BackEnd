<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => "Provied email address or password is incorrect"
            ], 422);
        }

        /** @var Student $user */
        $user = Auth::user();

        $token = $user->createToken("main")->plainTextToken;

        return response(compact('user', 'token'));
    }

    public function loginGoogle(LoginRequest $request)
    {
        $user = $request->user;
        dd($user);
    }
}
