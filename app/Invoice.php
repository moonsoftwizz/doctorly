<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'patient_id',
        'payment_mode',
        'payment_status',
        'invoice_date',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
    function invoice_detail(){
        return $this->hasMany(InvoiceDetail::class)->where('is_deleted',0);
    }
    function user(){
        return $this->hasOne(user::class,'id','patient_id');
    }
    function patient(){
        return $this->hasOne(user::class,'id','patient_id');
    }
    function doctor(){
        return $this->hasOne(user::class,'id','doctor_id');
    }
    function appointment(){
        return $this->hasOne(Appointment::class,'id','appointment_id');
    }
    function transaction(){
        return $this->hasOne(Transaction::class);
    }
}
