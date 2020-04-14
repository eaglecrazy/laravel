<?php


Route::get('/', 'HomeController@index')->name('Home');


/*
|--------------------------------------------------------------------------
| Админка
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
        Route::resource('news', 'NewsController', ['except' => ['show']]);
        Route::get('/news/export', 'NewsController@export')->name('news.export');

        //админ - пользователи
        Route::group(
            [
                'prefix' => 'users',
                'as' => 'users.'
            ],
            function () {
                Route::get('index', 'AdminController@users')->name('index');
            }
        );
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
        'namespace' => 'News',
        'as' => 'news.'
    ],
    function () {
        Route::get('/', 'NewsController@showAll')->name('all');
        //этот роут специально сделал таким, чтобы ссылка была красивая
        //как например реальная ссылка домен-категория-новость
        //https://news.mail.ru/economics/41188789/
        Route::get('/{category}/{news}', 'NewsController@showItem')->name('item');
        Route::get('/{category}', 'NewsController@showCategory')->name('category');
    }
);


Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
