<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\LookupStatus;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class LookupStatusController extends Controller
{
    use ApiResponse;

    public function lookupStatus($category_id)
    {
        try {
            $data = LookupStatus::where("category_id", $category_id)->get();

            return $this->successResponse("Data retrieved successfully", $data, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed retrieved data", 500, [$th->getMessage()]);
        }
    }
}
