<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'billing_name',
        'user_id',
        'order_id',
        'transaction_no',
        'amount',
        'signature',
        'payment_method',
    ];
}
