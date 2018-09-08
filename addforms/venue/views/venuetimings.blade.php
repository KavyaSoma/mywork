@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin-left:13px;text-align: center;">
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
              <li><a href="" title="Address & Contact">
                  <span class="round-tabs">
                       <i class="fa fa-phone"></i>
                  </span> </a>
                  </li>

                  <li  class="active"><a href="{{url('venuetimings/'.$venue_id)}}" title="Open hours & Facilities">
                      <span class="round-tabs">
                           <i class="fa fa-clock-o"></i>
                      </span>
                  </a></li>
                  <li><a href="{{url('venuesociallinks/'.$venue_id)}}" title="Web site & Social Links">
                      <span class="round-tabs">
                           <i class="fa fa-share-alt"></i>
                      </span>
                  </a></li>

                  <li><a href="" title="Confirm Venue">
                      <span class="round-tabs">
                           <i class="fa fa-check"></i>
                      </span> </a>
                  </li>

                  </ul></div>
                  <form method="post" action="{{ url('venuetimings/'.$venue_id) }}">
                    {{csrf_field()}}
                     <div class="tab-pane fade in active" id="venuefacilities">
                        <h5 style="color:#46A6EA"><b>Opening Hours</b></h5><hr>
                        <div class="row">
                    
  <div class="col-sm-2">
    <label class="checkbox-inline">
     <input type="checkbox" name="day_one[]" value="Monday">Monday
        
        </label>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label class="control-label col-sm-3" for="tme">From:</label>
          <div class="col-sm-2">
            <div class="input-group">
                  <input type="time" class="form-control" id="start-one" step="2" name="day_one[]">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
            </div>
          </div>
          </div>
        </div>
<div class="col-sm-4">
          <div class="form-group">
          <label class="control-label col-sm-3" for="tme">To:</label>
          <div class="col-sm-2">
            <div class="input-group">
                 <input type="time" class="form-control" id="end-one" step="2" name="day_one[]">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
            </div>
          </div>
          </div>
