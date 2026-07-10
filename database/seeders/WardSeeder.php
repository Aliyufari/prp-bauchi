<?php

namespace Database\Seeders;

use App\Models\Lga;
use App\Models\Ward;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Lga::all() as $lga) {

            foreach (range(1,5) as $i) {

                Ward::firstOrCreate([
                    'name' => "Ward {$i}",
                    'lga_id' => $lga->id,
                ]);

            }

        }
    }
}