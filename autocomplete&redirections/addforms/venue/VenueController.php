<?php

namespace App\Http\Controllers;
use Calendar;
use App\Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;

class VenueController extends Controller
{public function AddVenue(Request $request){
		if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			 return view('addvenue');
      
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
	}
	public function information(Request $request) {
		return view('venueinformation');
	}
	public function saveVenue(Request $request){
		$venue_name = $request->venue_name;
		$description = $request->description;
		$shortname = $request->short_name;
		$file_image = $request->venue_file;
		$venue_id = $request->id;
		$user_id = $request->session()->get('user_id');
		$basic_venue = DB::table('venue')->insertGetId(array('VenueName' => $venue_name,'Description' => $description,'AddressId' => 0,'Phone' => 'NA', 'Phone2' => 'NA','Mobile'=>'NA','Email' => 'NA', 'Website' => 'NA', 'Website2' => 'NA', 'Facebook' => 'NA','Twitter' => 'NA', 'GooglePlus' => 'NA','Others'=>'NA','Shower'=>'NA','Gym'=>'NA','Teachers'=>'NA','ParaSwimmingFacilities'=>'NA','LadiesOnlySwimming'=>'NA','LadiesOnlySwimTimes'=>'NA', 'Toilets' => 'NA','Diving'=>'NA','PrivateHire'=>'NA','VisitingGallery'=>'NA','Parking'=>'NA','SwimForKids'=>'NA','VenueOwner'=>$user_id,'ShortName'=>$shortname));
		if($basic_venue){
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
            $venue_image = DB::table('images')->insertGetId(array('ImagePath'=>$bimage,'ImageRefType'=>'Venue','ReferenceId'=>$basic_venue));        
             		$request->session()->flash('message.level', 'success');
            		$request->session()->flash('message.content', 'Basic Venu Details Added Sucessfully...');
            		return redirect('venuepool/'.$basic_venue);

		}
		else{
			$request->session()->flash('message.level', 'failed');
            $request->session()->flash('message.content', 'Venue not added.Please, Try again..');
            return view('addvenue');
		}
	}

