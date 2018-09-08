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
                <li  class="active">
                <a href="{{url('/addevent')}}" class="tab-one" title="Event Summary">
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

                      <li><a href="#" title="Conform">
                          <span class="round-tabs">
                               <i class="fa fa-check"></i>
                          </span> </a>
                      </li>

                      </ul></div>
<div class="tab-content tab_details">
    <div class="tab-pane fade in active" id="eventsummary">
      <form class="form-horizontal" style="background:#fff;" method="post" action="{{url('addevent')}}"  enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="row">
          <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-4" for="txt">Event Name:</label>
              <div class="col-xs-7 col-sm-6"> 
                  <input type="text" class="form-control" id="event-name" name="event_name" value="{{old('event_name')}}" required>

              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-xs-4 col-sm-4" for="txt">Description:</label>
                  <div class="col-xs-7 col-sm-6">
                      <textarea class="form-control" id="txt" name="description" value="{{old('description')}}" required></textarea>
                  </div>
          </div>
          <div class="form-group">
            <label class="control-label col-xs-4 col-sm-4" for="txt">Privacy:</label>
              <div class="col-xs-8 col-sm-4">
                <label class="radio-inline"><input type="radio" name="privacy" value="public" required>Public</label>
                  <label class="radio-inline"><input type="radio" name="privacy" value="private" required>Private</label>
                    <label class="radio-inline"><input type="radio" name="privacy" value="personal" required>Personal</label>
                    <label class="radio-inline"> <button class="btn btn-xs tooltips" data-container="body" data-placement="right" title=" 
                      Public means 'its shown for all users' ,
                      private means 'its shown for selected users' , 
                      Personal means 'its shown for personal invited users"> ? </button> </label>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-4 col-sm-4" for="txt">Short Name:</label>
                  <div class="col-xs-7 col-sm-6">
                    <input type="text" class="form-control" id="short-name" onblur="eventshortname('{{url('checkshortname/event')}}')" name="short_name" value="{{old('short_name')}}">
                    <div id="message"></div>
                  </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4 col-sm-4" for="imgUpload">Image:</label>
                <div class="col-xs-7 col-sm-6">
                    <input type="file" class="form-control" id="imgUpload" name="imgUpload"  accept="image/*" required>
                </div>
              </div>
              </div>
              <center>
              <a><button class="btn btn-primary" type="reset">Cancel</button></a>
                <button class="btn btn-primary" id="saveevent">Save and Continue</button>
              </form>
                </div>
                    </div>
                  </div>
                </div>
              </div>
        @endsection