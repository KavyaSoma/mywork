@extends('layouts.main')
@section('content')

@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
    <!-- event code starts here -->
     <div class="container mycntn" id="main-code">
   <ol class="breadcrumb" style="border:1px solid #46A6EA;color:#46A6EA;">
  <li class="breadcrumb-item"><a style="color:#777;" href="http://localhost/swim">Home</a></li>
  <li class="breadcrumb-item"><a style="color:#777;" href="http://localhost/swim/socialnetwork">Social Network</a></li>
  <li class="breadcrumb-item">Groups</li>
  </ol>
      <div class="col-xs-12 col-sm-3 kin_photo">
     <div class="fb-profile" style="margin-top:8%;">
 <img alt="Profile image" class="img-rounded profile_image" src="http://localhost/swim/public/images/sravan.jpeg">
     <div class="fb-profile-text text-center">
        <div class="col-xs-12 col-sm-12" style="margin-top: 14px;">
                    <input class="form-control myful" id="imgUpload" name="imgUpload" accept="image/*" type="file">
                </div>
         <!-- <p class="text-center"><i class="fa fa-map-marker" style="color:#46A6EA"></i> Location:UK</p>-->
</div>
</div>
</div>
<div class="col-sm-9 col-xs-12" style="border-left:1px solid #eee;padding:0">
                 <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                 <div class="board-inner">
            <ul class="nav nav-tabs nav_info" id="myTab">
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
                            <form method="post" style="padding:32px" action="{{url('schedule-event/'.$event_id)}}">
                              {{csrf_field()}}
                              <div class="form-group" id="field1">
                                  <label class="control-label col-sm-2" for="txt">Occurance:</label>
                                         <ul class="nav nav-pills">
                <li class="{{url('schedule-event/'.$event_id)}}"><a href="" style="background-color:#46A6EA">One Time</a></li>
                <li><a href="{{url('multiple-event/'.$event_id)}}"  style="background-color:#ddd;color:#46A6EA">Multiple</a></li>
                <li><a href="{{url('recurring-event/'.$event_id)}}" style="background-color:#ddd;color:#46A6EA">Recurring</a></li>
           </ul>
                                      
                              </div>
                    </div>
                      <div class="row one" id="single" style="padding:10px;">
                        
                      <div class="col-md-7">
                        <div class="form-group">
                        <label class="control-label col-xs-4 col-sm-3" for="dte">Between:</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="dte" name="start_date">
                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-3" for="dte">And:</label>
                      <div class="input-group">
                          <input type="date" class="form-control" id="dte" name="end_date">
                          <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="form-group">
                    <label class="control-label col-xs-4 col-sm-3" for="tme">At:</label>
                    <div class="input-group">
                        <input type="time" class="form-control" id="tme" name="time">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                  </div>
                </div>
                  <div class="col-sm-offset-3 col-sm-7 col-xs-offset-4">
              <a><button class="btn btn-primary mybtn" type="reset">Back</button></a>
				 <button class="btn btn-primary mybtn">Save</button>
				 <button class="btn btn-primary mybtn">Next</button>
</div>
              </form>
              </div>
             
</div>

              </div>
              

                    </div>
                  </div>
                </div>
              </div>
                      @endsection