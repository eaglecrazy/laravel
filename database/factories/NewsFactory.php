<?php

//php artisan make:factory NewsFactory --model=News

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    //вместо оптимизации я просто поменял параметр 'faker_locale' => 'ru_RU', в конфиге
    return [
        'title' => $faker->country,
        'text' => $faker->realText(rand(300, 500)),
        'category_id' => rand(1, 3)
    ];
});
