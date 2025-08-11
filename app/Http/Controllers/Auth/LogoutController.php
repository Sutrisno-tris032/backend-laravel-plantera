<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LogoutController extends Controller
{
    use ApiResponse;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        try {
            $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

            if ($removeToken) {
                return $this->successResponse(
                    "Logout successfully",
                    [],
                    200
                );
            }
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed created data", 500, [$th->getMessage()]);
        }
    }
}
