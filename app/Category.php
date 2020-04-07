<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    public static function getCategoryIdByLink($link)
    {
        return DB::table('categories')->where('link', $link)->first()->id;
    }

    public static function getCategoryAll()
    {
        $categories =  DB::table('categories')->get();
        $result = [];
        //Делаем ассоциативный массив, чтобы можно было обратиться к категории по id. Может его можно как то проще сделать?
        //в любом случае это временное решение, потом всё будет работать только через БД.
        foreach ($categories as $category_item){
            $result[$category_item->id] = $category_item;
        }
        return $result;
    }

    public static function getCategoryNameById($id)
    {
        return DB::table('categories')->where('id', $id)->first()->name;
    }

}
