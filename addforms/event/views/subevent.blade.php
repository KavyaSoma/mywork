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
                 <li >
                <a href="{{url('/addevent')}}" class="tab-one" title="Event Summary">
                  <span class="round-tabs">
                    <i class="fa fa-bullhorn"></i>
                  </span>
                 </a></li>
                 <li class="active"><a href="{{url('/subevent')}}" title="Sub Events">
                   <span class="round-tabs">
                     <i class="fa fa-list"></i>
                   </span>
                 </a>
                    </li>
                  <li><a href="{{url('/schedule-event/'.$event_id)}}" title="Schedule">
                      <span class="round-tabs">
                           <i class="fa fa-calendar"></i>
                      </span> </a>
                      </li>

                      <li><a href="{{url('/contact-event')}}" title="Contacts">
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
  
              <div class="tab-pane fade in active" id="subevents">
                <form class="form-horizontal" style="background:#fff;" method="post" action="{{url('/subevent/'.$event_id)}}">
                  {{csrf_field()}}
                  <div class="row">
                    <form class="form-horizontal">
    <div class="form-group"  id="field1">
      <label class="control-label col-xs-4 col-sm-4" for="txt">SubEvent Name:</label>
      <div class="col-xs-7 col-sm-6">
        <input type="text" class="form-control" id="sub-event" name="subevent_name" value="{{old('subevent_name')}}" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-xs-4 col-sm-4" for="sel">Swim Style:</label>
      <div class="col-xs-7 col-sm-6">
        <select class="form-control" id="sel" name="swim_styles" required>
          <option value="Any">Any</option>
          <option value="Butterfly">Butterfly</option>
          <option value="BackStroke">BackStroke</option>
          <option value="FrontStroke">FrontStroke</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-xs-4 col-sm-4" for="txt">Course:</label>
      <div class="col-xs-7 col-sm-6">
        <input type="text" class="form-control" id="course" name="course" value="{{old('course')}}" pattern="([0-9]){2,10}" required>
        <span class="course-error" style="color: red;display: none;">Course Should Contain Numeric Charaters</span>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-xs-4 col-sm-4" for="txt">Description:</label>
      <div class="col-xs-7 col-sm-6">
        <textarea type="text" class="form-control" id="txt" name="description" required>{{old('description')}}</textarea>
      </div>
    </div>
    <div class="form-group">
                          <label class="control-label col-xs-5 col-sm-offset-2 col-sm-2" for="txt">Disabled Only?:</label>
                              <div class="col-xs-7 col-sm-4">
                                  <label class="radio-inline"><input type="radio" name="disabled" value="yes" required>Yes</label>
                                      <label class="radio-inline"><input type="radio" name="disabled" value="no" required>No</label>
                              </div>
                        </div>
    @if($privacy == "personal")
   <!-- when privacy is set as personal participants block should be displayed-->
    @else
    <hr>
    <h5 style="color:#46A6EA"><b>Participants</b></h5>
                  <div class="form-group">
                    <label class="control-label col-xs-4 col-sm-4" for="txt">Minimum:</label>
                    <div class="col-xs-7 col-sm-6">
                      <input type="text" class="form-control" id="min-part" name="min_participants" value="{{old('min_participants')}}" pattern="([0-9]){1,3}" required>
                      <span class="min-part-error" style="color: red;display: none;">Minimum Participants should contain 2-3 Numeric values</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-xs-4 col-sm-4" for="txt">Maximum:</label>
                    <div class="col-xs-7 col-sm-6">
                      <input type="text" class="form-control" id="max-part" name="max_participants" value="{{old('max_participants')}}" pattern="([0-9]){1,3}" required>
                      <span class="max-part-error" style="color: red;display: none">Maximum partcipants should contain 2-3 Numeric values</span>
                      <span class="participant-error" style="color: red;display: none">Minimum partcipants should be less than Maximum participants</span>
                    </div>
                  </div>
                    <hr>
                    <h5 style="color:#46A6EA"><b>Age</b></h5>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Minimum:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="text" class="form-control" id="min-age" name="min_age" value="{{old('min_age')}}" pattern="([0-9]){1,3}" required>
                        <span class="min-age-error" style="color: red;display: none">Minimum Age should contain 1-2 Numeric values</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Maximum:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="text" class="form-control" id="max-age" name="max_age" value="{{old('max_age')}}" pattern="([0-9]){1,3}" required>
                        <span class="max-age-error" style="color: red;display: none">Minimum Age should contain 1-2 Numeric values</span>
                        <span class="age-error" style="color: red;display:none">Minimum Age should be less than Maximum Age</span>
                      </div>
                    </div>
                        <!--  <button class="btn btn-primary pull-right" id="subevent"><i class="fa fa-plus"> Add Another Sub Event</i></button>-->
                      </div><br>
                      @endif
                  <center>
                          <button class="btn btn-primary" id="save-subevent">Save</button>
                        </center>
                      </form>
                      </div>
                      
                       

                    </div>
                  </div>
                </div>
                <div id="old_events">
                
                </div>
              </div>
            </form>
          </div>
<script>
$(document).ready(function() {
console.log('{{ url('getoldevents/subevents/'.$event_id) }}');
$.ajax({
    url: '{{ url('getoldevents/subevents/'.$event_id) }}',
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