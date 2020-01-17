<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use Exception;
use App\Invite;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Session;

class EventController extends Controller {
    
    public function showEvents() {
        $events = DB::table('event')->paginate(5);
        return view('events', ['event' => $events]);
    }
    
    public function viewEventList() {
        // Return view over events
        return view('eventlist');
    }
    
    public function createEvent(Request $request) {
        
        //Getting information from form
        $event_name = $request->input('event_Name');
        $event_type = $request->input('event_Type');
        $event_desc = $request->input('event_Description');
        $event_loc = $request->input('event_Location');
        $event_priv = $request->input('event_Privacy');
        $eventHeader = $request->file('event_Header');
        
        // Set default header for event
        if($event_type == 'Wedding') {
            $filename = ('wedding-default.png');
        } elseif($event_type == 'Party') {
            $filename = ('party-default.png');
        }
        
        // Create header for event
        if($request->hasFile('event_Header')) {
            $filename = time() . '.' . $eventHeader->getClientOriginalExtension();
            Image::make($eventHeader)->resize(1000, 1000)->save(public_path('/uploads/events/' . $filename));
        }
        
        //Creating array then inserting it to table events.
        $data=array('event_Name'=>$event_name, 'event_Type'=>$event_type, 'event_Description'=>$event_desc, 'event_Location'=>$event_loc,
            'event_Privacy'=>$event_priv, 'event_Header'=>$filename);
        DB::table('events')->insert($data);
        
        //Adding user creating event as admin for event on table participants.
        $eventId = DB::table('events')->orderBy('event_Id', 'desc')->first();
        $userId = Auth::id();
        $data1=array('event_Id'=> $eventId->event_Id, 'user_Id'=> $userId, 'participant_Role'=>'Admin');
        DB::table('participants')->insert($data1);
        
        File::makeDirectory(public_path('uploads/events/' . $eventId->event_Id));
        
        return redirect('events');
    }

    public function viewEvents($eventId = null) {
        
        // Return view event when clicked on
        $event = null;
        if($eventId != null) {
            $event = \App\Event::find($eventId);
        } else {
            $user = \App\Event::find(Auth::event()->id);
        }
    
        if ($event != null) {
            if (Auth::check()) {
                return view('events', [
                    'event' => $event
                ]);
            }else{
                return redirect('error')->with('error', 'Login to see the event.');
            }
        } else {
            return redirect('error')->with('error', 'Event does not exist.');
        }
    }
    
    public function editEvent($eventId = null) {
        
        // Edit events
        $event = null;
        if($eventId != null) {
            $event = \App\Event::find($eventId);
        } else {
            $user = \App\Event::find(Auth::event()->id);
        }
    
        if($event != null) {
            return view('editevent', [
                'event' => $event
            ]);
        } else {
            return redirect('error')->with('error', 'Event does not exist.');
        }
    }
    
    public function updateEvent(Request $request) {
        
        //Getting info from form.
        $event_Id = $request->input('event_Id');
        $event_name = $request->input('event_Name');
        $event_type = $request->input('event_Type');
        $event_desc = $request->input('event_Description');
        $event_loc = $request->input('event_Location');
        $event_priv = $request->input('event_Privacy');
        
        //Finding current event and then update it.
        DB::table('events')
            ->where('event_Id', $event_Id)
            ->update(['event_Name'=>$event_name, 'event_Type'=>$event_type, 'event_Description'=>$event_desc,
                'event_Location'=>$event_loc, 'event_Privacy'=>$event_priv]);
        
        return redirect('events');
    }
    
    public function update_Header(Request $request) {
        
        // Handle the user upload for header on eventpage
        if($request->hasFile('event-header')) {
            $eventId = $request->input('eventId');
            $event = \App\Event::find($eventId);
            if ($event->event_Header != 'default-avatar.png') {
                $file = '/uploads/events/' . $event->event_Header;
                if (File::exists(public_path($file))) {
                    unlink(public_path($file));
                }
            }
            $eventHeader = $request->file('event-header');
            $filename = time() . '.' . $eventHeader->getClientOriginalExtension();
            Image::make($eventHeader)->resize(1000, 1000)->save(public_path('/uploads/events/' . $filename));
            $event->event_Header = $filename;
            $event->save();
            
            return back()->withInput();
        } else {
            return back()->withInput();
        }
    }
    
    public function joinEvent(Request $request) {
        
        // Join events
        $event_Id = $request->input('event_Id');

        DB::table('participants')
            ->insert(['user_Id' => Auth::id(), 'event_Id' => $event_Id, 'participant_Role' => 'User']);
        
        return back()->withInput();
    }
    
    public function leaveEvent(Request $request) {
        
        //Get event id
        $event_Id = $request->input('event_Id');
        
        //Find amount of admins on event
        $checkEvent = DB::table('participants')
            ->where('event_Id', "=", $event_Id)
            ->where('participant_Role', "=", "Admin")
            ->get()
            ->count();
        
        //if one admin
        if($checkEvent == 1){
            //check if you are the only admin
            $checkEvent1 = DB::table('participants')
                ->where('user_Id', "=", Auth::id())
                ->where('event_Id', "=", $event_Id)
                ->where('participant_Role', "=", "Admin")
                ->get()
                ->count();
            if($checkEvent1 == 1){
                return redirect()->back()->with('alert', 'you are the only admin. Delete event instead of leave it.');
            }
        }
        
        DB::table('participants')
            ->where('user_Id', "=", Auth::id())
            ->where('event_Id', "=", $event_Id)
            ->delete();
        
        return redirect('events');
    }
    
