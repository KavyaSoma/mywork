<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;


class AdminController extends Controller
{
  public function setHeat(Request $request){
    if($request->session()->has('user_id')){
      $event_id = $request->id;
      $subevents = DB::select('select SubEventId,SubEventName from subevents where EventId=?',[$event_id]);
      return view('heatsetup',['event_id'=>$event_id,'subevents'=>$subevents]);
    }
    else{
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Passwords didnot match. Please,Try again..');
        return redirect('login');
    }
  }
    public function heatSetup(Request $request){
    $user_id = $request->session()->get('user_id');
    $event_id = $request->id;
    $subevent = $request->subevents;
    $stage_no = $request->stage_no;
    $stage_name = $request->stage_name;
    $heat_generation = $request->heat_generation;
   
    $event_details = DB::select('select SubEventId,SwimStyle,Relay,MaxParticipants from subevents where SubEventId=?',[$subevent]);
    foreach($event_details as $event_detail){
    $insert_heat = DB::table('eventheats')->insertGetId(array('EventId'=>$event_id,'SubEventId'=>$event_detail->SubEventId,'HeatName'=>'NA','HeatStartDate'=>'0000-00-00','HeatEndDate'=>'0000-00-00','HeatTime'=>'00:00:00','StageNumber'=>$stage_no,'StageName'=>$stage_name,'MaxNoOfParticipants'=>$event_detail->MaxParticipants,'VenueId'=>0,'QualificationTime'=>0,'Relay'=>$event_detail->Relay,'SwimCourse'=>0,'SwimStyle'=>$event_detail->SwimStyle,'ChildHeatId'=>0,'VenueHeatSpecialInstructions'=>'NA','HeatNotes'=>'NA','CreatedBy'=>$user_id,'UpdatedBy'=>$user_id));
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Basic Heat details Added Sucessfully');
      return redirect('scheduleheat/'.$event_id.'/'.$event_detail->SubEventId.'/'.$insert_heat);
   
    }
  }
  public function schedule(Request $request){
    if($request->session()->has('user_id')){
      $event_id = $request->event_id;
      $heat_id = $request->heat_id;
      $subevent_id = $request->subevent_id;
      return view('scheduleheat',['event_id'=>$event_id,'heat_id'=>$heat_id,'subevent_id'=>$subevent_id]);
    }
    else{
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Passwords didnot match. Please,Try again..');
        return redirect('login');
    }
  }
  public function scheduleHeat(Request $request){
    $event_id = $request->event_id;
    $subevent_id = $request->subevent_id;
    $heat_id = $request->heat_id;
    $heat_name = $request->heat_name;
    $schedule_time = $request->schedule_time;
    $qualification = $request->qualification;
    $qualification_time = $request->qualification_time;
    $schedule_date = $request->schedule_date;
    $course = $request->course;
    $update_heat = DB::update('update eventheats set HeatName=?,HeatTime=?,QualificationTime=?,HeatStartDate=? where HeatId=?',[$heat_name,$schedule_time,$qualification[0],$schedule_date,$heat_id]);
    $request->session()->flash('message.level','success');
    $request->session()->flash('message.content','Heat Scheduled Sucessfully.Add Another Heat or <a href="'.url('manageparticpants/'.$event_id.'/'.$subevent_id.'/'.$heat_id).'"> Click here to Add Participants to Heat...</a>');
    return view('scheduleheat',['event_id'=>$event_id,'heat_id'=>$heat_id,'subevent_id'=>$subevent_id]);
    
  }
  public function manageParticpants(Request $request){
    if($request->session()->has('user_id')){
      $user_id = $request->session()->get('user_id');
      $event_id = $request->event_id;
      $subevent_id = $request->subevent_id;
      $heat_id = $request->heat_id;
      $participants = DB::select('SELECT DISTINCT participants.ParticipantId,participants.ParticipantName FROM participants INNER JOIN bridgeeventparticipants where participants.ParticipantId = bridgeeventparticipants.ParticipantId and bridgeeventparticipants.EventId=? ',[$event_id]);
      $mainheat = DB::select('select HeatName from eventheats where HeatId=? and EventId=?',[$heat_id,$event_id]);
      $heatname = $mainheat[0]->HeatName;
      $heats = DB::select('select HeatId,HeatName from eventheats where EventId=?',[$event_id]);
      $heat_participants = DB::select('select DISTINCT p.ParticipantId,p.ParticipantName from participants p INNER JOIN bridgeheatparticipants b where p.ParticipantId=b.ParticipantId and b.EventId=? and b.HeatId=?',[$event_id,$heat_id]);
      return view('manageparticipants',['participants'=>$participants,'heatname'=>$heatname,'heats'=>$heats,'event_id'=>$event_id,'heat_id'=>$heat_id,'heat_participants'=>$heat_participants,'subevent_id'=>$subevent_id]);
    }
    else{
      $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','Passwords didnot match. Please,Try again..');
      return redirect('login');
    }
  }

