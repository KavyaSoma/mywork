public function autocompleteclub(Request $request){
  $type = $request->type;
  if($type == "address"){
    $address = $request->key;
    $address_information = DB::select('select AddressLine1,City,County,Country,PostCode from address where AddressLine1 like "%'.$address.'%"');
    if(count($address_information)>0){
       echo json_encode($address_information);
    }
  }
  else{
    $contact = $request->key;
    $contact_details = DB::select('select Phone,Website,Email from contacts where Phone like "%'.$contact.'%"');
    if(count($contact_details)>0){
        echo json_encode($contact_details);
    }
  }
 }
