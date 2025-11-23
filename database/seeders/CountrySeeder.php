<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
           ['name' => 'Argentina'],
           ['name' => 'Australia'],
           ['name' => 'Austria'],
           ['name' => 'Belgium'],
           ['name' => 'Brazil'],
           ['name' => 'Canada'],
           ['name' => 'Chile'],
           ['name' => 'China'],
           ['name' => 'Colombia'],
           ['name' => 'Denmark'],
           ['name' => 'Egypt'],
           ['name' => 'Finland'],
           ['name' => 'France'],
           ['name' => 'Germany'],
           ['name' => 'Greece'],
           ['name' => 'India'],
           ['name' => 'Indonesia'],
           ['name' => 'Ireland'],
           ['name' => 'Italy'],
           ['name' => 'Japan'],
           ['name' => 'Kenya'],
           ['name' => 'Malaysia'],
           ['name' => 'Mexico'],
           ['name' => 'Morocco'],
           ['name' => 'Netherlands'],
           ['name' => 'New Zealand'],
           ['name' => 'Nigeria'],
           ['name' => 'Norway'],
           ['name' => 'Peru'],
           ['name' => 'Philippines'],
           ['name' => 'Portugal'],
           ['name' => 'Russia'],
           ['name' => 'Saudi Arabia'],
           ['name' => 'Singapore'],
           ['name' => 'South Africa'],
           ['name' => 'South Korea'],
           ['name' => 'Spain'],
           ['name' => 'Sweden'],
           ['name' => 'Switzerland'],
           ['name' => 'Thailand'],
           ['name' => 'Turkey'],
           ['name' => 'United Arab Emirates'],
           ['name' => 'United Kingdom'],
           ['name' => 'United States'],
           ['name' => 'Venezuela'],
        ];

        foreach ($countries as $country) {
            \DB::table('countries')->insert($country);
        }
    }
}
