<?php
namespace App;
 
use Illuminate\Database\Eloquent\Model;
use App\Presenters\DatePresenter;
 
 
class Comment extends Model {
    // use DatePresenter;
 
    // fields can be filled
    protected $fillable = ['comment_Id'];
 
    public function files() {
        return $this->belongsTo('App\Files');
    }
 
    public function user() {
        return $this->belongsTo('App\User');
    }
}