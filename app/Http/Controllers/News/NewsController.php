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
        $category = Category::where('link', $category_link)->get()->first();

        //если нет категории с таким линком то редирект
        if($category === null)
            return redirect()->route('news.all');

//ВОПРОС
        //Запрос ниже возвращает объект
        //Illuminate\Database\Eloquent\Builder
        //и к нему можно применить метод paginate
        $news = News::where('category_id', $category->id);
        $news = $news->paginate(static::$pagination);

        //Если использовать запрос по отношениям
        //то getNews вернёт объект
        //Illuminate\Database\Eloquent\Collection
        //как сделать пейджинацию для него?
        $temp_news = $category->getNews();

        //категории
        $categories = Category::getAll();

        return view('news.news',
            [
                'news' => $news,
                'categories' => $categories,
                'categoryName' => $category->name
            ]);
    }


}