	public function VenuePool(Request $request){
		if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
			return view('venuepool',['venue_id'=>$venue_id]);
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}

	}
	public function saveVenuePool(Request $request){
		$pool_name = $request->pool_name;
		$pool_width = $request->pool_width;
		$width_dimension = $request->width_dimension;
		$pool_length = $request->pool_length;
		$length_dimension = $request->length_dimension;
		$shallow_end = $request->shallow_end;
		$shallow_dimension = $request->shallow_dimension;
		$deep_end = $request->deep_end;
		$deep_dimension = $request->deep_dimension;
		$pool_area = $request->pool_area;
		$area_dimension = $request->area_dimension;
		$description = $request->description;

		$width = $pool_width." ".$width_dimension;
		$length = $pool_length." ".$length_dimension;
		$shallow = $shallow_end." ".$shallow_dimension;
		$deep = $deep_end." ".$deep_dimension;
		$area = $pool_area." ".$area_dimension;
		$venue_id = $request->id;

		$pool_details = DB::table('pools')->insertGetId(array('PoolName'=>$pool_name, 'VenueId'=>$venue_id,'Length'=>$length,'Width'=>$width,'MinimumDepth'=>$deep,'MaximumDepth'=>$shallow,'Area'=>$area,'SpecialRequirements'=>$description));
		if($pool_details){
			$request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Pool Information Added [Scroll down to see previous entries], You can add another pool or <a href="'.url('venueaddress/'.$venue_id).'">clickhere to continue</a>...');
            return redirect('venuepool/'.$venue_id);
		}
		else{
			$request->session()->flash('message.level', 'failed');
            $request->session()->flash('message.content', 'Venue Pool Information not added.Please, Try again..');
            return view('addvenue');
		}
	}

	public function VenueAddress(Request $request){
		if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
			 
				return view('venueaddress',['venue_id'=>$venue_id]);
			 
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
	}
        public function saveVenueAddress(Request $request){
		$address = $request->address;
		$city = $request->city;
		$post_code = $request->post_code;
		$town = $request->town;
		$country = $request->country;
		$contact = $request->contact;
		$mobile = $request->mobile;
		$email = $request->email;
		$venue_id = $request->id;
		$user_id = $request->session()->get('user_id');
		$venue_address = DB::table('address')->insertGetId(array('AddressLine1'=>$address,'AddressLine2'=>'NA','AddressLine3'=>'NA','City'=>$city,'Country'=>$country,'County'=>$town,'Council'=>'NA','PostCode'=>$post_code,'Latitude'=>0,'Longitude'=>0));
		if($venue_address){
			$update_venue = DB::update('update venue set AddressId=? where VenueId=?',[$venue_address,$venue_id]);
			$venue_contact = DB::table('contacts')->insertGetId(array('FirstName'=>$contact,'Email'=>$email,'Phone'=>$mobile));
			if($venue_contact){
				$bridge_venuecontact = DB::table('bridgevenuecontact')->insertGetId(array('VenueId'=>$venue_id,'ContactId'=>$venue_contact,'CreatedBy'=>$user_id));
				$request->session()->flash('message.level', 'success');
            	$request->session()->flash('message.content', 'Venue Address Added [scroll down to view previous entries], You can add another address or <a href="'.url('venuetimings/'.$venue_id).'">clickhere to continue</a>...');
            	return redirect('venueaddress/'.$venue_id);
			}
       
		}
         else {
                  $request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Unable to save details..');
  			return redirect('venueaddress/'.$venue_id);  
                }
	}

	public function VenueTimings(Request $request){
	if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
            if(count(DB::select('select DaysOpenId from daysopen where TableType=? and TypeId=?',['venue',$venue_id]))>0) {
                return redirect('venuesociallinks/'.$venue_id); 
            } else {
            	return view('venuetimings',['venue_id'=>$venue_id]);  
                  
            }
            		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}

	}
	public function saveVenueTimings(Request $request){
		$day_one = $request->day_one;
		$day_two = $request->day_two;
 		$day_three = $request->day_three;
 		$day_four = $request->day_four;
		$day_five = $request->day_five;
 		$day_six = $request->day_six;
 		$day_seven = $request->day_seven;
		$para_swimming = $request->para_swimming;
		$showers = $request->shower;
		$gyms = $request->gym;
		$ladies = $request->ladies;
		$parking = $request->parking;
		$instructors = $request->instructor;
		$diving = $request->diving;
		$swim_kids = $request->swim_kids;
		$visit_gallery = $request->visit_gallery;
		$toilets = $request->toilet;
		$privatehire = $request->privatehire;
		$venue_id = $request->id;
		if($para_swimming=="yes"){$para_swimm = "yes";} else{$para_swimm = "no";}
 		if($showers=="yes"){$shower = "yes";} else{$shower = "no";}
 		if($gyms=="yes"){$gym = "yes";} else{$gym = "no";}	
 		if($ladies=="yes"){$lady = "yes";} else{$lady = "no";}
 		if($parking=="yes"){$park = "yes";} else{$park = "no";}	
 		if($instructors=="yes"){$instructor = "yes";} else{$instructor = "no";}	
 		if($diving=="yes"){$dive = "yes";} else{$dive = "no";}	
 		if($swim_kids=="yes"){$swim_kid = "yes";} else{$swim_kid = "no";}
 		if($visit_gallery=="yes"){$gallery = "yes";} else{$gallery = "no";}	
 		if($toilets=="yes"){$toilet = "yes";} else{$toilet = "no";}
 		if($privatehire=="yes"){$hire = "yes";} else{$hire = "no";}
 		$venue_facilities = DB::table('venue')->where('VenueId',$venue_id)->update(['ParaSwimmingFacilities'=>$para_swimm,'Shower'=>$shower,'Gym'=>$gym,'LadiesOnlySwimming'=>$lady,'Parking'=>$park,'Teachers'=>$instructor,'Diving'=>$dive,'SwimForKids'=>$swim_kid,'VisitingGallery'=>$gallery,'Toilets'=>$toilet,'PrivateHire'=>$hire]);
 		if(count($day_one)==3){
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_one[0],'Open/Closed'=>'Open','OpeningHours'=>$day_one[1],'ClosingHours'=>$day_one[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_two)==3){
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_two[0],'Open/Closed'=>'Open','OpeningHours'=>$day_two[1],'ClosingHours'=>$day_two[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		} 		
 	    if(count($day_three)==3){
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_three[0],'Open/Closed'=>'Open','OpeningHours'=>$day_three[1],'ClosingHours'=>$day_three[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_four)==3){
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_four[0],'Open/Closed'=>'Open','OpeningHours'=>$day_four[1],'ClosingHours'=>$day_four[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_five)==3){
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_five[0],'Open/Closed'=>'Open','OpeningHours'=>$day_five[1],'ClosingHours'=>$day_five[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_six)==3){
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_six[0],'Open/Closed'=>'Open','OpeningHours'=>$day_six[1],'ClosingHours'=>$day_six[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_seven)==3){
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_seven[0],'Open/Closed'=>'Open','OpeningHours'=>$day_seven[1],'ClosingHours'=>$day_seven[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 			
 		}
  		$request->session()->flash('message.level','success');
  		$request->session()->flash('message.content','Venue Facilities Added Successfully');
  		return redirect('venuesociallinks/'.$venue_id);
	}

	public function VenueSocialLinks(Request $request){
		if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
				return view('venuesociallinks',['venue_id'=>$venue_id]);
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
	}
	public function saveVenueLinks(Request $request){
		$facebook = $request->facebook;
		$twitter = $request->twitter;
		$google = $request->google;
		$others = $request->others;
		$link1 = $request->link1;
		$link2 = $request->link2;
		$venue_id = $request->id;
		$update_venue = DB::table('venue')->where('VenueId',$venue_id)->update(['Facebook'=>$facebook,'Twitter'=>$twitter,'GooglePlus'=>$google,'Others'=>$others,'Website'=>$link1,'Website2'=>$link2]);
		if($update_venue){
			$venue_details = DB::select('select * from venue where VenueId=?',[$venue_id]);
			if($venue_details){
				$pool_details = DB::select('select PoolName,Length,Width,MinimumDepth,MaximumDepth,Area from pools where VenueId=?',[$venue_id]);
				$request->session()->flash('message.level', 'success');
            	$request->session()->flash('message.content', 'Venue Address Added Successfully...');
            	return redirect('confirmvenue/'.$venue_id);
            }
		}
		else{
				$request->session()->flash('message.level', 'danger');
            	$request->session()->flash('message.content', 'Venue Social Links not Added.Please, Try again.');
            	return view('venuesociallinks',['venue_id'=>$venue_id]);
		}
	}

	public function ConfirmVenue(Request $request){
		if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
			$pool_details = DB::select('select PoolName,Length,Width,MinimumDepth,MaximumDepth,Area,SpecialRequirements from pools where VenueId=?',[$venue_id]);
			$venue_address = DB::select('select a.AddressId,a.AddressLine1,a.City,a.Country,a.County,a.PostCode from address a INNER JOIN venue v where v.VenueId=? and a.AddressId=v.AddressId',[$venue_id]);
			$venue_contact = DB::select('select b.VenueId,b.ContactId,c.ContactId,c.FirstName,c.Email,c.Phone from contacts c INNER JOIN bridgevenuecontact b where c.ContactId=b.ContactId and b.VenueId=?',[$venue_id]);
			$timings = DB::select('select Day,OpeningHours,ClosingHours from daysopen where TypeId=? and TableType="venue"',[$venue_id]);
			return view('confirmvenue',['venue_id'=>$venue_id,'pool_details'=>$pool_details,'venue_address'=>$venue_address,'venue_contact'=>$venue_contact,'timings'=>$timings]);
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
	}
	public function saveConfirmVenue(Request $request){
		$venue_id = $request->id;
		$pool_details = DB::select('select PoolName,Length,Width,MinimumDepth,MaximumDepth,Area,SpecialRequirements from pools where VenueId=?',[$venue_id]);
		$venue_address = DB::select('select a.AddressId,a.AddressLine1,a.City,a.Country,a.County,a.PostCode from address a INNER JOIN venue v where v.VenueId=? and a.AddressId=v.AddressId',[$venue_id]);
		$venue_contact = DB::select('select b.VenueId,b.ContactId,c.ContactId,c.FirstName,c.Email,c.Phone from contacts c INNER JOIN bridgevenuecontact b where c.ContactId=b.ContactId and b.VenueId=?',[$venue_id]);
		$timings = DB::select('select Day,OpeningHours,ClosingHours from daysopen where TypeId=? and TableType="venue"',[$venue_id]);
		$request->session()->flash('message.level','success');
  		$request->session()->flash('message.content','Venue Information Added Successfully...');
		return view('confirmvenue',['venue_id'=>$venue_id,'pool_details'=>$pool_details,'venue_address'=>$venue_address,'venue_contact'=>$venue_contact,'timings'=>$timings]);
	}


	public function editVenue(Request $request){
		if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
			$venue_details = DB::select('select VenueId,VenueName,Description,ShortName from venue where VenueId=?',[$venue_id]);
			if($venue_details){
				return view('editvenue',['venue_details'=>$venue_details,'venue_id'=>$venue_id]);
			}
			else{
				$request->session()->flash('message.level','danger');
  				$request->session()->flash('message.content','Venue doesnot exist. Please, Add Venue details');
  				return view('addvenue');
			}
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
	}
	public function saveEditVenue(Request $request){
		$venue_name = $request->venue_name;
		$description = $request->description;
		$shortname = $request->short_name;
		$file_image = $request->venue_file;
		$venue_id = $request->id;
		 $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = 20;
        $image_details = DB::select('select ImageId from images where ImageRefType=? and ReferenceId=?',['Venue',$venue_id]);
		$venue_details = DB::select('select VenueId,VenueName,Description,ShortName from venue where VenueId=?',[$venue_id]);
		$update_venue = DB::table('venue')->where('VenueId',$venue_id)->update(['VenueName'=>$venue_name,'Description'=>$description,'ShortName'=>$shortname]);
		if(Input::hasFile('image')){
            $file = Input::file('image');
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $file->move('./public/images', $randomString.".png");
            $image = url("public/images/".$randomString.".png");
            $image_insert = DB::update('update images set ImagePath=? where ImageId=?',[$image,$image_details[0]->ImageId]);
            if($image_insert){
            	$request->session()->flash('message.level','success');
  			$request->session()->flash('message.content','Basic Venue Details Updates Successfully');
  			return redirect('editvenue/'.$venue_id);
            }
        }
        else {
            $image = "NA";
        }
		if($update_venue){
			$request->session()->flash('message.level','success');
  			$request->session()->flash('message.content','Basic Venue Details Updates Successfully');
  			return redirect('editvenue/'.$venue_id);
		}
		else{
			$request->session()->flash('message.level','info');
  			$request->session()->flash('message.content','No changes made to Basic Venue Details');
  			return view('editvenue',['venue_details'=>$venue_details,'venue_id'=>$venue_id]);
		}
	}
        
        public function checkPool(Request $request) {
            if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
			$pool_details = DB::select('select PoolId,PoolName,Length,Width,MinimumDepth,MaximumDepth,Area,SpecialRequirements from pools where VenueId=?',[$venue_id]);
			if(count($pool_details)>0){
			return redirect('edit-venuepool/'.$venue_id.'/'.$pool_details[0]->PoolId);
			}
			else{
				$request->session()->flash('message.level','danger');
  				$request->session()->flash('message.content','Pool doesnot exist. Please add poolinformation');
  				return redirect('venueool/'.$venue_id);
			}
			}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
        }

	public function editPool(Request $request){
if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$poolid = $request->id;
            $venue_id = $request->venue_id;
			$pool_details = DB::select('select PoolName,Length,Width,MinimumDepth,MaximumDepth,Area,SpecialRequirements from pools where PoolId=? and VenueId=?',[$poolid,$venue_id]);
			if($pool_details){
			return view('editvenuepool',['venue_id'=>$venue_id,'poolid'=>$poolid,'pool_details'=>$pool_details]);
			}
			else{
				$request->session()->flash('message.level','danger');
  				$request->session()->flash('message.content','Pool doesnot exist. Please add Venue');
  				return view('addvenue');
			}
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
	}
	public function saveEditPool(Request $request){
		$pool_name = $request->pool_name;
		$description = $request->description;
		$width =$request->pool_width;
		$length = $request->pool_length;
		$shallow =  $request->shallow_end;
		$deep = $request->deep_end;
		$area = $request->pool_area;
		$venue_id = $request->venue_id;
        $poolid = $request->id;
		$pool_details = DB::select('select PoolName,Length,Width,MinimumDepth,MaximumDepth,Area,SpecialRequirements from pools where VenueId=?',[$venue_id]);
		$update_pool = DB::table('pools')->where(['PoolId'=>$poolid,'VenueId'=>$venue_id])->update(['PoolName'=>$pool_name,'Length'=>$length,'Width'=>$width,'MinimumDepth'=>$shallow,'MaximumDepth'=>$deep,'Area'=>$area,'SpecialRequirements'=>$description]);
		if($update_pool){
			$request->session()->flash('message.level','success');
  			$request->session()->flash('message.content','Basic Venue Details Updates Successfully');
  			return redirect('edit-venuepool/'.$venue_id.'/'.$poolid);
		}
		else{
			$request->session()->flash('message.level','info');
  			$request->session()->flash('message.content','No changes made to Venue Pool Details');
  			return redirect('edit-venuepool/'.$venue_id.'/'.$poolid);
		}
	}

	 public function checkAddress(Request $request) {
            if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
			$venue_contact = DB::select('select * FROM contacts join bridgevenuecontact on contacts.ContactId=bridgevenuecontact.ContactId and bridgevenuecontact.VenueId=?',[$venue_id]);
			if(count($venue_contact)>0){
			return redirect('edit-venueaddress/'.$venue_id.'/'.$venue_contact[0]->ContactId);
			}
			else{
				$request->session()->flash('message.level','danger');
  				$request->session()->flash('message.content','Please add Address information');
  				return redirect('venueaddress/'.$venue_id);
			}
			}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
        }
        
	public function editVenueAddress(Request $request){
		if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
            $contact_id = $request->contact_id;
			$venue_address = DB::select('select a.AddressId,a.AddressLine1,a.City,a.Country,a.County,a.PostCode,v.Phone,v.Mobile,v.Email from address a INNER JOIN venue v ON a.AddressId=v.AddressId where v.VenueId=?',[$venue_id]);
			$contacts = DB::select("select * FROM contacts where ContactId=?",[$contact_id]);
			return view('editvenueaddress',['venue_id'=>$venue_id,'addressid'=>$venue_address[0]->AddressId,'venue_address'=>$venue_address,'contacts'=>$contacts,'contact_id'=>$contact_id]);
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
	}
	public function saveEditAddress(Request $request){
		$user_id = $request->session()->get('user_id');
		$contact_id = $request->contact_id;
		$address = $request->address;
		$city = $request->city;
		$post_code = $request->post_code;
		$town = $request->town;
		$country = $request->country;
		$contact_name = $request->contact_name;
		$mobile = $request->mobile;
		$email = $request->email;
		$venue_id = $request->venue_id;
		$address_id = $request->address_id;
		$new_contact = $request->new_contact;
		$new_mobile = $request->new_mobile;
		$new_email = $request->new_email;
		if($new_contact!=''){
			$venue_contact = DB::table('contacts')->insertGetId(array('FirstName'=>$new_contact,'Email'=>$new_email,'Phone'=>$new_mobile));
			$bridge_venuecontact = DB::table('bridgevenuecontact')->insertGetId(array('VenueId'=>$venue_id,'ContactId'=>$venue_contact,'CreatedBy'=>$user_id));
			$request->session()->flash('message.level','success');
  			$request->session()->flash('message.content','Contact Details Added Successfully');
  			return redirect('edit-venueaddress/'.$venue_id.'/'.$contact_id);
		}
		else{
        $update_venue_address = DB::table('address')->where('AddressId',$address_id)->update(['AddressLine1'=>$address,'City'=>$city,'PostCode'=>$post_code,'County'=>$town,'Country'=>$country]);
		$update_contacts = DB::table('contacts')->where('ContactId',$contact_id)->update(['FirstName'=>$contact_name,'Phone'=>$mobile,'Email'=>$email]);
			if($update_contacts || $update_venue_address){
                                $venue_address = DB::select('select a.AddressId,a.AddressLine1,a.City,a.Country,a.County,a.PostCode,v.Phone,v.Mobile,v.Email from address a INNER JOIN venue v ON a.AddressId=v.AddressId where v.VenueId=? and a.AddressId=?',[$venue_id,$address_id]);
				$request->session()->flash('message.level','success');
  				$request->session()->flash('message.content','Venue Address Updated Sucessfully');
  				return redirect('edit-venueaddress/'.$venue_id.'/'.$contact_id);
			}
			else{
				$request->session()->flash('message.level','info');
  			$request->session()->flash('message.content','No changes made.Please Try again');
  			return redirect('edit-venueaddress/'.$venue_id.'/'.$contact_id);
			}
		}

	}

	public function editVenueTiming(Request $request){
		if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
			$venue_facility = DB::select('select ParaSwimmingFacilities,Shower,Gym,LadiesOnlySwimming,Parking,Teachers,Diving,SwimForKids,VisitingGallery,Toilets,PrivateHire from venue where VenueId=?',[$venue_id]);
			$request->session()->flash('message.level','info');
  			$request->session()->flash('message.content','Venue Timings already Added. Update changes if required');
			return view('editvenuetimings',['venue_id'=>$venue_id,'venue_facility'=>$venue_facility]);
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
	}
	public function saveEditTiming(Request $request){
		$day_one = $request->day_one;
		$day_two = $request->day_two;
 		$day_three = $request->day_three;
 		$day_four = $request->day_four;
		$day_five = $request->day_five;
 		$day_six = $request->day_six;
 		$day_seven = $request->day_seven;
		$para_swimming = $request->para_swimming;
		$showers = $request->shower;
		$gyms = $request->gym;
		$ladies = $request->ladies;
		$parking = $request->parking;
		$instructors = $request->instructor;
		$diving = $request->diving;
		$swim_kids = $request->swim_kids;
		$visit_gallery = $request->visit_gallery;
		$toilets = $request->toilet;
		$privatehire = $request->privatehire;
		$venue_id = $request->id;

		$venue_facility = DB::select('select ParaSwimmingFacilities,Shower,Gym,LadiesOnlySwimming,Parking,Teachers,Diving,SwimForKids,VisitingGallery,Toilets,PrivateHire from venue where VenueId=?',[$venue_id]);
		if($para_swimming=="on"){$para_swimm = "yes";} else{$para_swimm = "no";}
 		if($showers=="on"){$shower = "yes";} else{$shower = "no";}
 		if($gyms=="on"){$gym = "yes";} else{$gym = "no";}
 		if($ladies=="on"){$lady = "yes";} else{$lady = "no";}
 		if($parking=="on"){$park = "yes";} else{$park = "no";}
 		if($instructors=="on"){$instructor = "yes";} else{$instructor = "no";}
 		if($diving=="on"){$dive = "yes";} else{$dive = "no";}
 		if($swim_kids=="on"){$swim_kid = "yes";} else{$swim_kid = "no";}
 		if($visit_gallery=="on"){$gallery = "yes";} else{$gallery = "no";}
 		if($toilets=="on"){$toilet = "yes";} else{$toilet = "no";}
 		if($privatehire=="on"){$hire = "yes";} else{$hire = "no";}
 		if(count($day_one)==3){
 			$remove_oldtimings = DB::delete('delete from daysopen where TableType=? and TypeId=? and Day=?',['venue',$venue_id,'Monday']);
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_one[0],'Open/Closed'=>'Open','OpeningHours'=>$day_one[1],'ClosingHours'=>$day_one[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_two)==3){
 			$remove_oldtimings = DB::delete('delete from daysopen where TableType=? and TypeId=? and Day=?',['venue',$venue_id,'Tuesday']);
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_two[0],'Open/Closed'=>'Open','OpeningHours'=>$day_two[1],'ClosingHours'=>$day_two[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		} 		
 	    if(count($day_three)==3){
 	    	$remove_oldtimings = DB::delete('delete from daysopen where TableType=? and TypeId=? and Day=?',['venue',$venue_id,'Wednesday']);
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_three[0],'Open/Closed'=>'Open','OpeningHours'=>$day_three[1],'ClosingHours'=>$day_three[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_four)==3){
 			$remove_oldtimings = DB::delete('delete from daysopen where TableType=? and TypeId=? and Day=?',['venue',$venue_id,'Thursday']);
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_four[0],'Open/Closed'=>'Open','OpeningHours'=>$day_four[1],'ClosingHours'=>$day_four[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_five)==3){
 			$remove_oldtimings = DB::delete('delete from daysopen where TableType=? and TypeId=? and Day=?',['venue',$venue_id,'Friday']);
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_five[0],'Open/Closed'=>'Open','OpeningHours'=>$day_five[1],'ClosingHours'=>$day_five[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_six)==3){
 			$remove_oldtimings = DB::delete('delete from daysopen where TableType=? and TypeId=? and Day=?',['venue',$venue_id,'Saturday']);
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_six[0],'Open/Closed'=>'Open','OpeningHours'=>$day_six[1],'ClosingHours'=>$day_six[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 		}
 		if(count($day_seven)==3){
 			$remove_oldtimings = DB::delete('delete from daysopen where TableType=? and TypeId=? and Day=?',['venue',$venue_id,'Sunday']);
 			$insert_days = DB::table('daysopen')->insertGetId(array('TableType'=>'venue','TypeId'=>$venue_id,'Day'=>$day_seven[0],'Open/Closed'=>'Open','OpeningHours'=>$day_seven[1],'ClosingHours'=>$day_seven[2],'LunchHours'=>'NA','ReasonForClosure'=>'NA'));
 			
 		}
 		$venue_facilities = DB::table('venue')->where('VenueId',$venue_id)->update(['ParaSwimmingFacilities'=>$para_swimm,'Shower'=>$shower,'Gym'=>$gym,'LadiesOnlySwimming'=>$lady,'Parking'=>$park,'Teachers'=>$instructor,'Diving'=>$dive,'SwimForKids'=>$swim_kid,'VisitingGallery'=>$gallery,'Toilets'=>$toilet,'PrivateHire'=>$hire]);
		if($venue_facilities || $insert_days){
			$request->session()->flash('message.level','info');
  			$request->session()->flash('message.content','Venue Timings updated Successfully');
			return view('editvenuetimings',['venue_id'=>$venue_id,'venue_facility'=>$venue_facility]);
		}
		else{
			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','No changes made to venue Timings');
  			return view('editvenuetimings',['venue_id'=>$venue_id,'venue_facility'=>$venue_facility]);
		}
	}

	public function editSocialLinks(Request $request){
		if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
			$userid = $request->session()->get('user_id');
			$venue_id = $request->id;
			$check_links = DB::select('select Facebook,Twitter,GooglePlus,Others,Website,Website2 from venue where VenueId=?',[$venue_id]);
				$request->session()->flash('message.level','info');
  				$request->session()->flash('message.content','Social Links already Added.Update changes if Required..');
				return view('editvenuesociallinks',['venue_id'=>$venue_id,'check_links'=>$check_links]);
		}
		else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','Login As Venue Admin to Add Venue');
  			return view('/');
  		}
	}
	public function saveEditLinks(Request $request){
		$facebook = $request->facebook;
		$twitter = $request->twitter;
		$google = $request->google;
		$others = $request->others;
		$link1 = $request->link1;
		$link2 = $request->link2;
		$venue_id = $request->id;
		$update_links = DB::table('venue')->where('VenueId',$venue_id)->update(['Facebook'=>$facebook,'Twitter'=>$twitter,'GooglePlus'=>$google,'Others'=>$others,'Website'=>$link1,'Website2'=>$link2]);
		$check_links = DB::select('select Facebook,Twitter,GooglePlus,Others,Website,Website2 from venue where VenueId=?',[$venue_id]);
		if($update_links){
			$request->session()->flash('message.level','success');
  			$request->session()->flash('message.content','Venue Social Links Updates Successfully');
  			return view('editvenuesociallinks',['venue_id'=>$venue_id,'check_links'=>$check_links]);
		}
		else{
			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','No Changes made to Venue Social Links');
  			return view('editvenuesociallinks',['venue_id'=>$venue_id,'check_links'=>$check_links]);
		}
	}
        
        public function getOldEntries(Request $request) {
        $type = $request->type;
        $id = $request->id;
        
        if($type == "poolinfo") {
            $pools = DB::select("select PoolId,PoolName from pools where VenueId=?",[$id]);
            if(count($pools) > 0) {
                echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>PoolName</td><td>Edit</td><td>Delete</td></tr>";
                foreach($pools as $pool) {
                    echo "<tr><td>".$pool->PoolName."</td><td><a href=".url('/edit-venuepool/'.$id.'/'.$pool->PoolId)." style='color:black'>Edit</a></td><td><a href=".url('/deletepool/'.$id.'/'.$pool->PoolId)." style='color:black'> Delete</a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            } else {
                echo "no";
            }
        }
        if($type == "address") {
            $contacts = DB::select("select contacts.ContactId,contacts.Phone,contacts.FirstName,contacts.Email FROM contacts join bridgevenuecontact on contacts.ContactId=bridgevenuecontact.ContactId and bridgevenuecontact.VenueId=?",[$id]);
            if(count($contacts) > 0) {
                echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Contact Name</td><td>Mobile</td><td>Email</td><td>Edit</td><td>Delete</td></tr>";
                foreach($contacts as $contact) {
                    echo "<tr><td>".$contact->FirstName."</td><td>".$contact->Phone."</td><td>".$contact->Email."</td><td><a href=".url('/edit-venueaddress/'.$id.'/'.$contact->ContactId)." style='color:black'>Edit</a></td><td><a href=".url('/delete-venuecontact/'.$id.'/'.$contact->ContactId)." style='color:black'>Delete</a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            } else {
                echo "no";
            }
        }
        if($type == "timings"){
        	$timings = DB::select('select * from daysopen where TypeId=?',[$id]);
        	if(count($timings)>0) {
        		echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Day</td><td>OpeningHours</td><td>ClosingHours</td></tr>";
                foreach($timings as $timing) {
                    echo "<tr><td>".$timing->Day."</td><td>".$timing->OpeningHours."</td><td>".$timing->ClosingHours."</td></tr>";
                }
                echo "</table>";
                echo '</div>';
        	}
        }
    }

    public function deleteContact(Request $request){
    	$venue_id = $request->venue_id;
    	$contact_id = $request->contact_id;
    	$remove_bridge = DB::delete('delete from bridgevenuecontact where VenueId=? and ContactId=?',[$venue_id,$contact_id]);
    	$remove_contact = DB::delete('delete from contacts where ContactId=?',[$contact_id]);
    	$request->session()->flash('message.level','success');
  		$request->session()->flash('message.content','Venue Contact Deleted Successfully');
    	return redirect('venueaddress/'.$venue_id);
    }
    public function deletepool(Request $request){
    	$venue_id = $request->venue_id;
    	$pool_id = $request->pool_id;
    	$remove_pool = DB::delete('delete from pools where PoolId=?',[$pool_id]);
    	$request->session()->flash('message.level','success');
  		$request->session()->flash('message.content','Pool Deleted Successfully');
    	return redirect('venuepool/'.$venue_id);
    }