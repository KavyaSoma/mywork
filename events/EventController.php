public function newevent(Request $request){
      if($request->session()->has('user_id')){
        $user_id = $request->session()->get('user_id');
        $image = url("public/images/event.jpg");
        $add_event = DB::table('events')->insertGetId(array('EventOwnerId'=>$user_id,'IsDeleted'=>'No','CreatedBy'=>$user_id,'ShortName'=>'NA'));
        $venue_image = DB::insert('insert into images (ImagePath,ImageRefType,ReferenceId) values(?,?,?)',[$image,'Event',$add_event]);
        return redirect('/addevent/'.$add_event);
      }
      else{
        $request->session()->flash('message.level', 'info');
        $request->session()->flash('message.content', 'Please login to continue...');
        return view('login');
      } 
    }
    public function addEvent(Request $request){
      if($request->session()->has('user_id')){
        $event_id = $request->event_id;
        $event_image = DB::select('select ImagePath from images where ImageRefType=? and ReferenceId=?',['Event',$event_id]);
        $event_details = DB::select('select EventName,Description,Privacy,ShortName from events where EventId=?',[$event_id]);
        if(count($event_details)>0){
        $show = "yes";
        }
        else{
        $show = "no";
        }
        return view('addevent',['event_id'=>$event_id,'event_details'=>$event_details,'show'=>$show,'event_image'=>$event_image]);
      }
      else{
        $request->session()->put('loginredirection', '/newevent');
        $request->session()->flash('message.level', 'info');
        $request->session()->flash('message.content', 'Please login to continue...');
        return redirect('login');
      }
    }
    public function saveEvent(Request $request){
        $event_name = $request->event_name;
        $description = $request->description;
        $privacy = $request->privacy;
        $short_name = $request->short_name;
        $event_id = $request->event_id;
        $image_check = $request->image_check;
        if($request->session()->has('user_id')){
        $user_id = $request->session()->get('user_id');
            $shortname = strtolower($short_name);
            $update_event = DB::update('update events set EventName=?,Description=?,Privacy=?,ShortName=? where EventId=?',[$event_name,$description,$privacy,$shortname,$event_id]);
            if(Input::hasFile('imgUpload')){
            $file = Input::file('imgUpload');
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = 20;
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $file->move('./public/images', $randomString.".png");
            $bimage = url("public/images/".$randomString.".png");     
            }
            else {
            $bimage = "NA";
             if($bimage!=$image_check){
              $bimage=$image_check;
            }
            }
            $event_image = DB::update('update images set ImagePath=? where ImageRefType=? and ReferenceId=?',[$bimage,'Event',$event_id]);    
            if($update_event || $event_image){    
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Details Added Successfully...');
            return redirect('eventtime/'.$event_id);
            }
            else{
                $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.content', 'Failed adding details, Please Try again...');
                return redirect('/addevent/'.$event_id);
            } 
        }
        else{
            $request->session()->put('loginredirection', '/newevent');
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function eventTime(Request $request){
      if($request->session()->get('user_id')){
        $event_id = $request->event_id;
        $event_image = DB::select('select ImagePath from images where ImageRefType=? and ReferenceId=?',['Event',$event_id]);
        $event_time = DB::select('select StartDate,EndDate,StartTime,EndTime from events where EventId=?',[$event_id]);
        return view('eventtime',['event_time'=>$event_time,'event_image'=>$event_image,'event_id'=>$event_id]);
      }
      else{
            $request->session()->put('loginredirection', '/newevent');
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveeventTime(Request $request){
      $start_date = $request->start_date;
      $end_date = $request->end_date;
      $start_time = $request->start_time;
      $end_time = $request->end_time;
      $event_id = $request->event_id;
      $update_timings = DB::update('update events set StartDate=?,EndDate=?,StartTime=?,EndTime=? where EventId=?',[$start_date,$end_date,$start_time,$end_time,$event_id]);
      if($update_timings){
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Details Added Successfully...');
        return redirect('/venue-event/'.$event_id);
      }
      else{
        $request->session()->flash('message.level', 'danger');
        $request->session()->flash('message.content', 'Failed adding details, Please Try again...');
        return redirect('/eventtime/'.$event_id);
      }
    }
    public function venueEvent(Request $request){
      if($request->session()->has('user_id')){
        $event_id = $request->event_id;
        $user_id = $request->session()->get('user_id');
        $event_image = DB::select('select ImagePath from images where ImageRefType=? and ReferenceId=?',['Event',$event_id]);
        $venue_details = DB::select('select a.AddressId,a.AddressLine1,a.City,a.PostCode,v.VenueId,v.VenueName from address as a inner join venue as v on v.AddressId=a.AddressId inner join bridgeeventvenues as b on b.VenueId = v.VenueId where b.EventId=? and b.CreatedBy=?',[$event_id,$user_id]);
        return view('venueevent',['event_id'=>$event_id,'venue_details'=>$venue_details,'event_image'=>$event_image]);
      }
      else{
        $request->session()->put('loginredirection', '/venueevent');
        $request->session()->flash('message.level', 'info');
        $request->session()->flash('message.content', 'Please login to continue...');
        return view('login');
      }
    }
    public function editVenueEvent(Request $request){
       if($request->session()->has('user_id')){
           $event_id = $request->event_id;
           $venue_id = $request->id;
           $user_id = $request->session()->get('user_id');
           $event_image = DB::select('select ImagePath from images where ImageRefType=? and ReferenceId=?',['Event',$event_id]);
           $venue_details = DB::select('select a.AddressId,a.AddressLine1,a.City,a.PostCode,v.VenueId,v.VenueName from address as a inner join venue as v on v.AddressId=a.AddressId inner join bridgeeventvenues as b on b.VenueId = v.VenueId where b.EventId=? and b.CreatedBy=? and v.VenueId=?',[$event_id,$user_id,$venue_id]);
           return view('venueevent',['event_id'=>$event_id,'venue_details'=>$venue_details,'event_image'=>$event_image]);
        }
       else{
           $request->session()->flash('message.level', 'info');
           $request->session()->flash('message.content', 'Please login to continue...');
           return view('login');
       }
   }
    public function saveVenueEvent(Request $request){
      $user_id = $request->session()->get('user_id');
        $venue_name = $request->venue_name;
        $venue_address = $request->venue_address;
        $venue_city = $request->venue_city;
        $venue_code = $request->venue_code;
        $user_id = $request->session()->get('user_id');
        $event_id = $request->event_id;
        $venue_id = $request->venue_id;
        $address_id = $request->address_id;
        $venue_details = DB::select('select VenueId from venue where VenueName=?',[$venue_name]);
        if(count($venue_details)>0){
         if($venue_id == ''){
        $bridge_event_venue = DB::table('bridgeeventvenues')->insertGetId(array('EventId'=>$event_id,'VenueId'=>$$venue_details[0]->VenueId,'ApproveStatus'=>'pending','ScheduleId'=>0,'CreatedBy'=>$user_id,'DeletedBy'=>0));     
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Details Added Successfully...');
        return redirect('subevent/'.$event_id);
        }
        else{
          $update_eventvenue = DB::update('update bridgeeventvenues set VenueId=? where EventId=? and CreatedBy=?',[$venue_details[0]->VenueId,$event_id,$user_id]);
          $request->session()->flash('message.level', 'success');
          $request->session()->flash('message.content', 'Details Updated Successfully...');
          return redirect('venue-event/'.$event_id);
         }
      }
      else{
        $request->session()->flash('message.level', 'danger');
        $request->session()->flash('message.content', 'Invalid Venue Details,Please Try again...');
        return redirect('venue-event/'.$event_id);
      }
    }
    public function subEvent(Request $request){
      if($request->session()->has('user_id')){
        $event_id = $request->event_id;
        $user_id = $request->session()->get('user_id');
        $event_image = DB::select('select ImagePath from images where ImageRefType=? and ReferenceId=?',['Event',$event_id]);
        $privacy = DB::select('select Privacy from events where EventId=?',[$event_id]);
        $sub_event = DB::select('select SubEventId,SubEventName,Swimstyle,Course,SpecialInstructions,AbleBodied,MinParticipants,MaxParticipants,MinimumAge,MaximumAge from subevents where  EventId=?',[$event_id]);
        return view('subevent',['event_id'=>$event_id,'privacy'=>$privacy,'event_image'=>$event_image,'subevents'=>$sub_event]);
      }
      else{
        $request->session()->put('loginredirection', '/addevent');
        $request->session()->flash('message.level', 'info');
        $request->session()->flash('message.content', 'Please login to continue...');
        return view('login'); 
      }
    }
     public function editSubEvent(Request $request){
        $event_id = $request->event_id;
        $sub_event_id = $request->sub_event_id;
        if($request->session()->has('user_id')){
          $event_image = DB::select('select ImagePath from images where ImageRefType=? and ReferenceId=?',['Event',$event_id]);
          $privacy = DB::select('select Privacy from events where EventId=?',[$event_id]);
            $sub_event = DB::select('select SubEventId,SubEventName,Swimstyle,Course,SpecialInstructions,AbleBodied,MinParticipants,MaxParticipants,MinimumAge,MaximumAge,Gender from subevents where SubEventId=? and EventId=?',[$sub_event_id,$event_id]);
            if(count($sub_event)>0){
                return view('subevent',['event_id'=>$event_id,'sub_event_id'=>$sub_event_id,'sub_events'=>$sub_event,'event_image'=>$event_image,'subevents'=>$sub_event,'privacy'=>$privacy]);
            }
            else{
                $request->session()->flash('message.level', 'info');
                $request->session()->flash('message.content', 'Please Add SubEvent.');
                return view('subevent',['event_id'=>$event_id]);
            }
        }
        else{
            $request->session()->put('loginredirection', '/edit-subevent/'.$event_id.'/'.$sub_event_id);
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveSubEvent(Request $request){
        $subevent_name = $request->subevent_name;
        $swim_style = $request->swim_styles;
        $course = $request->course;
        $description = $request->description;
        $min_participants = $request->min_participants;
        $max_participants = $request->max_participants;
        $disabled = $request->disabled;
        $min_age = $request->min_age;
        $max_age = $request->max_age;
        $eventid = $request->event_id;
        $length = $request->length;
        $user_id = $request->session()->get('user_id');
        if($max_participants!=''){   
          $team = $max_participants-$min_participants;
        if($length == "kms"){
          $swimcourse = $course*1000;
        }
        else{
          $swimcourse = $course;
        }         
        $add_subevent = DB::table('subevents')->insertGetId(array('SubEventName' => $subevent_name,'EventId' => $eventid ,'Course' => $swimcourse,'SwimStyle'=> $swim_style,'Relay'=>'NA', 'MaxParticipants'=> $max_participants, 'MinParticipants' => $min_participants, 'MinimumAge' => $min_age, 'MaximumAge' => $max_age, 'SpecialInstructions' => $description, 'AbleBodied' => $disabled,'MembersPerTeam' => $team, 'CreatedBy' => $user_id));
        if($add_subevent){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Details Added Successfully...');
            return redirect('/subevent/'.$eventid);
        }
        else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'SubEvent not added.Please, Try again..');
            return redirect('/subevent/'.$eventid);
        }
        }
        else{
          if($length == "kms"){
          $swimcourse = $course*1000;
        }
        else{
          $swimcourse = $course;
        } 
          $add_subevent = DB::table('subevents')->insertGetId(array('SubEventName' => $subevent_name,'EventId' => $eventid ,'Course' => $swimcourse ,'SwimStyle'=> $swim_style,'Relay'=>'NA', 'MaxParticipants'=> 0, 'MinParticipants' => 0, 'MinimumAge' => 0, 'MaximumAge' => 0, 'SpecialInstructions' => $description, 'AbleBodied' => $disabled,'MembersPerTeam' => 0, 'CreatedBy' => $user_id));
        if($add_subevent){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Details Added successfully');
            return redirect('/subevent/'.$eventid);
        }
        else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'SubEvent not added.Please, Try again..');
            return redirect('/subevent/'.$eventid);
        }
        }
    }

    public function getOldEntries(Request $request) {
        $type = $request->type;
        $id = $request->id;
        
        if($type == "subevents") {
            $subevents = DB::select("select SubEventId,SubEventName,EventId,Course,SwimStyle from subevents where EventId=?",[$id]);
            if(count($subevents) > 0) {
                 echo '<div class="row" style="border:1px solid #eee;margin-left:8px;margin-right:8px;">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Sub Event Name</td><td>Course</td><td>Swim Style</td><td>Edit</td><td>Delete</td></tr>";
                foreach($subevents as $subevent) {
                    echo "<tr><td>".$subevent->SubEventName."</td><td>".$subevent->Course."</td><td>".$subevent->SwimStyle."</td><td><a href=".url('/subevent/'.$id.'/'.$subevent->SubEventId)." style='color:black;'>Edit</a></td><td><a href=".url('/delete-subevent/'.$id.'/'.$subevent->SubEventId)." style='color:black;'><i class='fa fa-trash' style='font-size:18px;'></i></a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            } else {
                echo "no";
            }
        }
        
        if($type == "contacts") {
            $clubs = DB::select("select c.ClubName,c.Email,c.ClubId from clubs c inner join bridgeeventclubs b on c.ClubId = b.ClubId  where b.EventId=?",[$id]);
            if(count($clubs) > 0) {
                 echo '<div class="row" style="border:1px solid #eee;margin-left:8px;margin-right:8px;">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Club Name</td><td>Email</td><td>Edit</td><td>Delete</td></tr>";
                foreach($clubs as $club) {
                    echo "<tr><td>".$club->ClubName."</td><td>".$club->Email."</td><td><a href=".url('/edit-eventclub/'.$id.'/'.$club->ClubId)."style='color:black;'><i class='fa fa-edit' style='color: #f60;font-size: 18px;'></i></a></td><td><a href=".url('/delete-eventclub/'.$id.'/'.$club->ClubId)." style='color:black;'><i class='fa fa-trash' style='font-size:18px;'></i></a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            }
            $contacts = DB::select("select c.FirstName,c.Email,c.ContactId from contacts c inner join bridgeeventcontact b on c.ContactId = b.ContactId  where b.EventId=?",[$id]);
            if(count($contacts) > 0) { 
                 echo '<div class="row" style="border:1px solid #eee;margin-left:8px;margin-right:8px;">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Contact</td><td>Email</td><td>Edit</td><td>Delete</td></tr>";
                foreach($contacts as $contact) {
                    echo "<tr><td>".$contact->FirstName."</td><td>".$contact->Email."</td><td><a href=".url('/edit-eventcontact/'.$id.'/'.$contact->ContactId)." style='color:black;'><i class='fa fa-edit' style='color: #f60;font-size: 18px;'></i></a></td><td><a href=".url('/delete-eventcontact/'.$id.'/'.$contact->ContactId)." style='color:black;'><i class='fa fa-trash' style='font-size:18px;'></i></a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            }
        }
        
        if($type == "venues") {
            $venues = DB::select("select v.VenueId,v.VenueName from venue v inner join bridgeeventvenues b on b.VenueId=v.VenueId where b.EventId=?",[$id]);
            if(count($venues) > 0) {
                 echo '<div class="row" style="border:1px solid #eee;margin-left:8px;margin-right:8px;">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Venue Name</td><td>Edit</td><td>Delete</td></tr>";
                foreach($venues as $venue) {
                    echo "<tr><td>".$venue->VenueName."</td><td><a href=".url('/edit-eventvenue/'.$id.'/'.$venue->VenueId)." style='color:black;'><i class='fa fa-edit' style='color: #f60;font-size: 18px;'></i></a></td><td><a href=".url('/delete-eventvenue/'.$id.'/'.$venue->VenueId)." style='color:black;'><i class='fa fa-trash' style='font-size:18px;'></i></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            } else {
                echo "no";
            }
        }
        if($type == "schedule") {
            $schedulers = DB::select("select SchedulerUIId,ScheduleType,SubType,WeekDay,StartDate,EndDate from schedulerui where EventId=?",[$id]);
            if(count($schedulers) > 0) {
                echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><th>ScheduleType</th><th>SubType</th><th>WeekDay</th><th>StartDate</th><th>EndDate</th><th>Edit</th><th>Delete</th></tr>";
                foreach($schedulers as $scheduler) {
                    echo "<tr><td>".$scheduler->ScheduleType."</td><td>".$scheduler->SubType."</td><td>".$scheduler->WeekDay."</td><td>".$scheduler->StartDate."</td><td>".$scheduler->EndDate."</td><td><a href=".url('/edit-scheduleevent/'.$id)." style='color:black'>Edit</a></td><td><a href=".url('/delete-schedule/'.$id.'/'.$scheduler->SchedulerUIId)." style='color:black;'>Delete</a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            } else {
                echo "no";
            }
        }
        
    }