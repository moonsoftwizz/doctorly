<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailableTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'from',
        'to',
        'is_deleted'
    ];
}
