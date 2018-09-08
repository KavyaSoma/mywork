@extends('layouts.main')
@section('content')

@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
  <!--New hari Modal content-->
<div class="modal fade" id="myModalh" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
@if(count($venue_details)>0)
<h3 style="color:#46A6EA;background-color:#fff;padding-left:9px;">Previous Entries</h3>
@endif
</div>
<div class="modal-body">
<div id="old_events">
                
                </div>
</div>
<!--<div class="modal-footer">
    <button class="btn btn-primary col-sm-offset-5 col-sm-2 mybtn" type="submit">Post</button>

</div>--></div>
</div></div>

<!-- model popup ends here -->
    <!-- event code starts here -->
   <div class="container mycntn" id="main-code">
   <ol class="breadcrumb" style="border:1px solid #46A6EA;color:#46A6EA;">
  <li class="breadcrumb-item"><a style="color:#777;" href="http://localhost/swim">Home</a></li>
  <li class="breadcrumb-item"><a style="color:#777;" href="http://localhost/swim/socialnetwork">Social Network</a></li>
  <li class="breadcrumb-item">Groups</li>
  </ol>
      <!--<h5 class="add_venue" style="padding:10px;"><span class="" style="font-size:17px;" ><i class="fa fa-calendar"> </i> </span> GALA</h5>-->
      <div class="row" style="margin-left:0px;margin-right:0px;">
    <ul class="nav nav-tabs mob-none">
  <li ><a data-toggle="tab" class="" href="#mhome">Basic Details</a></li>
    <li ><a href=""> WHEN</a></li>
    <li class="active " style="margin-bottom:2px;"><a class="" data-toggle="tab" href="#menu1"> WHERE</a></li>
    <li><a class="" data-toggle="tab" href="#menu2"> EVENT</a></li>
    
  </ul>
   <button class="col-sm-2 btn btn-warning" data-toggle="modal" data-target="#myModalh"><i class="fa fa-bars"></i> Previous Entries</button></div>

  <ul class="nav nav-tabs desk-none tab-none mob-block" style="border-bottom:0px">
  <li class="active " style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#mhome"><i class="fa fa-list" id="info_fa"> </i></a></li>
    <li style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#home"><i class="fa fa-clock-o" id="info_fa"> </i> </a></li>
    <li><a class="" data-toggle="tab" href="#menu1"><i class="fa fa-map-marker" id="info_fa"> </i> </a></li>
    <li><a class="" data-toggle="tab" href="#menu2"><i class="fa fa-calendar" aria-hidden="true" id="info_fa"></i> </a></li>
    
  </ul>
  <div class="tab-content">  
    <div id="menu1" class="tab-pane fade in active">
      <div class="container" ><!--id="main-code"-->
     <div class="col-xs-12 col-sm-6 col-md-3 kin_photo">
     <div class="fb-profile" style="margin-top:13%">
      @if(count($event_image)>0)
 <img class="thumbnail profile_image" src="{{$event_image[0]->ImagePath}}" alt="Profile image">
 @else
 <img class="thumbnail profile_image" src="{{url('public/images/event.jpg')}}" alt="Profile image">
 @endif     <div class="fb-profile-text text-center">
         <!--<h3>Event Name</h3>
          <p class="text-center"><i class="fa fa-map-marker" style="color:#46A6EA"></i> Location:UK</p>-->
</div>
</div>
</div>
 <div class="col-xs-12 col-sm-9 kin_info" style="border-left:1px solid #eee">
<form class="form-horizontal kin_infor"  style="padding:30px;" method="post" action="{{url('venue-event/'.$event_id)}}">
  {{csrf_field()}}
<div>
  @if(count($venue_details)>0)
  @foreach($venue_details as $venue)
          <div class="row">
          <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Venue:</label>
              <div class="col-xs-8 col-sm-9"> 
                <input type="hidden" name="venue_id" value="{{$venue->VenueId}}">
                  <input type="text" class="form-control" name="venue_name" id="venuename" value="{{$venue->VenueName}}" required>
                

              </div>
          </div>
          <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Address:</label>
              <div class="col-xs-8 col-sm-9"> 
                <input type="hidden" name="address_id" value="{{$venue->AddressId}}">
                  <input type="text" class="form-control" name="venue_address" id="vaddress" value="{{$venue->AddressLine1}}" readonly>
                  
              </div>
          </div>
          
            <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">City:</label>
              <div class="col-xs-8 col-sm-9"> 
                  <input type="text" class="form-control" name="venue_city" value="{{$venue->City}}" id="venuecity" readonly>
                  

              </div>
          </div>
            <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Post code:</label>
              <div class="col-xs-8 col-sm-9"> 
                  <input type="int" class="form-control"  name="venue_code" id="venuecode" value="{{$venue->PostCode}}" readonly>
                  

              </div>
          </div>
               </div>
              @endforeach 
              @else
                       <div class="row">
          <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Venue:</label>
              <div class="col-xs-8 col-sm-9"> 
                  <input type="text" class="form-control" id="venuename" name="venue_name" required>
                

              </div>
          </div>
          <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Address:</label>
              <div class="col-xs-8 col-sm-9"> 
                  <input type="text" class="form-control" id="vaddress" name="venue_address" readonly>
                  
              </div>
          </div>
          
            <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">City:</label>
              <div class="col-xs-8 col-sm-9"> 
                  <input type="text" class="form-control" name="venue_city" id="venuecity" readonly>
                  

              </div>
          </div>
            <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Post code:</label>
              <div class="col-xs-8 col-sm-9"> 
                  <input type="int" class="form-control"  name="venue_code" id="venuecode" readonly>
              </div>
          </div>
               </div>
              @endif

</div>

</div></div>
<div class="col-sm-offset-5 col-xs-offset-2 ">
<a href="{{url('/eventtime/'.$event_id)}}" class="btn btn-primary mybtn">Back</a>
<button class="btn btn-primary mybtn" >Save</button>
@if(count($venue_details)>0)
<a href="{{url('/subevent/'.$event_id)}}" class="btn btn-primary mybtn" >Next</a>
@else
<a href="{{url('/subevent/'.$event_id)}}" class="btn btn-primary mybtn disabled" >Next</a>
@endif
          </div></form><br>
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
console.log('{{ url('getoldevents/venues/'.$event_id) }}');
$.ajax({
    url: '{{ url('getoldevents/venues/'.$event_id) }}',
    success: function(html) {
      if(html=="no") {
      } else {
        console.log(html);
        //$('#old_events').attr("src",html);
        $('#old_events').html(html);
      }
    },
    async:true
  });
              });
$(document).ready(function() {
  var options = {
    data:[
      {"VenueName": "VenueName",
       "AddressLine1": "AddressLine1",
       "City":"City",
       "PostCode":"PostCode"}
    ],
  url: function(phrase) {
    return "{{ url('eventvenues/') }}/"+phrase;
  },
  getValue: "VenueName",
  list: {
    onSelectItemEvent: function() {
      var value = $("#venuename").getSelectedItemData().AddressLine1;
      var city = $("#venuename").getSelectedItemData().City;
      var postcode = $("#venuename").getSelectedItemData().PostCode;
      
      $("#vaddress").val(value).trigger("change");
      $("#venuecity").val(city).trigger("change");
      $("#venuecode").val(postcode).trigger("change");
     }
  }
  };
  $("#venuename").easyAutocomplete(options); 
});
</script>
        @endsection
    
