public function ConfirmVenue(Request $request){
	   if($request->session()->has('user_id') && $request->session()->get('user_type')=="venue"){
      $userid = $request->session()->get('user_id');
      $venue_id = $request->id;
			$pool_details = DB::select('select PoolName,Length,Width,MinimumDepth,MaximumDepth,Area,SpecialRequirements from pools where VenueId=?',[$venue_id]);
			$venue_address = DB::select('select a.AddressId,a.AddressLine1,a.City,a.Country,a.County,a.PostCode from address a INNER JOIN venue v where v.VenueId=? and a.AddressId=v.AddressId',[$venue_id]);
			$venue_contact = DB::select('select b.VenueId,b.ContactId,c.ContactId,c.FirstName,c.Email,c.Phone from contacts c INNER JOIN bridgevenuecontact b where c.ContactId=b.ContactId and b.VenueId=?',[$venue_id]);
			$timings = DB::select('select Day,OpeningHours,ClosingHours from daysopen where TypeId=? and TableType="venue"',[$venue_id]);
      $venue_facilities = DB::select('select * from venue where VenueId=?',[$venue_id]);
			$request->session()->flash('message.level','success');
      $request->session()->flash('message.content','Venue Information Added Successfully...');
    return view('confirmvenue',['venue_id'=>$venue_id,'pool_details'=>$pool_details,'venue_address'=>$venue_address,'venue_contact'=>$venue_contact,'timings'=>$timings,'facilities'=>$venue_facilities]);
         }
    else{
      $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Login As Venue Admin to Add Venue');
        return view('/');
    }
     
	}