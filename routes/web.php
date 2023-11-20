<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/{taskId}', [TaskController::class, 'show'])->name('tasks.show');

// Routes for creating tasks
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// Routes for updating tasks
Route::get('/tasks/{taskId}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{taskId}', [TaskController::class, 'update'])->name('tasks.update');

// Route for deleting tasks
Route::delete('/tasks/{taskId}', [TaskController::class, 'destroy'])->name('tasks.destroy');

