<?php


use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
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
            'first_name' => 'Patient',
            'last_name' => 'Doctorly',
            'mobile' => '5142323114',
            'profile_photo' => 'Female_patient.png',
            'email' => 'patient@themesbrand.website',
            'password' => 'patient@123456',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = Sentinel::findRoleBySlug('patient');
        $role->users()->attach($user);
        DB::table('patients')->insert([
            'user_id' => 16,
            'age' => 20,
            'gender' => 'Male',
            'address' => $faker->address,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $i = 1;
        foreach (range(17, 30) as $item) {
            $fakerName = $faker->name;
            $user = [
                'first_name' => Str::before($fakerName, ' '),
                'last_name' => Str::after($fakerName, ' '),
                'mobile' => rand(1000000000, 2000000000),
                'profile_photo' => 'avatar-' . $i . '.jpg',
                'email' => $faker->safeEmail,
                'password' => 'patient@123456',
            ];
            $user = Sentinel::registerAndActivate($user);
            $role = Sentinel::findRoleBySlug('patient');
            $role->users()->attach($user);
            $i++;
        }
        foreach (range(17, 30) as $item) {
            DB::table('patients')->insert([
                'user_id' => $item,
                'age' => $item,
                'gender' => 'Male',
                'address' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
