@extends('layouts.main')
@section('content')

@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
    <!-- event code starts here -->
     <div class="container mycntn">
  <ol class="breadcrumb" style="border:1px solid #46A6EA;color:#46A6EA;">
  <li class="breadcrumb-item"><a style="color:#777;" href="http://localhost/swim">Home</a></li>
  <li class="breadcrumb-item"><a style="color:#777;" href="http://localhost/swim/socialnetwork">Social Network</a></li>
  <li class="breadcrumb-item">Groups</li>
  </ol>
  <div class="row"><h4 class="col-sm-12" style="color:green;text-align:center;">{{ session('message.level') }} {!! session('message.content') !!}</h4></div>
      <div class="row">
             <div class="col-xs-12 col-sm-3 kin_photo">
     <div class="fb-profile" style="margin-top:8%;">
 <img alt="Profile image" class="img-rounded profile_image" src="http://localhost/swim/public/images/sravan.jpeg">
     <div class="fb-profile-text text-center">
        <div class="col-xs-12 col-sm-12" style="margin-top: 14px;">
                    <input class="form-control myful" id="imgUpload" name="imgUpload" accept="image/*" type="file">
                </div>
         <!-- <p class="text-center"><i class="fa fa-map-marker" style="color:#46A6EA"></i> Location:UK</p>-->
</div>
</div>
</div>
<div class="col-sm-8 col-xs-12" style="border-left:1px solid #eee">
                 <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                 <div class="board-inner">
            <ul class="nav nav-tabs nav_info" id="myTab">
                <div class="liner"></div>
                <li>
                <a href="{{url('/addevent')}}" class="tab-one" title="Event Summary">
                  <span class="round-tabs">
                    <i class="fa fa-bullhorn"></i>
                  </span>
                 </a></li>
                 <li><a href="{{url('/subevent')}}" title="Sub Events">
                   <span class="round-tabs">
                     <i class="fa fa-list"></i>
                   </span>
                 </a>
                    </li>
                  <li><a href="{{url('/schedule-event')}}" title="Schedule">
                      <span class="round-tabs">
                           <i class="fa fa-calendar"></i>
                      </span> </a>
                      </li>

                      <li  class="active"><a href="{{url('/contact-event')}}" title="Contacts">
                          <span class="round-tabs">
                               <i class="fa fa-phone"></i>
                          </span>
                      </a></li>
                      <li><a href="{{url('/venue-event')}}" title="Venue">
                          <span class="round-tabs">
                               <i class="fa fa-paper-plane-o"></i>
                          </span>
                      </a></li>

                      <li><a href="{{url('/confirm-event')}}" title="Conform">
                          <span class="round-tabs">
                               <i class="fa fa-check"></i>
                          </span> </a>
                      </li>


                      </ul></div>
 <div class="tab-content tab_details">
  
            <div class="tab-pane fade in active" id="eventcontact">
                <h5  style="color:#46A6EA;text-align: center;"><b>Clubs</b></h5>
                <form class="form-horizontal" style="background:#fff;padding:30px;" method="post" action="{{ url('contact-event/club/'.$event_id) }}">
                    {{ csrf_field() }}
                  <div class="row">
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-2" for="txt">Club:</label>
                      <div class="col-xs-8 col-sm-9">
                        <div class="easy-autocomplete">
                        <input type="text" class="form-control" id="eventclub" name="club_name" required>
                        <div class="easy-autocomplete-container" id="eac-container-provider-remote" ><ul style="display: none;"></ul></div></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-2" for="txt">Mobile:</label>
                      <div class="col-xs-8 col-sm-9">
                        <input type="text" class="form-control" id="clubmobile" name="club_mobile" required>
                        <div class="mobile-error" style="color: red;display: none">Mobile Number Should Contain 10 Numeric Characters</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-2" for="email">Email:</label>
                      <div class="col-xs-8 col-sm-9">
                        <input type="email" class="form-control" id="clubemail" name="club_email" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-2" for="txt">Website:</label>
                      <div class="col-xs-8 col-sm-9">
                        <input type="url" class="form-control" id="clubsite" name="club_website" required>
                      </div>
                    </div>
                    <center>
                                        
                                        <button class="btn btn-primary mybtn">Save Club</button>
                                       
                                      </center>
                                    </form>  
                    <hr/>
                              <h5 style="color:#46A6EA;text-align: center;"><b>Contact</b></h5>
                    <form class="form-horizontal" style="background:#fff;padding:30px" method="post" action="{{ url('contact-event/contact/'.$event_id) }}">    
                        {{ csrf_field() }}
                              <div class="row">
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-2" for="txt">Contact:</label>
                                  <div class="col-xs-8 col-sm-9">
                                    <input type="text" class="form-control" id="econtact" name="event_contact" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-2" for="txt">Mobile:</label>
                                  <div class="col-xs-8 col-sm-9">
                                    <input type="text" class="form-control" id="eventmobile" name="event_mobile" required>
                                    <div id="mobile-error" style="color: red;display: none">Mobile Number Should Contain 10 Numeric Characters</div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-2" for="email">Email:</label>
                                  <div class="col-xs-8 col-sm-9">
                                    <input type="email" class="form-control" id="contactemail" name="event_email" required>
                                  </div>
                                </div>
                                <center>
                                        
                                        <button class="btn btn-primary mybtn">Save Contact</button>
                                       
                                      </center>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              </div>
                              </div>
                              <div id="old_events">
                
                              </div>
                              </div>
    <script>

$(document).ready(function() {
var $regexname = /^([0-9]{10})$/;
  $("#clubmobile").on('keypress keydown keyup',function(){
    if(!$(this).val().match($regexname)){
      $('.mobile-error').show();
    }
    else{
      $('.mobile-error').hide();
    }
  });
  $("#eventmobile").on('keypress keydown keyup',function(){
    if(!$(this).val().match($regexname)){
      $('#mobile-error').show();
    }
    else{
      $('#mobile-error').hide();
    }
  });
console.log('{{ url('getoldevents/contacts/'.$event_id) }}');
$.ajax({
    url: '{{ url('getoldevents/contacts/'.$event_id) }}',
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
      {"ClubName": "ClubName",
       "MobilePhone":"MobilePhone",
       "Email":"Email",
       "Website":"Website"}
    ],
  url: function(phrase) {
    return "{{ url('eventclub/') }}/"+phrase;
  },
  getValue: "ClubName",
   list: {
    onSelectItemEvent: function() {
      var value = $("#eventclub").getSelectedItemData().MobilePhone;
      var email = $("#eventclub").getSelectedItemData().Email;
      var web = $("#eventclub").getSelectedItemData().Website;
     
      $("#clubmobile").val(value).trigger("change");
      $("#clubemail").val(email).trigger("change");
      $("#clubsite").val(web).trigger("change");
    }
  }
  };
  $("#eventclub").easyAutocomplete(options); 
});
$(document).ready(function() {
  var options = {
    data:[
      {"FirstName": "FirstName",
       "Phone":"Phone",
       "Email":"Email"}
    ],
  url: function(phrase) {
    return "{{ url('eventcontact/') }}/"+phrase;
  },
  getValue: "FirstName",
   list: {
    onSelectItemEvent: function() {
      var value = $("#econtact").getSelectedItemData().Phone;
      var email = $("#econtact").getSelectedItemData().Email;
      
      $("#eventmobile").val(value).trigger("change");
      $("#contactemail").val(email).trigger("change");
     }
  }
  };
  $("#econtact").easyAutocomplete(options); 
});
</script>
                      @endsection