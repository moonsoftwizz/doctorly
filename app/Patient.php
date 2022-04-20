<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = [
        'user_id',
        'patient_dob'=>'',
        'patient_Age'=>'',
        'patient_rg'=>'',
        'patient_CPF'=>'',
        'patient_responsible'=>'',
        'patient_health'=>'',
        'patient_company'=>'',
        'patient_enrollment'=>'',
        'patient_plan'=>'',
        'patient_observation'=>'',
        'patient_social_name'=>'',
        'is_deleted',
    ];

    function appointment(){
        return $this->hasMany(Appointment::class,'appointment_for','id');
    }
    function user(){
        return $this->hasOne(user::class,'appointment_with','id')->where('is_deleted',0);
    }
}
