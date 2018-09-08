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
  

  
    
    public function AddInstructor(Request $request){
    if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
      $userid = $request->session()->get('user_id');

        return view('addinstructor');
      
      else{
        $request->session()->flash('message.level','info');
      $request->session()->flash('message.content','Pleasae Login as Venue Admin to AddInstructor');
      return redirect('/');
      }
   
  }

  public function InsertInstructorBasic(Request $request){
   $this->validate($request,[
        'FirstName' => 'required|string|min:4|max:20',
        'MiddleName' => 'required|string|min:4|max:20',
        'LastName' => 'required|string|min:4|max:20',
        'Title' => 'required',           
       ]);
   $firstname = $request->FirstName;
        $middlename = $request->MiddleName;
      $lastname = $request->LastName;
      $title = $request->Title;
      $userid = $request->id;
      $date=date("Y-m-d");
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $userrandomid = 20;
      $random = '';
      for ($i = 0; $i < 20; $i++) {
          $random .= $characters[rand(0, $userrandomid - 1)];
      }
      $shortname = $firstname.'_'.$random;
     $instructordetails = DB::table('users')->insertGetId(array('UserName' => $firstname, 'Email' => $shortname.'@dummy.com', 'Password' => 'NA','IsUserAccepted' => 0, 'UserRandomId' => $random, 'UserType' => 'instructor','Addressid' => 1, 'DayTimePhone' => 'NA', 'EveningPhone' => 'NA', 'IsDeleted' => 0, 'Image' => 'NA', 'Facebook' => 'NA', 'Twitter' => 'NA', 'Website' => 'NA', 'passreset' => 0, 'pm_count' => 0, 'Google_Id' => 'NA', 'Oauth_UId' => 'NA', 'ApprovalStatus' => 'NA', 'ShortName' => $shortname, 'LastLoginDate' => $date, 'FirstName' => $firstname, 'MiddleName' => $middlename, 'LastName' => $lastname, 'Title' => $title));
     if($instructordetails){
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
            DB::update('update users set Image=? where UserId=?',[$bimage,$instructordetails]);       
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Instructor Basic details added sucessfully...');
            return redirect('instructortimings/'.$instructordetails);
     } else{
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Unable to save your details please try again...');
        return view('addinstructor');
    }
    }

  public function InstructorTimings(Request $request){
    if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
    $userid = $request->session()->get('user_id');
    $id = $request->id;
   
      $users = DB::select('select * from users where UserId=?',[$id]);
      return view('instructortimings',['users' => $users, 'id' => $id]);
    }
    else{
      $request->session()->flash('message.level','info');
      $request->session()->flash('message.content','Pleasae Login as Venue Admin to AddInstructor');
      return redirect('/');
    }
  
  }

