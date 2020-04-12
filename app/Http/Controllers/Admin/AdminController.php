<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //главная страница админки
    public function index()
    {
        return view('admin.index');
    }

    //страница управления пользователями
    public function users()
    {
        return view('admin.users');
    }
}
