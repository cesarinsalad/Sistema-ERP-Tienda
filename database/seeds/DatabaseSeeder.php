<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
        ]);
        \App\Exchangerate::create([
            'value' => '1'
        ]);
        // $this->call(UserSeeder::class);
    }
}
