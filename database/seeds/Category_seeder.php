<?php

//php artisan db:seed --class=Category_seeder  (если возникает ошибка, то на сервере "composer dump-autoload)

use Illuminate\Database\Seeder;

class Category_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert($this->getData());
    }

    private function getData()
    {
        return
            [
                ['name' => 'Здоровье', 'link' => 'health'],
                ['name' => 'Проишествия', 'link' => 'incidents'],
                ['name' => 'Игры', 'link' => 'games'],
            ];
    }
}
