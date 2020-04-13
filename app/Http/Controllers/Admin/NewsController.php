<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use App\Category;
use Validator;

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
    public function add()
    {
        $categories = Category::getAll();
        return view('admin.news.create-update', ['categories' => $categories, 'edit' => false]);
    }

    //добавление новости
    public function create(Request $request)
    {
        //валидация идёт в отдельной функции, чтобы не дублировать код в create и update
        $new = $this->validateNews($request);
        //если были ошибки валидации то вернётся RedirectResponse
        if(is_object($new))
            return $new;

        //сохраним файл с картинкой
        $new = News::saveImage($new);
        $news = new News();
        $news->fill($new)->save();

        $alert = ['type' => 'success', 'text' => 'Новость успешно добавлена.'];
        return redirect()->route('admin.news.index')->with('alert', $alert);
    }

    //обновление новости
    public function update(Request $request, News $news)
    {
        //валидация идёт в отдельной функции, чтобы не дублировать код в create и update
        $new = $this->validateNews($request);
        //если были ошибки валидации то вернётся RedirectResponse
        if(is_object($new))
            return $new;
        //обновим файл с картинкой
        $new = News::updateImage($new, $news->image);

        $news->fill($new)->save();
        $alert = ['type' => 'success', 'text' => 'Новость успешно отредактирована.'];

        return redirect()->route('admin.news.edit', $new['id'])->with(['alert' => $alert]);
    }

    //страница редактирования новости
    public function edit(News $news)
    {
        $categories = Category::getAll();
        return view('admin.news.create-update', ['news_item' => $news, 'categories' => $categories, 'edit' => true]);
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

    //валидация идёт в отдельной функции, чтобы не дублировать код в create и update
    private function validateNews(Request $request){

// Вместо того, чтобы сделать так:
//        $new = $this->validate($request, News::rules(), [], News::fieldNames());
// решил использовать Validator::make так можно более гибкий ответ отправить на страницу
// в случае ошибки. В данном случае в форме остаётся фоточка, если она была прошла валидацию.
// Конечно теперь не одна строчка, но фреймворк сделал именно то, что я от него хочу! :))

        $new = $request->only(['id', 'title', 'category_id', 'text', 'image', 'temp-image']);

        $validator = Validator::make($new, News::rules(), [], News::fieldNames());
        if($validator->fails()){
            //если раньше был временный файл то передадим в форму его
            $temp_image = (isset($new['temp-image'])) ? $new['temp-image'] : null;
            //если был приложен какой то файл и он прошёл валидацию, то сохраним его как временный и передадим в форму
            if (isset($new['image']) && !$validator->errors()->has('image'))
                $temp_image = News::saveTempImage($new);
            $alert = ['type' => 'danger', 'text' => 'Ошибка добавления новости.'];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator->errors())
                ->with(['alert' => $alert, 'temp_image' => $temp_image]);
        }
        return $new;
    }
}
