<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public static function getAll(){
        return Category::all()->keyBy('id');
    }

    public function getNews(){
        return $this->hasMany(News::class, 'category_id', 'id')->getResults();
    }
}
