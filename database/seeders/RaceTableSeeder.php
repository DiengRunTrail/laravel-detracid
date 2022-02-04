<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Race;

class RaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $races = [
            [
                'title' => '14 K',
                'slug' => '14-k',
                'price' => 300,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time())

            ],
            [
                'title' => '50 K',
                'slug' => '50-k',
                'price' => 500,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time())

            ]

        ];

        // 1st method

        // foreach ($races as $key => $race) {
        //     Race::create($race);
        // }

        // 2nd method
        Race::insert($races);
    }
}
