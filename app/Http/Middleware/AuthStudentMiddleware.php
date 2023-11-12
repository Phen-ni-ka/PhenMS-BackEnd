<?php

namespace App\Http\Middleware;

use App\Models\Student;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthStudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (Auth::guard("students")->check()) {
                return $next($request);
            }
            $token = $request->bearerToken();
            if ($token == "") {
                return response()->json([
                    "message" => "accessToken not found"
                ], 404);
            }
            $localToken = PersonalAccessToken::findToken($token);
            if (is_null($localToken)) {
                $checkToken = Http::get("https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=$token");
                $responseGoogle = json_decode($checkToken->getBody()->getContents(), true);
                $student = Student::where("email", $responseGoogle['email'])->first();
            } else {
                $student = $localToken->tokenable;
            }
            Auth::guard("students")->login($student);
            return $next($request);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
