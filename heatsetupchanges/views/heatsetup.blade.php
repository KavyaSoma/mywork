@extends('layouts.main')
@section('content')
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
              <li class="active">
                <a href=""  class="tab-one"title="Stage Summary">
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
                 <li>
                   <a href="" title="Manage Participants">
                      <span class="round-tabs">
                        <i class="fa fa-plus"></i>
                     </span>
                  </a>
                 </li>
                </ul></center>
                  </div>
                   
                  <div class="tab-content tab_details">
                    
                    <div class="tab-pane fade in active" id="stagesummary">
                                 
                      <form class="form-horizontal" style="background:#fff;" method="post" action="{{url('heatsetup/'.$event_id)}}">
                        {{csrf_field()}}
                          <div class="col-sm-12">
                            <div class="form-group">
<label class="control-label col-sm-4" for="txt">SubEvent Name:</label>
<div class="col-sm-6">
  <select class="form-control"  name="subevents" required>
    <option value="">Select Dropdown</option>
    @foreach($subevents as $subevent)
    <option value="{{$subevent->SubEventId}}">{{$subevent->SubEventName}}</option>
    @endforeach
  </select>
 </div>
</div>            
                </div>
                        <div class="col-sm-12">
                          <div class="form-group">
                        
        <label class="control-label col-sm-4 form_heat" for="txt">Stage No:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="stage-no" name="stage_no" required>
          <div id="error-msg" style="color:red;display: none">Stage No should contain 3-10 Numeric Characters</div>
        </div>
      </div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Stage Name:</label>
<div class="col-sm-6">
  <input type="text" class="form-control" id="stage-name" name="stage_name" required>
  <div id="msg" style="color:red;display: none">StageName should contain only Alphabets</div>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Type of Heat Generation:</label>
<div class="col-sm-4">
<label class="radio-inline"><input type="radio" name="heat_generation" required>Manual</label>
<label class="radio-inline"><input type="radio" name="heat_generation" required>Automatic</label>
</div>
</div>
<center>
<a>
 <button class="btn btn-primary" type="reset">Cancel</button>
</a>
<button class="btn btn-primary">Save and Continue</button>
</form>
 </center>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
    $(document).ready(function() {
console.log('{{ url('resultentry/'.$event_id.'/3') }}');
$.ajax({
    url: '{{ url('resultentry/'.$event_id.'/3')  }}',
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