</div>
</div><br>
<div class="row">
<div class="col-sm-2">
<label class="checkbox-inline">
     <input type="checkbox" name="day_two[]" value="Tuesday">Tuesday
   </label>
 </div>
 <div class="col-sm-4">
   <div class="form-group">
     <label class="control-label col-sm-3" for="tme">From:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_two[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
   </div>
<div class="col-sm-4">
     <div class="form-group">
     <label class="control-label col-sm-3" for="tme">To:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_two[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
</div>

</div><br>
<div class="row">
<div class="col-sm-2">
<label class="checkbox-inline">
     <input type="checkbox" name="day_three[]" value="Wednesday">Wednesday
   </label>
 </div>
 <div class="col-sm-4">
   <div class="form-group">
     <label class="control-label col-sm-3" for="tme">From:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_three[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
   </div>
<div class="col-sm-4">
     <div class="form-group">
     <label class="control-label col-sm-3" for="tme">To:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_three[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
</div>

</div><br>
<div class="row">
<div class="col-sm-2">
<label class="checkbox-inline">
     <input type="checkbox" name="day_four[]" value="Thursday">Thursday
   </label>
 </div>
 <div class="col-sm-4">
   <div class="form-group">
     <label class="control-label col-sm-3" for="tme">From:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_four[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
   </div>
<div class="col-sm-4">
     <div class="form-group">
     <label class="control-label col-sm-3" for="tme">To:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_four[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
</div>

</div><br>
<div class="row">
<div class="col-sm-2">
<label class="checkbox-inline">
     <input type="checkbox" name="day_five[]" value="Friday">Friday
   </label>
 </div>
 <div class="col-sm-4">
   <div class="form-group">
     <label class="control-label col-sm-3" for="tme">From:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_five[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
   </div>
<div class="col-sm-4">
     <div class="form-group">
     <label class="control-label col-sm-3" for="tme">To:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_five[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
</div>

</div><br>
<div class="row">
<div class="col-sm-2">
<label class="checkbox-inline">
     <input type="checkbox" name="day_six[]" value="Saturday">Saturday
   </label>
 </div>
 <div class="col-sm-4">
   <div class="form-group">
     <label class="control-label col-sm-3" for="tme">From:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_six[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
   </div>
<div class="col-sm-4">
     <div class="form-group">
     <label class="control-label col-sm-3" for="tme">To:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_six[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
</div>

</div><br>
<div class="row">
<div class="col-sm-2">
<label class="checkbox-inline">
     <input type="checkbox" name="day_seven[]" value="Sunday">Sunday
   </label>
 </div>
 <div class="col-sm-4">
   <div class="form-group">
     <label class="control-label col-sm-3" for="tme">From:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_seven[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
   </div>
<div class="col-sm-4">
     <div class="form-group">
     <label class="control-label col-sm-3" for="tme">To:</label>
     <div class="col-sm-2">
       <div class="input-group">
           <input type="time" class="form-control" id="tme" step="2" name="day_seven[]">
           <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
       </div>
     </div>
     </div>
</div>

</div>

 
                        <h5 style="color:#46A6EA"><b>Facilities</b></h5><hr>
                        <div class="row">
                        <div class="col-sm-3">
                        <div class="checkbox">
                          <label><input type="checkbox" name="para_swimming" @if('checked') value="yes" @else value="no" @endif>Para swimming</label>
                          <!--<img src="{{ url('images/paraswimming.jpg') }}" height="30px" width="30px">-->
                        </div>
                        <div class="checkbox">
                          <label><input type="checkbox" name="shower"  @if('checked') value="yes" @else value="no" @endif>Shower</label>
                          <!--<img src="{{ url('images/shower.png') }}" height="30px" width="30px" style="margin-left:45px">-->
                        </div>
                        
                        <div class="checkbox">
                          <label><input type="checkbox" name="gym"  @if('checked') value="yes" @else value="no" @endif>Gym</label>
                         <!-- <img src="{{ url('images/gym.jpg') }}" height="30px" width="30px"  style="margin-left:70px">-->
                        </div>
                        <div class="checkbox">
                        <label><input type="checkbox" name="ladies"  @if('checked') value="yes" @else value="no" @endif>Ladies Only</label>
                       <!-- <img src="{{ url('images/parking.jpg') }}" height="30px" width="30px"style="margin-left:52px">-->
                      </div>
                      </div>
                      <div class="col-sm-3">
                      <div class="checkbox">
                        <label><input type="checkbox" name="parking"  @if('checked') value="yes" @else value="no" @endif>Parking</label>
                        <!--<img src="{{ url('images/parking.jpg') }}" height="30px" width="30px"style="margin-left:52px">-->
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" name="instructor"  @if('checked') value="yes" @else value="no" @endif>Instructors</label>
                        <!--<img src="{{ url('images/instructors.png') }}" height="30px" width="30px" style="margin-left:37px">-->
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" name="diving"  @if('checked') value="yes" @else value="no" @endif>Diving</label>
                        <!--<img src="{{ url('images/diving.png') }}" height="30px" width="30px"style="margin-left:64px">-->
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" name="swim_kids"  @if('checked') value="yes" @else value="no" @endif>Swim for kids</label>
                        <!--<img src="{{ url('images/parking.jpg') }}" height="30px" width="30px"style="margin-left:52px">-->
                      </div>
                      </div>
                      <div class="col-sm-3">
                      
                      <div class="checkbox">
                        <label><input type="checkbox" name="visit_gallery"  @if('checked') value="yes" @else value="no" @endif>Visiting Gallery</label>
                        <!--<img src="{{ url('images/kidszone.png') }}" height="30px" width="30px" style="margin-left:39px">-->
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" name="toilet" @if('checked') value="yes" @else value="no" @endif>Toilets</label>
                        <!--<img src="{{ url('images/instructors.png') }}" height="30px" width="30px" style="margin-left:37px">-->
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" name="privatehire"  @if('checked') value="yes" @else value="no" @endif>PrivateHire</label>
                        <!--<img src="{{ url('images/diving.png') }}" height="30px" width="30px"style="margin-left:64px">-->
                      </div>
                      </div>
                    </div>
                    

                    <center>
                       <button class="btn btn-primary">Save&Continue</button>
                       
                     </center>
</form>
                          </div>
                        </div>
                      </div>
                    </div>
                          @endsection