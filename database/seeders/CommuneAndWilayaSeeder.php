<?php

namespace Database\Seeders;

use App\Models\Commune;
use App\Models\Wilaya;
use Illuminate\Database\Seeder;

class CommuneAndWilayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonStates = json_decode(file_get_contents(base_path('resources/json/states.json'), true));
        $jsonAreas = json_decode(file_get_contents(base_path('resources/json/areas.json'), true));
        foreach ($jsonStates as $jsonState) {
            Wilaya::updateOrCreate(
                ['id' => $jsonState->id],
                ['name' => $jsonState->name]
            );
        }
        foreach ($jsonAreas as $jsonArea) {
            Commune::updateOrCreate(
                ['id' => $jsonArea->id],
                ['name' => $jsonArea->name, 'wilaya_id' => $jsonArea->state_id]
            );
        }
    }
}
