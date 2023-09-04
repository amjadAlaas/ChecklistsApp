<?php

use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\Checklist;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    // Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/checklists', [ChecklistController::class, 'index'])->name('checklist.index');
    // Route::get('/checklists/create', [ChecklistController::class, 'create'])->name('checklists.create');
    // Route::post('/checklists/store', [ChecklistController::class, 'store'])->name('checklists.store');
    // Route::get('/checklists/edit', [ChecklistController::class, 'edit'])->name('checklists.edit');
    Route::resource('checklists', ChecklistController::class);
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks-checked/{id}', [TaskController::class, 'checked'])->name('tasks.checked');
    // Route::get('/home', [HomeController::class, 'index']);
});
require __DIR__ . '/auth.php';
