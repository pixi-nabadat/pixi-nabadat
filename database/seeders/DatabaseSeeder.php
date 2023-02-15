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
        $this->call(LocationsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AddressTableSeeder::class);
        $this->call(DevicesTableSeeder::class);
        $this->call(CentersTableSeeder::class);
        $this->call(CenterDevicesTableSeeder::class);
        $this->call(PackagesTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(RateTableSeeder::class);
        $this->call(DoctorsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(SliderTableSeeder::class);
    }
}
