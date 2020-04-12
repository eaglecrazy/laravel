<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use File;


class News extends Model
{
    static $img_folder = 'storage/images/';//используется во вьюхах
    private static $images_save_folder = 'public/images/';


    protected $fillable = ['title', 'text', 'category_id', 'image'];


    //чтобы не писать в контроллере много кода сделал функции сохранения, изменения и удаления тут
    public static function saveNew($new)
    {
        //работаем с файлом
        if (isset($new['image'])) {
            $path = Storage::putFile(static::$images_save_folder, $new['image']);
            $new['image'] = File::name($path) . '.' . File::extension($path);
        }

        $news = new News();
        $news->fill($new)->save();
    }


    //чтобы не писать в контроллере много кода сделал функции сохранения, изменения и удаления тут
    public static function updateNews($new, News $old)
    {
        //работаем с файлом
        if (isset($new['image'])) {
            $path = Storage::putFile(static::$images_save_folder, $new['image']);
            $new['image'] = File::name($path) . '.' . File::extension($path);

            //удалим старую фоточку
            $old_path = static::$images_save_folder . $old->image;
            Storage::delete($old_path);
        } elseif(isset($new['temp-image'])) {//если новой фоточки не было, но был временный файл
            $extension = File::extension($new['temp-image']);
            $old_path = static::$images_save_folder  . '/temp-file.' . $extension;
            $path = static::$img_folder . uniqid() . '.' . $extension;
            Storage::move($old_path, $path);
            $new['image'] = $path;
        }


        //заменим фото в новом экземпляре старым, если его не было
        if (!isset($new['image'])) {
                $new['image'] = $old->image;
        }

        $old->fill($new)->save();
    }


    //если не была пройдена валидация, то сохраним файл чтобы вывести его при отображении формы добавления/редактирования
    public static function saveTempImage($new){
        $path = Storage::putFile(static::$images_save_folder, $new['image']);
        Storage::delete(static::$images_save_folder . '/temp-file.' . File::extension($path));
        Storage::move($path, static::$images_save_folder . '/temp-file.' . File::extension($path));
        return static::$img_folder . 'temp-file.' . File::extension($path);
    }


    //если не была пройдена валидация, то сохраним файл чтобы вывести его при отображении формы добавления/редактирования
    public static function deleteNews($to_delete)
    {
        //удалим файл
        if (isset($to_delete->image)) {
            $path = static::$images_save_folder . $to_delete->image;
            Storage::delete($path);
        }
        $to_delete->delete();
    }

    //проверим на заполнение полей
    //проверку сделал так как БД ругается, если не заполнить
    //конечно, когда будем делать валидацию сделаю всё правильно
    public static function thereIsError($new){
        if(empty($new['title']) || empty($new['category_id']) || empty($new['text']))
            return true;
        return false;
    }


    //хотел применить данный метод, но это непроизводительно
    //когда отображаются все новости, на каждую делается запрос в БД про категорию,
    //вместо одного запроса, получается столько запросов, сколько новостей -1.
    //но, вообще штука полезеная
    public function getCategory(){
        return $this->belongsTo(Category::class, 'category_id')->first();
    }
}
