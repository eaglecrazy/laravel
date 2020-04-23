<?php

namespace App\Http\Controllers\News;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;

class NewsController extends Controller
{
    private static $pagination = 30;

    public function showAll()
    {
        $news = News::paginate(static::$pagination);
        $categories = Category::getAll();

        return view('news.news',
            [
                'news' => $news,
                'categories' => $categories,
                'categoryName' => null,
            ]);
    }

    public function showItem($category, News $news)
    {
        return view('news.news-item', ['news_item' => $news]);
    }

    public function showCategory($category_link)
    {
        $category = Category::query()->where('link', $category_link)->firstOrFail();

        $news = $category->getNews()->paginate(2);
        $categories = Category::getAll();

        return view('news.news',
            [
                'news' => $news,
                'categories' => $categories,
                'categoryName' => $category->name
            ]);
    }
}
