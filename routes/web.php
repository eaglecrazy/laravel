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

        //админ - новости
        Route::group(
            [
                'prefix' => 'news',
                'as' => 'news.'
            ],
            function () {
                Route::get('index', 'NewsController@index')->name('index');
                Route::get('create', 'NewsController@create')->name('create');
                Route::get('export', 'NewsController@export')->name('export');
                Route::match(['get', 'post'],'add', 'NewsController@add')->name('add');
                Route::match(['get', 'post'],'update/{news}', 'NewsController@update')->name('update');
                Route::get('edit/{news}', 'NewsController@edit')->name('edit');
                Route::get('delete/{news}', 'NewsController@delete')->name('delete');
            }
        );

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
