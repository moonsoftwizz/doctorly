<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notification_types = [
            [
                'type' => "Appointment Added",
                'created_at' => now(),
            ],
            [
                'type' => "Appointment Confirm",
                'created_at' => now(),
            ],
            [
                'type' => "Appointment Cancel",
                'created_at' => now(),
            ],
            [
                'type' => "Invoice Generated",
                'created_at' => now(),
            ],
        ];
        DB::table('notification_types')->insert($notification_types);
    }
}
