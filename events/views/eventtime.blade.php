@extends('layouts.main')
@section('content')

@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
  <!--New hari Modal content-->
<div class="modal fade" id="myModalh" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h3 style="color:#46A6EA;background-color:#fff;padding-left:9px;">Previous Entries</h3>
</div>
<div class="modal-body">
<div id="old_events">
                
                </div>
</div>
<!--<div class="modal-footer">
    <button class="btn btn-primary col-sm-offset-5 col-sm-2 mybtn" type="submit">Post</button>

</div>--></div>
</div></div>

<!-- model popup ends here -->
    <!-- event code starts here -->
   <div class="container mycntn" id="main-code">
   <ol class="breadcrumb" style="border:1px solid #46A6EA;color:#46A6EA;">
  <li class="breadcrumb-item"><a style="color:#777;" href="http://localhost/swim">Home</a></li>
  <li class="breadcrumb-item"><a style="color:#777;" href="http://localhost/swim/socialnetwork">Social Network</a></li>
  <li class="breadcrumb-item">Groups</li>
  </ol>
      <!--<h5 class="add_venue" style="padding:10px;"><span class="" style="font-size:17px;" ><i class="fa fa-calendar"> </i> </span> GALA</h5>-->
      <div class="row" style="margin-left:0px;margin-right:0px;">
    <ul class="nav nav-tabs mob-none">
  <li ><a data-toggle="tab" class="" href="#mhome">Basic Details</a></li>
    <li class="active " style="margin-bottom:2px;"><a href=""> WHEN</a></li>
    <li><a class="" data-toggle="tab" href="#menu1"> WHERE</a></li>
    <li><a class="" data-toggle="tab" href="#menu2"> EVENT</a></li>
    
  </ul>
  <ul class="nav nav-tabs desk-none tab-none mob-block" style="border-bottom:0px">
  <li class="active " style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#mhome"><i class="fa fa-list" id="info_fa"> </i></a></li>
    <li style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#home"><i class="fa fa-clock-o" id="info_fa"> </i> </a></li>
    <li><a class="" data-toggle="tab" href="#menu1"><i class="fa fa-map-marker" id="info_fa"> </i> </a></li>
    <li><a class="" data-toggle="tab" href="#menu2"><i class="fa fa-calendar" aria-hidden="true" id="info_fa"></i> </a></li>
    
  </ul>
  <div class="tab-content">

    <div id="home" class="tab-pane fade in active">
      <div class="container"><!--id="main-code"-->
     <div class="col-xs-12 col-sm-3 kin_photo" style="border-right:1px solid #eee">
     <div class="fb-profile" style="margin-top:13%">
      @if(count($event_image)>0)
 <img class="thumbnail profile_image" src="{{$event_image[0]->ImagePath}}" alt="Profile image">
 @else
 <img class="thumbnail profile_image" src="{{url('public/images/event.jpg')}}" alt="Profile image">
 @endif

</div>
</div>
<form class="form-horizontal kin_infor" style="padding:30px;" method="post" action="{{url('eventtime/'.$event_id)}}">
  {{csrf_field()}}
 <div class="col-xs-12 col-sm-9 kin_info" >
   
<div>
  @if(count($event_time)>0)
  @foreach($event_time as $time)
          <div class="row">
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3" for="txt">Start Date & Time:</label>
                  <div class="col-xs-6 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="tme" name="start_date" type="date" value="{{$time->StartDate}}">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                    </div>
                  </div>
          <div class="col-xs-6 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="tme" name="start_time" type="time" value="{{$time->StartTime}}">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                    
                  </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3" for="txt">End Date & Time:</label>
                  <div class="col-xs-6 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="tme" name="end_date" type="date" value="{{$time->EndDate}}">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                    </div>
                  </div>
          <div class="col-xs-6 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="tme" name="end_time" type="time" value="{{$time->EndTime}}">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                    
                  </div>
            </div>
              </div>
              @endforeach
              @else
              <div class="row">
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3" for="txt">Start Date & Time:</label>
                  <div class="col-xs-6 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="tme" name="start_date" type="date">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                    </div>
                  </div>
          <div class="col-xs-6 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="tme" name="start_time" type="time">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                    
                  </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3" for="txt">End Date & Time:</label>
                  <div class="col-xs-6 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="tme" name="end_date" type="date">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                    </div>
                  </div>
          <div class="col-xs-6 col-sm-4">
                    <div class="input-group">
                        <input class="form-control" id="tme" name="end_time" type="time">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                    
                  </div>
            </div>
              </div>
              @endif
  
</div>

</div><div class="col-sm-offset-5 col-xs-offset-4 ">
  <a href="{{url('addevent/'.$event_id)}}" class="btn btn-primary mybtn">Back</a>
  <button class="btn btn-primary mybtn">Save</button>
  @if(count($event_time)>0)
  <a href="{{url('/venue-event/'.$event_id)}}" class="btn btn-primary mybtn" type="reset">Next</a>
  @else
  <a href="{{url('/venue-event/'.$event_id)}}" class="btn btn-primary mybtn disabled" type="reset">Next</a>
  @endif
         </div></form></div>
<br>
    </div>
  
   
                    </div>
          </div>
          </div>
          </div>
                  </div>
                </div>
              </div>
       
        @endsection
    
