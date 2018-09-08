@extends('layouts.calendarmain')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
 <!-- Dashboard code starts here -->
<div class="container" id="main-code">
  <section class="main" style="margin-top:20px">
    <section class="tab-content">
      <section class="tab-pane active fade in active">
        <div class="row" id="dashboard-mob">
          <div class="col-xs-12 col-sm-6">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default active col-md-12">
                    <div class="panel-heading" style="margin-left:-15px;margin-right:-15px;background:#46A6EA;color:#fff"  role="tab" id="headingOne">
                        <h3 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <span class="glyphicon glyphicon-calendar"></span> 
                            Upcoming Events</a>
                        </h3>
                    </div>
                      <div id="collapseOne" class="panel-collapse collapse in"  role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"  id="user_scroll">
                      @if(count($upcoming_events)>0)
                        <ul class="media-list">
                          @foreach($upcoming_events as $events)
                          @php
                          $pieces = explode(' ',$events->StartDateTime);
                          $date = $pieces[0];
                          $slices = explode('-',$date);
                          $year = $slices[0];
                          $month = $slices[1];
                          $day = $slices[2];
                          $months = array (1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',07=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
                          @endphp
                            <li class="media">
                                <div class="media-left">
                                    <div class="panel panel-default text-center date">
                                        <div class="panel-heading month" style="background:#ff6600;color:#fff">
                                            <span class="panel-title strong">
                                                {{$months[(int)$month]}}
                                            </span>
                                        </div>
                                        <div class="panel-body day text-default" style="color:#46A6EA">
                                            {{$day}}
                                        </div>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                       {{$events->EventName}}
                                    </h4>
                                    {{$events->Description}}
                                  </div>
                                <div class="media-right">
                                <a href="#" class="icon-block"><i class="fa fa-correct" style="color:#ff6600" title="Edit"></i></a>
                                    <p>
                                <a href="#" class="icon-block"><i class="fa fa-share-alt" style="color:  #46A6EA;"  title="Share"></i></a>
                                    </p>
                                </div>
                            </li>
                            @endforeach
                            
                        </ul>
                        @else
                        <h4>Upcoming Events Doesnot Exist</h4>
                        @endif
                    </div>
                </div>
                <!-- End fluid width widget -->
    </div>
    <div class="panel panel-default col-xs-12 col-sm-12">
              <div class="panel-heading" style="margin-left:-15px;margin-right:-15px;background:#46A6EA;color:#fff"  role="tab" id="headingTwo">
                  <h3 class="panel-title">  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      <span class="glyphicon glyphicon-calendar"></span> 
                      Completed Events</a>
                  </h3>
              </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body"  id="user_scroll">
                @if(count($completed_events)>0)
                  <ul class="media-list">
                    @foreach($completed_events as $completed)
                    @php
                          $pieces = explode(' ',$completed->StartDateTime);
                          $date = $pieces[0];
                          $slices = explode('-',$date);
                          $year = $slices[0];
                          $month = $slices[1];
                          $day = $slices[2];
                          $months = array (1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',07=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
                          @endphp
                      <li class="media">
                          <div class="media-left">
                              <div class="panel panel-default text-center date">
                                  <div class="panel-heading month"  style="background:#ff6600;color:#fff">
                                      <span class="panel-title strong">
                                         {{$months[(int)$month]}}
                                      </span>
                                  </div>
                                  <div class="panel-body day text-default" style="color:#46A6EA">
                                      {{$day}}
                                  </div>
                              </div>
                          </div>
                          <div class="media-body">
                              <h4 class="media-heading">
                                 {{$completed->EventName}}
                              </h4>
                              {{$completed->Description}}

                          </div>
                          <div class="media-right">
                          <a href="#" class="icon-block"><i class="fa fa-edit" style="color:#ff6600" title="Edit"></i></a>
                              <p>
                          <a href="#" class="icon-block"><i class="fa fa-share-alt" style="color:  #46A6EA;"  title="Share"></i></a>
                              </p>
                          </div>
                      </li>
                      @endforeach
                      
                  </ul>
                  @else
                  <h4>Completed Events Doesnot Exist</h4>
                  @endif
              </div>
          </div>
          <!-- End fluid width widget -->
    </div>
  </div>
  </div>
  <div class="col-xs-12 col-sm-6">
    <div class="panel panel-default magic-element isotope-item">
      <div class="panel-body-heading schedule_panel">
                  <h3 class="panel-title" style="padding:10px">Requests</h3>
              </div><br>
             <ul class="nav nav-tabs preview_tabs">
         <li class="active"><a href="#pending" data-toggle="tab" title="pending"> Pending</a></li>
         <li><a href="#accepted" data-toggle="tab" title="accepted">Accepted</a></li>
         
   </ul>
   <div class="tab-content tab_details">
    <div class="tab-pane fade in active" id="pending">
        <div class="row">
              <div class="panel-body">
                <div class="table table-responsive">
                  @if(count($instructor_schedule)>0)
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Venue Name</th>
                    <th>Edit/Delete</th>
                    </tr>
                  </thead>
                    <tbody>
                      @foreach($instructor_schedule as $instructor)
                      
                      <tr>
                        <td>{{$instructor->StartDate}}</td>
                        <td>{{$instructor->EndDate}}</td>
                        <td>{{$instructor->VenueName}}</td>
                        <!--<td><button class="btn btn-primary button_available">Available</button></td>-->
                        <td><a href="{{url('participant/'.$instructor->ParticipantId.'/'.$instructor->VenueId)}}" class="glyphicon glyphicon-ok" style="color: green"></a>/ <a href="{{url('deleteparticipant/'.$instructor->ParticipantId.'/'.$instructor->VenueId)}}" class="glyphicon glyphicon-remove" style="color: red" ></a></td>
                      </tr>
                      @endforeach
                       
                    </tbody>
                </table>
            </div>
            <center><ul class="pagination">
              {{$instructor_schedule->links()}}
            </ul></center>
            @else
            <h4>No Requests Received</h4>
            @endif
          </div>
        </div>
    </div>
  
     <div class="tab-pane fade" id="accepted">
        <div class="row">
              <div class="panel-body">
                <div class="table table-responsive">
                  @if(count($instructor_accept)>0)
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Venue Name</th>
                    <th>Edit/Delete</th>
                    </tr>
                  </thead>
                    <tbody>
                      @foreach($instructor_accept as $accepted)
                      
                      <tr>
                        <td>{{$accepted->StartDate}}</td>
                        <td>{{$accepted->EndDate}}</td>
                        <td>{{$accepted->VenueName}}</td>
                        <!--<td><button class="btn btn-primary button_available">Available</button></td>-->
                        <td><a href="{{url('participant/'.$accepted->ParticipantId.'/'.$accepted->VenueId)}}" class="glyphicon glyphicon-ok" style="color: green"></a>/ <a href="{{url('deleteparticipant/'.$accepted->ParticipantId.'/'.$accepted->VenueId)}}" class="glyphicon glyphicon-remove" style="color: red"></a></td>
                      </tr>
                      @endforeach
                       
                    </tbody>
                </table>
            </div>
            <center><ul class="pagination">
               
            </ul></center>
            @else
            <h4>You have not accepted any participants</h4>
            @endif
          </div>
        </div>
    </div>
  </div>
</div>
</div>

</div>
<div class="row">
  <div class="col-xs-12 col-sm-6">
    <div class="panel panel-default magic-element isotope-item">
      <div class="panel-body-heading schedule_panel">
                  <h3 class="panel-title" style="padding:10px">My Schedule</h3>
              </div>
                      <div class="box box-primary">
                        <div class="box-body no-padding">
                       {!! $calendar->calendar() !!}
                        </div>
                      </div>
                    </div>
</div>
</div>
</div>
  </section>
  </section>
    </section>
</div>
 <!-- Dashboard code ends here -->
 @endsection