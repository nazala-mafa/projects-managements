<?php

use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\TasksController;
use App\Http\Controllers\Admin\UsersController;
use App\Models\Project;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// Admin
Route::resource('users', UsersController::class)->names('users');
Route::resource('projects', ProjectsController::class)->names('projects')->only(['index', 'store', 'update', 'destroy']);
Route::resource('projects.tasks', TasksController::class)->names('tasks')->only(['index', 'store', 'update', 'destroy']);