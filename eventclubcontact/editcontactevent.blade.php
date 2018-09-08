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
                             
                              @if(count($contacts)>0)
                              <h5 style="color:#46A6EA"><b>Contact</b></h5>
                               <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('edit-contactevent/'.$event_id) }}">
                                {{csrf_field()}}
                              @foreach($contacts as $contact)
                              
                              <div class="row">
                                <div id="form-group-contact">
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-4" for="txt">Contact Name:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="hidden" name="contact_id[]" value="{{$contact->ContactId}}">
                                    <input type="text" class="form-control" id="event_contact_name" name="event_contact" pattern="([A-zÀ-ž\s]){3,25}" value="{{$contact->FirstName}}" required>
                                    <span class="eventcontact" style="color: red;display: none">Event Contact Name should contain 5-25 characters</span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-4" for="txt">Mobile:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="text" class="form-control" id="event-contact" name="event_mobile" pattern="([0-9]){3,25}" value="{{$contact->Phone}}" required>
                                    <span class="eventmobile" style="color: red;display: none">Mobile should contain 10 Numbers</span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-4" for="email">Email:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="email" class="form-control" id="email" name="event_email" value="{{$contact->Email}}" required>
                                  </div>
                                </div>
                              </div>
                              </div>
                           
                                @endforeach
                                @endif
                                  <div id="add-contacts">
                                 <center>
                                        <button class="btn btn-primary">Save Contact</button>
                                      </center>
                               </div>
                                    </form>
                                    <hr>
                      
 <h5 style="color:#46A6EA"><b>Contact</b></h5>
                                     <form class="form-horizontal" style="background:#fff;" method="post" action="{{ url('edit-contactevent/'.$event_id) }}">
                                {{csrf_field()}}
                              
                              <div class="row">
                                <div id="form-group-contact">
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-4" for="txt">Contact Name:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="text" class="form-control" id="event_contact_name" name="eventcontact" pattern="([A-zÀ-ž\s]){3,25}" required>
                                    <span class="eventcontact" style="color: red;display: none">Event Contact Name should contain 5-25 characters</span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-4" for="txt">Mobile:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="text" class="form-control" id="event-contact" name="eventmobile" pattern="([0-9]){3,25}" required>
                                    <span class="eventmobile" style="color: red;display: none">Mobile should contain 10 Numbers</span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-4" for="email">Email:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="email" class="form-control" id="email" name="eventemail" required>
                                  </div>
                                </div>
                              </div>
                              </div>
                                 <center>
                                        <button class="btn btn-primary">Save Contact</button>
                                      </center>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
@endsection                  
