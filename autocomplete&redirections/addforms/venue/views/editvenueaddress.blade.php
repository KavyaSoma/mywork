@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin-left:13px;text-align:center ">
    {!! session('message.content') !!}
    </div>
    @endif

    <div class="container">
  <h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Venue</h5>
      <div class="row" style="border:1px solid #eee">
             <div class="board">
                 <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                 <div class="board-inner  iconlist">
                 <ul class="nav nav-tabs nav_info" id="myTab">
                 <div class="liner"></div>
                <li>
                  <a href="{{ url('editvenue/'.$venue_id) }}" title="Venue Summary">
                   <span class="round-tabs">
                           <i class="fa fa-list"></i>
                   </span>
               </a></li>

               <li><a href="{{ url('edit-venuepool/'.$venue_id) }}"  title="Pool Information">
                  <span class="round-tabs">
                      <i class="fa fa-info"></i>
                  </span>
        </a>
              </li>
              <li  class="active"><a href="{{ url('edit-venueaddress/'.$venue_id) }}" title="Address & Contact">
                  <span class="round-tabs">
                       <i class="fa fa-phone"></i>
                  </span> </a>
                  </li>

                  <li><a href="{{ url('edit-venuetimings/'.$venue_id) }}" title="Open hours & Facilities">
                      <span class="round-tabs">
                           <i class="fa fa-clock-o"></i>
                      </span>
                  </a></li>
                  <li><a href="{{ url('edit-venuesociallinks/'.$venue_id) }}" title="Web site & Social Links">
                      <span class="round-tabs">
                           <i class="fa fa-share-alt"></i>
                      </span>
                  </a></li>

                  <li ><a href="{{url('confirmvenue/'.$venue_id)}}" title="Confirm Venue">
                      <span class="round-tabs">
                           <i class="fa fa-check"></i>
                      </span> </a>
                  </li>

                  </ul></div>
                   <div class="tab-pane fade in active" id="venuecontact">

                      <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('edit-venueaddress/'.$venue_id.'/'.$contact_id) }}">
                        {{csrf_field()}}
                          <h5 style="color:#46A6EA"><b>Address</b></h5><hr>
                        <div class="row">
                          @foreach($venue_address as $address)
                        <div class="form-group">
                              <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Address:</label>
                                <div class="col-xs-7 col-sm-6">
                                  <input type="hidden" name="address_id" value="{{$address->AddressId}}">
                                  <input type="text" class="form-control" id="txt" name="address" value="{{$address->AddressLine1}}" required>
                                </div>
                                </div>
                              <div class="form-group">
                                <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="email">City:</label>
                                    <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venue-city" name="city" value="{{$address->City}}" pattern="([A-zÀ-ž\s]){5,20}" required>
                                        <span class="city-error" style="color: red;display: none;">City Should contain Only characters</span>
                                    </div>
                              </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="email">Post Code:</label>
                                    <div class="col-xs-7 col-sm-6">
                                      <input type="text" class="form-control" id="post-code" name="post_code" value="{{$address->PostCode}}" pattern="([0-9]){3,25}" required>
                                      <span class="post-error" style="color: red;display: none;">Post Code Should contain Numeric Characters</span>
                                    </div>
                                </div>
                                  <div class="form-group">
                                    <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="email">Town:</label>
                                      <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="town" name="town" value="{{$address->County}}" pattern="([A-zÀ-ž\s]){5,25}" required>
                                        <span class="town-error" style="color: red;display: none;">Town Should contain Only 5-25 characters</span>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="email">Country:</label>
                                      <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="country" name="country" value="{{$address->Country}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                                        <span class="country-error" style="color: red;display: none;">Country Should contain Only 5-25 characters</span>
                                      </div>
                                  </div>
                                  <center>
                                    <button class="btn btn-primary">Save</button>
                                 <!-- <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Another Address</button>-->
                                </div>
 @endforeach
 <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('edit-venueaddress/'.$venue_id.'/'.$contact_id) }}">
                        {{csrf_field()}}
                                      <h5 style="color:#46A6EA"><b>Contact</b></h5><hr>
                                    <div class="row">
                                      @foreach($contacts as $contact)
                                      <div class="form-group">
                                           <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Contact Name:</label>
                                        <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venue-contact" name="contact_name" value="{{$contact->FirstName}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                                        <span class="contact-error" style="color: red;display: none;">Contact Name should contain 3-25 Characters.</span>
                                       </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label  col-xs-4 col-sm-offset-2 col-sm-2" for="email">Mobile:</label>
                                      <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venue-mobile" name="mobile" value="{{$contact->Phone}}" pattern="([0-9]){10}" required>
                                        <span class="mobile-error" style="color: red;display: none;">Mobile number should contain 10 digits.</span>
                                      </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label  col-xs-4 col-sm-offset-2 col-sm-2" for="email">Email:</label>
                                      <div class="col-xs-7 col-sm-6">
                                          <input type="email" class="form-control" id="venue-email" name="email" value="{{$contact->Email}}" required>
                                      </div>
                                      </div>
                                      @endforeach
                                        <!--<button class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Add Another Contact</button><br>-->
                              <center>
                              <button class="btn btn-primary">Save</button>
                            </center>
                               </form>
                               <hr>
                                <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('edit-venueaddress/'.$venue_id.'/'.$contact_id) }}">
                        {{csrf_field()}}
                                <div class="row">
                                      <div class="form-group">
                                           <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Contact Name:</label>
                                        <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venuecontact" name="new_contact" value="{{old('contact')}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                                        <span class="contact-error" style="color: red;display: none;">Contact Name should contain 3-25 Characters.</span>
                                       </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label  col-xs-4 col-sm-offset-2 col-sm-2" for="email">Mobile:</label>
                                      <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venue-mobile" name="new_mobile" value="{{old('mobile')}}" pattern="([0-9]){10}" required>
                                        <span class="mobile-error" style="color: red;display: none;">Mobile number should contain 10 digits.</span>
                                      </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label  col-xs-4 col-sm-offset-2 col-sm-2" for="email">Email:</label>
                                      <div class="col-xs-7 col-sm-6">
                                          <input type="email" class="form-control" id="venue-email" name="new_email" value="{{old('email')}}" required>
                                      </div>
                                      </div>
                                       <!-- <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Add Another Contact</button><br>-->
                              <center>
                              <button class="btn btn-primary">Save</button>
                              
                            </center>
                               </form>
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
console.log('{{ url('getoldvenues/address/'.$venue_id) }}');
$.ajax({
    url: '{{ url('getoldvenues/address/'.$venue_id) }}',
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