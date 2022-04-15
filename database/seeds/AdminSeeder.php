<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credentials = [
            'first_name' => 'Doctorly',
            'last_name'  => 'Admin',
            'mobile'     => '5142323114',
            'profile_photo'=>'avatar-5.jpg',
            'email'      => 'admin@themesbrand.website',
            'password' => 'admin@123456',
        ];
        $user = Sentinel::registerAndActivate( $credentials );
        $role = Sentinel::findRoleBySlug('admin');
        $role->users()->attach($user);
    }
}
