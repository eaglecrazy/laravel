<?php



use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
//    если сидер не находится, то сделать composer dump-autoload
    public function run()
    {
        $this->call(Category_seeder::class);
        $this->call(News_seeder::class);
        $this->call(Users_seeder::class);
    }
}
