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
                  <a href="" class="tab-one" title="Venue Summary">
                   <span class="round-tabs">
                           <i class="fa fa-list"></i>
                   </span>
               </a></li>

               <li><a href="" title="Pool Information">
                  <span class="round-tabs">
                      <i class="fa fa-info"></i>
                  </span>
        </a>
              </li>
              <li class="active"><a href="{{url('venueaddress/'.$venue_id)}}" data-toggle="tab" title="Address & Contact">
                  <span class="round-tabs">
                       <i class="fa fa-phone"></i>
                  </span> </a>
                  </li>

                  <li><a href="" title="Open hours & Facilities">
                      <span class="round-tabs">
                           <i class="fa fa-clock-o"></i>
                      </span>
                  </a></li>
                  <li><a href="" title="Web site & Social Links">
                      <span class="round-tabs">
                           <i class="fa fa-share-alt"></i>
                      </span>
                  </a></li>

                  <li><a href="" data-toggle="tab" title="Confirm Venue">
                      <span class="round-tabs">
                           <i class="fa fa-check"></i>
                      </span> </a>
                  </li>

                  </ul></div>
                   <div class="tab-pane fade in active" id="venuecontact">

                      <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('venueaddress/'.$venue_id) }}">
                        {{csrf_field()}}
                          <h5 style="color:#46A6EA"><b>Address</b></h5><hr>
                        <div class="row">
                        <div class="form-group">
                              <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Address:</label>
                                <div class="col-xs-7 col-sm-6">
                                  <input type="text" class="form-control" id="txt" name="address" value="{{old('address')}}" required>
                                </div>
                                </div>
                              <div class="form-group">
                                <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="email">City:</label>
                                    <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venue-city" name="city" value="{{old('city')}}" pattern="([A-zÀ-ž\s]){5,20}" required>
                                        <span class="city-error" style="color: red;display: none;">City Should contain Only 5-20 characters</span>
                                    </div>
                              </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="email">Post Code:</label>
                                    <div class="col-xs-7 col-sm-6">
                                      <input type="text" class="form-control" id="post-code" name="post_code" value="{{old('post_code')}}" pattern="([0-9]){3,25}" required>
                                      <span class="post-error" style="color: red;display: none;">Post Code Should contain Numeric Characters</span>
                                    </div>
                                </div>
                                  <div class="form-group">
                                    <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="email">Town:</label>
                                      <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="town" name="town" value="{{old('town')}}" pattern="([A-zÀ-ž\s]){5,25}" required>
                                        <span class="town-error" style="color: red;display: none;">Town Should contain Only 5-25 characters</span>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="email">Country:</label>
                                      <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="country" name="country" value="{{old('country')}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                                        <span class="country-error" style="color: red;display: none;">Country Should contain Only 5-25 characters</span>
                                      </div>
                                  </div>
                                  <!--<button class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Another Address</button>-->
                                </div>

                                      <h5 style="color:#46A6EA"><b>Contact</b></h5><hr>
                                    <div class="row">
                                      <div class="form-group">
                                           <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Contact Name:</label>
                                        <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venuecontact" name="contact" value="{{old('contact')}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                                        <span class="contact-error" style="color: red;display: none;">Contact Name should contain 3-25 Characters.</span>
                                       </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label  col-xs-4 col-sm-offset-2 col-sm-2" for="email">Mobile:</label>
                                      <div class="col-xs-7 col-sm-6">
                                        <input type="text" class="form-control" id="venue-mobile" name="mobile" value="{{old('mobile')}}" pattern="([0-9]){10}" required>
                                        <span class="mobile-error" style="color: red;display: none;">Mobile number should contain 10 digits.</span>
                                      </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label  col-xs-4 col-sm-offset-2 col-sm-2" for="email">Email:</label>
                                      <div class="col-xs-7 col-sm-6">
                                          <input type="email" class="form-control" id="venue-email" name="email" value="{{old('email')}}" required>
                                      </div>
                                      </div>
                                       <!-- <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Add Another Contact</button><br>-->
                              <center>
                              <button class="btn btn-primary">Save&Continue</button>
                              
                            </center>
                               </form>
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
$("#venuecontact").ready(function(){
  var $regexname = /^([A-zÀ-ž\s]){3,25})$/;
  $("#venuecontact").on('keypress keydown keyup',function(){
    if(!$(this).val().match($regexname)){
      $('.contact-error').show();
    }
    else{
      $('.contact-error').hide();
    }
  });
});
</script> 
                                 @endsection