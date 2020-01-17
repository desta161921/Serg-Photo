<?php

namespace App\Social;

use App\User;
use Exception;
use Session;
use DB;
use File;

class GoogleServiceProvider extends AbstractServiceProvider
{
   /**
     *  Handle Facebook response
     *  @return Illuminate\Http\Response
     */
    public function handle()
    {
        $user = $this->provider->stateless()->user([
                'name',
                'email',
                'gender',
                ]);
                
        
        /* if (User::where('provider', '=', Input::get('email'))->exists()) {
            echo "this email is already used";
        } 

        if (User::where('provider')->exists()){
            if  (User::where('provider') != 'google'){
                echo "this email is already used";
                die;
            }
        }*/
        
        
        $existingUser = User::where('provider_id', $user->id)->first();

        if ($existingUser) {
            $settings = $existingUser->provider_id;

            if (! isset($settings)) {
                $settings = $user->id;
                $existingUser->provider_id = $settings;
                $existingUser->save();
            }

            return $this->login($existingUser);
        }
        
        if (User::where('email', $user->email)->first()){
            echo "this email is already used";
            die;
        }
        
        //check if user has defined gender in array.
        if (isset($user->user['gender'])){
            $gender = $user->user['gender'];
        } else {
            $gender = "unknown";
        }
        // dd($user);
        $newUser = $this->register([
            'first_Name' => $user->user['name']['givenName'],
            'last_Name' => $user->user['name']['familyName'],
            'gender' => $gender,
            'provider' => 'google',
            'provider_id' => $user->id,
            'email' => $user->email,
        ]);
        
        $user_Id = DB::table('users')
            ->where('email', $user->email)
            ->first();
        
        //check if session token exist if yes add user to event
        if(Session::get('token') != null){
            $token = Session::get('token');
            
            $event_Id = DB::table('invites')
                ->where('token', $token)
                ->first();
                
            
            DB::table('participants')->insert(
                ['user_Id' => $user_Id->user_Id, 'event_Id' => $event_Id->event_Id, 'participant_Role' => 'User']);
                
            DB::table('invites')
            ->where('token', $token)
            ->delete();
            
            session()->forget('token');
        }
        
        File::makeDirectory(public_path('/uploads/users/' . $user_Id->user_Id));
        
        File::makeDirectory(public_path('/uploads/users/' . $user_Id->user_Id . '/' . $user_Id->first_Name . "'s album"));
    
        DB::table('albums')->insert(
                ['user_Id' => $user_Id->user_Id, 'album_Name' => $user_Id->first_Name . "'s album", 'album_Permission' => 'Public', 'album_Description' => 'Album for feed photos']);


        return $this->login($newUser);
    }
}