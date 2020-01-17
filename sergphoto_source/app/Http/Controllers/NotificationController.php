<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Notification;
use Illuminate\Notifications\Notifiable;
use DB;
use auth;

class NotificationController extends Controller{
    public function deleteNotification(Request $request) {
        $notification = $request->notification;
        
        
        if($notification == 'all'){
            //if delete all button is used all notification for the user.
            DB::table('notifications')
                ->where('notifiable_id', Auth::id())
                ->delete();
            
            return back();
        }else{
            //if normal delete notification is used the selected notification will be deleted.
            DB::table('notifications')
            ->where('id', "=", $notification)
            ->delete();
        
            return back();
        }
    }
}

