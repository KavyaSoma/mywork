     public function clubevent(Request $request){
        $club = $request->club;
        $club_details = DB::select('select ClubName,Email,MobilePhone,Website from clubs where ClubName like "%'.$club.'%"');
        if(count($club_details)>0) {
          echo json_encode($club_details);
        }
      }
      public function autocontact(Request $request){
        $contact = $request->contact;
        $contact_details = DB::select('select FirstName,Email,Phone from contacts where FirstName like "%'.$contact.'%"');
        if(count($contact_details)>0) {
          echo json_encode($contact_details);
        }
      }
         public function venuesevent(Request $request){
        $venue = $request->venue;
        $venue_details = DB::select('select v.VenueName,a.AddressLine1,a.City,a.PostCode from venue v JOIN address a on v.AddressId=a.AddressId and VenueName like "%'.$venue.'%"');
        if(count($venue_details)>0) {
          echo json_encode($venue_details);
        }
      }