<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrenciesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Currency::create(
            [
                'name' => [
                    'en' => 'egyptian pound',
                    'ar' => 'الجنيه المصرى'
                ],
                'code' => '£EGP',
                'symbol' => '£',
                'exchange_rate' => 0.0,
            ],
            [
                'name' =>
                        [
                            'en' => 'Dollar',
                            'ar' => ' الدولار الامريكى'
                        ],
                'code' => '$US',
                'symbol' => '$',
                'exchange_rate' => 0.0,
            ],
            [
                'name' =>
                        ['en' => 'Saudi riyal','ar' => 'الريال السعودى'],
                'code' => '﷼SAR',
                'symbol' => '﷼',
                'exchange_rate' => 0.0,
            ],
            [
                'name' => ['ar' => 'اليورو الاوروبى', 'en' => 'Euro'],
                'code' => '€EUR',
                'symbol' => '€',
                'exchange_rate' => 0.0,
            ]
        );

    }
}
