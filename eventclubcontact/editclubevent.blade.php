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

                      <li  class="active"><a href="#" title="Contacts">
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
  
            <div class="tab-pane fade in active" id="eventcontact">
                <h5 style="color:#46A6EA"><b>Clubs</b></h5>
           @if(count($clubs)>0)
                <h5 style="color:#46A6EA"><b>Clubs</b></h5>
                <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('edit-eventclub/'.$event_id) }}">
                  {{csrf_field()}}
                  <div class="event-clubs">
                  @foreach($clubs as $club)
                  <div id="event-details">
                  <div class="row">
                    <div id="event-form-group">
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Club Name:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="hidden" name="club_id[]" value="{{$club->ClubId}}">
                        <input type="text" class="form-control" id="event_club_name" name="club_name" pattern="([A-zÀ-ž\s]){3,25}" value="{{$club->ClubName}}" required>
                        <span class="eventclub" style="color: red;display: none">Club Name should contain 5-25 characters</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Mobile:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="text" class="form-control" id="event-mobile" name="club_mobile" pattern="([0-9]){10}" value="{{$club->MobilePhone}}" required>
                        <span class="clubmobile" style="color: red;display: none">Club Mobile should contain 10 Numbers</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="email">Email:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="email" class="form-control" id="email" name="club_email" value="{{$club->Email}}" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Website:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="url" class="form-control" id="txt" name="club_website" value="{{$club->Website}}" required>
                      </div>
                    </div> 
                  </div>
                </div>
                </div>
                    @endforeach
                    @endif
                  </div>
                                 <center>
                                        <button class="btn btn-primary">Save Club</button>
                                      </center>
                                   </form>
                                    <hr>
                                        <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('edit-eventclub/'.$event_id) }}">
                  {{csrf_field()}}
                  <div class="row">
                    <div id="event-form-group">
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Club Name:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="text" class="form-control" id="event_club_name" name="clubname" pattern="([A-zÀ-ž\s]){3,25}"  required>
                        <span class="eventclub" style="color: red;display: none">Club Name should contain 5-25 characters</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Mobile:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="text" class="form-control" id="event-mobile" name="clubmobile" pattern="([0-9]){10}" required>
                        <span class="clubmobile" style="color: red;display: none">Club Mobile should contain 10 Numbers</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="email">Email:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="email" class="form-control" id="email" name="clubemail" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-4" for="txt">Website:</label>
                      <div class="col-xs-7 col-sm-6">
                        <input type="url" class="form-control" id="txt" name="clubwebsite" required>
                      </div>
                    </div> 
                  </div>
                </div>
                </div>
                  </div>
                                 <center>
                                        <button class="btn btn-primary">Save Club</button>
                                      </center>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
@endsection                  
