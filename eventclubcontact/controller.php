public function editClubEvent(Request $request){
   if($request->session()->has('user_id')){
            $club_id = $request->id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $user_id = $request->session()->get('user_id');
            $clubs = DB::select('select ClubId,ClubName,MobilePhone,Email,Website from clubs where ClubId=? and CreatedBy=?',[$club_id,$user_id]);
            if(count($clubs)>0){
                return view('editclubevent',['clubs'=>$clubs,'event_id'=>$club_id]);
            }
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }  
}
public function saveEditClubEvent(Request $request){
    $event_id = $request->id;
    $club_id = $request->club_id;
    $club_name = $request->club_name;
    $club_mobile = $request->club_mobile;
    $club_email = $request->club_email;
    $club_website = $request->club_website;
    $clubname = $request->clubname;
    $clubmobile = $request->clubmobile;
    $clubemail = $request->clubemail;
    $clubwebsite = $request->clubwebsite;
    $user_id = $request->Session()->get('user_id');
    if($clubname!='' && $clubmobile!='' && $clubemail !='' && $clubwebsite!=''){
        $event_club = DB::table('clubs')->insertGetId(array('ClubName'=>$clubname, 'Description' => 'NA', 'ClubType' => 'NA', 'AddressId'=>0, 'Email' =>  $clubemail,'MobilePhone' => $clubmobile, 'Website' => $clubwebsite, 'OpeningHours' => '00:00:00', 'Facebook' => 'NA', 'Twitter' => 'NA', 'GooglePlus' => 'NA', 'Others' => 'NA', 'ClubOwner' =>$user_id , 'IsDeleted' => 'NA', 'CreatedBy' => $user_id, 'UpdatedBy' => $user_id, 'ShortName' => 'NA'));
        $bridege_event_club = DB::table('bridgeeventclubs')->insertGetId(array('EventId'=>$event_id,'ClubId'=>$event_club,'ScheduleId'=>0,'ApproveStatus'=>'pending','CreatedBy'=>$user_id,'DeletedBy'=>0));
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Event Contact Details Inserted Sucessfully');
        return redirect('edit-eventclub/'.$event_id);
    }
    else{
    $update_club = DB::table('clubs')->where('ClubId',$club_id)->update(['ClubName'=>$club_name,'MobilePhone'=>$club_mobile,'Email'=>$club_email,'Website'=>$club_website]);
    if($update_club){
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Event Club Details Updated Sucessfully');
        return redirect('edit-eventclub/'.$event_id);
    }
    else{
            $request->session()->flash('message.level', 'failed');
            $request->session()->flash('message.content', 'Event Club Details not updated.Please Try again...');
            return redirect('edit-eventclub/'.$event_id);
        }
    }
}
    public function editEventContact(Request $request){
        if($request->session()->has('user_id')){
            $contact_id = $request->id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $user_id = $request->session()->get('user_id');
            $contacts = DB::select('select ContactId,FirstName,Phone,Email from contacts where ContactId=?',[$contact_id]);
            if(count($contacts)>0){
                return view('editcontactevent',['contacts'=>$contacts,'event_id'=>$contact_id]);
            }
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveEditEventContact(Request $request){
        
        $contact_id = $request->contact_id;
        $event_contact = $request->event_contact;
        $event_mobile = $request->event_mobile;
        $event_email = $request->event_email;
        $event_id = $request->id;
        $eventcontact = $request->eventcontact;
        $eventmobile = $request->eventmobile;
        $eventemail = $request->eventemail;
        $user_id = $request->session()->get('user_id');
        if($eventcontact!='' && $eventmobile !='' && $eventemail !=''){
            $event_contact_details = DB::table('contacts')->insertGetId(array('FirstName'=> $eventcontact,'LastName'=>'NA','Title'=>'NA','Email'=>$eventemail,'Website'=>'NA','Phone'=>$eventmobile,'DayTimePhone'=>'NA','EveningPhone'=>'NA','PreferredContactMethod'=>'NA','EmergencyContactName'=>'NA','EmergencyContactNumber'=>'NA','AddressId'=>0));
            $bridge_event_contact = DB::table('bridgeeventcontact')->insertGetId(array('EventId'=>$event_id,'ContactId'=>$event_contact_details,'CreatedBy'=>$user_id,'DeletedBy'=>0));
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Event Contact Details Inserted Sucessfully');
            return redirect('edit-contactevent/'.$event_id);
        }
        else{   
        $update_contact = DB::table('contacts')->where('ContactId',$contact_id)->update(['FirstName'=>$event_contact,'Email'=>$event_email,'Phone'=>$event_mobile]);
        if($update_contact){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Event Contact Details Updated Sucessfully');
            return redirect('edit-contactevent/'.$event_id);
        }
        else{
            $request->session()->flash('message.level', 'failed');
            $request->session()->flash('message.content', 'Event Contact Details not updated.Please Try again...');
            return redirect('edit-contactevent/'.$event_id);
        }
        }
        
    }
