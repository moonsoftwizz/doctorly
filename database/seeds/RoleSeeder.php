<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Role
        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Administrator',
                'slug'       => 'admin',
            ]);

        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Doctor',
                'slug'       => 'doctor',
            ]);

        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Receptionist',
                'slug'       => 'receptionist',
            ]);

        Sentinel::getRoleRepository()
            ->createModel()
            ->create([
                'name'       => 'Patient',
                'slug'       => 'patient',
            ]);

        // admin permission add
        $role_admin = Sentinel::findRoleBySlug('admin');
        $role_admin->permissions = [
            'doctor.list' => true,
            'doctor.create' => true,
            'doctor.view' => true,
            'doctor.update' => true,
            'doctor.delete' => true,
            'doctor.time_edit' => true,
            'profile.update' => true,
            'patient.list' => true,
            'patient.create' => true,
            'patient.update' => true,
            'patient.delete' => true,
            'patient.view' => true,
            'receptionist.list' => true,
            'receptionist.create' => true,
            'receptionist.update' => true,
            'receptionist.delete' => true,
            'receptionist.view' => true,
            'appointment.list' => true,
            'appointment.status' => true,
            // 'prescription.list' => true,
            'prescription.show' => true,
            'invoice.show' => true,
            'api.create'=>true,
            'api.list'=>true,
            'api.delete'=>true,
            'api.update'=>true,
            // 'invoice.list' => true,
        ];
        $role_admin->save();

        // doctor permission add
        $role_doctor = Sentinel::findRoleBySlug('doctor');
        $role_doctor->permissions = [
            'receptionist.list' => true,
            'doctor.time_edit' => true,
            'doctor.delete' => true,
            'profile.update' => true,
            'patient.list' => true,
            'patient.create' => true,
            'patient.update' => true,
            'patient.delete' => true,
            'patient.view' => true,
            'appointment.list' => true,
            'appointment.create' => true,
            'appointment.status' => true,
            'prescription.list' => true,
            'prescription.create' => true,
            'prescription.update' => true,
            'prescription.delete' => true,
            'prescription.show' => true,
            'invoice.show' => true,
            'invoice.list' => true,
            'invoice.create' => true,
            'invoice.update' => true,
            'invoice.delete' => true,
            'invoice.edit'=>true,
        ];
        $role_doctor->save();

        // patient permission add
        $role_patient = Sentinel::findRoleBySlug('patient');
        $role_patient->permissions = [
            'doctor.list' => true,
            'profile.update' => true,
            // 'patient.delete' => true,
            'patient-appointment.list' => true,
            'appointment.create' => true,
            'appointment.status' => true,
        ];
        $role_patient->save();

        // receptionist permission add
        $role_receptionist = Sentinel::findRoleBySlug('receptionist');
        $role_receptionist->permissions = [
            'doctor.list' => true,
            'doctor.view' => true,
            'patient.list' => true,
            'profile.update' => true,
            'patient.create' => true,
            'patient.update' => true,
            'patient.delete' => true,
            'patient.view' => true,
            'appointment.list' => true,
            'appointment.create' => true,
            'appointment.status' => true,
            'prescription.list' => true,
            'prescription.show' => true,
            'invoice.show' => true,
            'invoice.list' => true,
            'invoice.create' => true,
            'invoice.update' => true,
            'invoice.delete' => true,
            'receptionist.delete' => true,
            'invoice.edit'=>true,

        ];
        $role_receptionist->save();
    }
}
