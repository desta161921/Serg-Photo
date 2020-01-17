<?php

namespace App\Social;

use App\User;
use Exception;
use Session;
use DB;
use File;

class FacebookServiceProvider extends AbstractServiceProvider
{
   /**
     *  Handle Facebook response
     * 
     *  @return Illuminate\Http\Response
     */
    public function handle()
    {
	//dd($this->provider->fields(['email']));
        $user = $this->provider->fields([
                    'first_name',
		    'last_name', 
                    'email',
                    //'gender',
                    //'user_birthday',
                ])->user();
     	       
         /*     if (User::where('provider')->exists()){
                if  (User::where('provider') != 'facebook'){
                echo "this email is already used";
                die;
            }
        }*/
        $existingUser = User::where('provider_id', $user->id)->first();

        if ($existingUser) {
            $settings = $existingUser->settings;

            if (! isset($settings['facebook_id'])) {
                $existingUser->provider_id = $user->id;
                $existingUser->provider = 'facebook';
                $existingUser->save();
            }

            return $this->login($existingUser);
        }
        
        if (User::where('email', $user->email)->first()){
            echo "this email is already used";
            die;
        }


        $newUser = $this->register([
            'first_Name' => $user->user['first_name'],
            'last_Name' => $user->user['last_name'],
            'email' => $user->email,
            //'gender' => $user->user['gender'],
            //'DOB' => $user->user['user_birthday'],
            'provider' => 'facebook',
            'provider_id' => $user->id
            ]);
            
        $user_Id = DB::table('users')
            ->where('email', $user->email)
            ->first();
            
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
