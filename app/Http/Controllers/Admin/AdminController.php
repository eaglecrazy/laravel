<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //страница управления пользователями
    public function showUsers()
    {
        return view('admin.users', ['users' => User::paginate(20)]);
    }
}
