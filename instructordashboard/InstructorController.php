<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Calendar;
use App\Event;
use Mail;

class InstructorController extends Controller
{
  public function instructordashboard(Request $request) {
    $user_id = $request->session()->get('user_id');
    $user_details = DB::select('select UserType from users where UserId=?',[$user_id]);
    if($user_details[0]->UserType == "instructor"){
    $upcoming_events = DB::select('select events.*, eventschedules.* FROM events JOIN eventschedules on events.eventID = eventschedules.eventID and eventschedules.StartDateTime >= CURDATE()');
    $completed_events = DB::select('select events.*, eventschedules.* FROM events JOIN eventschedules on events.eventID = eventschedules.eventID and eventschedules.StartDateTime < CURDATE()');
    //select venue.*,classbookings.* from venue JOIN classbookings ON classbookings.VenueId=venue.VenueId and classbookings.Status=? and classbookings.InstructorId=?
    $instructor_schedule = DB::table('venue')
    ->selectRaw('*,classbookings.*')
    ->DISTINCT('venue.VenueName')
    ->JOIN('classbookings','classbookings.VenueId','=','venue.VenueId')
    ->where('classbookings.InstructorId','=',$user_id)
    ->where('classbookings.Status','=',0)
    ->paginate(10);
    $instructor_accept = DB::table('venue')
    ->selectRaw('*,classbookings.*')
    ->DISTINCT('venue.VenueName')
    ->JOIN('classbookings','classbookings.VenueId','=','venue.VenueId')
    ->where('classbookings.InstructorId','=',$user_id)
    ->where('classbookings.Status','=',1)
    ->paginate(10);
     $events = [];
        $futureevents = DB::select('select events.*, eventschedules.* FROM events JOIN eventschedules on events.eventID = eventschedules.eventID and eventschedules.StartDateTime > CURDATE()');
      
        if(count($futureevents)>0) {
            foreach ($futureevents as $value) {
                $events[] = Calendar::event(
                    $value->EventName,
                    true,
                    new \DateTime($value->StartDateTime),
                    new \DateTime($value->EndDateTime.' +1 day'),
                    null,
                    // Add color and link on event
                  [
                      'color' => '#028482',
                      'url' => 'venuedashboard',
                  ]
                );
            }
        }
         
 $pastevents = DB::select('select events.*, eventschedules.* FROM events JOIN eventschedules on events.eventID = eventschedules.eventID and eventschedules.StartDateTime < CURDATE()');
      
   if(count($pastevents)>0) {
            foreach ($pastevents as $value1) {
                $events[] = Calendar::event(
                    $value1->EventName,
                    true,
                    new \DateTime($value1->StartDateTime),
                    new \DateTime($value1->EndDateTime.' +1 day'),
                    null,
                    // Add color and link on event
                  [
                      'color' => '#FF0000',
                      'url' => 'venuedashboard',
                  ]
                );
            }
        }
        
     $presentevents = DB::select('select events.*, eventschedules.* FROM events JOIN eventschedules on events.eventID = eventschedules.eventID and eventschedules.StartDateTime = CURDATE()');

   if(count($presentevents)>0) {
            foreach ($presentevents as $value2) {
                $events[] = Calendar::event(
                    $value2->EventName,
                    true,
                    new \DateTime($value2->StartDateTime),
                    new \DateTime($value2->EndDateTime.' +1 day'),
                    null,
                    // Add color and link on event
                  [
                      'color' => '#336699',
                      'url' => 'venuedashboard',
                  ]
                );
            }
        }
        
        $calendar = Calendar::addEvents($events);
    return view('instructordashboard',compact('calendar'),['instructor_schedule'=>$instructor_schedule,'completed_events'=>$completed_events,'upcoming_events'=>$upcoming_events,'instructor_accept'=>$instructor_accept]);
    }
    else{
      $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','Not Autherised to access Instructor Dashboard');
      return redirect('/');
    }
  }

  public function acceptParticipant(Request $request){
    $participant = $request->participant;
    $venue_id = $request->venue_id;
    $user_id = $request->session()->get('user_id');
    $accept_participant = DB::update('update classbookings set Status=? where InstructorId=? and ParticipantId=? and VenueId=?',[1,$user_id,$participant,$venue_id]);
    if($accept_participant){
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Request Accepted Successfully');
      return redirect('instructordashboard');
    }
  }
  public function deleteParticipant(Request $request){
    $participant = $request->participant;
    $venue_id = $request->venue_id;
    $user_id = $request->session()->get('user_id');
     $accept_participant = DB::update('update classbookings set Status=? where InstructorId=? and ParticipantId=? and VenueId=?',[0,$user_id,$participant,$venue_id]);
    if($accept_participant){
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Request Rejected Successfully');
      return redirect('instructordashboard');
    }
  }