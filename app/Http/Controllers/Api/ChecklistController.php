<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChecklistResource;
use App\Models\Checklist;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        $checklists = ChecklistResource::collection($user->checklist);
        return $this->apiResponse($checklists, 'success', 200);
    }

    public function show($id)
    {
        $user = Auth::guard('sanctum')->user();
        $checklist = Checklist::find($id);
        if ($checklist && $checklist->user_id == $user->id) {
            return $this->apiResponse(new ChecklistResource($checklist), 'success', 200);
        }
        return $this->apiResponse(null, 'not found', 401);
    }
    public function store(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $checklist = Checklist::create(['title' => $request->title, 'user_id' => $user->id]);
        if ($checklist) {
            return $this->apiResponse(new ChecklistResource($checklist), 'added successfuly', 201);
        }
        return $this->apiResponse(null, 'not created', 400);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $checklist = Checklist::find($id);
        if (!$checklist) {
            return $this->apiResponse(null, 'not found', 401);
        }
        $checklist->update(['title' => $request->title, 'user_id' => $request->user_id]);
        if ($checklist) {
            return $this->apiResponse(new ChecklistResource($checklist), 'updated successfuly', 201);
        }
        return $this->apiResponse(null, 'not created', 400);
    }
    public function destroy($id) {

        $user = Auth::guard('sanctum')->user();
        $checklist = Checklist::find($id);
        if ($checklist && $checklist->user_id == $user->id) {
            $checklist->delete();
            if ($checklist) {

                return $this->apiResponse(null, 'deleted successfuly', 200);
            } else {
                return $this->apiResponse(null, 'deleted not successfuly', 400);
            }
        } else {
            return $this->apiResponse(null, 'checklist not found', 400);
        }
    }
}
