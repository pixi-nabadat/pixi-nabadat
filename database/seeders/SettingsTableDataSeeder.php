<?php

namespace Database\Seeders;

use App\Services\SettingService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (app()->make(SettingService::class)->getPredefinedPages() as $page)
        {
            if (!app()->make(SettingService::class)->checkIfPageNameExists($page)){
                //create settings code here
                dd('tesy');
            }

        }
    }
}