  public function saveParticipants(Request $request){
    $user_id = $request->session()->get('user_id');
    $participant = $request->participants;
    $heats_participants = $request->heats_participants;
    $heats_id = $request->heats_id;
    $heat_id = $request->heat_id;
    $event_id = $request->event_id;
    $subevent_id = $request->subevent_id;
    if($participant!=''){
      for($i=0;$i<count($participant);$i++){
        $eventparticipants = DB::delete('delete from bridgeeventparticipants where EventId=? and ParticipantId=?',[$event_id,$participant[$i]]);
        $set_heatparticipants = DB::table('bridgeheatparticipants')->insertGetId(array('HeatId'=>$heat_id,'EventId'=>$event_id,'ParticipantId'=>$participant[$i],'CreatedBy'=>$user_id,'StageNo'=>0,'AssignStatus'=>0));
      }
      $request->session()->flash('message.level','success');
    $request->session()->flash('message.content','Participants Moved to heat');
    return redirect('manageparticpants/'.$event_id.'/'.$subevent_id.'/'.$heat_id);
    }
    elseif($heats_participants!=''){
      for($i=0;$i<count($heats_participants);$i++){
        $heatparticipants = DB::delete('delete from bridgeheatparticipants where ParticipantId=? and EventId=? and HeatId=?',[$heats_participants[$i],$event_id,$heat_id]);
        $set_eventparticipants = DB::table('bridgeeventparticipants')->insertGetId(array('EventId'=>$event_id,'ParticipantId'=>$heats_participants[$i],'GroupId'=>0,'CreatedBy'=>$user_id,'DeletedBy'=>0,'Invite'=>0,'ConfirmCode'=>0,'ApproverId'=>0,'Status'=>0));
      }
        $request->session()->flash('message.level','success');
    $request->session()->flash('message.content','Participants Removed from heat');
    return redirect('manageparticpants/'.$event_id.'/'.$subevent_id.'/'.$heat_id);
    }
    else{
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Changes saved Sucessfully');
    return redirect('resultentry/'.$event_id);
    }
  }
  public function semifinalsetup(Request $request){
    if($request->Session()->has('user_id')){
      $event_id = $request->event_id;
      $heat_id = $request->heat_id;
      $participants = DB::table('participants')
      ->DISTINCT('participants.ParticipantId')
      ->selectRaw('*,participants.ParticipantId,participants.ParticipantName,eventresults.Result,eventresults.HeatId,eventresults.EventResultId')
      ->JOIN('eventresults','eventresults.ParticipantId','=','participants.ParticipantId')
      ->where('eventresults.EventId','=',$event_id)
      ->ORDERBY('eventresults.Result')
      ->paginate(10);
      return view('semifinalsetup',['event_id'=>$event_id,'participants'=>$participants]);
    }
    else{
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Passwords didnot match. Please,Try again..');
        return redirect('login');
    }
  }
  public function saveSemifinalsetup(Request $request){
    $event_id = $request->event_id;
    $participants = $request->participants;
    $senifinal = $request->semifinal;
    $heat_id = $request->heat_id;
    for($i=0;$i<count($participants);$i++){
      $update_result = DB::update('update eventresults set SemiFinal=? where EventId=? and HeatId=? and ParticipantId=?',[$senifinal[$i],$event_id,$heat_id[$i],$participants[$i]]);
    }
    if($update_result){
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Participant Added to semifinals');
      return redirect('semifinalsetup/'.$event_id);
    }
    else{
      $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','Failed Adding Participants to semifinal.Please try again..');
      return redirect('semifinalsetup/'.$event_id);
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
    for($i=0;$i<count($time);$i++){
      $results = DB::table('eventresults')->insertGetId(array('EventId'=>$event_id,'ParticipantId'=>$userid[$i],'HeatId'=>$heat_id,'SemiFinal'=>0,'RecordedTime'=>$time[$i],'Result'=>$result[$i],'ParentResultId'=>0,'CreatedBy'=>$user_id,'UpdatedBy'=>$user_id));
    }
    if($results){
        $request->session()->flash('message.level','success');
        $request->session()->flash('message.content','Result Saved Sucessfully..<a href="'.url('semifinalsetup/'.$event_id).'"> Click here </a> to add participants to semifinal.');
        return redirect('resultentry/'.$event_id.'/'.$heat_id); 
      }
      else{
        $request->session()->flash('message.level','failed');
        $request->session()->flash('message.content','Result not saved.Please,try again');
        return redirect('resultentry/'.$event_id.'/'.$heat_id);
      }
  }