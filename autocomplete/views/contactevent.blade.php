@extends('layouts.main')
@section('content')

@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
    <!-- event code starts here -->
     <div class="container" id="main-code">
      <h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Event</h5>
      <div class="row" style="border:1px solid #eee">
        <div class="board" id="board_height">
          <div class="board-inner event_iconlist" id="icons_align">
            <ul class="nav nav-tabs nav_info" id="myTab"  style="margin:40px 25%">
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
                <h5 style="color:#46A6EA"><b>Clubs</b></h5>
                <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('contact-event/club/'.$event_id) }}">
                    {{ csrf_field() }}
                  <div class="row">
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Club:</label>
                      <div class="col-xs-7 col-sm-6">
                        <div class="easy-autocomplete">
                        <input type="text" class="form-control" id="eventclub" name="club_name" required>
                        <div class="easy-autocomplete-container" id="eac-container-provider-remote" ><ul style="display: none;"></ul></div></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Mobile:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="text" class="form-control" id="clubmobile" name="club_mobile" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="email">Email:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="email" class="form-control" id="clubemail" name="club_email" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Website:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="text" class="form-control" id="clubsite" name="club_website" required>
                      </div>
                    </div>
                    <center>
                                        
                                        <button class="btn btn-primary">Save Club</button>
                                       
                                      </center>
                                    </form>  
                    <hr/>
                              <h5 style="color:#46A6EA"><b>Contact</b></h5>
                    <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('contact-event/contact/'.$event_id) }}">    
                        {{ csrf_field() }}
                              <div class="row">
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-4" for="txt">Contact:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="text" class="form-control" id="econtact" name="event_contact" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-4" for="txt">Mobile:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="text" class="form-control" id="eventmobile" name="event_mobile" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-4" for="email">Email:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="email" class="form-control" id="contactemail" name="event_email" required>
                                  </div>
                                </div>
                                <center>
                                        
                                        <button class="btn btn-primary">Save Contact</button>
                                       
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