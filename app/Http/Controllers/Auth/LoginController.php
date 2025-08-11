<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ApiResponse;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            //set validation
            $validator = Validator::make($request->all(), [
                'email'     => 'required',
                'password'  => 'required'
            ]);

            //if validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //get credentials from request
            $credentials = $request->only('email', 'password');

            //if auth failed
            if (!$token = auth()->guard('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email or Passwor Fail'
                ], 401);
            }

            return $this->successResponse(
                "Data registered successfully",
                [
                    'user' => auth()->guard('api')->user(),
                    'token' => $token,
                    'expires_in' => auth('api')->factory()->getTTL() * 60,
                ],
                200
            )->header('Authorization', 'Bearer ' . $token);
        } catch (\Throwable $th) {
            return $this->errorResponse("Login failed", 500, [$th->getMessage()]);
        }
    }
}
