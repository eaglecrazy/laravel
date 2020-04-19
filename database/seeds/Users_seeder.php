<?php

use Illuminate\Database\Seeder;
use App\User;

class Users_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert($this->getAdmin());
        DB::table('users')->insert($this->getUser());
        factory(User::class, 10)->create();
    }

    private function getAdmin()
    {
        return [
            'name' => 'admin',
            'email' => 'ad@ad.ru',
            'email_verified_at' => now(),
            'password' => '$2y$10$h5OMZOeAnyEFU3xbnjC3pu.dMZ0hYcI2QF8NmW1CCoWIdgTfaAwg2', // password
            'remember_token' => null,
            'role' => 1
        ];
    }

    private function getUser()
    {
        return [
            'name' => 'user',
            'email' => 'us@us.ru',
            'email_verified_at' => now(),
            'password' => '$2y$10$h5OMZOeAnyEFU3xbnjC3pu.dMZ0hYcI2QF8NmW1CCoWIdgTfaAwg2', // password
            'remember_token' => null,
            'role' => 0
        ];
    }
}