public function InsertInstructorTimings(Request $request){
 
  $monday = $request->monday;
   $tuesday = $request->tuesday;
  $wednesday = $request->wednesday;
  $thursday = $request->thursday;
  $friday = $request->friday;
  $saturday = $request->saturday;
  $sunday = $request->sunday;
  $id = $request->id;
  $user_id = $request->session()->get('user_id');
  
  $venue_details = DB::select('select VenueId from venue where VenueOwner=?',[$user_id]);
  $venue_id = $venue_details[0]->VenueId;
  if(count($monday)==3){
     $insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'instructor','TypeId'=>$venue_id,'Day'=>$monday[0],'Open/Closed'=>'Open','OpeningHours'=>$monday[1],'ClosingHours'=>$monday[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
   }
   if(count($tuesday)==3){
     $insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'instructor','TypeId'=>$venue_id,'Day'=>$tuesday[0],'Open/Closed'=>'Open','OpeningHours'=>$tuesday[1],'ClosingHours'=>$tuesday[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
   }    
     if(count($wednesday)==3){
     $insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'instructor','TypeId'=>$venue_id,'Day'=>$wednesday[0],'Open/Closed'=>'Open','OpeningHours'=>$wednesday[1],'ClosingHours'=>$wednesday[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
   }
   if(count($thursday)==3){
     $insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'instructor','TypeId'=>$venue_id,'Day'=>$thursday[0],'Open/Closed'=>'Open','OpeningHours'=>$thursday[1],'ClosingHours'=>$thursday[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
   }
   if(count($friday)==3){
     $insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'instructor','TypeId'=>$venue_id,'Day'=>$friday[0],'Open/Closed'=>'Open','OpeningHours'=>$friday[1],'ClosingHours'=>$friday[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
   }
   if(count($saturday)==3){
     $insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'instructor','TypeId'=>$venue_id,'Day'=>$saturday[0],'Open/Closed'=>'Open','OpeningHours'=>$saturday[1],'ClosingHours'=>$saturday[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
   }
   if(count($sunday)==3){
     $insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'instructor','TypeId'=>$venue_id,'Day'=>$sunday[0],'Open/Closed'=>'Open','OpeningHours'=>$sunday[1],'ClosingHours'=>$sunday[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
     
   }
   $request->session()->flash('message.level','info');
   $request->session()->flash('message.content','Instructor Timings Inserted Successfully');
  //return redirect('instructoraddress/'.$id);
}

  public function InstructorAddress(Request $request){
    if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
    $userid = $request->session()->get('user_id');
    $id = $request->id;
    
    $users = DB::select('select * from users where UserId = ?',[$id]);
    return view('instructoraddress',['users' => $users,'id' => $id]);
    }
    else{
      $request->session()->flash('message.level','info');
      $request->session()->flash('message.content','Pleasae Login as Venue Admin to AddInstructor');
      return redirect('/');
    }
  
}

  public function InsertInstructorAddress(Request $request){
    
       $this->validate($request,[
        'AddressLine1' => 'required',
        'AddressLine2' => 'required',
        'City' => 'required',
        'Country' => 'required',
        'County' => 'required',
        'PostCode' => 'required|numeric',
       ]);
       $addressid = $request->AddressId;     
      $address1 = $request->AddressLine1;
      $address2 = $request->AddressLine2;
      $city = $request->City;
      $country = $request->Country;
      $town = $request->County;
      $postcode = $request->PostCode;
      $date=date("Y-m-d");
      $id = $request->id;
      $insertaddressdetails = DB::table('address')->insertGetId(array('AddressId' => $addressid,'AddressLine1' => $address1, 'AddressLine2' => $address2, 'AddressLine3' => 'NA', 'Council' => 'NA', 'Latitude' => 0, 'CreatedDate' => $date, 'UpdatedDate' => $date, 'Longitude' => 0, 'City' => $city, 'Country' => $country, 'County' => $town, 'PostCode' => $postcode));
      if($insertaddressdetails){
    $updateuser = DB::table('users')->where('UserId',$id)->update(['AddressId'=>$insertaddressdetails]);
        $users = DB::select('select * from users where UserId = ?',[$id]);
        $address = DB::select('select AddressId from address where AddressId=?',[$insertaddressdetails]);
        
         $request->session()->flash('message.level','info');
         $request->session()->flash('message.content','Address details are saved successfully..');
           return view('instructorexperience',['users' => $users, 'id' => $id, 'address' => $address]);
          }
        else{
         $request->session()->flash('message.level','danger');
         $request->session()->flash('message.content','Unable to save your  details...');
          return redirect('instructoraddress');
        }
       }
    

  
  public function InstructorExperience(Request $request){
     
    if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
    $userid = $request->session()->get('user_id');
    $id = $request->id;
    $users = DB::select('select * from users where UserId = ?',[$id]);
    return view('instructorexperience',['users' => $users, 'id' => $id]);
    }
    else{
      $request->session()->flash('message.level','info');
      $request->session()->flash('message.content','Pleasae Login as Venue Admin to AddInstructor');
      return redirect('/');
    }
   
  }

 public function InsertInstructorExperience(Request $request){
 
      $id =$request->id;
        $qualification = $request->Qualification;
      $experience = $request->Experience;
      $specialization = $request->Specialization;
      $weight = $request->Weight;
        $gender = $request->input('Gender');
      $description = $request->Description;
      $addressid = $request->AddressId;
      
$instructorexperience =  DB::table('instructor')->insertGetId(array('InstructorId' => $id, 'Qualification' => $qualification, 'Experience' => $experience, 'Specialization' => $specialization, 'PreviousPositions' => 'NA', 'Facebook' => 'NA', 'Twitter' => 'NA', 'Google+' => 'NA', 'Gender' => $gender, 'Description' => $description));
     if($instructorexperience){
     
      $request->session()->flash('message.level','info');
      $request->session()->flash('message.content','Details are saved successfully...');
      return redirect('instructorcontact/'.$id);
     }
     else{
      $request->session()->flash('message.level','info');
      $request->session()->flash('message.content','Details are saved successfully...');
      return redirect('instructorcontact/'.$id);
     }
   }

  public function InstructorContact(Request $request){
    if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
      $userid = $request->session()->get('user_id');
     $id = $request->id;
     $addressid =$request->AddressId;
      $users = DB::select('select * from users where UserId = ?',[$id]);
      return view('instructorcontact',['users' => $users, 'id' => $id]);
    }
    else{
      $request->session()->flash('message.level','info');
      $request->session()->flash('message.content','Pleasae Login as Venue Admin to AddInstructor');
      return redirect('/');
    }
  }
}
