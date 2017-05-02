<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'My User',
            'email'    => 'test@test.dev',
            'password' => bcrypt('password'),
        ]);
    }
}
