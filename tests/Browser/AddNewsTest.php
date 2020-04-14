<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddNewsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */


//    Я запускал тесты через homestead, с тестовой БД.
//    Но пока не сделана форма "категории" я не могу с ней нормально протестировать.
//    Точнее протестировать можно, но будут показываться ошибки, так как БД пустая.
//    Поэтому тесты запускал через PHPstorm c обычной БД.

//    use RefreshDatabase;

    public function testFormAdd()
    {
        //ошибка добавления новости
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/news/add')
                ->assertSee('Название новости')
                ->type('title', 'title')
                ->press('Отправить')
                ->assertPathIs('//admin/news/add')
                ->assertSee('Ошибка добавления новости.');
        });

        //корректное добавление новости
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/news/add')
                ->type('title', 'Новая новость')
                ->type('text', 'Текст новой новости.')
                ->select('category_id', '1')
                ->press('Отправить')
                ->assertPathIs('/admin/news/index')
                ->assertSee('Новость успешно добавлена.');
        });
    }
}
