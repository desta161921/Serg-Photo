<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use File;

class AlbumController extends Controller {
    public function createAlbum(Request $request) {
        //get user id
        $user_Id = Auth::id();
        $album_Name= $request->input('album_Name-input');
        $album_Priv = $request->input('album_Privacy');
        $album_Desc = $request->input('album_Description');
        
        //make an array with information
        $data=array('user_Id'=>Auth::id(), 'album_Name'=>$album_Name, 'album_Description'=>$album_Desc,
            'album_Permission'=>$album_Priv);
        
        //Checks if user has an album with same name.
        if(DB::table('albums')->where('user_Id', Auth::Id())->where('album_Name', $album_Name)->exists()){
            die("Album name has to be unique.");
        }
        
        //Insert the array on albums table    
        DB::table('albums')->insert($data);
        
        // create directory
        File::makeDirectory(public_path('/uploads/users/' . $user_Id .'/'. $album_Name));
        
        return back();
    }
    
    public function viewAlbum($album_Id = null) {
        
        //Get album id from url then shows album
        $album = DB::table('albums')->where('album_Id', $album_Id)->first();
        if(DB::table('albums')->where('album_Id', $album_Id)->exists()) {
            return view('album', [
                'album' => $album
            ]);
        } else {
            return redirect('error')->with('error', 'Album does not exist.');
        }
    }
    
    public function updateAlbum(Request $request) {
        
        //Get input from form
        $album_Id = $request->input('album_Id');
        $album_Priv = $request->input('album_Privacy');

        //Update privacy on event
        DB::table('albums')
            ->where('album_Id', $album_Id)
            ->update(['album_Permission' => $album_Priv]);
            
        return back();
        
    }
    
    public function deleteAlbum(Request $request) {
        //get user input
        $user = DB::table('users')->where('user_Id', Auth::id())->first();
        $album_Id = $request->input('album_Id');
        $album = DB::table('albums')->where('album_Id', $album_Id)->first();

        // Delete files on album
        File::deleteDirectory(public_path('/uploads/users/' . $user->user_Id .'/'. $album->album_Name));
        
        //Delete comments and reacts from DB
        $files = DB::table('files')->where('user_Id', $user->user_Id)->where('album_Id', '=', $album_Id)->get();
        foreach($files as $file){
            DB::table('comments')->where('file_Id', $file->file_Id)->delete();
            DB::table('reacts')->where('file_Id', $file->file_Id)->delete();
        }
        
        // Delete files AND album from DB
        DB::table('files')->where('user_Id', $user->user_Id)->where('album_Id', '=', $album_Id)->delete();
        DB::table('albums')->where('user_Id', $user->user_Id)->where('album_Id', '=', $album_Id)->delete();
        
        return back();
    }
    
    
}