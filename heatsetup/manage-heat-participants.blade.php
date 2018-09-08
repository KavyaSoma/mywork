@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
    <!--Heat setup starts here -->
  <div class="container" style="margin-top:20px">
  <ol class="breadcrumb" style="background:#46A6EA;">
  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ url('/manageheatsetup') }}">Heat setup & Result entry</a></li>
  <li class="breadcrumb-item"><a href="{{ url('/heatsetup/'.$event_id) }}">Heat Setup</a></li>
  <li class="breadcrumb-item active">Add Participants</li>
 </ol>    
  <div class="row">
    <div class="board">
        <div class="tab-content tab_details">            
<div class="tab-pane fade in active" id="manageparticipants">
<form class="form-horizontal" style="background:#fff;" method="post" action="{{url('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id) }}">
  {{csrf_field()}}
<div class="form-group">
<label class="control-label col-sm-4 form_heat" for="sel1">Select Heat:</label>
<div class="col-sm-6">
  @if(count($heats)>0)
<select class="form-control country" id="sel1"  name="heats_id" onchange="heats('{{url('manageparticipants/'.$event_id.'/'.$subevent_id)}}')" required>
   <option value="">Select Option</option>
  @foreach($heats as $heat)
  <option value="{{$heat->HeatId}}" @if($heat_id == $heat->HeatId) selected @endif>{{$heat->HeatName}}</option>
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
<form class="form-horizontal" style="background:#fff;" method="post" action="{{url('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id) }}">
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
<form method="post" action="{{url('manageparticipants/'.$event_id.'/'.$subevent_id.'/'.$heat_id) }}">
	{{csrf_field()}}
<button class="btn btn-primary" style="margin-left: 40px">Save Participants</button>

 </center>
 </div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
  function heats(url){
  var selectedCountry = $(".country option:selected ").val();
  window.location.assign(url+'/'+selectedCountry);
}
</script>
@endsection