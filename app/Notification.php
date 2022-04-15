<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['notification_type_id', 'title', 'data',  'from_user', 'to_user', 'read_at', 'is_deleted'];

    public function user(){
        return $this->hasOne(User::class,'id','from_user');
    }
    public function invoice_user(){
        return $this->hasOne(Invoice::class,'id','data');
    }
    public function appointment_user(){
        return $this->hasOne(Appointment::class,'id','data');
    }

}
