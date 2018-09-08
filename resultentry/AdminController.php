<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SocialController extends Controller
{
//Heat
public function resultEntry(Request $request){
    if($request->session()->has('user_id')){
      $event_id = $request->event_id;
      $heat_participants = DB::select('select HeatId,HeatName from eventheats where EventId=?',[$event_id]);
      $participants=array();
        return view('resultentry',['heat_participants'=>$heat_participants,'event_id'=>$event_id,'participants'=>$participants]);
    }
    else{
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Passwords didnot match. Please,Try again..');
        return redirect('login');
    }
  }
   public function heatResult(Request $request){
    $event_id = $request->event_id;
    $heat_id = $request->heat_id;
    $heat_participants = DB::select('select HeatId,HeatName from eventheats where EventId=?',[$event_id]);
    $participants = DB::select('select DISTINCT Participants.ParticipantName,Participants.ParticipantId,Participants.Image from Participants JOIN bridgeheatparticipants ON Participants.ParticipantId=bridgeheatparticipants.ParticipantId where bridgeheatparticipants.EventId=? and bridgeheatparticipants.HeatId=?',[$event_id,$heat_id]);
    return view('resultentry',['heat_participants'=>$heat_participants,'participants'=>$participants,'event_id'=>$event_id,'heat_id'=>$heat_id]);
  }
  public function saveResult(Request $request){
    $user_id = $request->session()->get('user_id');
    $event_id = $request->event_id;
    $heat_id = $request->heat_id;
    $time = $request->time;
    $result = $request->result;
    $userid = $request->userid;
    $max_participants = $request->max_participants;
    $get_qualificationTime = DB::select('select QualificationTime from eventheats where HeatId=?',[$heat_id]);
    $qualification_time = $get_qualificationTime[0]->QualificationTime;
    for($i=0;$i<count($time);$i++){
      sscanf($time[$i], "%d:%d:%d", $hours, $minutes, $seconds);
      $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
      $results = DB::table('eventresults')->insertGetId(array('EventId'=>$event_id,'ParticipantId'=>$userid[$i],'HeatId'=>$heat_id,'SemiFinal'=>0,'RecordedTime'=>$time[$i],'Result'=>$result[$i],'ParentResultId'=>0,'CreatedBy'=>$user_id,'UpdatedBy'=>$user_id));
      if($result[$i]<=$qualification_time){
        $move_semifinal = DB::update('update eventresults set SemiFinal=? where EventResultId=?',[1,$results]);
        $participants = DB::select('select ParticipantId from eventresults where EventId=? and SemiFinal=? and EventResultId=?',[$event_id,1,$results]);
        foreach($participants as $participant){
        $update_participant_status = DB::update('update bridgeeventparticipants set Status=? where EventId=? and ParticipantId=?',[2,$event_id,$participant->ParticipantId]);
        }
      }
      elseif($time_seconds == $qualification_time){
        $move_semifinal = DB::update('update eventresults set SemiFinal=? where EventResultId=?',[1,$results]);
        $participants = DB::select('select ParticipantId from eventresults where EventId=? and SemiFinal=? and EventResultId=?',[$event_id,1,$results]);
        foreach($participants as $participant){
        $update_participant_status = DB::update('update bridgeeventparticipants set Status=? where EventId=? and ParticipantId=?',[2,$event_id,$participant->ParticipantId]);
        }
      }
      else{
        echo "No participant moved to semifinal";
      }
    }
    $request->session()->flash('message.level','success');
    $request->session()->flash('message.content','Result Saved Sucessfully. <a href="'.url('schedulesemifinal/'.$event_id).'"> Click here </a>to setup Semifinal');
    return redirect('resultentry/'.$event_id.'/'.$heat_id);
  }
}
