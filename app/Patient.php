<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'address',
        'is_deleted',
    ];

    function appointment(){
        return $this->hasMany(Appointment::class,'appointment_for','id');
    }
    function user(){
        return $this->hasOne(user::class,'appointment_with','id')->where('is_deleted',0);
    }
}
