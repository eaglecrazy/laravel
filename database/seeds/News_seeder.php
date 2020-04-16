<?php

use Illuminate\Database\Seeder;
use App\News;

//php artisan make:seeder news_seeder
//php artisan db:seed --class=News_seeder (если возникает ошибка, то на сервере "composer dump-autoload)


class News_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('news')->insert($this->getData());
        factory(News::class, 10)->create();
    }

    //этот метод не нужен при использовании фабрики
    private function getData(): array
    {
        $faker = Faker\Factory::create('ru_RU');
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'title' => $faker->country,
                'text' => $faker->realText(rand(300, 500)),
                'category_id' => rand(1, 3)
            ];
        }
        return $data;
    }
}
