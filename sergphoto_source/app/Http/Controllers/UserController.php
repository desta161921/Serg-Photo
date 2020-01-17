<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use File;

class UserController extends Controller {
    public function viewProfile($userId = null) {
        $user = null;
            if($userId != null) {
                $user = \App\User::find($userId);
            } else {
                $user = \App\User::find(Auth::user()->id);
            }
    
        if ($user != null) {
            return view('profile', [
                'user' => $user
            ]);
        } else {
            return redirect('error')->with('error', 'User does not exist.');
        }
    }
    
    public function currentProfile() {
        $user = Auth::user();
        if (Auth::check()) {
        return view('profile', [
                'user' => $user
            ]); 
        }else{
            return redirect('error')->with('error', 'Login to see your profile');
        }
    }
    
    public function update(Request $request) { 
        
        //Getting info from form
        $profession = $request->input('profession');
        $DOB = $request->input('DOB');
        $hobby = $request->input('hobby');
        $location = $request->input('location');
        
        //Finding users row then updating it.
        DB::table('users')
            ->where('user_Id', Auth::id())
            ->update(['profession'=>$profession, 'DOB'=>$DOB, 'hobby'=>$hobby, 'location'=>$location]);
        
        return redirect('profile');
    }
    
    public function update_Avatar(Request $request) {
        // Handles the user upload of avatar
        if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(500, 500)->save(public_path('/uploads/avatars/' . $filename));
            $user = Auth::user();
            
            // Checks if user already have an avatar uploaded, then if so,
            // deletes the old one
            // skips if user has default avatar
            if($user->avatar != 'default-avatar.png') {
                $file = '/uploads/avatars/' . $user->avatar;
                if(File::exists(public_path($file))) {
                    unlink(public_path($file));
                }
            }
            
            //sets filename on users row on database.
            $user->avatar = $filename;
            $user->save();
        }
        return view('editprofile', array('user' => Auth::user()));
    }
    
    public function delete_Avatar(Request $request) {
        
        $user = Auth::user();
        
        //Delete user avatar if not default avatar.
        if($user->avatar != 'default-avatar.png') {
            $file = '/uploads/avatars/' . $user->avatar;
            if(File::exists(public_path($file))) {
                unlink(public_path($file));
            }
            
            $default_avatar = 'default-avatar.png';
            $user->avatar = $default_avatar;
            $user->save();
        }
        return redirect('editprofile');
    }
    
    
    /*
    public function updateProfile(Request $request) {
        // Fetching the user
        $user = Auth::user();
        
        $this->validate($request, [
           'first_Name' => 'required|max:255|unique:user, first_Name, ' . $user->id,
           'last_Name' => 'required|max:255|unique:user, last_Name, ' . $user->id,
           'schoolname' => 'required|max:255|unique:user, schoolname, ' . $user->id,
           'class' => 'required|max:255|unique:user, class, ' . $user->id,
           'location' => 'required|max:255|unique:user, location, ' . $user->id,
           'hobby' => 'required|max:255|unique:user, hobby, ' . $user->id,
        ]);
        
        $input = $request->only('first_Name', 'last_Name', 'schoolname', 'class', 'location', 'hobby');
        
        $user->update($input);
        
        return back();
    } */
    
    public function deleteUser() {
        
        //checking which event user are admin on
        $checkEvent = DB::table('participants')
                ->where('user_Id', Auth::id())
                ->where('participant_Role', 'Admin')
                ->orderBy('event_Id', 'desc')
                ->get();
        
        //checks if this user is the only admin on the event
        foreach ($checkEvent as $eventId) {
            $event = DB::table('participants')
            ->where('event_Id', $eventId->event_Id)
	    ->where('participant_Role', "Admin")
            ->count();
            
            //delete all participants on event and event if only one admin
            if($event == 1){
                //DB::table('participants')->where('event_Id', '=', $eventId->event_Id)->delete();
                
		// Delete event header if not standard header
            	$event = \App\Event::find($eventId->event_Id);
		
            	if (($event->event_Header != 'wedding-default.png') && ($event->event_Header != 'party-default.png')) {
			$file = '/uploads/events/' . $event->event_Header;
                	if (File::exists(public_path($file))) {
                    		unlink(public_path($file));
                	}
           	}	
	
		//Delete the event directory and files inside.
		File::deleteDirectory(public_path('uploads/events/' . $eventId->event_Id));
	        
		// Delete files from event directory in database
		DB::table('files')
                	->where('event_Id', '=', $eventId->event_Id)
                	->delete();

		//Delete the event from database.
                DB::table('events')
                    ->where('event_Id', '=', $eventId->event_Id)
                    ->delete();
            }	
        }
        
        //Deleting all rows in participant with current user.
        DB::table('participants')->where('user_Id', '=', Auth::id())->delete();
        
        //Delete all comments for the files user are owner.
        $photos = DB::table('files')->where('user_Id', '=', Auth::id())->get();
        
        foreach ($photos as $photo){
            DB::table('comments')->where('file_Id', $photo->file_Id)->delete();
        }
        
        //Delete all likes for the files user are owner.
        $photos = DB::table('files')->where('user_Id', '=', Auth::id())->get();
        
        foreach ($photos as $photo){
            DB::table('reacts')->where('file_Id', $photo->file_Id)->delete();
        }
        
        //Delete all rows in files where user is owned
        DB::table('files')->where('user_Id', '=', Auth::id())->delete();
        
        //delete all rows in comments where user is the commenter.
        DB::table('comments')->where('user_Id', '=', Auth::id())->delete();
        
        //Find user then deleting users avatar file and user row.
        $user = Auth::user();
        
	//Skip delete avatar if user are using default avatar.
        if ($user->avatar != 'default-avatar.png') {
            $file = 'uploads/avatars/' . $user->avatar;

            if (File::exists($file)) {
                unlink($file);
            }
        }

        $user->delete();

       return redirect('index');
        
        
    }
    
    public function uploadProfileImages(Request $request) {
        
        //get user from form
        $user_Id = Auth::id();
        
        
        if($request->hasFile('profileImages')) {
            // Function to handle user uploads in feed
            $profilePhotos = $request->file('profileImages');
            $filename = time() . '.' . $profilePhotos->getClientOriginalExtension();
            $album_Id = $request->input('album_Id');
            $file_Description = $request->input('file_Description');
            $file_Location = $request->input('file_Location');
            
            $album = DB::table('albums')->where('user_Id', Auth::id())->where('album_Id', $album_Id)->first();
            
            $background = Image::canvas(1000, 1000, '#000');
            
            $image = Image::make($profilePhotos)->resize(1000, 1000, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            
            $background->insert($image, 'center');
            
            $background->save(public_path('/uploads/users/' . $user_Id . "/" . $album->album_Name . '/' . $filename));
         
            if(!$album->album_Name == "") {
                $data=array('user_Id'=>Auth::id(), 'album_Id'=>$album->album_Id, 'file_Name'=>$filename, 'file_Description'=>$file_Description,
                'file_Location'=>$file_Location, 'file_URL'=>$filename, 'file_Permission'=>'Public');
                DB::table('files')->insert($data);
            
                return back()->withInput();
            } else {
                return back();
            }
        } else {
            return back()->withInput();
        }
    }
    
    public function sendWelcomeMail() {
        
    }
}
