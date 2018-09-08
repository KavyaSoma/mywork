<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use session;
use Calendar;
use App\Event;
class ClubController extends Controller
{
 public function eventClub(Request $request){
    $clubid = $request->session()->get('user_id');
    $event_details = DB::table('events')
    ->DISTINCT('events.EventName')
    ->selectRaw('*,EventName')
    ->JOIN('bridgeeventclubs','events.EventId','=','bridgeeventclubs.EventId')
    ->where('bridgeeventclubs.ClubId','=',$clubid)
    ->paginate(10);
    if(count($event_details)>0){
    foreach($event_details as $event){
        $heat = DB::select('select SubEventId,HeatName from eventheats where EventId=?',[$event->EventId]);
    }
    if(count($heat)>0){
    return view('eventclub',['event_details'=>$event_details,'heat'=>$heat]);
    }
    else{  $heat=array();
        return view('eventclub',['event_details'=>$event_details,'heat'=>$heat]);
    }
    }
    else{
        $event_details=array();
        $heat=array();
        return view('eventclub',['event_details'=>$event_details,'heat'=>$heat]);
    }
 }