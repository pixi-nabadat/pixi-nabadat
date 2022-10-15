<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Location::create([
            'slug' => 'Eg',
            'title' => 'Egypt',
            'children' => [
                [
                    'slug' => 'Ca',
                    'title' => 'Cairo',
                    'children' => [
                        ['slug' => 'Gi' , 'title' => 'Giza'],
                        ['slug' => 'Alm','title' => 'Almokattem'],
                        ['slug' => 'nas', 'title' => 'Nasr city'],
                    ],
                ],
                [
                    'slug' => 'bns',
                    'title' => 'Banisuef',
                    'children' => [
                        ['slug' => 'Eh' , 'title' => 'Ehnasia'],
                        ['slug' => 'Bb','title' => 'Biba'],
                        ['slug' => 'nas', 'title' => 'Elfashn'],
                    ],
                ],
            ],
        ]);
  }
}
