<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorAvailableDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 15) as $item) {
            DB::table('doctor_available_days')->insert([
                'doctor_id' => $item,
                'sun' => 0,
                'mon' => 1,
                'tue' => 0,
                'wen' => 0,
                'thu' => 1,
                'fri' => 0,
                'sat' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
