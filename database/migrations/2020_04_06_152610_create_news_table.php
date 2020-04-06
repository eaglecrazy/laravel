<?php

//php artisan make:migration create_news_table --create=news - создание миграции
//php artisan migrate
//php artisan migrate:rollback
//php artisan migrate --seed


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('title')->comment('Заголовок новости');
            $table->text('text')->comment('Текст новости');
            $table->bigInteger('category')->comment('ID категории');
            $table->string('image')
                ->nullable()
                ->default(null)
                ->comment('Картинка');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
//            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
