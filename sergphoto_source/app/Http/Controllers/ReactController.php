<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class ReactController extends Controller
{
    
    public function plusOne(Request $request) {
    
        // If user click a button containing the FILE_ID the NUMBER is incremented by 1.
        $user_Id = Auth::id();
        $button = $request->input('plusOneLike');
        $file_Id = $request->input('file_Id');
        
        //If user already liked the photo this function will delete it (Unlike it).
        if(!DB::table('reacts')->where('user_Id',Auth::id())->where('file_Id',$file_Id)->exists()) {
            $data=array('user_Id'=>Auth::id(), 'react_Type'=>$button, 'file_Id'=>$file_Id);
            DB::table('reacts')->insert($data);
        } else {
            DB::table('reacts')->where('user_Id',Auth::id())->where('file_Id',$file_Id)->delete();    
        }
        
        return back();
    }
    
}
