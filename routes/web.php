<?php


Route::get('/', 'HomeController@index')->name('Home');

/*
|--------------------------------------------------------------------------
| Админка 123
|--------------------------------------------------------------------------
|
| Функции администратора
|
*/
Route::group(
    [
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'as' => 'admin.'
    ],
    function () {
        Route::get('/', 'AdminController@index')->name('index');
        Route::get('/news', 'AdminController@news')->name('news');
        Route::get('/users', 'AdminController@users')->name('users');
    });

/*
|--------------------------------------------------------------------------
| Новости
|--------------------------------------------------------------------------
|
| Вывод новостей
|
*/
Route::group(
    [
        'prefix' => 'news',
        'namespace'=> 'News',
        'as' => 'news.'
    ],
    function(){
        Route::get('/', 'NewsController@showAll')->name('all');
        Route::get('/{category}/{id}', 'NewsController@showItem')->name('item');
        Route::get('/{category}', 'NewsController@showCategory')->name('category');
    }
);


//оставил для примера
//Route::get('/admin',
//    [
//        'uses' => 'Admin\AdminController@index',
//        'as' => 'Admin'
//    ]);
