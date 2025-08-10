<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($message = null, $data, $statusCode = 200)
    {
        return response()->json([
            "success" => true,
            "message" => $message,
            "data" => $data
        ], $statusCode);
    }

    protected function errorResponse($message = null, $statusCode = 500, $errors = [])
    {
        return response()->json([
            "success" => false,
            "message" => $message,
            "errors" => $errors
        ], $statusCode);
    }
}
