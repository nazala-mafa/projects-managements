<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
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

Route::resource('users', UsersController::class)->names('users')->only(['index', 'store'])->middleware('role:admin');

Route::resource('projects', ProjectsController::class)->names('projects')->only(['index'])->middleware('role:admin,user');
Route::resource('projects', ProjectsController::class)->names('projects')->only(['store', 'update', 'destroy'])->middleware('role:admin');

Route::resource('projects.tasks', TasksController::class)->names('tasks')->only(['index', 'update'])->middleware('role:admin,user');
Route::resource('projects.tasks', TasksController::class)->names('tasks')->only(['store', 'destroy'])->middleware('role:admin');