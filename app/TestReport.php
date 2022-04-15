<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestReport extends Model
{
    protected $table = 'test_reports';

    protected $fillable = [
        'prescription_id',
        'name',
        'notes',
        'is_deleted',
    ];
}
