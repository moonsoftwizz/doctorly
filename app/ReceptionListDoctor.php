<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceptionListDoctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'reception_id',
        'is_deleted',
    ];

    function doctor()
    {
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }
}
