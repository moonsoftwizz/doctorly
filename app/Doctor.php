<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';

    protected $fillable = [
        'user_id',
        'title',
        'degree',
        'experience',
        'doc_CPF',
        'doc_CRM',
        'doc_Advice',
        'doc_specialty',
        'is_deleted',
    ];
}
