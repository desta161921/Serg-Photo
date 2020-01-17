<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\User;
use Notification;
use App\Notifications\Comment;

class CommentController extends Controller
{
     public function newComment(Request $request) {

        // Get User ID
        $user_Id = Auth::id();
        $event_Id = $request->input('event_Id');
        // Get comment text from input

        $comment_Text = $request->input('comment_Text');
        // Get File ID
        $file_Id = $request->input('file_Id');

        $data=array('user_Id'=>Auth::id(), 'comment_Text'=>$comment_Text, 'file_Id'=>$file_Id);
        DB::table('comments')->insert($data);
        
        
        $usercommented = DB::table('comments')
            ->where('file_Id', $file_Id)
            ->pluck('user_Id');
            
        $usercommented = $usercommented->unique();
        foreach($usercommented as $user_Id){
            if($user_Id != Auth::id()){
                $user = User::where('user_Id', $user_Id)->first();
                Notification::send($user, new Comment($data));
            }
        }
      
        return back();
    }
    
   
    public function deleteComment(Request $request) {
        // Get User ID
        $user_Id = Auth::id();
        // Get comment_Id
        $comment_Id = $request->input('comment_Id');
        
        // getting information from comment_Id
        $verify = DB::table('comments')
            ->where('comment_Id', '=', $comment_Id)
            ->first();
          
        // verify if user is owner of comment if yes delete comment 
        if($verify->user_Id == $user_Id){
            DB::table('comments')
                ->where('comment_Id', '=', $comment_Id)
                ->delete();
        }else{
            die ("You are not the owner of this comment");
            
        }
        return back();
    }
}
