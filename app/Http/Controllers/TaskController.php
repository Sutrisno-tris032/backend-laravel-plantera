<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class TaskController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $task = Task::orderBy("created_at", "desc")->paginate(10);

            return $this->successResponse("Data retrieved successfully", $task, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed retrieve data", 500, [$th->getMessage()]);
        }
    }

    public function show($task_uid)
    {
        try {
            $task = Task::where('task_uid', $task_uid)->first();

            return $this->successResponse("Data retrieved successfully", $task, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed retrieve data", 500, [$th->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'sprint_uid'        => 'required|uuid',
                'project_uid'       => 'required|uuid',
                'task_name'         => 'required|max:100',
                'task_description'  => 'nullable|string',
                'assign_uid'        => 'nullable|uuid',
                'start_date'        => 'date',
                'end_date'          => 'date',
                'status_state_id'   => 'required|integer',
                'status_state_name' => 'required|string|max:50',
                'priority'          => 'nullable|integer',
                'created_by'        => 'required|string',
                'updated_by'        => 'required|string'
            ]);

            $task = Task::create($validated);

            return $this->successResponse("Data created successfully", $task, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed created data", 500, [$th->getMessage()]);
        }
    }

    public function updateStatus(Request $request, $task_uid)
    {
        try {
            $validated = $request->validate([
                'status_state_id'   => 'required|integer',
                'status_state_name' => 'required|string|max:50',
                'updated_by'        => 'required|string'
            ]);

            $task = Task::findOrFail($task_uid);

            $task->update($validated);


            return $this->successResponse("Status updated", $task, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed updated status", 500, [$th->getMessage()]);
        }
    }

    public function update(Request $request, $task_uid)
    {
        try {
            $validated = $request->validate([
                'sprint_uid'        => 'required|uuid',
                'project_uid'       => 'required|uuid',
                'task_name'         => 'required|max:100',
                'task_description'  => 'nullable|string',
                'assign_uid'        => 'nullable|uuid',
                'start_date'        => 'date',
                'end_date'          => 'date',
                'status_state_id'   => 'required|integer',
                'status_state_name' => 'required|string|max:50',
                'priority'          => 'nullable|integer',
                'updated_by'        => 'required|string'
            ]);

            $task = Task::findOrFail($task_uid);

            $task->update($validated);

            return $this->successResponse("Data updated successfully", $task, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed updated data", 500, [$th->getMessage()]);
        }
    }

    public function destroy($task_uid)
    {
        try {

            $task = Task::findOrFail($task_uid);

            $task->delete($task);

            return $this->successResponse("Data deleted successfully", $task, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Failed deleted data", 500, [$th->getMessage()]);
        }
    }
}
