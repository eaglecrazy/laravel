<?php

use Illuminate\Database\Seeder;

class Tasks_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('tasks')->insert($this->getTasks());
    }

    private function getTasks()
    {
        return [['task' => 'news'], ['task' => 'articles'], ['task' => 'top7'], ['task' => 'last24'], ['task' => 'news/russia']];
    }
}
