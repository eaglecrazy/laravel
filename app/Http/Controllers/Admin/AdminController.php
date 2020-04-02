<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function news()
    {
        $news = News::getNewsAll();
        return view('admin.news',
            [
                'news' => $news,
                'categories' => Category::getCategoryAll()
            ]);
    }
}
