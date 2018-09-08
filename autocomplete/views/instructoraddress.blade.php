@extends('layouts.main')
@section('content')
<div class="row1">
@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger }}">
        {{ $error }}
        </div>
    @endforeach
@endif
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
@endif
    <div class="container">
    
        <div class="container">
        <h5 class="add_instructor"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Instructor</h5>
        <div class="row" style="border:1px solid #eee">
          <div class="board">
          <div class="board-inner instructor_tabs">
              <center><ul class="nav nav-tabs nav_info" id="myTab">
                  <div class="liner"></div>
                    <li>
                      <a href="#" class="tab-one" title="Basic Details">
                        <span class="round-tabs">
                          <i class="fa fa-info"></i>
                        </span>
                       </a>
                     </li>
                     <li>
                       <a href="#" title="Timings">
                          <span class="round-tabs">
                            <i class="fa fa-clock-o"></i>
                         </span>
                      </a>
                     </li>
                       <li  class="active">
                         <a href="#" title="Address">
                            <span class="round-tabs">
                              <i class="fa fa-map-marker"></i>
                           </span>
                        </a>
                       </li>
                       <li>
                         <a href="#" title="Experience">
                            <span class="round-tabs">
                              <i class="fa fa-globe"></i>
                           </span>
                          </a>
                        </li>
                        <li>
                          <a href="#" title="Contact">
                            <span class="round-tabs">
                              <i class="fa fa-phone"></i>
                            </span>
                         </a>
                        </li>
                      </ul></center>
                        </div>
           
         <div class="tab-pane fade in active" id="instructor_address">
  <form class="form-horizontal" method="post" action="{{url('instructoraddress/'.$id)}}" style="background:#fff;">
    {{csrf_field()}}
      <div class="col-sm-12">
          <div class="form-group">
            
<label class="control-label col-sm-4" for="txt">Address 1:</label>
<div class="col-sm-6">
  <input type="text" class="form-control" id="address1" name="AddressLine1" required>
</div>
</div>
 <div class="form-group">
  <label class="control-label col-sm-4" for="txt">Address 2:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="address2" name="AddressLine2" required>
  </div>
  </div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Town:</label>
<div class="col-sm-6">
  <input type="text" class="form-control" id="instructor-town" name="County" pattern="([A-zÀ-ž\s]){5,50}" required>
  <span class="error-town" style="color: red;display: none">Town should contain 5-30 Characters</span>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">City:</label>
<div class="col-sm-6">
<input type="text" class="form-control" id="instructor-city" name="City" pattern="([A-zÀ-ž\s]){5,50}" required>
<span class="error-city" style="color: red;display: none">City should contain 5-30 Characters</span>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Postcode:</label>
<div class="col-sm-6">
<input type="text" class="form-control" id="instructor-postcode" name="PostCode" pattern="([0-9]){5,10}" required>
<span class="error-instrucotcode" style="color: red;display: none">PostCode should contain 5-10 digits</span>
</div>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Country:</label>
<div class="col-sm-6">
  <input type="text" class="form-control" id="instructor-country" name="Country" pattern="([A-zÀ-ž\s]){5,50}" required>
  <span class="error-instructorcountry" style="color: red;display: none">Country should contain 5-10 Characters</span>
</div>
</div>

 

<center>
     <button type="submit" class="btn btn-primary">Save</button>
  
</div>
</form>
</div>

</center>
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
      {"AddressLine1": "AddressLine1",
        "AddressLine2": "AddressLine2",
       "City":"City",
       "County":"County",
       "Country":"Country",
       "PostCode":"PostCode"}
    ],

  url: function(phrase) {
    return "{{ url('addressinstructor') }}/"+phrase;
  },
  getValue: "AddressLine1",
  list: {
    onSelectItemEvent: function() {
      var address2 = $("#address1").getSelectedItemData().AddressLine2;
      var city = $("#address1").getSelectedItemData().City;
      var town = $("#address1").getSelectedItemData().County;
      var country = $("#address1").getSelectedItemData().Country;
      var postcode = $("#address1").getSelectedItemData().PostCode;
     
        $("#address2").val(address2).trigger("change");
      $("#instructor-city").val(city).trigger("change");
       $("#instructor-town").val(town).trigger("change");
       $("#instructor-postcode").val(postcode).trigger("change");
       $("#instructor-country").val(country).trigger("change");
    }
  }
  };
  $("#address1").easyAutocomplete(options); 
});
</script>
@endsection