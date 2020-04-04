<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;
use Storage;


//const FILE = '/files/news.json';
const FILE = '/home/vagrant/code/laravel/storage/app/files/news.json';
const FILE_PUBLIC = '/public/news.json';


class News extends Model
{

    public static function getNewsAll()
    {
        $json = File::get(FILE);
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

//ВОПРОС "addNumeration вот что странно, зачем это, сразу нельзя что ли индексы хранить, лишнее это."
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

//ВОПРОС. "Не понял логику в saveNews, вы что иногда и меняете новость, не только добавляете? Этого не было по заданию."
//ОТВЕТ. Да, реализовал не только изменение и удаление новостей. Не по заданию, зато больше практики.

    //сохраняем новость
    public static function saveNews($new, $update = false)
    {
        $news = News::getNewsAll();
        //если добавление новости генерируем id
        if ($update == false) {
            $new['id'] = (int)$news[count($news)]['id'] + 1;
            $news[] = $new;
        } else {
            //иначе ищем элемент с таким id и заменяем
            foreach ($news as &$item) {
                if ($item['id'] == $new['id']) {
                    $item = $new;
                    break;
                }
            }
        }
        $json = json_encode($news, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        File::put(FILE, $json);
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
        unset($news[$id]);
        $json = json_encode($news, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        File::put(FILE, $json);
    }

    //копирует файл с новостями в папку public
    public static function getFileName()
    {
        return FILE;
    }


}
