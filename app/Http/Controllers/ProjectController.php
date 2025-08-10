<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $data = Project::orderBy("created_at", "desc")->paginate(10);

            return $this->successResponse("Data retrieved successfully", $data, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed retrieve data", 500, [$th->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'project_name' => 'required|string|max:255',
                'description'  => 'nullable|string',
                'start_date'   => 'nullable|date',
                'end_date'     => 'nullable|date',
                'owner_uid'    => 'required|uuid',
                'status_id'    => 'required|integer',
                'status_name'  => 'required|string|max:50',
                'created_by'   => 'required|string',
                'updated_by'   => 'required|string'
            ]);

            // $validated['project_uid'] = (string) Str::uuid();

            $project = Project::create($validated);

            return $this->successResponse("Data created successfully", $project, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed created data", 500, [$th->getMessage()]);
        }
    }

    public function update(Request $request, $project_uid)
    {
        try {
            $validated = $request->validate([
                'project_name' => 'required|string|max:255',
                'description'  => 'nullable|string',
                'start_date'   => 'nullable|date',
                'end_date'     => 'nullable|date',
                'owner_uid'    => 'required|uuid',
                'status_id'    => 'required|integer',
                'status_name'  => 'nullable|string|max:50',
                'updated_by'   => 'required|string'
            ]);

            $project = Project::findOrFail($project_uid);

            $project->update($validated);

            return $this->successResponse("Data updated successfully", $project, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed updated data", 500, [$th->getMessage()]);
        }
    }

    public function destroy($project_uid) {
        try {

            $project = Project::findOrFail($project_uid);

            $project->delete();
            
            return $this->successResponse("Deleted data succesfully", $project, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed delete data", 500, [$th->getMessage()]);
        }
    }
}
