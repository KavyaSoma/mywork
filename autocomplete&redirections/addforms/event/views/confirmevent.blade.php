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
                  <li><a href="#" title="Schedule">
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

                      <li  class="active"><a href="#" title="Conform">
                          <span class="round-tabs">
                               <i class="fa fa-check"></i>
                          </span> </a>
                      </li>


                      </ul></div>
                       <div class="tab-content tab_details">
 
                                          <div class="tab-pane fade in active" id="eventconform">
                                            <div class="table-responsive">
                                              @if(count($event_details)>0)
                                              <table class="table">
                                                <thead>
                                                <tr>
                                                  <th>Event Name</th>
                                                  <th>Swim Style</th>
                                                  <th>Team Size</th>
                                                  <th>Is Disabled</th>
                                                  <th>Age(Min-Max)</th>
                                                  <th>Participants (Min-Max)</th>
                                                </tr>
                                              </thead>
                                              @foreach($event_details as $event)
                                                <tr>
                                                  <td>{{$event->EventName}}</td>
                                                  <td>{{$event->SwimStyle}}</td>
                                                  <td>{{$event->MembersPerTeam}}</td>
                                                  <td>{{$event->AbleBodied}}</td>
                                                  <td>{{$event->MinimumAge}}-{{$event->MaximumAge}}</td>
                                                  <td>{{$event->MinParticipants}}-{{$event->MaxParticipants}}</td>
                                                </tr>
                                               @endforeach
                                              </table>
                                              @endif
                                            </div>
                                         <!--   <center><ul class="pagination">

          <li><a href="#">&laquo;</a></li>
          <li><a href="#">1</a></li>
           <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
          <li><a href="#">&raquo;</a></li>
        </ul>
                                        </center>-->
                                            <h5 style="color:#46A6EA"><b>Event Description</b></h5>
                                            <p>{{$event_descripiton}}</p>
                                            @if(count($venues)>0)
                                            <h5 style="color:#46A6EA"><b>Venue</b></h5>
                                            @foreach($venues as $venue)
                                            <p>{{$venue->VenueName}}</p>
                                            @endforeach
                                            @endif
                                            @if(count($schedulers)>0)
                                            <h5 style="color:#46A6EA"><b>Schedule</b></h5>
                                            @foreach($schedulers as $schedule)
                                            <p>Occuarance:{{$schedule->ScheduleType}}<br> Between {{$schedule->StartDate}} and {{$schedule->EndDate}} at {{$schedule->StartTime}}</p>
                                            @endforeach
                                            @endif
                                            @if(count($venues)>0)
                                            <h5 style="color:#46A6EA"><b>Address</b></h5>
                                            @foreach($venues as $venue)
                                            <p>{{$venue->AddressLine1}}<br>Post Code: {{$venue->PostCode}}<br> {{$venue->City}}</p>
                                            @endforeach
                                            @endif
                                            @if(count($venues)>0)
                                            <h5 style="color:#46A6EA"><b>Contact</b></h5>
                                            @foreach($contacts as $contact)
                                            <p>Mobile:{{$contact->Phone}}<br>Email:{{$contact->Email}}</p>
                                            @endforeach
                                            @endif
                                            <hr>
                                            <form method="post" action="{{url('confirm-event/'.$event_id)}}">
                                              {{csrf_field()}}
                                               @foreach($event_details as $event)
                                              <input type="hidden" name="event_name" value="{{$event->EventName}}">
                                              @endforeach
                                        <center>
                                              <button class="btn btn-primary">Submit</button>
                                        </center>
                                      </form>

                                                 </div>

                    </div>
                  </div>
                </div>
              </div>
              @endsection