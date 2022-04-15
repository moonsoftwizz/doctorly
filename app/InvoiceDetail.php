<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'invoice_details';

    protected $fillable = [
        'invoice_id',
        'title',
        'amount',
        'is_deleted',
    ];
    function invoice(){
        return $this->hasMany(Invoice::class,'id','invoice_id');
    }
}
