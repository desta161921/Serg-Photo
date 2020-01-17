<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Event extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    protected $primaryKey = 'event_Id';
     
    protected $fillable = [
        'event_Name','event_Type', 'event_Description', 'event_Privacy'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    

}