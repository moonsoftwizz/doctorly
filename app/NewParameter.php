<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewParameter extends Model
{
    use HasFactory;
    
    protected $table = 'new_parameter';
    
    protected $fillable = [
        'parameter',
        'type',
        'unit',
        'abbreviations',
        'standard_value',
        'formula',
        'size',
        'decimal_places',
        'decimal_mask',
        'block_recording_when_out_of_bounds',
        'mandatory_parameter',
        'minimum',
        'maximum',
        'imp_ruler',
        'previous_imp',
        'description',
        'reference_value',
        'support_parameter',
        'evolutionary_report_parameter',
        'is_deleted'
    ];
}
