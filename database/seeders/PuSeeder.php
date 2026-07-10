<?php

namespace Database\Seeders;

use App\Models\Pu;
use App\Models\Ward;
use Illuminate\Database\Seeder;

class PuSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Ward::all() as $ward) {

            foreach (range(1,5) as $i) {

                Pu::firstOrCreate([
                    'code' => sprintf('PU-%03d', $i),
                    'ward_id' => $ward->id,
                ],[
                    'name' => "Polling Unit {$i}",
                ]);

            }

        }
    }
}