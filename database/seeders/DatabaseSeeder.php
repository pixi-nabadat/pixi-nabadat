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
        $this->call(AddressTableSeeder::class);
        $this->call(DevicesTableSeeder::class);
        $this->call(CentersTableSeeder::class);
        $this->call(CenterDevicesTableSeeder::class);
        $this->call(PackagesTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(RateTableSeeder::class);
        $this->call(DoctorsTableSeeder::class);
        // $this->call('Database\Seeders\CurrenciesTableDataSeeder');
        // \App\Models\User::factory(10)->create();
    }
}
