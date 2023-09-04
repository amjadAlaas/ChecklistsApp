<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $checklists = $user->checklist;

        return view('checklists.index', compact('checklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('checklists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);
        $checklist = Checklist::create([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
        ]);
        return redirect(route('checklists.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $req = $request->req;
        $user = Auth::user();
        if ($req === 'today') {
            $user->load([
                'checklist' => function ($query) use ($id) {
                    $query->where('id', $id)
                        ->with([
                            'task' => function ($query) {
                                    $query->whereDate('date', Carbon::today()->format('Y-m-d'))
                                        ->orderBy('date', 'desc');
                                }
                        ]);
                }
            ]);
        } elseif ($req === "tomorrow") {
            $user->load([
                'checklist' => function ($query) use ($id) {
                    $query->where('id', $id)
                        ->with([
                            'task' => function ($query) {
                                    $query->whereDate('date', Carbon::tomorrow()->format('Y-m-d'))
                                        ->orderBy('date', 'desc');
                                }
                        ]);
                }
            ]);
        } elseif ($req === 'thisweek') {
            $user->load([
                'checklist' => function ($query) use ($id) {
                    $query->where('id', $id)
                        ->with([
                            'task' => function ($query) {
                                    $query->whereBetween('date', [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])
                                        ->orderBy('date', 'desc');
                                }
                        ]);
                }
            ]);
        } elseif ($req === 'thismonth') {
            $user->load([
                'checklist' => function ($query) use ($id) {
                    $query->where('id', $id)
                        ->with([
                            'task' => function ($query) {
                                    $query->whereBetween('date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])
                                        ->orderBy('date', 'desc');
                                }
                        ]);
                }
            ]);
        } else { // retive all tasks
            // $user->load('checklist.task');
            $user->load([
                'checklist' => function ($query) use ($id) {
                    $query->where('id', $id);
                }
            ]);
        }
        return view('checklists.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist)
    {
        return view('checklists.edit', compact('checklist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checklist $checklist)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);
        $checklist->update([
            'title' => $request->title,
        ]);
        return redirect(route('checklists.index'))->with('success', 'Checklist updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklist)
    {
        $checklist->delete();
        return redirect(route('checklists.index'))->with('success', 'Checklist deleted successfully');
    }
}
