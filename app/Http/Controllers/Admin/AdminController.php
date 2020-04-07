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
            $new = $request->only(['title', 'category', 'text', 'image']);

            //проверим на ошибки
            if (News::thereIsError($new)) {
                $request->flash();
                $alert = ['type' => 'danger', 'text' => 'Ошибка добавления новости.'];
                return redirect()->route('admin.news.create')->with('alert', $alert);
            }

            //сохраним новость
            $alert = ['type' => 'success', 'text' => 'Новость успешно добавлена.'];
            News::saveNews($new);
        }
        return redirect()->route('admin.news.index')->with('alert', $alert);
    }

    //страница редактирования новости
    public function newsEdit($id)
    {
        $news_item = News::getNewsItem($id);
        if (empty($news_item))
            redirect()->route('admin.news.index');
        $categories = Category::getCategoryAll();
        return view('admin.news.edit', ['news_item' => $news_item, 'categories' => $categories]);
    }

    //обновление новости
    public function newsUpdate(Request $request)
    {
        $alert = null;
        if ($request->isMethod('post')) {
            //получим новость
            $new = $request->only(['title', 'category', 'text', 'id', 'image']);
            //проверим на ошибки
            if (News::thereIsError($new)) {
                $request->flash();
                $alert = ['type' => 'danger', 'text' => 'Ошибка изменения новости.'];
            } else {
                //перезапишем новость
                News::updateNews($new);
                $alert = ['type' => 'success', 'text' => 'Новость успешно отредактирована.'];
            }
        }
        return redirect()->route('admin.news.edit', $new['id'])->with('alert', $alert);
    }

    //удаление новости
    public function newsDelete($id)
    {
        News::deleteNews($id);
        $alert = ['type' => 'info', 'text' => 'Новость удалена.'];
        return redirect()->route('admin.news.index')->with('alert', $alert);
    }

    //экспорт
    public function newsExport()
    {
        return response()->download(News::getFileName());
    }
}
