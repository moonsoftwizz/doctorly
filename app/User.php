<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Notifications\Notifiable;
use App\Events\AccountCreated;

class User extends EloquentUser
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'full_name',
        'user_sex',
        'zip_code',
        'user_address',
        'city',
        'mobile',
        'profile_photo',
        'created_by',
        'updated_by',
        'permissions',
        'is_deleted',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */

    function doctor(){
        return $this->hasOne(Doctor::class);
    }
    function patient(){
        return $this->hasOne(Patient::class);
    }

}
