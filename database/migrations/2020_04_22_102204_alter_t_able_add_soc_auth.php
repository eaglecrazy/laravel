<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTAbleAddSocAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_id', 20)
                ->default('')
                ->comment('ID "В контакте"');
            $table->enum('type_auth', ['site', 'vk', 'github'])
                ->default('site')
                ->comment('Тип авторизации');
            $table->string('avatar', 150)
                ->default('')
                ->comment('ССылка на аватар');;
            $table->index('social_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('social_id', 'type_auth', 'avatar');
        });
    }
}
