public function autocomplete(Request $request){
      $type = $request->type;
      if($type == "contact"){
      $contact = $request->contact;
      $tags = DB::select('select FirstName,Phone,Email from contacts where FirstName like "%'.$contact.'%"');
      if(count($tags)>0) {
        echo json_encode($tags);
      }
      }else{
        $address = $request->contact;
        $address_information = DB::select('select AddressLine1,City,County,Country,PostCode from address where AddressLine1 like "%'.$address.'%"');
        if(count($address_information)>0){
           echo json_encode($address_information);
        }
      }
  }