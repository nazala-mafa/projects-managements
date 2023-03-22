<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsersRequest;
use App\Models\User;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(User::select('*'))->toJson();
        }
        return view('users.index');
    }


    public function store(StoreUsersRequest $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = password_hash($request->input('password'), PASSWORD_BCRYPT);

        $success = User::insert([
            'name' => $name,
            'email' => $email,
            'role' => 'user',
            'password' => $password
        ]);

        return response()->json([
            'message' => $success ? 'User saved successfully' : 'User failed to save',
            'success' => $success
        ], $success ? 201 : 400);
    }
}