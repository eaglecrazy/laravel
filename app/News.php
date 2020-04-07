<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Result;
use Storage;

//Для хранения путей (они используются ещё и во вьюхах) я использовал $GLOBALS,
//чтобы не хранить в БД повторяющуюся информацию в каждой записи
//Или такие вещи лучше в конфиге хранить?

$GLOBALS['json-file'] = storage_path() . '/app/files/news.json';
$GLOBALS['images-save-folder'] = 'public/images/';
$GLOBALS['img-folder'] = 'storage/images/';


class News extends Model
{

    //получение всех новостей
    public static function getNewsAll()
    {
        return DB::table('news')->get();
    }

    //получение одной новости
    public static function getNewsItem($id)
    {
        $result = DB::table('news')->find($id);
        if ($result)
            return $result;
        return null;
    }

    //получение новостей одной категории
    public static function getNewsByCategory($category)
    {
        return DB::table('news')->where('category', $category)->get();
    }

//ВАШ КОММЕНТАРИЙ "addNumeration вот что странно, зачем это, сразу нельзя что ли индексы хранить, лишнее это."
//Это не индексы, а нумерация строк таблицы, используемая при во вьюхе. Новость с id=10 может быть на 7 строке.
// Не нашёл как грамотно прямо во вьюхе сделать нумерацию без JS, поэтому и передаю с данными.

    //добавляем нумерацию всем новостям
    public static function addNumeration($news)
    {
        $n = 1;
        foreach ($news as &$item) {
            $item->number = $n++;
        }
        return $news;
    }

//ВАШ КОММЕНТАРИЙ. "Не понял логику в saveNews, вы что иногда и меняете новость, не только добавляете? Этого не было по заданию."
//ОТВЕТ. Да, реализовал не только изменение и удаление новостей. Не по заданию, зато больше практики.
// Перенёс изменение в отдельный метод.

    //сохраняем новость
    public static function saveNews($new)
    {
        //работаем с файлом
        $file_name = null;
        if (isset($new['image'])) {
            $path = Storage::putFile($GLOBALS['images-save-folder'], $new['image']);
            $new['image'] = File::name($path) . '.' . File::extension($path);
        }

        DB::table('news')->insert($new);
    }

    //обновляем новость
    public static function updateNews($new)
    {
        //работаем с файлом
        if (isset($new['image'])) {
            $path = Storage::putFile($GLOBALS['images-save-folder'], $new['image']);
            $new['image'] = File::name($path) . '.' . File::extension($path);
        }

        //получим  прошлый экземпляр новости
        $old = DB::table('news')->find($new['id']);
        if (!isset($new['image'])) {
            $new['image'] = $old->image;
        }

        //установим время обновления
        $new['updated_at'] = DB::raw('CURRENT_TIMESTAMP()');

        //обновим новость
        DB::table('news')->
        where('id', $new['id'])->
        update($new);
    }

    //проверка есть ли ошибки в новости
    public static function thereIsError($new)
    {
        //проверка существования ключей
        if (!array_key_exists('title', $new) || !array_key_exists('category', $new) || !array_key_exists('text', $new))
            return true;
        //проверка на пустые значения
        if ($new['title'] == '' || $new['category'] == '' || $new['text'] == '')
            return true;
        //проверка на существование в категориях $new['category']
        if (empty(Category::getCategoryNameById($new['category'])))
            return true;
        return false;
    }

    //удаление новости
    public static function deleteNews($id)
    {
        //удалим файл
        $old = DB::table('news')->find($id);
        if (isset($old->image)) {
            $path = $GLOBALS['images-save-folder'] . $old->image;
            Storage::delete($path);
        }
        DB::table('news')->where('id', $id)->delete();
    }

    public static function getFileName()
    {
        $result = DB::table('news')->get();
        $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
        File::put($GLOBALS['json-file'], $json);
        return $GLOBALS['json-file'];
    }
}
