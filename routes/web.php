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
        Route::get('/news', 'AdminController@news')->name('news');
        Route::get('/news/create', 'AdminController@newsCreate')->name('news.create');
        Route::post('/news/add', 'AdminController@newsAdd')->name('news.add');
        Route::get('/news/edit/{id}', 'AdminController@newsEdit')->name('news.edit');
        Route::get('/news/delete/{id}', 'AdminController@newsDelete')->name('news.delete');
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
        'namespace' => 'News',
        'as' => 'news.'
    ],
    function () {
        Route::get('/', 'NewsController@showAll')->name('all');
        //этот роут специально сделал таким, чтобы ссылка была красивая
        //как например реальная ссылка домен-категория-новость
        //https://news.mail.ru/economics/41188789/
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


Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
