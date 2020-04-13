<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use File;


class News extends Model
{
    protected $fillable = ['title', 'text', 'category_id', 'image'];

    static $img_folder = 'storage/images/';//используется во вьюхах
    private static $images_save_folder = 'public/images/';

    //копируем файл в хранилище и возвращаем путь
    private static function copyImageToStorage($image)
    {
        $path = Storage::putFile(static::$images_save_folder, $image);
        return File::name($path) . '.' . File::extension($path);
    }

    //перемещаем временный файл, переименовываем его и возвращаем имя
    private static function moveAndRenameTempImage($image)
    {
        //новое имя файла
        $extension = File::extension($image);
        $file_name = uniqid() . '.' . $extension;
        //новый путь
        $new_path = static::$images_save_folder . $file_name;
        //путь к старому файлу
        $old_path = static::$images_save_folder . '/temp-file.' . $extension;
        //переместим файл и запишем имя
        Storage::move($old_path, $new_path);
        return $file_name;
    }

    //сохраняем файл с картинкой
    public static function saveImage($new)
    {
        //работаем с файлом
        if (isset($new['image']))
            $new['image'] = static::copyImageToStorage($new['image']);
        //если новой фоточки не было, но был временный файл
        elseif (isset($new['temp-image']))
            $new['image'] = static::moveAndRenameTempImage($new['temp-image']);
        return $new;
    }

    //обновляем файл с картинкой
    public static function updateImage($new, $old_image)
    {
        //работаем с файлом
        if (isset($new['image'])) {
            //скопируем в хранилище
            $new['image'] = static::copyImageToStorage($new['image']);
            //удалим старую фоточку
            $old_path = static::$images_save_folder . $old_image;
            Storage::delete($old_path);

            //если новой фоточки не было, но был временный файл
        } elseif (isset($new['temp-image'])) {
            $new['image'] = static::moveAndRenameTempImage($new['temp-image']);
        }

        //заменим фото в новом экземпляре старым, если оно не менялось
        if (!isset($new['image']))
            $new['image'] = $old_image;
        return $new;
    }

    //сохраняем временный файл с картинкой, возвращаем путь к нему
    public static function saveTempImage($new)
    {
        $path = Storage::putFile(static::$images_save_folder, $new['image']);
        //удалим и переименуем, чтобы на сервере не скапливались ненужные файлы
        Storage::delete(static::$images_save_folder . '/temp-file.' . File::extension($path));
        Storage::move($path, static::$images_save_folder . '/temp-file.' . File::extension($path));
        return static::$img_folder . 'temp-file.' . File::extension($path);
    }

    //удаляем файл с картинкой
    public static function deleteImage($to_delete)
    {
        if (isset($to_delete)) {
            $path = static::$images_save_folder . $to_delete->image;
            Storage::delete($path);
        }
    }

    //проверим на заполнение полей
    //проверку сделал так как БД ругается, если не заполнить
    //конечно, когда будем делать валидацию сделаю всё правильно
    public static function thereIsError($new)
    {
        if (empty($new['title']) || empty($new['category_id']) || empty($new['text']))
            return true;
        return false;
    }


    //хотел применить данный метод, но это непроизводительно
    //когда отображаются все новости, на каждую делается запрос в БД про категорию,
    //вместо одного запроса, получается столько запросов, сколько новостей -1.
    //но, вообще штука полезеная
    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id')->first();
    }

    public static function rules()
    {
        //получаем имя таблицы
        $tableNameCategory = (new Category())->getTable();

        return [
            'title' => 'required|min:2|max:255',
            'text' => 'required|min:2|max:65535',
            'category_id' => "required|exists:$tableNameCategory,id",
            'image' => 'mimes:jpeg,bmp,png|max:1000'
        ];
    }

    public static function fieldNames()
    {
        return ['title' => '"Название новости"',
            'text' => '"Текст новости"',
            'category_id' => '"Категория"',
            'image' => 'Изображение'];
    }
}
