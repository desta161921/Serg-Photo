 <?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class File extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    protected $primaryKey = 'user_Id', 'album_Name';
     
    protected $fillable = [
        'user_Id', 'file_Location', 'file_Id', 'file_Permission', 'file_Description' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     
    public function file() {
        return $this->belongsTo('App\User');
}
 
 
 
 
 
 
 
 
