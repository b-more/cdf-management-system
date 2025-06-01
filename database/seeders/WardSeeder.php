<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ward;

class WardSeeder extends Seeder
{
    public function run(): void
    {
        $wards = [
            // Lusaka Province
            [
                'name' => 'Kanyama',
                'code' => 'LK001',
                'description' => 'Kanyama Ward - High density residential area',
                'latitude' => -15.4067,
                'longitude' => 28.2833,
                'area_size' => 25.5,
                'contact_person' => 'John Mwansa',
                'phone' => '260971000010',
            ],
            [
                'name' => 'Matero',
                'code' => 'LK002',
                'description' => 'Matero Ward - Mixed residential and commercial area',
                'latitude' => -15.3833,
                'longitude' => 28.3167,
                'area_size' => 18.7,
                'contact_person' => 'Mary Banda',
                'phone' => '260971000011',
            ],
            [
                'name' => 'Munali',
                'code' => 'LK003',
                'description' => 'Munali Ward - Residential area with educational institutions',
                'latitude' => -15.3500,
                'longitude' => 28.3500,
                'area_size' => 22.3,
                'contact_person' => 'David Phiri',
                'phone' => '260971000012',
            ],
            [
                'name' => 'Kabwata',
                'code' => 'LK004',
                'description' => 'Kabwata Ward - Central business district',
                'latitude' => -15.4167,
                'longitude' => 28.2833,
                'area_size' => 15.8,
                'contact_person' => 'Grace Tembo',
                'phone' => '260971000013',
            ],
            [
                'name' => 'Chongwe Central',
                'code' => 'CH001',
                'description' => 'Chongwe Central Ward - Rural-urban interface',
                'latitude' => -15.3333,
                'longitude' => 28.6833,
                'area_size' => 45.2,
                'contact_person' => 'Peter Mulenga',
                'phone' => '260971000014',
            ],

            // Copperbelt Province
            [
                'name' => 'Wusakile',
                'code' => 'KT001',
                'description' => 'Wusakile Ward - Mining community area',
                'latitude' => -12.8333,
                'longitude' => 28.2167,
                'area_size' => 28.9,
                'contact_person' => 'Joseph Mwanza',
                'phone' => '260971000015',
            ],
            [
                'name' => 'Nkana',
                'code' => 'KT002',
                'description' => 'Nkana Ward - Industrial and residential area',
                'latitude' => -12.8167,
                'longitude' => 28.2333,
                'area_size' => 21.4,
                'contact_person' => 'Catherine Musonda',
                'phone' => '260971000016',
            ],
            [
                'name' => 'Kamfinsa',
                'code' => 'KT003',
                'description' => 'Kamfinsa Ward - Agricultural and residential area',
                'latitude' => -12.7833,
                'longitude' => 28.2667,
                'area_size' => 35.6,
                'contact_person' => 'Emmanuel Chipata',
                'phone' => '260971000017',
            ],

            // Northern Province
            [
                'name' => 'Kasama Central',
                'code' => 'KS001',
                'description' => 'Kasama Central Ward - Provincial headquarters',
                'latitude' => -10.2167,
                'longitude' => 31.1833,
                'area_size' => 12.7,
                'contact_person' => 'Agnes Mubanga',
                'phone' => '260971000018',
            ],
            [
                'name' => 'Mbala',
                'code' => 'MB001',
                'description' => 'Mbala Ward - Tourist and farming area',
                'latitude' => -8.8333,
                'longitude' => 31.3667,
                'area_size' => 42.1,
                'contact_person' => 'Charles Simwanza',
                'phone' => '260971000019',
            ],
        ];

        foreach ($wards as $ward) {
            Ward::firstOrCreate(
                ['code' => $ward['code']],
                $ward
            );
        }
    }
}
