<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function users(){
        return view('admin.users');
    }

    public function news(){
        return view('admin.news');
    }
}
