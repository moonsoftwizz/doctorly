<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailableDay extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'mon',
        'sun',
        'tue',
        'wen',
        'thu',
        'fri',
        'sat'
    ];
}
