@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
    <div class="alert alert-info" style="margin:13px;text-align: center;">
    Please Click on Confirm button to save changes
    </div>
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
                <a href="" title="Stage Summary">
                  <span class="round-tabs">
                    <i class="fa fa-list"></i>
                  </span>
                 </a>
               </li>
               <li>
                 <a href="" title="Schedule Event">
                    <span class="round-tabs">
                      <i class="fa fa-calendar"></i>
                   </span>
                </a>
               </li>
                 <li class="active">
                   <a href="" title="Manage Participants">
                      <span class="round-tabs">
                        <i class="fa fa-plus"></i>
                     </span>
                  </a>
                 </li>
                </ul></center>
                  </div>
                  <div class="tab-content tab_details">
                    
 
<div class="tab-pane fade in active" id="manageparticipants">
<form class="form-horizontal" style="background:#fff;" method="post" action="{{url('manageparticpants/'.$event_id.'/'.$subevent_id.'/'.$heat_id) }}">
  {{csrf_field()}}
<div class="form-group">
<label class="control-label col-sm-4 form_heat" for="sel1">Select Heat:</label>
<div class="col-sm-6">
  @if(count($heats)>0)
<select class="form-control country" id="sel1"  name="heats_id" onchange="heats('{{url('manageparticpants/'.$event_id.'/'.$subevent_id)}}')">
   <option>Select Option</option>
  @foreach($heats as $heat)
  <option value="{{$heat->HeatId}}">{{$heat->HeatName}}</option>
  @endforeach
</select>
@else
<h4>Add Heat</h4>
@endif
  </div>
</div>
<hr>
<div class="col-sm-4">
<ul class="list-group">
  <li class="list-group-item active">
    <div class="checkbox">
      <label>Participants</label>
    </div>
  </li>
@foreach($participants as $participant)  
  <li class="list-group-item">
    <div class="checkbox">
    <label><input type="checkbox" value="{{$participant->ParticipantId}}" name="participants[]">{{$participant->ParticipantName}}</label>
   </div>
  </li>
  @endforeach
 </ul>
</div>
 <div class="col-sm-offset-1 col-sm-3" style="margin-top:30px">
<button class="btn btn-primary" style="width: 170px"> Move to Heat <i class="fa fa-arrow-right" style="color:#ff6600"></i> </button><br><br>
</form>
<form class="form-horizontal" style="background:#fff;" method="post" action="{{url('manageparticpants/'.$event_id.'/'.$subevent_id.'/'.$heat_id) }}">
  {{csrf_field()}}
 <button class="btn btn-primary"><i class="fa fa-arrow-left"  style="color:#ff6600"></i> Move to Participants</button><br><br>
</div>
<div class="row">
<div class="col-sm-4">
<ul class="list-group">
  <li class="list-group-item active">
    <div class="checkbox">
      <label>{{$heatname}}</label>
    </div>
  </li>
  @foreach($heat_participants as $heat_participant)
     <li class="list-group-item ">
    <div class="checkbox">
      <label><input type="checkbox" value="{{$heat_participant->ParticipantId}}" name="heats_participants[]">{{$heat_participant->ParticipantName}}</label>
    </div>
  </li>
  @endforeach
   </ul>
</div>
</div>
<hr>
<center>
</form>
<form method="post" action="{{url('manageparticpants/'.$event_id.'/'.$subevent_id.'/'.$heat_id) }}">
	{{csrf_field()}}
<button class="btn btn-primary" style="margin-left: 40px">Confirm & Finish</button>

 </center>
 </div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

@endsection