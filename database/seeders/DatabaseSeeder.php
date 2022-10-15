<?php

namespace Database\Seeders;
use Database\Seeders\LocationsTableSeeder;
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
        $this->call('Database\Seeders\LocationsTableSeeder');
        $this->call('Database\Seeders\UsersTableSeeder');
        // \App\Models\User::factory(10)->create();
    }
}
