  public function autocompleteaddress(Request $request){
      $address = $request->address;
      $address_information = DB::select('select AddressLine1,AddressLine2,City,County,Country,PostCode from address where AddressLine1 like "%'.$address.'%"');
      if(count($address_information)>0){
         echo json_encode($address_information);
      }
    }