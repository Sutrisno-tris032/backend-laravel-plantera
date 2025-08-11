<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    use ApiResponse;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //set validation
        try {
            $request->validate([
                'name'      => 'required',
                'email'     => 'required|email|unique:users',
                'password'  => 'required|min:8|confirmed'
            ]);

            //create user
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password)
            ]);

            //return response JSON user is created
            if ($user) {
                $token = JWTAuth::fromUser($user);
                return $this->successResponse("Data registered successfully", ['user' => $user, 'token' => $token], 200);
            }

            //return JSON process insert failed 
            return response()->json([
                'success' => false,
            ], 409);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed created data", 500, [$th->getMessage()]);
        }
    }
}
