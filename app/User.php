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
        'last_name',
        'first_name',
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

}
