<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    protected $primaryKey = 'user_Id';
     
    protected $fillable = [
        'first_Name', 'last_Name', 'gender', 'email', 'avatar', 'password', 'profession', 'location', 'hobby', 'DOB', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];
    
    public function comments() {
        return $this->hasMany('App\Comment');
    }

}