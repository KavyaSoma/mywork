@extends('layouts.main')
@section('content')
    <!--Heat setup starts here -->
 @if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
  <div class="container" style="margin-top:20px">
  <ol class="breadcrumb" style="background:#46A6EA;">
  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ url('/manageheatsetup') }}">Heat setup & Result entry</a></li>
  <li class="breadcrumb-item active">Heat Setup</li>
 </ol>
  <div class="row">
    
    <div class="board">
  You can create heats, semi finals and finals in this page. Create a heat to continue creating semi final, once you created a semi final you can create a final setup.
  You can scroll down to see previous entries and to add participants to a heat click on "add participants" link.
      <div class="board-inner instructor_tabs">
        <center><ul class="nav nav-tabs nav_info" id="myTab">
            <div class="liner"></div>
              <li class="active">
                <a href=""  class="tab-one"title="Stage Summary">
                  <span class="round-tabs">
                    <i class="fa fa-users"></i>
                  </span>
                 </a>
               </li>
                 <li>
                   <a href="{{ url('semiheatsetup/'.$event_id.'/'.$subevent_id) }}" title="Setup Semifinals">
                      <span class="round-tabs">
                        <i class="fa fa-thumbs-up"></i>
                     </span>
                  </a>
              
                 </li>
                 <li>
                   <a href="{{ url('finalheatsetup/'.$event_id.'/'.$subevent_id) }}" title="Setup Finals">
                      <span class="round-tabs">
                        <i class="fa fa-trophy"></i>
                     </span>
                  </a>
                  
                 </li>
                </ul></center>
                  </div>
                   
                  <div class="tab-content tab_details">
                    
                    <div class="tab-pane fade in active" id="stagesummary">
                                 @foreach($heat_details as $heat)
                    <form class="form-horizontal" style="background:#fff;" method="post" action="{{url('editheat/'.$event_id.'/'.$subevent_id.'/'.$heat->HeatId)}}">
                        {{csrf_field()}}

                        <div class="col-sm-12">
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Type of Heat Generation:</label>
<div class="col-sm-4">
<label class="radio-inline"><input type="radio" name="heat_generation" required>Manual</label>
<label class="radio-inline"><input type="radio" name="heat_generation" required>Automatic</label>
</div>
</div>  
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Heat Name:</label>
<div class="col-sm-4">
<input type="text" class="form-control" name="heat_name" placeholder="Heat Name" value="{{$heat->HeatName}}">  
</div>
</div>                             
<div class="form-group">
<label class="control-label col-sm-4" for="tme">Heat Start Date:</label>
<div class="col-sm-6">
<div class="input-group">
<input type="date" class="form-control" id="tme" name="start_date" value="{{$heat->HeatStartDate}}" required>
<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="tme">Heat End Date:</label>
<div class="col-sm-6">
<div class="input-group">
<input type="date" class="form-control" id="tme" name="end_date" value="{{$heat->HeatEndDate}}" required>
<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Heat Time:</label>
<div class="col-sm-4">
<input type="text" class="form-control" name="heat_time" style="width: 90px;margin-left: 13px;" value="{{$heat->HeatTime}}" placeholder="5 Seconds">
<input type="hidden" class="form-control" name="id" value="{{ $event_id }}" required>
<input type="hidden" class="form-control" name="childheatid" value="-1" required>
<input type="hidden" class="form-control" name="stagenumber" value="1" required>
</div>
</div> 
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Qualification Time:</label>
<div class="col-sm-4">
<input type="text" class="form-control" name="qualification_time" style="width: 90px;margin-left: 13px;" value="{{$heat->QualificationTime}}" placeholder="5 Seconds">  
</div>
</div>                            
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Max no of Participants:</label>
<div class="col-sm-6">
<input type="text" class="form-control"  name="max_participants" value="{{$heat->MaxNoOfParticipants}}" readonly required> 
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Location:</label>
<div class="col-sm-6">
<select class="form-control" id="sel" name="venue_id" required>
  @foreach($venues as $venue)
          <option value="{{$venue->VenueId}}">{{$venue->VenueName}}</option>
          @endforeach
        </select> 
</div>
</div>                            
      <div class="form-group">
        <label class="control-label col-sm-4" for="txt">Relay:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" value="{{$heat->Relay}}" name="relay" required> 
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4" for="txt">SwimCourse:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" value="{{$heat->SwimCourse}}" name="course" readonly required> 
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-sm-4" for="txt">SwimStyle:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" value="{{$heat->SwimStyle}}" name="swim_style" readonly required> 
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4" for="txt">SpecialInstructions:</label>
        <div class="col-sm-6">
          <textarea class="form-control" name="specialinstructions" required>{{$heat->VenueHeatSpecialInstructions}}</textarea>
        </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4" for="txt">Heat Notes:</label>
        <div class="col-sm-6">
          <textarea class="form-control" name="descriptions" required>{{$heat->HeatNotes}}</textarea>
        </select>
        </div>
      </div>
<center>
<button class="btn btn-primary mybtn" type="submit">Save Heat Settings</button>
</form>
@endforeach
 </center>
</div>
</div>

</div>
</div>

</div>
<div id="heat_participants">
  </div>
</div>

</div>
</div>
<script>
    $(document).ready(function() {
console.log('{{ url('oldscheduleheat/'.$event_id.'/'.$subevent_id) }}');
$.ajax({
    url: '{{ url('oldscheduleheat/'.$event_id.'/'.$subevent_id)  }}',
    success: function(html) {
      if(html=="no") {
      } else {
        console.log(html);
        //$('#old_events').attr("src",html);
        $('#heat_participants').html(html);
      }
    },
    async:true
  });
              });

</script>
@endsection