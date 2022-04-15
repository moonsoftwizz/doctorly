<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Faker\Factory as faker;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = faker::create();
        $user = [
            'first_name' => 'Doctor',
            'last_name' => 'Doctorly',
            'mobile' => '5142323114',
            'profile_photo' => 'Female_doctor.png',
            'email' => 'doctor@themesbrand.website',
            'password' => 'doctor@123456',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = Sentinel::findRoleBySlug('doctor');
        $role->users()->attach($user);

        DB::table('doctors')->insert([
            'user_id' => 2,
            'title' => $faker->title,
            'fees' => '500',
            'degree' => 'MBBS',
            'experience' => '2 Year',
            'slot_time' => 25,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        foreach (range(3, 15) as $item) {
            $fakerName = $faker->name;
            $user = [
                'first_name' => Str::before($fakerName, ' '),
                'last_name' => Str::after($fakerName, ' '),
                'mobile' => rand(1000000000, 2000000000),
                'profile_photo' => 'dr-avatar-' . $item . '.jpg',
                'email' => $faker->safeEmail,
                'password' => 'doctor@123456',
            ];
            $user = Sentinel::registerAndActivate($user);
            $role = Sentinel::findRoleBySlug('doctor');
            $role->users()->attach($user);
        }
        foreach (range(3, 15) as $item) {
            DB::table('doctors')->insert([
                'user_id' => $item,
                'title' => $faker->title,
                'fees' => '500',
                'degree' => 'MBBS',
                'experience' => $item . 'year',
                'slot_time' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
