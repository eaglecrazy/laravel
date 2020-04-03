<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    private static $categories = [
        1 => ['id' => 1, 'name' => 'Здоровье', 'link' => 'health' ],
        2 => ['id' => 2, 'name' => 'Проишествия', 'link' => 'incidents' ],
        3 => ['id' => 3, 'name' => 'Игры', 'link' => 'games' ],
    ];

    public static function getCategoryLink($id)
    {
        return static::$categories[$id]['link'];
    }

    public static function getCategoryId($link)
    {
        foreach (static::$categories as $id => $item){
            if($item['link'] === $link)
                return $id;
        }
    }

    public static function getCategoryAll()
    {
        return static::$categories;
    }

    public static function getCategoryName($id)
    {
        return static::$categories[$id]['name'];
    }

}
