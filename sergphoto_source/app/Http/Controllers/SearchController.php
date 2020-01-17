<?php

namespace App\Http\Controllers;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller {
    use Searchable;
    
    public function search(Request $request) {
        $eventId = $request->event_Id;
        if($request->ajax()) {
            $output = "";
            $users = DB::table('users')->where('first_Name', 'LIKE', '%'.$request->search."%")->get();
            $eventId = $request->event_Id;
            if($users) {
                foreach($users as $key => $user) {
                    if(!DB::table('participants')->where('user_Id', '=', $user->user_Id)->where('event_Id','=', $eventId)->exists()){
                        $output.= '<tr>'.
                        '<td>' .$user->first_Name .'</td>'.
                        '<td>' .$user->last_Name .'</td>'.
                        '<td>Not member</td>'.
                        '<td> <form action="/inviteToEvent" method="POST" value="'.csrf_token().'"> '.
                        csrf_field().
                        '<input type="submit" value="Invite">'.
                        '<input type="hidden" name="user_Id" value="'.$user->user_Id.'">'.
                        '<input type="hidden" name="event_Id" value="'.$eventId.'">'.
                        '</form></td>'.
                        '</tr>';
                    }else{
                        if(DB::table('participants')->where('user_Id', '=', $user->user_Id)->where('event_Id','=', $eventId)->first()->participant_Role == "User"){
                            $output.= '<tr>'.
                            '<td>' .$user->first_Name .'</td>'.
                            '<td>' .$user->last_Name .'</td>'.
                            '<td>' .DB::table('participants')->where('user_Id', '=', $user->user_Id)->where('event_Id','=', $eventId)->first()->participant_Role .'</td>'.
                            '<td> <form action="/setRole" method="POST" value="'.csrf_token().'"> '.
                            csrf_field().
                            '<input id="setRole" type="submit" value="Upgrade to admin">'.
                            '<input name="delete" id="delete" type="submit" value="Delete">'.
                            '<input type="hidden" name="user_Id" value="'.$user->user_Id.'">'.
                            '<input type="hidden" name="event_Id" value="'.$eventId.'">'.
                            '</form></td>'.
                            '</tr>';
                        }else{
                            $output.= '<tr>'.
                            '<td>' .$user->first_Name .'</td>'.
                            '<td>' .$user->last_Name .'</td>'.
                            '<td>' .DB::table('participants')->where('user_Id', '=', $user->user_Id)->where('event_Id','=', $eventId)->first()->participant_Role.'</td>'.
                            '<td> <form action="/setRole" method="POST" value="'.csrf_token().'"> '.
                            csrf_field().
                            '<input id="setRole" type="submit" value="Downgrade user">'.
                            '<input name="delete" id="delete" type="submit" value="Delete">'.
                            '<input type="hidden" name="user_Id" value="'.$user->user_Id.'">'.
                            '<input type="hidden" name="event_Id" value="'.$eventId.'">'.
                            '</form></td>'.
                            '</tr>';
                        }
                    }
                }
                return Response($output);
            }
        }
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(Request $request) {
        // $searchValue is the name of the search input form in header
        $search = $request->input('searchValue');
        
        $userquery = DB::table('users');
        if($search != '') {
            $userquery->where(function ($userquery) use ($search) {
                $userquery->where("first_Name", "LIKE", "%$search%");
            });
        } else {
            $userquery = 'empty';
        }
        
        $eventquery = DB::table('events');
        
        if($search != '') {
            $eventquery->where(function($eventquery) use ($search) {
                $eventquery->where("event_Name", "LIKE", "%$search%");
            });
        } else {
            $eventquery = 'empty';
        }

        return view('usersearchlist', [
            'userquery' => $userquery,
            'eventquery' => $eventquery
        ]);
    }
}