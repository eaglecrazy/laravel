<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use App\Category;

class NewsController extends Controller
{
    //страница управления новостями
    public function index()
    {
        //можно конечно и так
        //$news = News::query()->paginate(5);
        //но так проще, мне кажется, во всяком случае результат один
        $news = News::paginate(20);

        $categories = Category::getAll();

        return view('admin.news.news',
            [
                'news' => $news,
                'categories' => $categories
            ]);
    }

    //страница создания новости
    public function create()
    {
        $categories = Category::getAll();
        return view('admin.news.create-update', ['categories' => $categories, 'edit' => false]);
    }

    //добавление новости
    public function add(Request $request)
    {
        $alert = null;
        if ($request->isMethod('post')) {
            //получим новость
            $new = $request->only(['title', 'category_id', 'text', 'image', 'temp-image']);

            if (News::thereIsError($new)) {
                $request->flash();
                $alert = ['type' => 'danger', 'text' => 'Ошибка добавления новости.'];

                //если меняли картинку
                $temp_image = null;
                if ($new['image'])
                    $temp_image = News::saveTempImage($new);

                return redirect()->route('admin.news.create')->with(['alert' => $alert, 'temp_image' => $temp_image]);
            }

            //теперь не работаю с объектом News внутри статики, но операции с файлами всё же делаю там
            $new = News::saveImage($new);
            $news = new News();
            $news->fill($new)->save();

            $alert = ['type' => 'success', 'text' => 'Новость успешно добавлена.'];
        }
        return redirect()->route('admin.news.index')->with('alert', $alert);
    }

    //страница редактирования новости
    public function edit(News $news)
    {
        $categories = Category::getAll();
        return view('admin.news.create-update', ['news_item' => $news, 'categories' => $categories, 'edit' => true]);
    }

    //обновление новости
    public function update(Request $request, News $news)
    {
        $alert = null;
        $temp_image = null;

        if ($request->isMethod('post')) {

            //получим новость
            $new = $request->only(['id', 'title', 'category_id', 'text', 'image', 'temp-image']);

            //проверим на ошибки
            //да, конечно валидацию потом переделаю как надо, но бд ругается если не заполнить поле
            if (News::thereIsError($new)) {
                $request->flash();
                $alert = ['type' => 'danger', 'text' => 'Ошибка изменения новости.'];

                //передаём временное фото
                if (isset($new['image'])) {
                    $temp_image = News::saveTempImage($new);
                }

            } else {
                //обновим файл с картинкой
                $new = News::updateImage($new, $news->image);

                $news->fill($new)->save();
                $alert = ['type' => 'success', 'text' => 'Новость успешно отредактирована.'];
            }
        }
        return redirect()->route('admin.news.edit', $new['id'])->with(['alert' => $alert, 'temp_image' => $temp_image]);
    }

    //удаление новости
    public function delete(News $news)
    {
        News::deleteImage($news->image);
        $news->delete();
        $alert = ['type' => 'info', 'text' => 'Новость удалена.'];
        return redirect()->route('admin.news.index')->with('alert', $alert);
    }

    //экспорт новостей
    public function export()
    {
        return response()->download(News::getFileName());
    }
}
