<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChecklistResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        // $checklists = $user->checklist;
        $user->load('checklist.task');
        return response($user);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'checklist' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $task = Task::create([
            'title' => $request->title,
            'date' => $request->date,
            'checklist_id' => $request->checklist,
        ]);
        return $this->apiResponse($task, "success", 200);
    }
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if ($task) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'checklist' => 'required',
                'date' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 400);
            }
            $task->update([
                'title' => $request->title,
                'date' => $request->date,
                'checklist_id' => $request->checklist,
            ]);
            return $this->apiResponse($task, "success", 200);
        } else {
            return $this->apiResponse(null, "The task is not exist", 404);
        }
    }
}
