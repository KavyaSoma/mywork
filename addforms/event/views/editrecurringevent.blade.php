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
                            <div class="tab-pane" id="tab-3">
        <div class="container">
                           
                              <div class="form-group" id="field1">
                                  <label class="control-label col-sm-2" for="txt">Occurance:</label>
                                         <ul class="nav nav-pills">
                <li><a href="{{url('edit-scheduleevent/'.$event_id)}}" style="background-color:#ddd;color:#46A6EA">One Time</a></li>
                <li><a href="{{url('edit-multipleevent/'.$event_id)}}"  style="background-color:#ddd;color:#46A6EA">Multiple</a></li>
                <li class="active"><a href="{{url('edit-recurringevent/'.$event_id)}}" style="background-color:#46A6EA">Recurring</a></li>
           </ul>
                                      
                              </div>
                    </div>
                    <hr>
                      
             
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#week">By Week</a></li>
    <li><a data-toggle="tab" href="#month">By Month</a></li>
    <li><a data-toggle="tab" href="#year">By Year</a></li>
  </ul>
 <form method="post" action="{{url('edit-weekevent/'.$event_id)}}">
      {{csrf_field()}}
  <div class="tab-content">
    <div id="week" class="tab-pane fade in active">
      <div class="container"  style="padding-left:50px;border:1px solid #eee;margin-top:20px">
      <div class="col-sm-3 row" style="margin-top:10px">
        <div class="checkbox">
                        <input id="checkbox1" type="checkbox" name="weekday[]" value="Monday">
                        <label for="checkbox1">
                            Monday
                        </label>
                    </div>
                    <div class="checkbox">
                        <input id="checkbox2" type="checkbox" name="weekday[]" value="Tuesday">
                        <label for="checkbox2">
                            Tuesday
                        </label>
                    </div>
                    <div class="checkbox">
                        <input id="checkbox3" type="checkbox" name="weekday[]" value="Wednesday">
                        <label for="checkbox3">
                            Wednesday
                        </label>
                    </div>
                    <div class="checkbox">
                        <input id="checkbox4" type="checkbox" name="weekday[]" value="Thursday">
                        <label for="checkbox4">
                            Thursday
                        </label>
                    </div>
                    <div class="checkbox">
                        <input id="checkbox5" type="checkbox" name="weekday[]" value="Friday">
                        <label for="checkbox5">
                          Friday
                        </label>
                    </div>
                    <div class="checkbox">
                        <input id="checkbox6" type="checkbox" name="weekday[]" value="Saturday">
                        <label for="checkbox6">
                          Saturday
                        </label>
                    </div>
                    <div class="checkbox">
                        <input id="checkbox7" type="checkbox" name="weekday[]" value="Sunday">
                        <label for="checkbox7">
                          Sunday
                        </label>
                    </div>
  </div>
  <div class="col-sm-6 row" style="margin-top:20px">
<div class="form-group">
    <label class="control-label col-sm-4" for="dte">Between:</label>
    <div class="input-group">
        <input type="date" class="form-control" id="dte" name="start_date">
        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
    </div>
  </div>
<div class="form-group">
  <label class="control-label col-sm-4" for="dte">And:</label>
  <div class="input-group">
      <input type="date" class="form-control" id="dte" name="end_date">
      <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
  </div>
  </div>
  <div class="form-group at">
  <label class="control-label col-sm-4" for="tme">At:</label>
  <div class="input-group">
    <input type="time" class="form-control" id="tme" name="time">
    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
  </div>
  </div>
  <center>
<button class="btn btn-primary">Save</button>
  
  </form>
  </div>
</div>
    </div>

     <div id="month" class="tab-pane fade">
      <form method="post" action="{{url('edit-monthevent/'.$event_id)}}">
        {{csrf_field()}}
    <div class="container" style="padding-left:50px;margin-top:20px">

                      <div class="form-group">
                          <div class="radio"><input type="radio" name="month_details" value="mothly_day">
                            <div class="col-sm-2 mob-none">The</div>
                              <div class="form-group">
                              <div class="col-sm-2">
                                      <select  class="form-control" id="sel" name="recuring_monthday">
                                        <option value="1">First</option>
                                        <option value="2">Second</option>
                                        <option value="3">Third</option>
                                        <option value="4">Fourth</option>
                                      </select>
                                      </div>
                                      <div class="col-sm-2">
                                    <select  class="form-control" id="sel" name="recuring_day">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                  </select>
                                </div>
                                  <div class="col-sm-2">of Every</div>
                                    <div class="col-sm-2">
                                      <select  class="form-control" id="sel" name="recuring_month">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                  </select>
                                </div>
                                    <div class="col-sm-2">Months</div>
                          </div></div></div><br><br>
                          <div class="radio"><input type="radio" name="month_details" value="monthly">  <div class="col-sm-2 mob-none">The</div>
                              <div class="form-group">
                              <div class="col-sm-2">
                                      <select  class="form-control" id="sel" name="recuring_monthday">
                                        <option value="1">1st</option>
                                        <option value="2">2nd</option>
                                        <option value="3">3rd</option>
                                        <option value="4">4th</option>
                                      </select>
                                      </div>
                                      <div class="col-sm-2">Day of Every</div>
                                    <div class="col-sm-2 mob-none"></div>
                                    <div class="col-sm-2">
                                      <select  class="form-control" id="sel" name="recuring_month">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                  </select>
                                </div>
                                    <div class="col-sm-2">Months</div>
                          </div></div>
                    </div>
