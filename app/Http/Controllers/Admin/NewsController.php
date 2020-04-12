<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use App\Category;

class NewsController extends Controller
{
    private static $pagination = 15;


    //страница управления новостями
    public function index()
    {
        $news = News::paginate(static::$pagination);

//
// ВОПРОС
// Как мне пронумеровать во вьюхе "admin/news/news.blade.php" новости (первый столбец в таблице)?
// Сейчас можно использовать id, но в реальном проекте они могут идти не подряд.
// Можно сделать из коллекции массив и дополнить его, но наверняка можно сделать используя коллекцию.
// Я пытался трансформировать коллекцию и добавлять туда номера. Но после изменения все элементы коллекции равны null.
// Возможно это защита какая то.
//
// Если так делать неправильно, то как правильно? Может есть возможность сделать это во вьюхе?
// Подскажите, пожалуйста, лучший способ. Пока оставлю без нумерации.
//
//        $GLOBALS['num'] = 1;
//        $news_collection = $news->getCollection();
//        $news_collection->transform(function ($news_item, $key){
//            $news_item->number = $GLOBALS['num']++;
//            dd($news_item); //тут элемент коллекции меняется
//        });
//        dd($news_collection);
//        /*  #items: array:5 [▼
//                0 => null
//                1 => null
//                2 => null
//                3 => null
//                4 => null
//        ]*/

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

            //сохраним новость, чтобы не засорять контроллер сделал всё в модели
            News::saveNew($new);

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


    //ВОПРОС
    //С файлами хелпер old не работает. Хочу чтобы загруженное фото в случае неудачной
    //валидации сохранялось, сейчас реализовал это так (почти работает, нужно немного доделать).
    // Есть ли лучший способ?

                //передаём временное фото
                if (isset($new['image'])) {
                    $temp_image = News::saveTempImage($new);
                }

            } else {
                //перезапишем новость
                News::updateNews($new, $news);
                $alert = ['type' => 'success', 'text' => 'Новость успешно отредактирована.'];
            }
        }
        return redirect()->route('admin.news.edit', $new['id'])->with(['alert' => $alert, 'temp_image' => $temp_image]);
    }

    //удаление новости
    public function delete(News $news)
    {
        News::deleteNews($news);
        $alert = ['type' => 'info', 'text' => 'Новость удалена.'];
        return redirect()->route('admin.news.index')->with('alert', $alert);
    }

    //экспорт новостей
    public function export()
    {
        return response()->download(News::getFileName());
    }
}
