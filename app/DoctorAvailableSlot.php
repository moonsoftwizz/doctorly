<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailableSlot extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'doctor_available_id',
        'from',
        'to',
        'is_deleted'
    ];
    function appointment(){
        return $this->hasMany(Appointment::class,'available_slot','id');
    }

}
