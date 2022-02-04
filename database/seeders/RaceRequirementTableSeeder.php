<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RaceRequirement;

class RaceRequirementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $raceRequirements = [
            [
                'race_id' => 1,
                'name' => 'has road race 10k record'
            ],
            [
                'race_id' => 1,
                'name' => 'vaccinated'
            ],
            [
                'race_id' => 2,
                'name' => 'has 42k record'
            ],
            [
                'race_id' => 2,
                'name' => 'vaccinated'
            ]

            ];

            RaceRequirement::insert($raceRequirements);
    }
}
