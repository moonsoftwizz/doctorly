<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalInfo extends Model
{
    protected $table = 'medical_infos';

    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'b_group',
        'b_pressure',
        'pulse',
        'respiration',
        'allergy',
        'diet',
        'is_deleted',
    ];
}
