<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;
use Storage;

$GLOBALS['file'] = storage_path() . '/app/files/news.json';
$GLOBALS['images-save-folder'] = 'public/images/';
$GLOBALS['img-folder'] = 'storage/images/';


class News extends Model
{

    public static function getNewsAll()
    {
        $json = File::get($GLOBALS['file']);
        return json_decode($json, true);

    }

    public static function getNewsItem($id)
    {
        $news = static::getNewsAll();
        if (array_key_exists($id, $news)) {
            return $news[$id];
        }
        return null;
    }

    public static function getNewsByCategory($category)
    {
        $result = [];
        $news = static::getNewsAll();
        foreach ($news as $id => $item) {
            if ($item['category'] == $category)
                $result[$id] = $item;
        }
        return $result;
    }

//ВАШ ВОПРОС "addNumeration вот что странно, зачем это, сразу нельзя что ли индексы хранить, лишнее это."
//Это не индексы, а нумерация строк таблицы, используемая при во вьюхе. Новость с id=10 может быть на 7 строке.
// Не нашёл как грамотно прямо во вьюхе сделать нумерацию без JS, поэтому и передаю с данными.

    //добавляем нумерацию всем новостям
    public static function addNumeration($news)
    {
        $n = 1;
        foreach ($news as &$item) {
            $item['number'] = $n++;
        }
        return $news;
    }

//ВАШ ВОПРОС. "Не понял логику в saveNews, вы что иногда и меняете новость, не только добавляете? Этого не было по заданию."
//ОТВЕТ. Да, реализовал не только изменение и удаление новостей. Не по заданию, зато больше практики.
// Перенёс изменение в отдельный метод.

    //сохраняем новость
    public static function saveNews($new)
    {
        //работаем с файлом
        $file_name = null;
        if (isset($new['image'])) {
            $path = Storage::putFile($GLOBALS['images-save-folder'], $new['image']);
            $file_name = File::name($path) . '.' . File::extension($path);
        }

        $news = News::getNewsAll();
        //генерируем уникальный id
        $new['id'] = end($news)['id'] + 1;
        $new['image'] = $file_name;
        $news[] = $new;

        $json = json_encode($news, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
        File::put($GLOBALS['file'], $json);
    }

    //сохраняем новость
    public static function updateNews($new)
    {
        $file_name = null;
        //если был прикреплён файл
        if (isset($new['image'])) {
            $path = Storage::putFile($GLOBALS['images-save-folder'], $new['image']);
            $file_name = File::name($path) . '.' . File::extension($path);
        }

        //ищем элемент с таким id и заменяем
        $news = News::getNewsAll();
        foreach ($news as &$item) {
            if ($item['id'] == $new['id']) {
                //если файл не прикреплён, то сохраним старый файл
                if ($file_name === null) {
                    $new['image'] = $item['image'];
                } else {//если файл прикреплён, то удалим старый файл и присвоим новый
                    if (isset($item['image'])) {
                        $old_path = $GLOBALS['images-save-folder'] . $item['image'];
                        Storage::delete($old_path);
                    }
                    $new['image'] = $file_name;
                }
                $item = $new;
                break;
            }
        }
        $json = json_encode($news, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
        File::put($GLOBALS['file'], $json);
    }

    //проверка есть ли ошибки в новости
    public static function thereIsError($new)
    {
        //проверка существования ключей
        if (!array_key_exists('title', $new) || !array_key_exists('category', $new) || !array_key_exists('content', $new))
            return true;
        //проверка на пустые значения
        if ($new['title'] == '' || $new['category'] == '' || $new['content'] == '')
            return true;
        //проверка на существование в категориях $new['category']
        if (empty(Category::getCategoryName($new['category'])))
            return true;
        return false;
    }

    //удаление новости
    public static function deleteNews($id)
    {
        $news = News::getNewsAll();
        //удалим файл
        if (isset($news[$id]['image'])) {
            $path = $GLOBALS['images-save-folder'] . $news[$id]['image'];
            Storage::delete($path);
        }
        unset($news[$id]);
        $json = json_encode($news, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
        File::put($GLOBALS['file'], $json);
    }

    public static function getFileName()
    {
        return $GLOBALS['file'];
    }
}
