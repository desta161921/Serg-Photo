<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\People;
use App\Invite;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Notifications\Notifiable;
use App\Notifications\InvitedToEvent;
use Notification;
use App\User;

class InviteController extends Controller{
    
    public function invite(){
        return view('invite');
    }
  
    public function process(Request $request){
        // validate the incoming request data
        do {
            //generate a random string using Laravel's str_random helper
            $token = str_random();
        }
        //check if the token already exists and if it does, try again
        while (Invite::where('token', $token)->first());
        
        //create a new invite record
        $event = DB::table('events')->where('event_Id', '=', $request->get('event_Id'))->first();
        
        //Checks if event already invited this email
        if (!DB::table('invites')->where('event_Id', $event->event_Id)->where('email', $request->get('search'))->exists()){
            
            $invite = Invite::create([
                'email' => $request->get('search'),
                'event_Id' => $event->event_Id,
                'event_Name' => $event->event_Name,
                'token' => $token
            ]);
            
            // send the email
            Mail::to($request->get('search'))->send(new InviteCreated($invite));
            
            // send notification if user exsist
            if (DB::table('users')->where('email', $request->get('search'))->exists()){
                $user = User::where('email', $request->get('search'))->first();
                
                $information = array([
                    'event_Name' => $event->event_Name,
                    'event_Id' => $event->event_Id,
                    'token' => $token
                ]);
                
                Notification::send($user, new InvitedToEvent($information));
            }
            
            // redirect back where we came from
            return back();
        }else{
            return back();
        }
    }
  
    public function accept($token){
        // Look up the invite
        if (!$invite = Invite::where('token', $token)->first()) {
            //if the invite doesn't exist do something more graceful than this
            abort(404);
        }

        //    
        $url = url('/inviteregistration/'.$token);
        // create the user with the details from the invite
        
        // delete the invite so it can't be used again
        $invite->delete();
        // here you would probably log the user in and show them the dashboard, but we'll just prove it worked
        return redirect($url);
    }
}