<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $state = State::first();

        $zones = [
            'Bauchi North',
            'Bauchi Central',
            'Bauchi South',
        ];

        foreach ($zones as $zone) {
            Zone::firstOrCreate([
                'name' => $zone,
                'state_id' => $state->id,
            ]);
        }
    }
}