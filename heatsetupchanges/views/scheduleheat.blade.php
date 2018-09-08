@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
    <!--Heat setup starts here -->
  <div class="container" style="margin-top:20px">
    <ul class="nav nav-tabs preview_tabs">
                                 <li class="active"><a href="{{url('heatsetup/'.$event_id)}}">Heat</a></li>
                                 <li><a href="">SemiFinal</a></li>
                                 <li><a href="">Final</a></li>
                               </ul>
  <div class="row" style="border:1px solid #eee">
    <div class="board">
      <div class="board-inner instructor_tabs">
        <center><ul class="nav nav-tabs nav_info" id="myTab">
            <div class="liner"></div>
              <li >
                <a href="#stagesummary" data-toggle="tab" class="tab-one"title="Stage Summary">
                  <span class="round-tabs">
                    <i class="fa fa-list"></i>
                  </span>
                 </a>
               </li>
               <li class="active">
                 <a href="#scheduleevent" data-toggle="tab" title="Schedule Event">
                    <span class="round-tabs">
                      <i class="fa fa-calendar"></i>
                   </span>
                </a>
               </li>
                 <li>
                   <a href="#manageparticipants" data-toggle="tab" title="Manage Participants">
                      <span class="round-tabs">
                        <i class="fa fa-plus"></i>
                     </span>
                  </a>
                 </li>
                </ul></center>
                  </div>
                  <div class="tab-content tab_details">
                    
<div class="tab-pane fade in active" id="scheduleevent">
<form class="form-horizontal  col-sm-10" method="post" action="{{url('scheduleheat/'.$event_id.'/'.$subevent_id.'/'.$heat_id)}}">
  {{csrf_field()}}
<div class="row">
  <div class="form-group">
  <label class="control-label col-sm-4 form_heat" for="txt" id="createevent_form">Heat Name:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="heat-name" name="heat_name" required>
    <div id="error" style="color: red;display: none">Heat Name should Contain 5-30 characters</div>
  </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-4" for="tme">Schedule Time:</label>
    <div class="col-sm-6">
      <div class="input-group">
          <input type="time" class="form-control" id="tme" name="schedule_time" required>
          <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
      </div>
    </div>
    </div>
    <div class="form-group">
    <label class="control-label col-sm-4" for="txt">Qualification:</label>
    <div class="col-sm-4">
    <label class="radio-inline"><input type="radio" name="qualification_time" value="0" required>Qualification Time <input type="text" name="qualification[]" style="width: 90px" placeholder="seconds"></label> 
    <label class="radio-inline"><input type="radio" name="qualification_time" value="1" style="margin-left:-29px;" required>Top from Heat <input type="text" name="qualification[]" style="width: 90px;margin-left: 13px;" placeholder="seconds"></label> 
    </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-4" for="tme">Schedule Date:</label>
        <div class="col-sm-6">
          <div class="input-group">
              <input type="date" class="form-control" id="tme" name="schedule_date" required>
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
          </div>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-4" for="txt">Course:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="heat-course" name="course" required>
          <div id="msg" style="color: red;display: none">Course should Contain 2-10 Numeric characters</div>
        </div>
      </div>
       <!-- <a href="#"><button class="btn btn-primary pull-right">Add Another Heat</button><br><br>-->
  </div>
<center>
 <button class="btn btn-primary">Save and Continue</button>

</center>
</form>
</div>
 
 </div>
</div>
</div>
<div id="old_schedule">
 </div>
</div>
</div>
</div>
<script>
$(document).ready(function() {
console.log('{{ url('oldscheduleheat/'.$event_id.'/'.$subevent_id.'/'.$heat_id) }}');
$.ajax({
    url: '{{ url('oldscheduleheat/'.$event_id.'/'.$subevent_id.'/'.$heat_id) }}',
    success: function(html) {
      if(html=="no") {
      } else {
        console.log(html);
        //$('#old_events').attr("src",html);
        $('#old_schedule').html(html);
      }
    },
    async:true
  });
              });
</script>
 
@endsection