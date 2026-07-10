<?php

namespace Database\Seeders;

use App\Enums\ConstituencyType;
use App\Models\Constituency;
use App\Models\State;
use Illuminate\Database\Seeder;

class ConstituencySeeder extends Seeder
{
    public function run(): void
    {
        $state = State::first();

        Constituency::create([
            'name' => 'Bauchi Governorship',
            'type' => ConstituencyType::GOVERNORSHIP,
            'state_id' => $state->id,
            'description' => 'Governor of Bauchi State',
        ]);
    }
}