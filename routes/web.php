<?php


Route::get('/', 'HomeController@index')->name('Home');

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
|
| Контроллер пользователя
|
*/
Route::resource('user', 'UserController', ['only' => ['edit', 'update', 'show']]);



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
        'as' => 'admin.',
        'middleware' => 'auth'

    ],
    function () {
        Route::resource('news', 'NewsController', ['except' => ['show']]);
        Route::get('/news/export', 'NewsController@export')->name('news.export');
        Route::get('/news/{some}', function (){ abort(404); });
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

//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
//Route::post('login', 'Auth\LoginController@login');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');


