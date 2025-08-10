<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class SprintController extends Controller
{
    //
    use ApiResponse;

    public function index()
    {
        try {
            $task = Sprint::orderBy("created_at", "desc")->paginate(10);

            return $this->successResponse("Data retrieved successfully", $task, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed retrieve data", 500, [$th->getMessage()]);
        }
    }

    public function show($sprint_uid)
    {
        try {
            $task = Sprint::with('task')->findOrFail($sprint_uid);

            return $this->successResponse("Data retrieved successfully", $task, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed retrieve data", 500, [$th->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'project_uid'   => 'required|uuid',
                'title'         => 'required|string|max:100',
                'start_date'    => 'required|date',
                'end_date'      => 'required|date',
                'state'         => 'nullable',
                'created_by'    => 'required|string',
                'updated_by'    => 'required|string'
            ]);

            $data = Sprint::create($validated);

            return $this->successResponse("Data created successfully", $data, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed created data", 500, [$th->getMessage()]);
        }
    }

    public function update(Request $request, $sprint_uid)
    {
        try {
            $validated = $request->validate([
                'project_uid'   => 'required|uuid',
                'title'         => 'required|string|max:100',
                'start_date'    => 'required|date',
                'end_date'      => 'required|date',
                'state'         => 'nullable',
                'updated_by'    => 'required|string'
            ]);

            $data = Sprint::findOrFail($sprint_uid);

            $data->update($validated);

            return $this->successResponse("Data updated successfully", $data, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed updated data", 500, [$th->getMessage()]);
        }
    }

    public function destroy($sprint_uid)
    {
        try {

            $data = Sprint::findOrFail($sprint_uid);

            $data->delete();

            return $this->successResponse("Data updated successfully", $data, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed updated data", 500, [$th->getMessage()]);
        }
    }
}
