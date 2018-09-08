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
                            <form method="post" action="{{url('edit-scheduleevent/'.$event_id)}}">
                              {{csrf_field()}}
                              <div class="form-group" id="field1">
                                  <label class="control-label col-sm-2" for="txt">Occurance:</label>
                                  
                                        <div class="col-sm-4">
                                          <label class="radio-inline"><input type="radio" id="one-occurance"  value="OneTime" name="privacy" @if($occurance=="OneTime")  checked @endif>one time</label>
                                          <label class="radio-inline"><input type="radio" id="multiple-occurance" value="MULTIPLE" name="privacy" @if($occurance=="MULTIPLE")  checked @endif>multiple</label>
                                          <label class="radio-inline"><input type="radio" id="recuring-occurance" value="RECURRING" name="privacy" @if($occurance=="RECURRING")  checked @endif>recuring</label>
                                        </div>
                                      
                              </div>
                    </div>
               
                      <div class="row one" id="single">
                        <hr>
                      <div class="col-md-4">
                        <div class="form-group">
                        <label class="control-label col-xs-4 col-sm-4" for="dte">Between:</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="dte" name="start_date">
                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="dte">And:</label>
                      <div class="input-group">
                          <input type="date" class="form-control" id="dte" name="end_date">
                          <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group at">
                    <label class="control-label col-xs-4 col-sm-4" for="tme">At:</label>
                    <div class="input-group">
                        <input type="time" class="form-control" id="tme" name="time">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                  </div>
                </div>
                  <center>
                <button class="btn btn-primary" type="submit">Update</button>
                
              </form>
              </div>
               
             
            <div id="multiple">
                
              <div class="row">
                <hr>
                <form method="post" action="{{url('edit-scheduleevent/'.$event_id)}}">
                 {{csrf_field()}}
               <div class="fields">

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
                <input type="time" class="form-control" id="tme" name="multiple_time[]">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
              </div>
              </div>
              </div>             
              </div>
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
                <input type="time" class="form-control" id="tme" name="multiple_time[]">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
              </div>
              </div>
              </div>             
              </div>
              </div>
                 <center>
                
                <button class="btn btn-primary" type="submit" name="save">Update</button>
                
              </form>
            

               <button class="btn btn-primary pull-right" id="sub-event"><i class="fa fa-plus"> Add Another Date</i></button>
             </div>
         
              <div class="row recuring" >
                <hr>
                <div class="col-xs-12 col-sm-6">
                  <div class="col-xs-4 col-sm-4">
                    <button class="btn btn-default" id="week">By Week</button>
                  </div>
                  <div class="col-xs-4 col-sm-4">
                      <button class="btn btn-default" id="month">By Month</button>
                  </div>
                  <div class="col-xs-4 col-sm-4">
                      <button class="btn btn-default" id="year">By Year</button>
                  </div>
                </div>
              </div><br>
              <div id="weekdays">
                   <form method="post" action="{{url('edit-scheduleevent/'.$event_id.'/'.$schedule_id)}}">
                    {{csrf_field()}}
                <div class="well" style="background:#fff">
                  
                   <label class="checkbox-inline">
                    <input type="checkbox" value="monday" name="weekday[]">Monday
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" value="tuesday"  name="weekday[]">Tuesday
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" value="wednesday"  name="weekday[]">Wednesday
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" value="thursday" name="weekday[]">Thursday
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" value="friday" name="weekday[]">Friday
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" value="saturday" name="weekday[]">Saturday
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" value="sunday" name="weekday[]">Sunday
                  </label>
                  
                </div>
              <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                <label class="control-label col-sm-4" for="dte">Between:</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="dte" name="week_startdate">
                    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                </div>
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group">
              <label class="control-label col-sm-4" for="dte">And:</label>
              <div class="input-group">
                  <input type="date" class="form-control" id="dte" name="week_enddate">
                  <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
              </div>
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group at">
              <label class="control-label col-sm-4" for="tme">At:</label>
              <div class="input-group">
                <input type="time" class="form-control" id="tme" name="week_time">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
              </div>
              </div>
              </div>
              </div>
                <center>
                <button class="btn btn-primary" type="submit">Update</button>
              </form>
             </div>
         
                 
            <div id="monthdays">
              <div class="well" style="background:#fff;">
                <div class="form-group">
                   <form method="post" action="{{url('edit-scheduleevent/'.$event_id)}}">
                      {{csrf_field()}}
                    <div class="radio"><input type="radio" name="month_details" value="0" checked>
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
                              <option>Monday</option>
                              <option>Tuesday</option>
                              <option>Wednesday</option>
                              <option>Thursday</option>
                              <option>Friday</option>
                              <option> Saturday</option>
                              <option>Sunday</option>
                            </select>
                          </div>
                            <div class="col-sm-2">of Every</div>
                              <div class="col-sm-2">
                                <select  class="form-control" id="sel" name="recuring_month"> 
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
                    </div></div></div><br><br>
                    <div class="radio"><input type="radio" name="month_details" value="monthly">  
                      <div class="col-sm-2 mob-none">The</div>
                        <div class="form-group">
                        <div class="col-sm-2">
                                <select  class="form-control" id="sel" name="recuring_monthday">
                                   <option>1st</option>
                                  <option>2nd</option>
                                  <option>3rd</option>
                                  <option>4th</option>
                                </select>
                                </div>
                                <div class="col-sm-2">Day of Every</div>
                              <div class="col-sm-2 mob-none"></div>
                              <div class="col-sm-2">
                                <select  class="form-control" id="sel" name="recuring_month">
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
                    </div></div><br>
              </div>
              <div class="row">
              <div class="col-md-4">
              <div class="form-group">
              <label class="control-label col-sm-4" for="dte">Between:</label>
              <div class="input-group">
                  <input type="date" class="form-control" id="dte" name="month_startdate">
                  <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
              </div>
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group">
              <label class="control-label col-sm-4" for="dte">And:</label>
              <div class="input-group">
                <input type="date" class="form-control" id="dte" name="month_enddate">
                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
              </div>
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group at">
              <label class="control-label  col-sm-4" for="tme">At:</label>
              <div class="input-group">
              <input type="time" class="form-control" id="tme" name="month_time">
              <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
              </div>
              </div>
              </div>
              </div>           
                <center>
                <button class="btn btn-primary" type="submit">Update</button>
              </form>
            </div>
              
             
             <div id="yeardays">
             <div class="well" id="well" style="background:#fff;">
                <div class="form-group">
                  <form method="post" action="{{url('edit-scheduleevent/'.$event_id)}}">
                    {{csrf_field()}}
                    <div class="radio"><input type="radio" name="year" value="yearly" checked>
                      <div class="col-sm-2">The</div>
                        <div class="form-group">
                        <div class="col-sm-2">
                                <select  class="form-control" id="sel" name="year_monthly_days">
                                  <option>First</option>
                                  <option>Second</option>
                                  <option>Third</option>
                                  <option>Fourth</option>
                                </select>
                                </div>
                                <div class="col-sm-2">
                              <select  class="form-control" id="sel" name="year_weekly_days">
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
                    <br><br>
                      <div class="col-sm-2">Every</div>
                        <div class="col-sm-4"><input type="text" class="form-control" id="txt" name="txt" placeholder="Enter Number"></div>
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
              <div class="row">
              <div class="col-md-4">
              <div class="form-group">
              <label class="control-label  col-sm-4" for="dte">Between:</label>
              <div class="input-group">
                  <input type="date" class="form-control" id="dte" name="year_startdate">
                  <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
              </div>
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group">
              <label class="control-label col-sm-4" for="dte">And:</label>
              <div class="input-group">
                <input type="date" class="form-control" id="dte" name="year_enddate">
                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
              </div>
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group at">
              <label class="control-label col-sm-4" for="tme">At:</label>
              <div class="input-group">
              <input type="time" class="form-control" id="tme" name="year_time">
              <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
              </div>
              </div>
              </div>
              </div>
               <center>
                <button class="btn btn-primary" type="submit">Update</button>
              </form>
            </div>
              </div>

           
              

                    </div>
                     </div>
                      </div>
                      <div class="row">
                    <div id="old_schedule">
                
                </div>
              </div>
                 
               
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