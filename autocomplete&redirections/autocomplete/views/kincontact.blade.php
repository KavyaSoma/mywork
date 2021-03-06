@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margi-left:13px;">
    {!! session('message.content') !!}
    </div>
    @endif
<div class="container">
        <h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Kin</h5>
  <div class="row" style="border:1px solid #eee">
      <div class="board">
        <div class="board-inner">
          <center><ul class="nav nav-tabs nav_info" id="myTab">
              <div class="liner"></div>
                <li>
                  <a href="#" class="tab-one" title="Kin Basic Details">
                    <span class="round-tabs">
                      <i class="fa fa-info"></i>
                    </span>
                   </a>
                 </li>
                   <li  class="active">
                      <a href="{{url('kincontact/'.$participant_id)}}" class="tab-one"  title="Emergency Contact">
                        <span class="round-tabs">
                          <i class="fa fa-phone"></i>
                        </span>
                     </a>
                    </li>
              </ul></center>
          </div>
<div class="tab-pane fade in active" id="kin_contact">
 
      <form class="form-horizontal" method="post" action="{{url('kincontact/'.$participant_id)}}" style="background:#fff;padding:35px">
        {{csrf_field()}}
            <div class="col-sm-12">
              <div class="form-group">
                   
                <label class="control-label col-sm-4" for="txt">EmergencyContact Name:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="contactname" name="EmergencyContactName" required>
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-4" for="txt">EmergencyContact Number:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="contactnumber" name="EmergencyContactNumber" required>
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-4" for="txt">EmergencyContact Address:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="address" name="EmergencyContactAddress" required>
                </div>
                </div>
                
                  <center>
                       <button type="submit" class="btn btn-primary">Save</button><br><br>
                  </div>
                </form>
              </div>
          </div>
        </div>
    </div>
  </div>
 </div>
 </div>
 </div>
 <script>
  $(document).ready(function() {
  var options = {
     data:[
      {"FirstName": "FirstName",
       "Phone":"Phone",
       "AddressLine1":"AddressLine1",
       "City":"City",
       "County":"County",
       "Country":"Country",
       "PostCode":"PostCode"}
    ],
  url: function(phrase) {
    return "{{ url('contactkin') }}/"+phrase;
  },
  getValue: "FirstName",
   list: {
    onSelectItemEvent: function() {
      var phone = $("#contactname").getSelectedItemData().Phone;
      var address = $("#contactname").getSelectedItemData().AddressLine1;
      var city = $("#contactname").getSelectedItemData().City;
      var town = $("#contactname").getSelectedItemData().County;
      var country = $("#contactname").getSelectedItemData().Country;
      var code = $("#contactname").getSelectedItemData().PostCode;
     
      $("#contactnumber").val(phone).trigger("change");
      $("#address").val(address).trigger("change");
      $("#kincity").val(city).trigger("change");
      $("#kintown").val(town).trigger("change");
      $("#post-code").val(code).trigger("change");
      $("#kincountry").val(country).trigger("change");
    }
  }
  };
  $("#contactname").easyAutocomplete(options); 
});
 </script>
 @endsection