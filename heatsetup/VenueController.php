  public function heatSetup(Request $request){
  if($request->session()->has('user_id')){
      $userid = $request->session()->get('user_id');
      $event_id = $request->eventid;
      $subevent_id = $request->subeventid;
       
      $venues = DB::select('select VenueId,VenueName from venue where VenueOwner=? and IsDeleted=?',[$userid,'no']);
  
      $events = DB::select('select e.EventId,e.EventName,s.Course,s.SwimStyle,s.Relay,s.MaxParticipants,s.SpecialInstructions from events e inner join subevents s on e.EventId=s.EventId'
              . ' where e.EventId=? and e.IsDeleted=? or e.IsDeleted=? and s.SubEventId=?',[$event_id,'No','no',$subevent_id]);
      
      $heat_info = DB::select('select max(StageNumber) as stage from eventheats where EventId=?',[$event_id]);
      $stage_level = 0;
      if($heat_info[0]->stage == 3) {
       $stage_level = 3;   
      } elseif($heat_info[0]->stage == 2) {
       $stage_level = 2;   
      } elseif($heat_info[0]->stage == 1) {
       $stage_level = 1;   
      } else {
       $stage_level = 0;   
      }
  return view('heatsetup',['event_id'=>$event_id,'venues'=>$venues,'events'=>$events, 'stage_level'=>$stage_level,'subevent_id'=>$subevent_id]);
  }
  else{
      $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','please login to continue...');
      return view('login');
  }
 }
 public function saveheatSetup(Request $request){
  $user_id = $request->session()->get('user_id');
  $event_id = $request->eventid;
  $subevent_id = $request->subeventid;
  $heat_name = $request->heat_name;
  $start_date = $request->start_date;
  $end_date = $request->end_date;
  $heat_time = $request->heat_time;
  $venueid = $request->venue_id;
  $max_participants = $request->max_participants;
  $qualification_time = $request->qualification_time;
  $relay = $request->relay;
  $course = $request->course;
  $swim_style = $request->swim_style;
  $specialinstructions = $request->specialinstructions;
  $description = $request->descriptions;
  $stagennumber = $request->stagenumber;

   $venues = DB::select('select VenueId,VenueName from venue where VenueOwner=? and IsDeleted=?',[$user_id,'no']);
  
      $events = DB::select('select e.EventId,e.EventName,s.Course,s.SwimStyle,s.Relay,s.MaxParticipants,s.SpecialInstructions from events e inner join subevents s on e.EventId=s.EventId where e.EventId=? and e.IsDeleted=? and s.SubEventId=?',[$event_id,'no',$subevent_id]);
 $add_heat = DB::table('eventheats')->insertGetId(array('EventId'=>$event_id,'SubEventId'=>$subevent_id,'HeatName'=>$heat_name,'HeatStartDate'=>$start_date,'HeatTime'=>$heat_time,'StageNumber'=> $stagennumber ,'MaxNoOfParticipants'=>$max_participants,'VenueId'=>$venueid,'QualificationTime'=>$qualification_time,'Relay'=>$relay,'SwimCourse'=>$course,'SwimStyle'=>$swim_style,'ChildHeatId'=>0,'VenueHeatSpecialInstructions'=>$specialinstructions,'HeatNotes'=>$description,'CreatedBy'=>$user_id,'UpdatedBy'=>$user_id));
  if($add_heat){
    $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Added Heat details, Scrolldown to see heats options');
      return redirect('heatsetup/'.$event_id.'/'.$subevent_id);
  }
  else{
    $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','Heat not added.Please try again..');
     return redirect('heatsetup/'.$event_id.'/'.$subevent_id);
  }
 }

   public function heatsemifinal(Request $request){
    if($request->session()->has('user_id')){
      $userid = $request->session()->get('user_id');
        $event_id = $request->event_id;
        $subevent_id = $request->subevent_id;
      $venues = DB::select('select VenueId,VenueName from venue where VenueOwner=? and IsDeleted=?',[$userid,'no']);
  
      $events = DB::select('select e.EventId,e.EventName,s.Course,s.SwimStyle,s.Relay,s.MaxParticipants,s.SpecialInstructions from events e inner join subevents s on e.EventId=s.EventId'
              . ' where e.EventId=? and e.IsDeleted=? and s.SubEventId=?',[$event_id,'No',$subevent_id]);
     
      $heat_info = DB::select('select max(StageNumber) as stage from eventheats where EventId=?',[$event_id]);
      $stage_level = 0;
      if($heat_info[0]->stage == 3) {
       $stage_level = 3;   
      } elseif($heat_info[0]->stage == 2) {
       $stage_level = 2;   
      } elseif($heat_info[0]->stage == 1) {
       $stage_level = 1;   
      } else {
       $stage_level = 0;   
      }

      return view('semiheatsetup',['event_id'=>$event_id,'venues'=>$venues,'events'=>$events, 'stage_level'=>$stage_level,'subevent_id'=>$subevent_id]);
    }
    else{
      $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','please login to continue...');
      return view('login');
    }

  }
 public function savesemifinal(Request $request){
  $user_id = $request->session()->get('user_id');
  $event_id = $request->event_id;
  $subevent_id = $request->subevent_id;
  $heat_name = $request->heat_name;
  $start_date = $request->start_date;
  $end_date = $request->end_date;
  $heat_time = $request->heat_time;
  $venueid = $request->venue_id;
  $max_participants = $request->max_participants;
  $qualification_time = $request->qualification_time;
  $relay = $request->relay;
  $course = $request->course;
  $swim_style = $request->swim_style;
  $specialinstructions = $request->specialinstructions;
  $description = $request->descriptions;
  $stagennumber = $request->stagenumber;
  $venues = DB::select('select VenueId,VenueName from venue where VenueOwner=? and IsDeleted=?',[$user_id,'no']);
  
      $events = DB::select('select e.EventId,e.EventName,s.Course,s.SwimStyle,s.Relay,s.MaxParticipants,s.SpecialInstructions from events e inner join subevents s on e.EventId=s.EventId'
              . ' where e.EventId=? and e.IsDeleted=? ',[$event_id,'No']);
      $semi_final = DB::table('eventheats')->insertGetId(array('EventId'=>$event_id,'SubEventId'=>$subevent_id,'HeatName'=>$heat_name,'HeatStartDate'=>$start_date,'HeatTime'=>$heat_time,'StageNumber'=> $stagennumber ,'MaxNoOfParticipants'=>$max_participants,'VenueId'=>$venueid,'QualificationTime'=>$qualification_time,'Relay'=>$relay,'SwimCourse'=>$course,'SwimStyle'=>$swim_style,'ChildHeatId'=>0,'VenueHeatSpecialInstructions'=>$specialinstructions,'HeatNotes'=>$description,'CreatedBy'=>$user_id,'UpdatedBy'=>$user_id));
      if($semi_final){
    $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Heat added Successfully <a href="'.url('finalheatsetup/'.$event_id.'/'.$subevent_id).'"> Click here</a>  to Add finals.');
      return redirect('semiheatsetup/'.$event_id.'/'.$subevent_id);
  }
  else{
    $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','Heat not added.Please try again..');
     return redirect('semiheatsetup/'.$event_id.'/'.$subevent_id);
  }
  }


    public function heatfinal(Request $request){
    if($request->session()->has('user_id')){
      $userid = $request->session()->get('user_id');
        $event_id = $request->event_id;
        $subevent_id = $request->subevent_id;
      $venues = DB::select('select VenueId,VenueName from venue where VenueOwner=? and IsDeleted=?',[$userid,'no']);
  
      $events = DB::select('select e.EventId,e.EventName,s.Course,s.SwimStyle,s.Relay,s.MaxParticipants,s.SpecialInstructions from events e inner join subevents s on e.EventId=s.EventId'
              . ' where e.EventId=? and e.IsDeleted=? and SubEventId=?',[$event_id,'No',$subevent_id]);

      return view('finalheatsetup',['event_id'=>$event_id,'venues'=>$venues,'events'=>$events,'subevent_id'=>$subevent_id]);
    }
    else{
      $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','please login to continue...');
      return view('login');
    }

  }


  public function savefinal(Request $request){
  $user_id = $request->session()->get('user_id');
  $event_id = $request->event_id;
  $subevent_id = $request->subevent_id;
  $heat_name = $request->heat_name;
  $start_date = $request->start_date;
  $end_date = $request->end_date;
  $heat_time = $request->heat_time;
  $venueid = $request->venue_id;
  $max_participants = $request->max_participants;
  $qualification_time = $request->qualification_time;
  $relay = $request->relay;
  $course = $request->course;
  $swim_style = $request->swim_style;
  $specialinstructions = $request->specialinstructions;
  $description = $request->descriptions;
  $stagennumber = $request->stagenumber;
  $venues = DB::select('select VenueId,VenueName from venue where VenueOwner=? and IsDeleted=?',[$user_id,'no']);
  
      $events = DB::select('select e.EventId,e.EventName,s.Course,s.SwimStyle,s.Relay,s.MaxParticipants,s.SpecialInstructions from events e inner join subevents s on e.EventId=s.EventId'
              . ' where e.EventId=? and e.IsDeleted=? ',[$event_id,'No']);
      $semi_final = DB::table('eventheats')->insertGetId(array('EventId'=>$event_id,'HeatName'=>$heat_name,'HeatStartDate'=>$start_date,'HeatTime'=>$heat_time,'StageNumber'=> $stagennumber ,'MaxNoOfParticipants'=>$max_participants,'VenueId'=>$venueid,'QualificationTime'=>$qualification_time,'Relay'=>$relay,'SwimCourse'=>$course,'SwimStyle'=>$swim_style,'ChildHeatId'=>0,'VenueHeatSpecialInstructions'=>$specialinstructions,'HeatNotes'=>$description,'CreatedBy'=>$user_id,'UpdatedBy'=>$user_id));
      if($semi_final){
    $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Heat added Successfully <a href="'.url('finalheatsetup/'.$event_id.'/'.$subevent_id).'"> Click here</a>  to Add finals.');
      return redirect('finalheatsetup/'.$event_id.'/'.$subevent_id);
  }
  else{
    $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','Heat not added.Please try again..');
      return redirect('finalheatsetup/'.$event_id.'/'.$subevent_id);
  }
  }

 public function manageParticpants(Request $request){
   if($request->session()->has('user_id')){
     $user_id = $request->session()->get('user_id');
     $event_id = $request->event_id;
     $subevent_id = $request->subevent_id;
     $heat_id = $request->heat_id;
     $participants = DB::select('SELECT DISTINCT participants.ParticipantId,participants.ParticipantName FROM participants INNER JOIN bridgeeventparticipants where participants.ParticipantId = bridgeeventparticipants.ParticipantId and bridgeeventparticipants.EventId=? and bridgeeventparticipants.Status=?',[$event_id,0]);
     $mainheat = DB::select('select HeatId,HeatName from eventheats where HeatId=? and EventId=? and SubEventId=?',[$heat_id,$event_id,$subevent_id]);
     $heatname = $mainheat[0]->HeatName;
     $heats = DB::select('select HeatId,HeatName from eventheats where EventId=? and StageNumber=?',[$event_id,1]);
     $heat_participants = DB::select('select DISTINCT p.ParticipantId,p.ParticipantName from participants p INNER JOIN bridgeheatparticipants b where p.ParticipantId=b.ParticipantId and b.EventId=? and b.HeatId=?',[$event_id,$heat_id]);
     return view('manage-heat-participants',['participants'=>$participants,'heatname'=>$heatname,'heats'=>$heats,'event_id'=>$event_id,'heat_id'=>$heat_id,'heat_participants'=>$heat_participants,'subevent_id'=>$subevent_id,'subevent_id'=>$subevent_id]);
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
    $max_participants = DB::select('select MaxNoOfParticipants from eventheats where EventId=? and HeatId=?',[$event_id,$heat_id]);
    $max_participant = $max_participants[0]->MaxNoOfParticipants;
    $participants_added = DB::select('select ParticipantId from bridgeheatparticipants where EventId=? and HeatId=?',[$event_id,$heat_id]);
    if(count($participants_added)>=$max_participant){
      $request->session()->flash('message.level','info');
   $request->session()->flash('message.content','Max Participants limit exceeded');
   return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id);
    }
    else{
    for($i=0;$i<count($participant);$i++){
       $eventparticipants = DB::update('update bridgeeventparticipants set Status=? where EventId=? and ParticipantId=?',[1,$event_id,$participant[$i]]);
       $set_heatparticipants = DB::table('bridgeheatparticipants')->insertGetId(array('HeatId'=>$heat_id,'EventId'=>$event_id,'ParticipantId'=>$participant[$i],'CreatedBy'=>$user_id,'StageNo'=>1,'AssignStatus'=>0));
     }
     $request->session()->flash('message.level','success');
   $request->session()->flash('message.content','Participants Moved to heat');
   return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id);
    }
   }
   elseif($heats_participants!=''){
     for($i=0;$i<count($heats_participants);$i++){
       $heatparticipants = DB::delete('delete from bridgeheatparticipants where ParticipantId=? and EventId=? and HeatId=?',[$heats_participants[$i],$event_id,$heat_id]);
       $set_eventparticipants = DB::update('update bridgeeventparticipants set Status=? where EventId=? and ParticipantId=?',[0,$event_id,$heats_participants[$i]]);
     }
       $request->session()->flash('message.level','success');
   $request->session()->flash('message.content','Participants Removed from heat');
   return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id);
   }
   else{
     $request->session()->flash('message.level','success');
     $request->session()->flash('message.content','Changes saved Sucessfully');
     return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id);
   }
 }
 
 public function semifinalParticipants(Request $request){
    $event_id = $request->event_id;
    $subevent_id = $request->subevent_id;
    $heat_id = $request->heat_id;
    $level_id = $request->level_id;
    if($level_id == 2){
    $semifinals = DB::select('select DISTINCT HeatId,HeatName from eventheats where HeatId=?',[$heat_id]);
    $semifinalname = $semifinals[0]->HeatName;
     $semifinal_heats = DB::select('select DISTINCT HeatId,HeatName from eventheats where EventId=? and StageNumber=? and SubEventId=?',[$event_id,2,$subevent_id]);
    $participants = DB::select('select DISTINCT p.ParticipantId,p.ParticipantName from participants p JOIN bridgeeventparticipants b on b.EventId=? and b.Status=? and b.ParticipantId=p.ParticipantId JOIN eventresults e on e.EventId=? and e.Result=? and e.ParticipantId=p.ParticipantId',[$event_id,2,$event_id,'semifinal']);
    $semifinal_participants = DB::select('select DISTINCT p.ParticipantId,p.ParticipantName from participants p JOIN bridgeheatparticipants b on b.EventId=? and b.HeatId=? and b.StageNo=? and b.AssignStatus=? and b.ParticipantId=p.ParticipantId JOIN bridgeeventparticipants be on b.ParticipantId=be.ParticipantId',[$event_id,$heat_id,2,1]);
    return view('semifinalparticipants',['event_id'=>$event_id,'heat_id'=>$heat_id,'level_id'=>$level_id,'semifinal_participants'=>$semifinal_participants,'semifinals'=>$semifinals,'semifinalname'=>$semifinalname,'participants'=>$participants,'semifinal_heats'=>$semifinal_heats,'subevent_id'=>$subevent_id]);
    }
    else{
      $semifinals = DB::select('select DISTINCT HeatId,HeatName from eventheats where HeatId=?',[$heat_id]);
      $semifinalname = $semifinals[0]->HeatName;
      $semifinal_heats = DB::select('select DISTINCT HeatId,HeatName from eventheats where EventId=? and StageNumber=?  and SubEventId=?',[$event_id,3,$subevent_id]);
      $participants = DB::select('select DISTINCT p.ParticipantId,p.ParticipantName from participants p JOIN bridgeeventparticipants b on b.EventId=? and b.Status=? and b.ParticipantId=p.ParticipantId JOIN eventresults e on e.EventId=? and e.Result=? and e.ParticipantId=p.ParticipantId',[$event_id,3,$event_id,'final']);
      $semifinal_participants = DB::select('select DISTINCT p.ParticipantId,p.ParticipantName from participants p JOIN bridgeheatparticipants b on b.HeatId=? and b.EventId=? and b.StageNo=? and b.AssignStatus=? and b.ParticipantId=p.ParticipantId JOIN bridgeeventparticipants be on b.ParticipantId=be.ParticipantId',[$heat_id,$event_id,3,2]);
      return view('semifinalparticipants',['event_id'=>$event_id,'heat_id'=>$heat_id,'level_id'=>$level_id,'semifinal_participants'=>$semifinal_participants,'semifinals'=>$semifinals,'semifinalname'=>$semifinalname,'participants'=>$participants,'semifinal_heats'=>$semifinal_heats,'subevent_id'=>$subevent_id]);
    }
  }

  public function savesemifinalParticipants(Request $request){
    $participants = $request->participants;
    $heats_participants = $request->heats_participants;
    $heats_id = $request->heats_id;
    $event_id = $request->event_id;
    $subevent_id = $request->subevent_id;
    $level_id = $request->level_id;
    $heat_id = $request->heat_id;
    if($level_id == 2){
    if($participants!=''){
       $max_participants = DB::select('select MaxNoOfParticipants from eventheats where EventId=? and HeatId=?',[$event_id,$heat_id]);
    $max_participant = $max_participants[0]->MaxNoOfParticipants;
    $participants_added = DB::select('select ParticipantId from bridgeheatparticipants where EventId=? and HeatId=?',[$event_id,$heat_id]);
    if(count($participants_added)>=$max_participant){
      $request->session()->flash('message.level','info');
   $request->session()->flash('message.content','Max Participants limit exceeded');
   return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id.'/'.$level_id);
    }
    else{
      for($i=0;$i<count($participants);$i++){
      $update_participants = DB::update('update bridgeheatparticipants set HeatId=?,StageNo=?,AssignStatus=? where ParticipantId=? and EventId=?',[$heat_id,2,1,$participants[$i],$event_id]);
      $update_eventparticipants = DB::update('update bridgeeventparticipants set Status=? where EventId=? and ParticipantId=?',[3,$event_id,$participants[$i]]);
      }
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Participants moved to semifinal');
      return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id.'/'.$level_id);
    }
    }
    elseif($heats_participants!=''){
      for($i=0;$i<count($heats_participants);$i++){
        $update_participants = DB::update('update bridgeheatparticipants set StageNo=?,AssignStatus=? where ParticipantId=? and EventId=?',[1,0,$heats_participants[$i],$event_id]);
        $update_eventparticipants = DB::update('update bridgeeventparticipants set Status=? where EventId=? and ParticipantId=?',[2,$event_id,$heats_participants[$i]]);
      }
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Participants moved to semifinal');
      return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id.'/'.$level_id);
    }
    else{
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Changes saved Sucessfully');
      return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id.'/'.$level_id);
    }
    }
    else{
      if($participants!=''){
         $max_participants = DB::select('select MaxNoOfParticipants from eventheats where EventId=? and HeatId=?',[$event_id,$heat_id]);
    $max_participant = $max_participants[0]->MaxNoOfParticipants;
    $participants_added = DB::select('select ParticipantId from bridgeheatparticipants where EventId=? and HeatId=?',[$event_id,$heat_id]);
    if(count($participants_added)>=$max_participant){
      $request->session()->flash('message.level','info');
   $request->session()->flash('message.content','Max Participants limit exceeded');
   return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id.'/'.$level_id);
    }
    else{
      for($i=0;$i<count($participants);$i++){
      $update_participants = DB::update('update bridgeheatparticipants set HeatId=?,StageNo=?,AssignStatus=? where ParticipantId=? and EventId=?',[$heat_id,3,2,$participants[$i],$event_id]);
      $update_eventparticipants = DB::update('update bridgeeventparticipants set Status=? where EventId=? and ParticipantId=?',[4,$event_id,$participants[$i]]);
      }
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Participants moved to semifinal');
      return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id.'/'.$level_id);
    }
    }
    elseif($heats_participants!=''){
      for($i=0;$i<count($heats_participants);$i++){
        $update_participants = DB::update('update bridgeheatparticipants set StageNo=?,AssignStatus=? where ParticipantId=? and EventId=?',[2,1,$heats_participants[$i],$event_id]);
         $update_eventparticipants = DB::update('update bridgeeventparticipants set Status=? where EventId=? and ParticipantId=?',[3,$event_id,$heats_participants[$i]]);
      }
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Participants moved to semifinal');
      return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id.'/'.$level_id);
    }
    else{
      $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Changes saved Sucessfully');
      return redirect('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id.'/'.$level_id);
    }
    }
  }

  
 public function oldHeatSchedule(Request $request){
    $event_id = $request->event_id;
    $subevent_id = $request->subevent_id;
 
    $schedules = DB::select('select HeatId,HeatName,HeatStartDate,HeatTime,QualificationTime,SubEventId from eventheats where EventId=? and IsDeleted = "No" and StageNumber = 1 and SubEventId=?',[$event_id,$subevent_id]);
    $heat_id = $schedules[0]->HeatId;
    if( count($schedules)>0 ) {
    echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><th>Heat Name</th><th>Heat StartDate</th><th>Edit</th><th>Delete</th><th>Add Participants<th>Result Entry</th><th>View Results</th></tr>";
                foreach($schedules as $schedule) {
                    echo "<tr><td>".$schedule->HeatName."</td><td>".$schedule->HeatStartDate."</td><td><a href=".url('/editheat/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId)." style='color:black;'>Edit</a></td><td><a href=".url('/deleteheat/'.$event_id.'/'.$schedule->HeatId)." style='color:black;'>Delete</a></td><td><a href=".url('/manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId)." style='color:black;'>Add Participants</a><a href=".url('/participantsexcel/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId.'/1')."><img src='".url('public/images/excel.png')."' width='20' height='20'></a></td>";
                 $heatparticipants = DB::select('select * from bridgeheatparticipants where EventId=? and HeatId=?',[$event_id,$heat_id]);
                  if(count($heatparticipants)>0){
                    echo "<td><a href=".url('/resultentry/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId.'/1')." style='color:black;'>Result entry</td>"; 
               }
                  else{
                   echo "<td><a href='' style='color:black;'>------</td>";
                  }
                  $heatresults = DB::select('select * from eventresults where EventId =? and HeatId = ?',[$event_id,$heat_id]);
                  if(count($heatresults)>0){
                   echo "<td><a href=".url('/heatresults/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId.'/1')." style='color:black;'>View Result</td></tr>";
                  }
                  else{
                  echo "<td><a href='' style='color:black;'>-------</td></tr>";
                  }
                }
                echo "</table>";
                echo '</div>';
    }
  }

    public function oldSemiSchedule(Request $request){
   $event_id = $request->event_id;
   $subevent_id = $request->subevent_id;
   $heat_id = $request->heat_id;
   $subevent_id = $request->subevent_id;
   $schedules = DB::select('select HeatId,HeatName,HeatStartDate,HeatTime,QualificationTime from eventheats where EventId=? and IsDeleted = "No" and StageNumber = 2',[$event_id]);
   if( count($schedules)>0 ) {
   echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
               echo '<div class="row" style="border:1px solid #eee">';
               echo "<table class='table table-striped'>";
               echo "<tr><th>Heat Name</th><th>Heat StartDate</th><th>Edit</th><th>Delete</th><th>Manage Participants</th><th>Result Entry</th><th>View Result</th></tr>";
               foreach($schedules as $schedule) {
                   echo "<tr><td>".$schedule->HeatName."</td><td>".$schedule->HeatStartDate."</td><td><a href=".url('/editheat/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId)." style='color:black;'>Edit</a></td><td><a href=".url('/deleteheat/'.$event_id.'/'.$schedule->HeatId)." style='color:black;'>Delete</a></td><td><a href=".url('/manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId.'/2')." style='color:black;'>Manage Participants</a><a href=".url('/participantsexcel/'.$event_id.'/'.$schedule->HeatId.'/1')."><img src='".url('public/images/excel.png')."' width='20' height='20'></a></td>";
                 $heatparticipants = DB::select('select * from bridgeheatparticipants where EventId=? and HeatId=? and StageNo = 2',[$event_id,$heat_id]);
                 if(count($heatparticipants)>0){
                   echo "<td><a href=".url('/resultentry/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId.'/2')." style='color:black;'>Result entry</td>";
                 }
                 else{
                  echo "<td><a href='' style='color:black;'>------</td>";
                 }
               $heatresults = DB::select('select * from bridgeheatparticipants where EventId =? and HeatId = ?',[$event_id,$heat_id]);
                 if(count($heatresults)>0){
                  echo "<td><a href=".url('/heatresults/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId.'/2')." style='color:black;'>View Result</td></tr>";
                 }
                 else{
                 echo "<td><a href='' style='color:black;'>-------</td></tr>";
                 }
               }
               echo "</table>";
               echo '</div>';
   }
 }

 public function oldFinalSchedule(Request $request){
    $event_id = $request->event_id;
    $subevent_id = $request->subevent_id;
    $heat_id = $request->heat_id;
    $schedules = DB::select('select HeatId,HeatName,HeatStartDate,HeatTime,QualificationTime from eventheats where EventId=? and IsDeleted = "No" and StageNumber = 3',[$event_id]);
    if( count($schedules)>0 ) {
    echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><th>Heat Name</th><th>Heat StartDate</th><th>Edit</th><th>Delete</th><th>Manage Participants</th><th>Result Entry</th><th>View Result</th></tr>";
                foreach($schedules as $schedule) {
                    echo "<tr><td>".$schedule->HeatName."</td><td>".$schedule->HeatStartDate."</td><td><a href=".url('/editheat/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId)." style='color:black;'>Edit</a></td><td><a href=".url('/deleteheat/'.$event_id.'/'.$schedule->HeatId)." style='color:black;'>Delete</a></td><td><a href=".url('/manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId.'/3')." style='color:black;'>Manage Participants</a><a href=".url('/participantsexcel/'.$event_id.'/'.$schedule->HeatId.'/1')."><img src='".url('public/images/excel.png')."' width='20' height='20'></a></td>";
                     $heatparticipants = DB::select('select * from bridgeheatparticipants where EventId=? and HeatId=? and StageNo = 3',[$event_id,$heat_id]);
                  if(count($heatparticipants)>0){
                    echo "<td><a href=".url('/resultentry/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId.'/3')." style='color:black;'>Result entry</td>"; 
                  }
                  else{
                   echo "<td><a href='' style='color:black;'>------</td>";
                  }
                $heatresults = DB::select('select * from bridgeheatparticipants where EventId =? and HeatId = ?',[$event_id,$heat_id]);
                  if(count($heatresults)>0){
                   echo "<td><a href=".url('/heatresult/'.$event_id.'/'.$subevent_id.'/'.$schedule->HeatId.'/3')." style='color:black;'>View Result</td></tr>";
                  }
                  else{
                  echo "<td><a href='' style='color:black;'>-------</td></tr>";
                  }
                }
            
                echo "</table>";
                echo '</div>';
    }
  }

  public function editheat(Request $request){
    if($request->session()->get('user_id')){
      $userid = $request->session()->get('user_id');
      $event_id = $request->event_id;
      $subevent_id = $request->subevent_id;
      $heat_id = $request->heat_id;
      $venues = DB::select('select VenueId,VenueName from venue where VenueOwner=? and IsDeleted=?',[$userid,'no']);
      $heat_details = DB::select('select * from eventheats where HeatId=? and EventId=? and SubEventId=?',[$heat_id,$event_id,$subevent_id]);

      return view('editheat',['event_id'=>$event_id,'heat_id'=>$heat_id,'heat_details'=>$heat_details,'subevent_id'=>$subevent_id,'venues'=>$venues]);
    }
    else{
      $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','Passwords didnot match. Please,Try again..');
      return redirect('login');
    }
  }
  public function saveheatSetup(Request $request){
  $user_id = $request->session()->get('user_id');
  $event_id = $request->eventid;
  $subevent_id = $request->subeventid;
  $heat_name = $request->heat_name;
  $start_date = $request->start_date;
  $end_date = $request->end_date;
  $heat_time = $request->heat_time;
  $venueid = $request->venue_id;
  $max_participants = $request->max_participants;
  $qualification_time = $request->qualification_time;
  $relay = $request->relay;
  $course = $request->course;
  $swim_style = $request->swim_style;
  $specialinstructions = $request->specialinstructions;
  $description = $request->descriptions;
  $stagennumber = $request->stagenumber;

   $venues = DB::select('select VenueId,VenueName from venue where VenueOwner=? and IsDeleted=?',[$user_id,'no']);
  
      $events = DB::select('select e.EventId,e.EventName,s.Course,s.SwimStyle,s.Relay,s.MaxParticipants,s.SpecialInstructions from events e inner join subevents s on e.EventId=s.EventId where e.EventId=? and e.IsDeleted=? and s.SubEventId=?',[$event_id,'no',$subevent_id]);
 $add_heat = DB::table('eventheats')->insertGetId(array('EventId'=>$event_id,'SubEventId'=>$subevent_id,'HeatName'=>$heat_name,'HeatStartDate'=>$start_date,'HeatTime'=>$heat_time,'StageNumber'=> $stagennumber ,'MaxNoOfParticipants'=>$max_participants,'VenueId'=>$venueid,'QualificationTime'=>$qualification_time,'Relay'=>$relay,'SwimCourse'=>$course,'SwimStyle'=>$swim_style,'ChildHeatId'=>0,'VenueHeatSpecialInstructions'=>$specialinstructions,'HeatNotes'=>$description,'CreatedBy'=>$user_id,'UpdatedBy'=>$user_id));
  if($add_heat){
    $request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Added Heat details, Scrolldown to see heats options');
      return redirect('heatsetup/'.$event_id.'/'.$subevent_id);
  }
  else{
    $request->session()->flash('message.level','danger');
      $request->session()->flash('message.content','Heat not added.Please try again..');
     return redirect('heatsetup/'.$event_id.'/'.$subevent_id);
  }
 }