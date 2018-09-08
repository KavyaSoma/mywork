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

    public function addClub(Request $request){
        if($request->session()->has('user_id') && $request->session()->get('user_type')) {
        $userid = $request->session()->get('userid');
      
         return view('addClub');
        }
        else{
             $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login as Club Admin to Add Club');
            return redirect('/');
        }
    }
    public function clubname(Request $request){
       $shortname = $request->shortname;
        if(count(DB::select('select ClubId from clubs where ShortName=?',[$shortname]))>0){
            echo "error";
        }
        else{
            echo "success";
        }
    }
   public function saveClub(Request $request){
    $userid = $request->session()->get('user_id');
    $address = $request->Address;
    $city = $request->city;
    $postcode = $request->post_code;
    $town = $request->town;
    $country = $request->country;
      $date=date("Y-m-d");
      $image = $request->image;
     $club_name = $request->club_name;
        $description = $request->description;
        $club_type= $request->club_type;
        $mobile = $request->mobile;
        $email = $request->email;
        $website = $request->web;
        $facebook  = $request->facebook;
        $twitter = $request->twitter;
        $googleplus = $request->google;
        $others = $request->others;
        $shortname = $request->short_name;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = 20;
    $clubaddress = DB::table('address')->insertGetId(array('AddressLine1' => $address,'AddressLine2' => 'NA','AddressLine3' => 'NA', 'City' => $city, 'Country' => $country,'County'=>$town, 'Council' =>'NA', 'PostCode'=>$postcode,'Latitude' =>0, 'Longitude' =>0, 'CreatedDate' => $date, 'UpdatedDate' => $date));
    if($clubaddress){
    $addclub = DB::table('clubs')->insertGetId(array('ClubName'=>$club_name, 'Description' => $description, 'ClubType' => $club_type, 'AddressId'=>$clubaddress, 'Email' =>  $email,'MobilePhone' => $mobile, 'Website' => $website, 'Facebook' => $facebook, 'Twitter' => $twitter, 'GooglePlus' => $googleplus, 'Others' => $others, 'OpeningHours' => '00:00:00', 'CreatedDate' => $date, 'UpdatedDate' =>$date, 'ClubOwner' =>$userid , 'IsDeleted' => 'no', 'CreatedBy' => $userid, 'UpdatedBy' => $userid, 'ShortName' => $shortname));
        if(Input::hasFile('image')){
            $file = Input::file('image');
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $file->move('./public/images', $randomString.".png");
            $image = url("public/images/".$randomString.".png");
            $image_insert = DB::table('images')->insertGetId(array('ImagePath'=>$image,'ImageRefType'=>'Club','ReferenceId'=>$addclub));
        }
        else {
            $image = "NA";
        }
     $request->session()->flash('message.level','info');
     $request->session()->flash('message.content','Club details saved successfully...');
     return view('addclub');
    }
    else{
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Unable to save your details,please try again..');
        return view('addclub');
    }
    }
    public function editClub(Request $request){
        if($request->session()->has('user_id') && $request->session()->get('user_type')) {
            $userid = $request->session()->get('user_id');
            $clubinfo = DB::select('select clubs.ClubName,clubs.ClubId, address.AddressLine1,address.AddressId,address.City,address.PostCode,address.County,address.Country,clubs.ClubName,clubs.ShortName,clubs.ClubType,clubs.Description,clubs.MobilePhone,clubs.Email,clubs.Website,clubs.Facebook,clubs.GooglePlus,clubs.Twitter,clubs.Others FROM clubs INNER JOIN address ON clubs.AddressId=address.AddressId and clubs.ClubId=?',[$request->id]); 
           return view('editclub',['clubinfo' => $clubinfo]);  
     }
        else{
             $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login as Club Admin to Add Club');
            return redirect('/');
        }
    }
      public function saveEditClub(Request $request){
        $club_id = $request->id;
        $userid = $request->session()->get('user_id');
       $clubname = $request->ClubName;
       $clubtype = $request->ClubType;
       $description = $request->Description;
       $mobile = $request->MobilePhone;
       $email = $request->Email;
       $website = $request->Website;
       $facebook = $request->Facebook;
       $twitter = $request->Twitter;
       $googleplus = $request->GooglePlus;
       $others = $request->Others;
       $shortname =$request->shortname;
        $addressid = $request->AddressId;
        $address = $request->AddressLine1;
        $city = $request->City;
        $postcode = $request->PostCode;
        $county = $request->Town;
        $country = $request->Country;
        $image = $request->image;
        $image_details = DB::select('select ImageId from images where ImageRefType=? and ReferenceId=?',['Club',$club_id]);
     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = 20;
        if(Input::hasFile('image')){
            $file = Input::file('image');
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $file->move('./public/images', $randomString.".png");
            $image = url("public/images/".$randomString.".png");
            $image_insert = DB::update('update images set ImagePath=? where ImageId=?',[$image,$image_details[0]->ImageId]);
        }
        else {
            $image = "NA";
        }
      $updateclub = DB::update('update clubs set ClubName=?,ClubType=?,Description=?,MobilePhone=?,Email=?,Website=?,Facebook=?,Twitter=?,GooglePlus=?,Others=?,shortname=? where ClubId=? and CreatedBy=?',[$clubname,$clubtype,$description,$mobile,$email,$website,$facebook,$twitter,$googleplus,$others,$shortname,$club_id,$userid]);
      $clubinfo = DB::select('select clubs.ClubName,clubs.ClubId, address.AddressLine1,address.AddressId,address.City,address.PostCode,address.County,address.Country,clubs.ClubName,clubs.ShortName,clubs.ClubType,clubs.Description,clubs.MobilePhone,clubs.Email,clubs.Website,clubs.Facebook,clubs.GooglePlus,clubs.Twitter,clubs.Others FROM clubs INNER JOIN address ON clubs.AddressId=address.AddressId and clubs.ClubId=?',[$club_id]); 
      $update_club_address = DB::update('update address set AddressLine1=?,City=?,PostCode=?,County=?,Country=? where AddressId = ?',[$address,$city,$postcode,$county,$country,$addressid]);
      $request->session()->flash('message.level', 'info');
      $request->session()->flash('message.content', 'Club Details Edited Sucessfully');
      return redirect('editclub/'.$club_id);
     }