    public function deleteEvent(Request $request) {
        
        // Leave event
        $event_Id = $request->input('event_Id');
        
        $checkAdmin = DB::table('participants')
            ->where('user_Id', "=", Auth::id())
            ->where('event_Id', "=", $event_Id)
            ->where('participant_Role', "=", "Admin")
            ->get()
            ->count();
            
            
        // Check if user is admin of event
        if($checkAdmin == 1){
            
                
            // Remove directory of files from database
            File::deleteDirectory(public_path('uploads/events/' . $event_Id));
            
            // Delete event header if not standard header
            $event = \App\Event::find($event_Id);
            if (($event->event_Header != 'wedding-default.png') && ($event->event_Header != 'party-default.png')) {
		$file = '/uploads/events/' . $event->event_Header;
                if (File::exists(public_path($file))) {
                    unlink(public_path($file));
                }
            }
            // Delete participant list to event
            DB::table('participants')
                ->where('event_Id', "=", $event_Id)
                ->delete();
            
            // Delete files from event directory in database
            DB::table('files')
                ->where('event_Id', '=', $event_Id)
                ->delete();
            
            // Delete event from database
            DB::table('events')
                ->where('event_Id', "=", $event_Id)
                ->delete();
        } else {
            return redirect('error')->with('error', 'You are not admin.');
        }
        return redirect('events');
    }
    
    // PROJECT invite users to event underneath // Author: Doni29 Jondiz
    
    public function inviteToEvent(Request $request){
        $event_Id = $request->input('event_Id');
        $token = $request->input('token');
        
        DB::table('participants')->insert(
        ['user_Id' => Auth::id(), 'event_Id' => $event_Id, 'participant_Role' => 'User']);
      
        DB::table('invites')
            ->where('token', '=', $token)
            ->delete();
        
        return redirect('/events/' . $event_Id);
    }
    
    public function inviteByEmail(Request $request){
        $email = strip_tags($request->input('search'));
        die ("mail sent to " .$email);
    }
    
    public function setRole(Request $request) {
        $user_Id = $request->input('user_Id');
        $event_Id = $request->input('event_Id');
        $deleteFunc = $request->input('delete');
        
        if($deleteFunc == "Delete"){
            if(DB::table('participants')->where('user_Id', '=', $user_Id)->where('event_Id','=', $event_Id)->first()->participant_Role == "Admin"){ 
                return back();
            } else {
                DB::table('participants')
                ->where(['user_Id' => $user_Id, 'event_Id' => $event_Id])
                ->delete();
            }
        } else {
            if(DB::table('participants')->where('user_Id', '=', $user_Id)->where('event_Id','=', $event_Id)->first()->participant_Role == "User"){
                DB::table('participants')
                ->where(['user_Id' => $user_Id, 'event_Id' => $event_Id, 'participant_Role' => 'User'])
                ->update(['participant_Role' => 'Admin']);
            } else {
                DB::table('participants')
                ->where(['user_Id' => $user_Id, 'event_Id' => $event_Id, 'participant_Role' => 'Admin'])
                ->update(['participant_Role' => 'User']);
            }
        }
        return back();
    }
    
    public function deletePhoto(Request $request) {
        $user_Id = $request->input('user_Id');
        $event_Id = $request->input('event_Id');
        $file = $request->input('file_Name');
        
        $file_Name = basename($file);
        
        if (File::exists(public_path($file))) {
            unlink(public_path($file));
        }
        
        DB::table('files')
                ->where('event_Id', '=', $event_Id)
                ->where('user_Id', "=", $user_Id)
                ->where('file_Name', '=', $file_Name)
                ->delete();
                
        return back();
    }
    
    public function viewInvitation($eventId = null) {
        
        // Return view event when clicked on
        $event = null;
            if($eventId != null) {
                $event = \App\Event::find($eventId);
            } else {
                $user = \App\Event::find(Auth::event()->id);
            }
    
        if ($event != null) {
            return view('invitation/view', [
                'event' => $event
            ]);
        } else {
            return redirect('error')->with('error', 'Event does not exist.');
        }
    }
    
    public function editInvitation($eventId = null) {
        
        // Return view event when clicked on
        $event = null;
            if($eventId != null) {
                $event = \App\Event::find($eventId);
            } else {
                $user = \App\Event::find(Auth::event()->id);
            }
    
        if ($event != null) {
            return view('invitation/edit', [
                'event' => $event
            ]);
        } else {
            return redirect('error')->with('error', 'Event does not exist.');
        }
    }
            
    public function saveInvitation(Request $request) {
        
        $event_Id = $request->event;
        $img = Image::make($request->imgBase64);
        $imgtext = "$request->imgBase64";
        $img->save(public_path('uploads/events/' . $event_Id . "/invitation.png"));
        
        return back();
        
    }
    
    public function deleteInvitation(Request $request) {
        //get token from form
        $token = $request->input('invite_token');
        
        //get info of invite that's going to be deleted
        $invite = DB::table('invites')
            ->where('token', '=', $token)
            ->first();
        
        //taking email from it        
        $email = $invite->email;
        
        //delete the row
        DB::table('invites')
            ->where('token', '=', $token)
            ->delete();
        
        //return with message        
        return redirect()->back();
        
        
    }
}
