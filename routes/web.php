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
                Route::get('index', 'AdminController@news')->name('index');
                Route::get('create', 'AdminController@newsCreate')->name('create');
                Route::match(['get', 'post'],'add', 'AdminController@newsAdd')->name('add');
                Route::match(['get', 'post'],'update', 'AdminController@newsUpdate')->name('update');
                Route::get('edit/{id}', 'AdminController@newsEdit')->name('edit');
                Route::get('delete/{id}', 'AdminController@newsDelete')->name('delete');
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
