<?php


Route::get('/', 'HomeController@index')->name('Home');

/*
|--------------------------------------------------------------------------
| Авторизация
|--------------------------------------------------------------------------
|
| Контроллер пользователя
|
*/
Auth::routes();
Route::get('/auth/vk', 'SocialLoginController@loginVK')
    ->name('loginvk')
    ->middleware('not_auth');

//        ВОПРОС
//        Я запретил доступ в посреднике для зарегистрированых пользователей, к этому роуту,
//        но к нему должен быть доступ незарегистрированного.
//        Но если зайти на него по ссылке http://laravel.local/auth/vk/response
//        то сайт падает. Я сделал проерку на исключение InvalidStateException в контроллере,
//        но оно почему то не отлавливается.
//        Как сделать правильно? Как заставить это всё работать?

Route::get('/auth/vk/response', 'SocialLoginController@responseVK')
    ->name('respovsevk')
    ->middleware('not_auth');



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
        Route::get('/news/import', 'ParserController@import')->name('news.import');
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





