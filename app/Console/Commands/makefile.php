<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class makefile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makefile:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Тестовая команда';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arr = [
            1 => ['id' => '1', 'name' => 'one'],
            2 => ['id' => 2, 'name' => 'two'],
            3 => ['id' => 3, 'name' => 'three'],
        ];
        $json = json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
        echo $json;
        //файл я конечно уже сделал раньше, но сделать новую команду было интересно.
    }
}
