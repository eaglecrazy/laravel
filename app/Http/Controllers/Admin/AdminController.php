<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\News;
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

    //страница управления новостями
    public function news()
    {
        $news = News::getNewsAll();
        $news = News::addNumeration($news);
        return view('admin.news.news',
            [
                'news' => $news,
                'categories' => Category::getCategoryAll()
            ]);
    }

    //страница создания новости
    public function newsCreate()
    {
        $categories = Category::getCategoryAll();
        return view('admin.news.create', ['categories' => $categories]);
    }

    //добавление новости
    public function newsAdd(Request $request)
    {
        if ($request->isMethod('post')) {
            //получим новость
            $new = $request->only(['title', 'category', 'content']);
            //проверим на ошибки
            if (News::thereIsError($new)) {
                $request->flash();
                return redirect()->route('admin.news.create');
            }
            //сохраним новость
            News::saveNews($new);
        }
        return redirect()->route('admin.news.index');
    }

    //страница редактирования новости
    public function newsEdit($id, Request $request)
    {
        //уведомление была ли ошибка при редактировании
        $edit_error = $request->only('edit_status')['edit_error'] ?? '';

        $categories = Category::getCategoryAll();
        $news_item = News::getNewsItem($id);
        if (empty($news_item))
            redirect()->route('admin.news.index');
        return view('admin.news.edit', ['news_item' => $news_item, 'categories' => $categories, 'edit_status' => $edit_error]);
    }

    //обновление новости
    public function newsUpdate(Request $request)
    {
        if ($request->isMethod('post')) {
            //получим новость
            $new = $request->only(['title', 'category', 'content', 'id']);
            //проверим на ошибки
            if (News::thereIsError($new)) {
                $request->flash();
                return redirect()->route('admin.news.edit', [$new['id'], 'edit_status' => 'error']);
            }
            //сохраним новость
//            News::saveNews($new);

            Сохранить новость
            Сделать статусы добавления новости

        }
        return redirect()->route('admin.news.edit', [$new['id'], 'edit_status' => 'ok']);
    }
}
