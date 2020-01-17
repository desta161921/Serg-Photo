<?php
namespace App;
 
use Illuminate\Database\Eloquent\Model;
use App\Presenters\DatePresenter;
 
 
class React extends Model {
 
    // fields can be filled
    protected $fillable = ['user_Id', 'file_Id', 'react_Type'];
 
    public function files() {
        return $this->belongsTo('App\Files');
    }
 
    public function user() {
        return $this->belongsTo('App\User');
    }
}