<?php

namespace Tests\Browser;

use Category_seeder;
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

    use RefreshDatabase;

    public function testFormAdd()
    {
//ВОПРОС А  почему сидер не работает в этом файле?
        //(new Category_seeder())->run();

        //ошибка добавления новости
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/news/create')
                ->assertSee('Название новости')
                ->type('title', 'title')
                ->press('Отправить')
                ->assertPathIs('//admin/news/create')
                ->assertSee('Ошибка добавления новости.');
        });

        //корректное добавление новости
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/news/create')
                ->type('title', 'Новая новость')
                ->type('text', 'Текст новой новости.')
                ->select('category_id', '1')
                ->press('Отправить')
                ->assertPathIs('/admin/news')
                ->assertSee('Новость успешно добавлена.');
        });
    }
}
