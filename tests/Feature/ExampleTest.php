<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    public function testResponseStatusAndText()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Главная страница');

        $response = $this->get('admin');
        $response->assertStatus(200);
        $response->assertSeeText('Админка');

        $response = $this->get('admin/news/create');
        $response->assertStatus(200);
        $response->assertSeeText('Название новости');

        $response = $this->get('admin/news/export');
        $response->assertStatus(200);

        $response = $this->get('admin/users/index');
        $response->assertStatus(200);
        $response->assertSeeText('Управление пользователями');

        $response = $this->get('news');
        $response->assertStatus(200);
        $response->assertSeeText('Разделы');

        $response = $this->get('news/games');
        $response->assertStatus(200);
        $response->assertSeeText('Новости раздела Игры');

        $response = $this->get('news/games/1');
        $response->assertStatus(200);
        $response->assertSeeText('Удивительный стакан');
    }
}
