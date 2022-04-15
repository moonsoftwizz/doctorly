<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentApi extends Model
{
    use HasFactory;
    protected $fillable = [
        'gateway_type',
        'key',
        'secret',
        'is_deleted'
    ];
}
