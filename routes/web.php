<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('Home');

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
|
| Контроллер пользователя
|
*/
Route::resource('user', 'UserController', ['only' => ['edit', 'update', 'show', 'destroy']])
    -> middleware(['auth', 'user_update_validation']);




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
        'middleware' => ['auth', 'is_admin']
    ],
    function () {
        Route::resource('news', 'NewsController', ['except' => ['show']]);

        //"ЭКСПОРТ ПРОПАЛ

        Route::get('/news/export', 'NewsController@export')->name('news.export');
        Route::get('/news/{some}', function (){ abort(404); });
        Route::get('/users', 'AdminController@showUsers')->name('users');
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





