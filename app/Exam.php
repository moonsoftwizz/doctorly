<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'abbreviation',
        'name',
        'category',
        'team',
        'destiny',
        'label_group',
        'quantity_label',
        'exam_kit',
        'exam_support',
        'exam_price',
        'exam_editor',
    ];
    public $timestamps = false;
}
