public function venueevents(Request $request){
    if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
  $venue_id = $request->venue_id;
  $event_details = DB::select('select DISTINCT b.Id,e.EventId,e.EventName,s.StartDateTime,s.EndDateTime,b.ApproveStatus from events e join bridgeeventvenues b on b.EventId=e.EventId and b.VenueId=? join eventschedules s on s.EventId=b.EventId',[$venue_id]);
  return view('venue-event',['venue_id'=>$venue_id,'event_details'=>$event_details]);
  }
  else{
           $request->session()->flash('message.level', 'danger');
           $request->session()->flash('message.content', 'Please Login to continue....');
           return view('login');
       }
  }

  public function acceptevent(Request $request){
    $id = $request->id;
    $venue_id = $request->venue_id;
    $event_id = $request->event_id;
    $start_date = $request->start_date;
    $end_date = $request->end_date;
    $bridge_id = $request->bridge_id;
    $email = $request->session()->get('user_email');
    $username = $request->session()->get('user_name');
    $venue = DB::select('select VenueName from venue where VenueId=?',[$venue_id]);
    $event_details = DB::select('select DISTINCT b.Id,e.EventId,e.EventName,s.StartDateTime,s.EndDateTime,b.ApproveStatus from events e join bridgeeventvenues b on b.EventId=e.EventId and b.VenueId=? join eventschedules s on s.EventId=b.EventId',[$venue_id]);
    for($i=0;$i<count($bridge_id);$i++){
    $dates = DB::select('select DISTINCT  e.EventId,e.StartDateTime,e.EndDateTime,b.ApproveStatus from eventschedules e join bridgeeventvenues b on e.EventId=b.EventId and ((e.StartDateTime=? or e.EndDateTime=?) or (? between e.StartDateTime and e.EndDateTime)) and b.ApproveStatus=?',[$start_date[$i],$end_date[$i],$start_date[$i],'Accepted']);
    if(count($dates)>0){
        $request->session()->flash('message.level', 'info');
        $request->session()->flash('message.content', 'Venue Booked on the required date');
        return redirect('venueevents/'.$venue_id);
    }
    else{
        $update_status = DB::update('update bridgeeventvenues set ApproveStatus=? where Id=?',['Accepted',$bridge_id[$i]]);
        $event_email = DB::select('select u.Email,u.UserName,e.* from users u join events e on u.UserId=e.CreatedBy and e.EventId=?',[$event_id[$i]]);
        foreach($event_email as $event){
          $name = $event->UserName;
          $data = array( 'email' => $event->Email, 'name' => $event->UserName, 'event_name'=>$event->EventName ,'venue_name'=>$venue[0]->VenueName);
           Mail::send('emailtemplates.venueconfirmation', $data, function($message) use($email,$name) {
             $message->to($email, $name)->subject('Venue Confirmed for your Event');
            $message->from('swimiqmail@gmail.com','SwimmIQ');
          });
           $information = array( 'email' => $email,'events'=>$event_details ,'venue_name'=>$venue[0]->VenueName);
           Mail::send('emailtemplates.adminvenueconfirmation', $information, function($message) use($email,$username) {
             $message->to($email, $username)->subject('You have Confirmed Venue for Event');
            $message->from('swimiqmail@gmail.com','SwimmIQ');
          });
        }
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Venue Added Successfully  to Event');
        return redirect('venueevents/'.$venue_id);
    }
    $update_status = DB::update('update bridgeeventvenues set ApproveStatus=? where EventId=? and VenueId=?',['Rejected',$event_id[$i],$venue_id]);
    $event_email = DB::select('select u.Email,u.UserName,e.* from users u join events e on u.UserId=e.CreatedBy and e.EventId=?',[$event_id[$i]]);
        foreach($event_email as $event){
          $name = $event->UserName;
          $data = array( 'email' => $event->Email, 'name' => $event->UserName, 'event_name'=>$event->EventName ,'venue_name'=>$venue[0]->VenueName);
           Mail::send('emailtemplates.venuerejected', $data, function($message) use($email,$name) {
             $message->to($email, $name)->subject('Venue Rejected for your Event');
            $message->from('swimiqmail@gmail.com','SwimmIQ');
          });
           $information = array( 'email' => $email,'events'=>$event_details ,'venue_name'=>$venue[0]->VenueName);
           Mail::send('emailtemplates.adminvenueconfirmation', $information, function($message) use($email,$username) {
             $message->to($email, $username)->subject('Venue Rejected for Event');
            $message->from('swimiqmail@gmail.com','SwimmIQ');
          });
        }
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Venue Changes Made Successfully');
        return redirect('venueevents/'.$venue_id);
    }
  }