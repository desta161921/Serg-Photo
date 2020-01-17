<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Album extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    protected $primaryKey = 'user_Id';
     
    protected $fillable = [
        'album_Id', 'album_Name', 'album_Permission', 'album_Description' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}