<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use File;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Notification;
use App\Notifications\EventPhoto;

class UploadController extends Controller {

	public function uploadImage(Request $request) {
        // GLOBAL VARIABLES
        $user = DB::table('users')->where('user_Id', Auth::id())->first();
        $file_Description = $request->input('file_Description');
        $file_Location = $request->input('file_Location');
        $filter = $request->input('filter');
        
        if($request->hasFile('feed__photo')) {
            // UPLOAD TO FEED
            $feedPhoto = $request->file('feed__photo');
            $filename = time() . '.' . $feedPhoto->getClientOriginalExtension();

            $background = Image::canvas(1000, 1000, '#000');
            
            $img = Image::make($feedPhoto)->resize(1000, 1000, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            
            $img = $this->filter($filter, $img);
            
            $background->insert($img, 'center');
            
            $background->save(public_path('/uploads/users/' . $user->user_Id . '/' . $user->first_Name . "'s album" . '/' . $filename));
	        
	        $album_Id = DB::table('albums')->where('user_Id',Auth::id())->first();
	       
            $data=array('user_Id'=>Auth::id(), 'file_Name'=>$filename, 'file_Description'=>$file_Description, 'album_Id'=>$album_Id->album_Id,
            'file_URL'=>$filename, 'file_Location'=>$file_Location, 'file_Permission'=>'Public');
            
            DB::table('files')->insert($data);
            
            return back()->withInput();
            
        } elseif($request->hasFile('profileImages')) {
            // UPLOAD TO PROFILE
            $user_Id = Auth::id();
            $profilePhotos = $request->file('profileImages');
            $filename = time() . '.' . $profilePhotos->getClientOriginalExtension();
            $album_Id = $request->input('album_Id');
            $album = DB::table('albums')->where('user_Id', Auth::id())->where('album_Id', $album_Id)->first();
            
            $background = Image::canvas(1000, 1000, '#000');
            
            $img = Image::make($profilePhotos)->resize(1000, 1000, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            
            $img = $this->filter($filter, $img);
            
            $background->insert($img, 'center');
            
            $background->save(public_path('/uploads/users/' . $user_Id . "/" . $album->album_Name . '/' . $filename));
            
            if(!$album->album_Name == "") {
                $data=array('user_Id'=>Auth::id(), 'album_Id'=>$album->album_Id, 'file_Name'=>$filename, 'file_Description'=>$file_Description,
                'file_Location'=>$file_Location, 'file_URL'=>$filename, 'file_Permission'=>'Public');
                DB::table('files')->insert($data);
            
                return back()->withInput();
            } else {
                return back();
            }
            
        } elseif($request->hasFile('eventImages')) {
            // UPLOAD TO EVENTS
            $event_Id = $request->input('event_Id');
            $eventPhoto = $request->file('eventImages');
            $filename = time() . '.' . $eventPhoto->getClientOriginalExtension();
            
            $background = Image::canvas(1000, 1000, '#000');
            
            $img = Image::make($eventPhoto)->resize(1000, 1000, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            
            
            
            $img = $this->filter($filter, $img);
            
            $background->insert($img, 'center');
            
            $background->save(public_path('/uploads/events/' . $event_Id . "/" . $filename));
            
            $data=array('user_Id'=>Auth::id(), 'event_Id'=>$event_Id, 'file_Name'=>$filename, 'file_Description'=>$file_Description,
            'file_Location'=>$file_Location, 'file_URL'=>$filename, 'file_Permission'=>'Public');
            DB::table('files')->insert($data);
            
            $participants = DB::table('participants')
                ->where('event_Id', $event_Id)
                ->get();
            
            $event = DB::table('events')
                ->where('event_Id', $event_Id)
                ->first();
                
            foreach($participants as $participant){
                if($participant->user_Id != Auth::id()){
                    $user = User::where('user_Id', $participant->user_Id)->first();
                    Notification::send($user, new EventPhoto($event));
                }
            }
            return back()->withInput();
                
        } else {
            return back();
        }
    }
    
    public function filter($filt, $i) {
        $filter = $filt;
        $img = $i;
        // FILTER
        if($filter == "Grayscale"){
            $img->greyscale();
        } elseif($filter == "Sepia"){
            $img->greyscale();
            $img->brightness(-10);
            $img->contrast(10);
            $img->colorize(38, 27, 12);
            $img->brightness(-10);
            $img->contrast(10);
        } elseif($filter == "Saturate"){
            
        } elseif($filter == "Hue"){
            
        } elseif($filter == "Invert"){
            $img->invert();
        } elseif($filter == "Opacity"){
            $img->opacity(50);
        } elseif($filter == "Brighty"){
            $img->brightness(50);
        } elseif($filter == "Contrast"){
            $img->contrast(100);
        } elseif($filter == "Blurry"){
                
        }
        
        return $img;
    }
}