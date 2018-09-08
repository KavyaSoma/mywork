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
                <a href="#" class="tab-one" title="Event Summary">
                  <span class="round-tabs">
                    <i class="fa fa-bullhorn"></i>
                  </span>
                 </a></li>
                 <li><a href="#" title="Sub Events">
                   <span class="round-tabs">
                     <i class="fa fa-list"></i>
                   </span>
                 </a>
                    </li>
                  <li><a href="#" title="Schedule">
                      <span class="round-tabs">
                           <i class="fa fa-calendar"></i>
                      </span> </a>
                      </li>

                      <li><a href="#" title="Contacts">
                          <span class="round-tabs">
                               <i class="fa fa-phone"></i>
                          </span>
                      </a></li>
                      <li   class="active"><a href="#" title="Venue">
                          <span class="round-tabs">
                               <i class="fa fa-paper-plane-o"></i>
                          </span>
                      </a></li>

                      <li><a href="#" title="Conform">
                          <span class="round-tabs">
                               <i class="fa fa-check"></i>
                          </span> </a>
                      </li>


                      </ul></div>
 <div class="tab-content tab_details">
<div class="tab-pane fade in active" id="eventvenue">
                                
                                    <div class="tab-pane fade in active" id="eventvenue">
                                      <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('edit-venueevent/'.$event_id) }}">
                                        {{csrf_field()}}
                                        <div class="event-venue"> 
                                        @foreach($venues as $venue)
                                      
                              <div class="row">
                                          <div id="form-group-venue">
                                    <div class="form-group" id="field1">
                                        <label class="control-label col-xs-4 col-sm-offset-2 col-sm-1" for="txt">Venue:</label>
                                        
                                        <div class="col-xs-7 col-sm-6">
                                          <input type="hidden" name="venue_id[]" value="{{$venue->VenueId}}">
                                          <input type="text" class="form-control" id="venue-name" name="venue_name[]" pattern="([A-zÀ-ž\s]){5,25}" value="{{$venue->VenueName}}" required>
                                          <span class="venuename" style="color: red;display: none">Venue Name Should contain 5-25 characters</span>
                                        </div>
                                        
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label col-xs-4 col-sm-offset-2 col-sm-1" for="email">Address:</label>
                                        <div class="col-xs-7 col-sm-6">
                                          <input type="hidden" name="address_id[]" value="{{$venue->AddressId}}">
                                          <input type="text" class="form-control" id="email" name="venue_address[]" value="{{$venue->AddressLine1}}" required>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label  col-xs-4 col-sm-offset-2 col-sm-1" for="txt">City:</label>
                                        <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venue-city" name="venue_city[]" pattern="([A-zÀ-ž\s]){5,25}" value="{{$venue->City}}" required>
                                        <span class="city-error" style="color: red;display: none">City Should contain 5-25 characters</span>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label col-xs-4 col-sm-offset-2 col-sm-1" for="txt">Post code:</label>
                                        <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venue-post" name="venue_code[]" pattern="([0-9]){5,20}" value="{{$venue->PostCode}}" required>
                                        <span class="venuepost-error" style="color: red;display: none">Post Code Should contain Numeric Characters</span>
                                        </div>
                                        </div></div></div>
                                        @endforeach
                                      
                                    </div>
                                      <center>
                                                
                                                
                                                <a href="{{ url('confirm-event/'.$event_id)}}" class="btn btn-primary">Save Changes</a>
                                              </center>
                                    </form>
                                    <hr>
                                     <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('venue-event/'.$event_id) }}">
                                      {{csrf_field()}}
                                      <div id="venue-event-add">
                                           <div class="row">
                                        <div class="form-group" id="field1">
                                        <label class="control-label col-xs-4 col-sm-offset-2 col-sm-1" for="txt">Venue:</label>
                                        <div class="col-xs-7 col-sm-6">
                                          <input type="text" class="form-control" id="txt" name="venue_name" required>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label col-xs-4 col-sm-offset-2 col-sm-1" for="txt">Address:</label>
                                        <div class="col-xs-7 col-sm-6">
                                          <input type="txt" class="form-control" id="txt" name="venue_address">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label  col-xs-4 col-sm-offset-2 col-sm-1" for="txt">City:</label>
                                        <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="txt" name="venue_city">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label col-xs-4 col-sm-offset-2 col-sm-1" for="txt">Post code:</label>
                                        <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="txt" name="venue_code">
                                        </div>
                                        </div>
                                      </div>
                                      <center>
                                         <button class="btn btn-primary">Save Changes</button>
                                              </center>
                                      </div>
                                       
                                      </div><br>
                                      
                                       
                                        
                                              </form>
                                          </div>
                                        
       
                    </div>
                  </div>
                </div><div id="old_events">
                
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
</script>
                      @endsection