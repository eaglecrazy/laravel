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
        return view('news.news',
            [
                'news' => News::getNewsAll(),
                'categories' => Category::getCategoryAll(),
                'categoryName' => null
            ]);
    }

    //Параметр $category в методе не нужен, но без него не обойтись, насколько я понимаю?
    //Route::get('/{category}/{id}', 'NewsController@showItem')->name('item');
    public function showItem($category, $id)
    {
        $item = News::getNewsItem($id);
        return view('news.news-item', ['id' => $id, 'item' => $item]);
    }

    public function showCategory($category)
    {
        $id = Category::getCategoryId($category);
        return view('news.news',
            [
                'news' => News::getNewsByCategory($id),
                'categories' => Category::getCategoryAll(),
                'categoryName' => Category::getCategoryName($id)
            ]);
    }
}
