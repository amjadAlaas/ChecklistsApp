<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Task;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $req = $request->req;
        $user = Auth::user();
        if ($req === 'today') { // retive today's tasks

            $user->load([
                'checklist.task' => function ($query) {
                    $query->whereDate('date', Carbon::today()->format('Y-m-d'))
                        ->orderBy('date', 'desc');
                }
            ]);

        } elseif ($req === 'tomorrow') { // retive tomorrow's tasks

            $user->load([
                'checklist.task' => function ($query) {
                    $query->whereDate('date', Carbon::tomorrow()->format('Y-m-d'))
                        ->orderBy('date', 'desc');
                }
            ]);

        } elseif ($req === 'thisweek') { // retive this week's tasks
            $user->load([
                'checklist.task' => function ($query) {
                    $query->whereBetween('date', [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->get();
                }
            ]);
        } elseif ($req === 'thismonth') { // retive this month's tasks
            $user->load([
                'checklist.task' => function ($query) {
                    $query->whereBetween('date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->get();
                }
            ]);
        } else { // retive all tasks
            $user->load('checklist.task');
        }

        return view('tasks.index', compact('user'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $checklists = Checklist::all()->where('user_id', Auth::user()->id);
        return view('tasks.create', compact('checklists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => ['required', 'max:255'],
                'date' => ['required', 'date_format:Y-m-d', 'after:start_date'],
            ],
            [
                'title.required' => 'Title Is Required',
                'title.max' => 'max charachter is 255',
                'date.required' => 'Date is required',
            ]
        );
        $tasks = Task::create([
            'title' => $request->title,
            'date' => $request->date,
            'checklist_id' => $request->checklist,
        ]);
        return response()->json([
            'status' => "success",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $checklists = $user->checklist;
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task', 'checklists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date_format:Y-m-d', 'after:start_date'],
            'checklist' => ['required'],
        ]);
        $task->update([
            'title' => $request->title,
            'date' => $request->date,
            'checklist_id' => $request->checklist,
        ]);
        return response()->json([
            'status' => "success",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json([
            'status' => "success",
        ]);
    }

    //toggle status checked or not
    public function checked($id)
    {
        $task = Task::findOrFail($id);
        $status = $task->status;
        $task->update(['status' => !$status]);
        return response()->json([
            'status' => "success",
        ]);
    }
}
