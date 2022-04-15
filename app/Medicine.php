<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicines';

    protected $fillable = [
        'prescription_id',
        'name',
        'notes',
        'is_deleted',
    ];
}
