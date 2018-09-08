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
                  <li   class="active"><a href="#" title="Schedule">
                      <span class="round-tabs">
                           <i class="fa fa-calendar"></i>
                      </span> </a>
                      </li>

                      <li><a href="#" title="Contacts">
                          <span class="round-tabs">
                               <i class="fa fa-phone"></i>
                          </span>
                      </a></li>
                      <li><a href="#" title="Venue">
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
  
                      <div class="tab-pane fade in active" id="eventschedule">
                          <div class="row">
                            <form method="post" action="{{url('multiple-event/'.$event_id)}}">
                              {{csrf_field()}}
                              <div class="form-group" id="field1">
                                  <label class="control-label col-sm-2" for="txt">Occurance:</label>
                                         <ul class="nav nav-pills">
                <li><a href="{{url('edit-scheduleevent/'.$event_id)}}" style="background-color:#ddd;color:#46A6EA">One Time</a></li>
                <li class="active"><a href="{{url('edit-multipleevent/'.$event_id)}}"  style="background-color:#46A6EA">Multiple</a></li>
                <li><a href="{{url('edit-recuringevent/'.$event_id)}}" style="background-color:#ddd;color:#46A6EA">Recurring</a></li>
           </ul>
                                      
                              </div>
                    </div>
                      
                        <hr>
                        <div class="fields">
             <div id="add-event">
              <div class="col-md-4">
                <div class="form-group">
                <label class="control-label col-xs-4 col-sm-4" for="dte">Between:</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="dte" name="multiple_startdate[]">
                    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                </div>
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group">
              <label class="control-label col-xs-4 col-sm-4" for="dte">And:</label>
              <div class="input-group">
                  <input type="date" class="form-control" id="dte" name="multiple_enddate[]">
                  <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
              </div>
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group at">
              <label class="control-label col-xs-4 col-sm-4" for="tme">At:</label>
              <div class="input-group">
                <input type="time" class="form-control" id="tme" name="time[]">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
              </div>
              </div>
              </div> 
                 

              </div>
              </div> 
              
              </div>
                 <center>
                <button class="btn btn-primary" type="submit" name="save">Save</button>
              </form>
               <button class="btn btn-primary pull-right" id="sub-event"><i class="fa fa-plus"> Add Another Date</i></button>
            </div>


</div>
             
</div>
<div class="row">
                    <div id="old_schedule">
                
                </div>
              </div>
              </div>
              

                    </div>
                  </div>
                </div>
                
              </div>
              <script>
                $(function(){
  $("#sub-event").click(function(){
    $(".fields").append($('.fields'));
  });
});
$(document).ready(function() {
console.log('{{ url('getoldevents/schedule/'.$event_id) }}');
$.ajax({
    url: '{{ url('getoldevents/schedule/'.$event_id) }}',
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