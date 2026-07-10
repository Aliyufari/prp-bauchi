<?php

namespace Database\Seeders;

use App\Models\Lga;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class LgaSeeder extends Seeder
{
    public function run(): void
    {
        $north = Zone::where('name', 'Bauchi North')->first();
        $central = Zone::where('name', 'Bauchi Central')->first();
        $south = Zone::where('name', 'Bauchi South')->first();

        $lgas = [

            'Bauchi North' => [
                'Gamawa',
                'Giade',
                'Itas/Gadau',
                'Jama\'are',
                'Katagum',
                'Shira',
                'Zaki',
            ],

            'Bauchi Central' => [
                'Dambam',
                'Darazo',
                'Ganjuwa',
                'Misau',
                'Ningi',
                'Warji',
            ],

            'Bauchi South' => [
                'Alkaleri',
                'Bauchi',
                'Bogoro',
                'Dass',
                'Kirfi',
                'Tafawa Balewa',
                'Toro',
            ],

        ];

        foreach ($lgas as $zoneName => $items) {

            $zone = Zone::where('name', $zoneName)->first();

            foreach ($items as $lga) {

                Lga::firstOrCreate([
                    'name' => $lga,
                    'zone_id' => $zone->id,
                ]);

            }
        }
    }
}