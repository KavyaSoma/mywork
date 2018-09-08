    public function autocompletecontact(Request $request){
      $q = $request->key;
      $contact_details = DB::select('select c.FirstName,a.AddressLine1,a.County,a.City,a.Country,a.PostCode,c.Phone from contacts c join address a on c.AddressId=a.AddressId and c.FirstName like "%'.$q.'%"');
      if(count($contact_details)>0){
        echo json_encode($contact_details);
      }
    }
    public function ViewKinForm(Request $request){
    	 if($request->session()->has('user_id')) {
    	$userid = $request->session()->get('user_id');
        return view('addkin');
    }
    else{
    	$request->session()->flash('message.level', 'danger');
       $request->session()->flash('message.content', 'Please Login to your account first...');
       return redirect('login');
    }
 
    }

    public function ViewKinForm(Request $request){
       if($request->session()->has('user_id') && $request->session()->get('user_type')=="user") {
      $userid = $request->session()->get('user_id');
        return view('addkin');
      }
      else{
        $request->session()->flash('message.level', 'info');
        $request->session()->flash('message.content', 'Please Login as User to AddKin');
        return redirect('/');
      }
   
    }
    public function SaveKindetail(Request $request){
    	$relationship = $request->Relationship;
      $participantname = $request->ParticipantName;
    	$dob = $request->DateofBirth;
    	$height = $request->Height;
    	$weight = $request->Weight;
      $gender = $request->input('Gender');
    	$isdisabled = $request->input('IsDisabled');
    	$relationtouser = $request->session()->get('user_id');
    	$disabilitydescription = $request->DisabilityDescription;
    	$specialrequirements = $request->SpecialRequirements;
    	$notes = $request->Notes;

      $lastinsertedid = DB::table('participants')->insertGetId(array('RelatedToUserId' => $relationtouser, 'Relationship' => $relationship, 'ParticipantName' => $participantname, 'DateofBirth' => $dob, 'Height' => $height, 'Weight' => $weight, 'Gender' => $gender, 'IsDisabled' => $isdisabled, 'DisabilityDescription' => 'no', 'SpecialRequirements' => 'NA', 'Notes' => 'NA','EmergencyContactName' =>'NA', 'EmergencyContactNumber' =>'NA','EmergencyContactNumber' =>'NA','EmergencyContactAddress' => 'NA','Image' => 'NA'));

      if($lastinsertedid){
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
            } 
            echo $bimage;
            $participant_image = DB::update('update participants set Image=? where ParticipantId=?',[$bimage,$lastinsertedid]);   
            
        $request->session()->flash('message.level','info');
         $request->session()->flash('message.content','Kin details are saved,please add their contact details...');
           return redirect('kincontact/'.$lastinsertedid);
          }
        else{
         $request->session()->flash('message.level','danger');
         $request->session()->flash('message.content','Unable to save your kin details...');
         return redirect('addkin');
        }
       }
    public function kincontact(Request $request){
       if($request->session()->has('user_id') && $request->session()->get('user_type')=="user") {
          $participant_id = $request->id;
          return view('kincontact',['participant_id'=>$participant_id]);
        }
        else{
          $request->session()->flash('message.level','info');
          $request->session()->flash('message.content','Login as User to AddKin');
          return redirect('/');
        }
    }
    public function savekincontact(Request $request){
      $user_email = $request->session()->get('email');
      $participant_id = $request->id;
      $EmergencyContactName = $request->EmergencyContactName;
      $EmergencyContactNumber = $request->EmergencyContactNumber;
      $EmergencyContactAddress = $request->EmergencyContactAddress;
      $participant_address = DB::update('update participants set EmergencyContactName=?,EmergencyContactNumber=?,EmergencyContactAddress=? where ParticipantId=?',[$EmergencyContactName,$EmergencyContactNumber,$EmergencyContactAddress,$participant_id]);
      if($participant_address){
          $request->session()->flash('message.level','success');
          $request->session()->flash('message.content','Kin Contact Details inserted Sucessfully');
          return redirect('addkin');
      }
    }

    public function EditKinContact(Request $request){
       if($request->session()->has('user_id') && $request->session()->get('user_type')=="user") {
            $userid = $request->session()->get('user_id');
            $participant_id = $request->id;
            //$kininformation = DB::Select('select * from participants where RelatedToUserId = ?',[$userid]);
            $participants = DB::Select('select ParticipantId,EmergencyContactName,EmergencyContactNumber,EmergencyContactAddress from participants where ParticipantId = ?',[$request->id]);
            return view('editkincontact',['participants' => $participants,'participant_id'=>$participant_id]);
        }
        else{
            $request->session()->flash('message.level','info');
            $request->session()->flash('message.content','Please Login as User to Add/Edit Kin');
            return redirect('/');
        }
     }
     public function saveEditKitContact(Request $request){
      $user_email = $request->session()->get('email');
      $participant_id = $request->id;
      $EmergencyContactName = $request->EmergencyContactName;
      $EmergencyContactNumber = $request->EmergencyContactNumber;
      $EmergencyContactAddress = $request->EmergencyContactAddress;
      $participant_address = DB::update('update participants set EmergencyContactName=?,EmergencyContactNumber=?,EmergencyContactAddress=? where ParticipantId=?',[$EmergencyContactName,$EmergencyContactNumber,$EmergencyContactAddress,$participant_id]);
      if($participant_address){
          $request->session()->flash('message.level','success');
          $request->session()->flash('message.content','Kin Contact Details inserted Sucessfully');
          return redirect('addkin');
      }
     }
     public function emailSuggestions(Request $request){
     $q = $request->id;
     $to_mail = DB::select('select Email from users where Email like "%'.$q.'%"');
     if(count($to_mail)>0) {
       echo json_encode($to_mail);
     }
    }