<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUsersRequest $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = password_hash($request->input('password'), PASSWORD_BCRYPT);

        User::insert([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        return redirect()->route('users.index')->with('message', 'User added successfully.');
    }
}