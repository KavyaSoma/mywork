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
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <a href="#"><i class="fa fa-plus-circle" style="color:#46A6EA;"></i></a> Add Member
                  </div>
                    <div class="panel-body">
                      <form class="form-horizontal">
                        <div class="form-group">
                          <label class="control-label col-sm-4" for="txt">Contact Name:</label>
                          <div class="col-sm-6">
                          <input type="text" class="form-control" id="txt" name="txt">
                          </div>
                        </div>
                          <div class="form-group">
                          <label class="control-label col-sm-4" for="txt">Club Name:</label>
                          <div class="col-sm-6">
                          <input type="text" class="form-control" id="txt" name="txt">
                          </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4" for="txt">User Type:</label>
                              <div class="col-sm-6">
                            <select class="form-control" id="sel" name="sel">
                              <option>Club Admin</option>
                              <option>Venue Admin</option>
                              <option>System Admin</option>
                              <option>Instructor</option>
                          </select>
                          </div>
                          </div>
                          <center><button class="btn btn-primary">Submit</button></center>
                        </div>
                       </div>
                      </div>
                        <div class="col-xs-12 col-sm-6">
                      <div class="box box-primary">
                        <div class="box-body no-padding">
                       {!! $calendar->calendar() !!}
                        </div>
                      </div>
                    </div>

  <div class="col-xs-12 col-sm-6">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
       <div class="panel panel-default active col-md-12">
                    <div class="panel-heading" style="margin-left:-15px;margin-right:-15px;background:#46A6EA;color:#fff"  role="tab" id="headingOne">
                        <h3 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Pending Requests</a>
                        </h3>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in"  role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body" id="user_scroll">
                        <ul class="media-list">
                         @if(count($pendingrequests)>0)
                            @foreach($pendingrequests as $pending)
                          <li class="media">
                              <div class="media-left">
                                <img src="{{$pending->Image}}" class="img-circle" width="65px" height="65px">
                              </div>
                              <div class="media-body">
                                <p><b> {{$pending->UserName}}</b></p><p> {{$pending->CreatedDate}} </p>

                                                                    <p>
                                                                    Request to Join the club
                                                                    </p>

                              </div>
                              <div class="media-right">
                                  <a href="{{url('/acceptclubrequest/'.$pending->ReferenceId.'/club')}}"><i class="fa fa-check-circle" aria-hidden="true" title="Accept" style="font-size:20px;color: #46A6EA;"></i></a>
                                  <a href="{{url('/rejectclubrequest/'.$pending->ReferenceId.'/club')}}"><i class="fa fa-times-circle-o" aria-hidden="true" title="Reject" style="font-size:20px;color: #d9534f;" ></i></a>
                              </div>
                          </li>
                          @endforeach
                           @else
                           <li class="media">
                              <div class="media-body">
                                <h3>No Pending Requests</h3>
                              </div>
                           </li>
                           @endif
                        </ul>      </div>

<br><br>
                </div>
                <!-- End fluid width widget -->
  </div>
<div class="panel panel-default col-xs-12 col-sm-12">
            <div class="panel-heading" style="margin-left:-15px;margin-right:-15px;background:#46A6EA;color:#fff"  role="tab" id="headingTwo">
                <h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Completed Requests</a>
                </h3>
            </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body"  id="user_scroll">
              
                <ul class="media-list">
                   @if(count($completedrequests)>0)
                          @foreach($completedrequests as $completed)
                          <li class="media">
                              <div class="media-left">
                                <img src="{{$completed->Image}}" class="img-circle" width="65px" height="65px">
                              </div>
                              <div class="media-body">
                                <p><b> {{$completed->UserName}}</b></p><p> {{$completed->CreatedDate}} </p>
                                <p>Request to Join The Venue</p>
                                  
                              </div>
                              <div class="media-right">
                                @if($completed->ApproveStatus == "accepted")
                                   <i class="fa fa-check-circle" aria-hidden="true" title="Accept" style="font-size:20px;color: #46A6EA;"></i>
                                   @else
                                  <i class="fa fa-times-circle-o" aria-hidden="true" title="Reject" style="font-size:20px;color: #d9534f;" ></i>
                                  @endif
                              </div>
                           </li>
                          @endforeach
                          @else
                           <li class="media">
                              <div class="media-body">
                                <h3>No Completed Requests</h3>
                              </div>
                           </li>
                           @endif
                        </ul>
                </ul>
                 
            </div><br><br>
        </div>
  </div>
  </div>    <!-- End fluid width widget -->
  </div>
  </div>
  </section>
  </section>
  </section>
</div><br>
 <!-- Dashboard code ends here -->
@endsection