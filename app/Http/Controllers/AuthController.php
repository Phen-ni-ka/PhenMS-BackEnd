<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;

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

    public function loginGoogle(Request $request)
    {
        $token = $request->token;
        $checkToken = Http::get("https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=$token");
        if (!$checkToken->successful()) {
            return  response([
                'message' => "Đăng nhập bằng google thất bại"
            ], 400);
        }
        $responseGoogle = json_decode($checkToken->getBody()->getContents(), true);

        $student = Student::where("email", $responseGoogle['email'])->first();
        if (is_null($student)) {
            return  response([
                'message' => "Tài khoản này không tồn tại trên hệ thống"
            ], 400);
        }
        if (is_null($student->avatar_url)) {
            $student->avtar->url = $responseGoogle["picture"];
            $student->save();
        }
        Auth::guard("students")->login($student);
        return [
            "user" => $student,
            "token" => $token
        ];
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

    public function resetPassword(Request $request)
    {

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $student = Student::where("email", $request->email)->first();
                $student->password = $request->password;
                $student->save();
            }
        );

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully'])
            : response()->json(['message' => 'Unable to reset password'], 400);
    }
}
