<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    
    protected $primaryKey = 'invite_Id';
    
    protected $fillable = [
      'email', 'event_Id', 'token',
    ];
}