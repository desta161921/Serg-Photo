<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;
use DB;
use File;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_Name' => 'required|string|max:255',
            'last_Name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'DOB' => 'required|date',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        

        $user = User::create([
            'first_Name' => $data['first_Name'],
            'last_Name' => $data['last_Name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'DOB' => $data['DOB'],
            'gender' => $data['gender'],
        ]);
        
        $user_Id = DB::table('users')
            ->where('email', $data['email'])
            ->first();
        
        if(isset($data['token'])){
            $event_Id = DB::table('invites')
                ->where('token', $data['token'])
                ->first();
                
            
            DB::table('participants')->insert(
                ['user_Id' => $user_Id->user_Id, 'event_Id' => $event_Id->event_Id, 'participant_Role' => 'User']);
                
            DB::table('invites')
            ->where ('token', $data['token'])
            ->delete();
            

        }
        
        // create directory
        File::makeDirectory(public_path('/uploads/users/' . $user_Id->user_Id));
        
        File::makeDirectory(public_path('/uploads/users/' . $user_Id->user_Id . '/' . $user_Id->first_Name . "'s album"));
    
        DB::table('albums')->insert(
                ['user_Id' => $user_Id->user_Id, 'album_Name' => $user_Id->first_Name . "'s album", 'album_Permission' => 'Public', 'album_Description' => 'Album for feed photos']);
    
        Mail::to($data['email'])->send(new Welcome($user));
        
        return $user;
    }
}