<br>

    <div class="row between_months">
    <div class="col-md-4">
    <div class="form-group">
    <label class="control-label col-sm-4" for="dte">Between:</label>
    <div class="input-group">
        <input type="date" class="form-control" id="dte" name="start_date">
        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
    </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label class="control-label col-sm-4" for="dte">And:</label>
    <div class="input-group">
      <input type="date" class="form-control" id="dte" name="end_date">
      <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
    </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label class="control-label  col-sm-4" for="tme">At:</label>
    <div class="input-group">
    <input type="time" class="form-control" id="tme" name="time">
    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
    </div>
    </div>
    </div>
    </div>

                  <center>
                    <a  href="#subevents" data-toggle="tab">
                       <button class="btn btn-primary">Back</button>
                     </a>
                    <button class="btn btn-primary">Save</button>
                    <a href="#eventcontact" data-toggle="tab">
                      <button class="btn btn-primary">Next</button>
                    </a>
                  </form>


  </div>


    <div id="year" class="tab-pane fade">
      <form method="post" action="{{url('edit-yearevent/'.$event_id)}}">
        {{csrf_field()}}
      <div class="container" style="padding-left:50px;margin-top:20px">
                    <div class="form-group">
                        <div class="radio"><input type="radio" name="year" value="yearly">
                          <div class="col-sm-2">The</div>
                            <div class="form-group">
                            <div class="col-sm-2">
                                    <select  class="form-control" id="year_monthly_days">
                                      <option>First</option>
                                      <option>Second</option>
                                      <option>Third</option>
                                      <option>Fourth</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-2">
                                  <select  class="form-control" id="year_weekly_days">
                                  <option>Monday</option>
                                  <option>Tuesday</option>
                                  <option>Wednesday</option>
                                  <option>Thursday</option>
                                  <option>Friday</option>
                                  <option>Saturday</option>
                                  <option>Sunday</option>
                                </select>
                              </div>
                                <div class="col-sm-2">of Every</div>
                                  <div class="col-sm-2">
                                    <select  class="form-control" id="year_monthly">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                  <option>4</option>
                                  <option>5</option>
                                  <option>6</option>
                                  <option>7</option>
                                  <option>8</option>
                                  <option>9</option>
                                  <option>10</option>
                                  <option>11</option>
                                  <option>12</option>
                                </select>
                              </div>
                                  <div class="col-sm-2">Months</div>
                        <br><br>

                          <div class="col-sm-2">Every</div>
                            <div class="col-sm-4"><input type="text" class="form-control" id="txt" name="recuring_year" placeholder="Enter Number"></div>
                              <div class="col-sm-2">Years</div>
                            <br><br>
                        <div class="radio"><input type="radio" name="year" value="monthly">  <div class="col-sm-2 ">The</div>
                            <div class="form-group">
                            <div class="col-sm-2">
                                    <select  class="form-control" id="sel" name="year_monthly_days">
                                      <option>1st</option>
                                      <option>2nd</option>
                                      <option>3rd</option>
                                      <option>4th</option>
                                    </select>
                                    </div>

                                <div class="col-sm-2">Day of Every</div>
                                  <div class="col-sm-2"></div>
                                  <div class="col-sm-2">
                                  <select  class="form-control" id="sel" name="year_monthly">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                  <option>4</option>
                                  <option>5</option>
                                  <option>6</option>
                                  <option>7</option>
                                  <option>8</option>
                                  <option>9</option>
                                  <option>10</option>
                                  <option>11</option>
                                  <option>12</option>
                                </select>
                              </div>
                                  <div class="col-sm-2">Months</div>
                        </div></div>
                  </div>
                </div>
                      </div>
    </div>

                  <div class="row between_months">
                  <div class="col-md-4">
                  <div class="form-group">
                  <label class="control-label  col-sm-4" for="dte">Between:</label>
                  <div class="input-group">
                      <input type="date" class="form-control" id="dte" name="start_date">
                      <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                  </div>
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                  <label class="control-label col-sm-4" for="dte">And:</label>
                  <div class="input-group">
                    <input type="date" class="form-control" id="dte" name="end_date">
                    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                  </div>
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                  <label class="control-label col-sm-4" for="tme">At:</label>
                  <div class="input-group">
                  <input type="time" class="form-control" id="tme" name="time">
                  <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                  </div>
                  </div>
                  </div>
                  </div>

                                <center>
                                  <button class="btn btn-primary">Save</button>
                                </form>



    </div>

  </div>
</div>

      </div>
    </div>
    </div>

              </div>
              

                    </div><div class="row">
                    <div id="old_schedule">
                
                </div>
              </div>
                  </div>
                </div>
              </div>
            </center>
          </div>
        </center>
      </div>
    </center>
 

</div>
<script>
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