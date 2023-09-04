<?php

namespace App\Providers;

use App\Models\Checklist;
use Carbon\Carbon;
use DB;
use App\Models\Task;
// use Illuminate\Console\View\Components\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ChecklistsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        view()->composer(['layouts.navigation', 'layouts.navigation-mobile'], function ($view) {
            $checklists = Auth::user()->checklist;
            $view->with('checklists', $checklists);
        });

        view()->composer(['layouts.navigation', 'layouts.navigation-mobile'], function ($view) {
            $user = Auth::user();
            $user->load([
                'checklist.task' => function ($query) {
                    $query->get();
                }
            ]);

            // Retrieve the total number of tasks
            $totalTasks = $user->checklist->flatMap(function ($checklist) {
                return $checklist->task;
            })->count();

            // Retrieve the number of tasks with status 0
            $tasksWithStatus0 = $user->checklist->flatMap(function ($checklist) {
                return $checklist->task->where('status', 0);
            })->count();

            // Retrieve the number of tasks with status 1
            $tasksWithStatus1 = $user->checklist->flatMap(function ($checklist) {
                return $checklist->task->where('status', 1);
            })->count();

            // Calculate the percentages
            // $percentageStatus0 = ($tasksWithStatus0 / $totalTasks) * 100;
            // $percentageStatus1 = ($tasksWithStatus1 / $totalTasks) * 100;
            $view->with(['tasksWithStatus1' => $tasksWithStatus1, 'tasksWithStatus0' => $tasksWithStatus0]);
        });
        view()->composer('layouts.navigation-mobile', function ($view) {
            $user = Auth::user();
            

            // Retrieve the total number of tasks
            $totalTasks = $user->checklist->flatMap(function ($checklist) {
                return $checklist->task;
            })->count();

            // Retrieve the number of tasks with status 0
            $tasksWithStatus0 = $user->checklist->flatMap(function ($checklist) {
                return $checklist->task->where('status', 0);
            })->count();

            // Retrieve the number of tasks with status 1
            $tasksWithStatus1 = $user->checklist->flatMap(function ($checklist) {
                return $checklist->task->where('status', 1);
            })->count();

            // Calculate the percentages
            // $percentageStatus0 = ($tasksWithStatus0 / $totalTasks) * 100;
            // $percentageStatus1 = ($tasksWithStatus1 / $totalTasks) * 100;
            $view->with(['tasksWithStatus1' => $tasksWithStatus1, 'tasksWithStatus0' => $tasksWithStatus0]);
        });
    }
}
