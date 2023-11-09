<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];
        if (!Auth::guard("admins")->attempt($credentials)) {
            return response([
                'message' => "Provied email address or password is incorrect"
            ], 422);
        }

        /** @var Admin $user */
        $user = Auth::guard("admins")->user();

        $token = $user->createToken("main")->plainTextToken;

        return response(compact('user', 'token'));
    }

    public function forgetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response([
                'message' => "Vui lòng kiểm tra email"
            ], 200)
            : response([
                'message' => "Vui lòng thử lại sau"
            ], 400);
    }

    public function redirectToReset(Request $request)
    {
        return redirect()->away(env("LINK_RESET_PASSWORD") . "?token=" . $request->token . "&email=" . $request->email);
    }

    public function reset(Request $request)
    {
        $this->validateReset($request);

        $response = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully'])
            : response()->json(['message' => 'Unable to reset password'], 400);
    }
}
