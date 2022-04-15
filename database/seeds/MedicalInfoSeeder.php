<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as faker;

class MedicalInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = faker::create();
        foreach (range(1, 15) as $item) {
            DB::table('medical_infos')->insert([
                'user_id' => $item + 15,
                'height' => $item,
                'b_group' => 'B+',
                'pulse' => $faker->address,
                'allergy' => $faker->address,
                'weight' => $item,
                'b_pressure' => 'no',
                'respiration' => 'no',
                'diet' => 'Vegetarian',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
