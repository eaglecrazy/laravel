<?php

namespace App\Http\Controllers\News;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;

class NewsController extends Controller
{
    public function showAll()
    {
        $news = News::getNewsAll();
        return view('news.news',
            [
                'news' => $news,
                'categories' => Category::getCategoryAll(),
                'categoryName' => null,
            ]);
    }

    public function showItem($category, $id)
    {
        $item = News::getNewsItem($id);

        //если неправильный id то редирект
        if($item === null)
            return redirect()->route('news.all');

        return view('news.news-item', ['id' => $id, 'item' => $item]);
    }

    public function showCategory($category)
    {
        $id = Category::getCategoryId($category);

        //если неправильный id то редирект
        if($id === null)
            return redirect()->route('news.all');

        return view('news.news',
            [
                'news' => News::getNewsByCategory($id),
                'categories' => Category::getCategoryAll(),
                'categoryName' => Category::getCategoryName($id)
            ]);
    }
}
