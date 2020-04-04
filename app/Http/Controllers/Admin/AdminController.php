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
    public function newsCreate(Request $request)
    {
        //уведомление была ли ошибка при создании
        $create_status = $request->only('create_status')['create_status'] ?? '';

        $categories = Category::getCategoryAll();
        return view('admin.news.create', ['categories' => $categories, 'create_status' => $create_status]);
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
                return redirect()->route('admin.news.create', ['create_status' => 'error']);
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
        $edit_status = $request->only('edit_status')['edit_status'] ?? '';

        $categories = Category::getCategoryAll();
        $news_item = News::getNewsItem($id);
        if (empty($news_item))
            redirect()->route('admin.news.index');
        return view('admin.news.edit', ['news_item' => $news_item, 'categories' => $categories, 'edit_status' => $edit_status]);
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
            //перезапишем новость
            News::saveNews($new, true);
        }
        return redirect()->route('admin.news.edit', [$new['id'], 'edit_status' => 'ok']);
    }

    //удаление новости
    public function newsDelete($id){
        News::deleteNews($id);
        return redirect()->route('admin.news.index');
    }

    //экспорт
    public function newsExport(){
        return News::getFile();
    }
}
