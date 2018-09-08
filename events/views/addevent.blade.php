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
  <li class="active " style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#mhome">Basic Details</a></li>
    <li style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#home"> WHEN</a></li>
    <li><a class="" data-toggle="tab" href="#menu1"> WHERE</a></li>
    <li><a class="" data-toggle="tab" href="#menu2"> EVENT</a></li>
    
  </ul>
  <ul class="nav nav-tabs desk-none tab-none mob-block" style="border-bottom:0px">
  <li class="active " style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#mhome"><i class="fa fa-list" id="info_fa"> </i></a></li>
    <li style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#home"><i class="fa fa-clock-o" id="info_fa"> </i> </a></li>
    <li><a class="" data-toggle="tab" href="#menu1"><i class="fa fa-map-marker" id="info_fa"> </i> </a></li>
    <li><a class="" data-toggle="tab" href="#menu2"><i class="fa fa-calendar" aria-hidden="true" id="info_fa"></i> </a></li>
    
  </ul>
        <form class="form-horizontal kin_infor" style="padding:17px;" method="post" action="{{url('addevent/'.$event_id)}}" enctype="multipart/form-data">
{{csrf_field()}}
  <div class="tab-content">
  <div id="mhome" class="tab-pane fade in active">
  <div class="container"><!--id="main-code"-->

<div>
     <div class="col-xs-12 col-sm-3 kin_photo">
     <div class="fb-profile" style="margin-top:13%">
      @if($event_image)
      <img class="thumbnail profile_image" id="eventimage" src="{{$event_image[0]->ImagePath}}" alt="Profile image">
      <input type="hidden" name="image_check" value="{{$event_image[0]->ImagePath}}">
      @else
 <img class="thumbnail profile_image" id="eventimage" src="{{url('public/images/event.jpg')}}" alt="Profile image">
  <input type="hidden" name="image_check"  value="{{url('public/images/event.jpg')}}">
 @endif
     <div class="fb-profile-text text-center">
        <div class="col-xs-12 col-sm-12">
                    <input class="form-control myful" id="imgUpload" name="imgUpload" accept="image/*" type="file">
                </div><br><br><br>
         <!-- <p class="text-center"><i class="fa fa-map-marker" style="color:#46A6EA"></i> Location:UK</p>-->
</div>
</div>
</div>
 <div class="col-xs-12 col-sm-9 kin_info" style="border-left:1px solid #eee">

  @if(count($event_details)>0)
  @foreach($event_details as $event)
          <div class="row">
          <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Event Name:</label>
              <div class="col-xs-8 col-sm-9"> 
                  <input type="text" class="form-control" id="event-name" name="event_name" value="{{$event->EventName}}" required>
                  

              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-xs-4 col-sm-2" for="txt">Description:</label>
                  <div class="col-xs-8 col-sm-9">
                      <textarea class="form-control" id="txt" name="description" required>{{$event->Description}}</textarea>
                  </div>
          </div>
          <div class="form-group">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Privacy:</label>
              <div class="col-xs-8 col-sm-9 mob-none">
    <label class="radio-inline containerh">Public<input name="privacy"  required="" type="radio" @if($event->Privacy == "Public") value="Public" checked @endif><span class="checkmark"></span></label>
  <label class="radio-inline containerh">Private<input name="privacy"  required type="radio" @if($event->Privacy == "Private") value="Private" checked @endif><span class="checkmark"></span></label>
  <label class="radio-inline containerh">Personal<input name="privacy"   required type="radio" @if($event->Privacy == "Personal") value="Personal" checked @endif><span class="checkmark"></span></label>
                    <label class="radio-inline containera"> <button class="btn btn-xs tooltips" data-container="body" data-placement="right" title=" 
                      Public means 'its shown for all users' ,
                      private means 'its shown for selected users' , 
                      Personal means 'its shown for personal invited users"> ? </button> </label>
              </div>
        <div class="col-xs-8 col-sm-4 desk-none tab-none mob-block">
    <label class="radio-inline containerh">Public<input name="privacy" value="Public" required type="radio" @if($event->Privacy == "Public") checked @endif><span class="checkmark"></span></label><br>
  <label class="radio-inline containerh">Private<input name="privacy" value="Private" required type="radio" @if($event->Privacy == "Private") checked @endif><span class="checkmark"></span></label><br>
  <label class="radio-inline containerh">Personal<input name="privacy" value="Personal" required type="radio" @if($event->Privacy == "Personal") checked @endif><span class="checkmark"></span></label><br>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-4 col-sm-2" for="txt">Short Name:</label>
              <div class="col-xs-8 col-sm-9"> 
                @if($event->ShortName == 'NA')
                  <input type="text" class="form-control" id="short-name" name="short_name" onblur="eventshortname('{{url('/checkshortname/event')}}')" required>
                  @else
                  <input type="text" class="form-control" id="short-name" name="short_name" onblur="eventshortname('{{url('/checkshortname/event')}}')" value="{{$event->ShortName}}" required>
                  @endif
                  <div id="message"></div>
              </div>
            </div>
          
              </div>
              </div>
              @endforeach
              @else
                        <div class="row">
          <div class="form-group" id="field1">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Event Name:</label>
              <div class="col-xs-8 col-sm-9"> 
                  <input type="text" class="form-control" id="event-name" name="event_name" value="{{old('event_name')}}" required>
                  

              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-xs-4 col-sm-2" for="txt">Description:</label>
                  <div class="col-xs-8 col-sm-9">
                      <textarea class="form-control" id="txt" name="description" value="{{old('description')}}" required></textarea>
                  </div>
          </div>
          <div class="form-group">
            <label class="control-label col-xs-4 col-sm-2" for="txt">Privacy:</label>
              <div class="col-xs-8 col-sm-9 mob-none">
    <label class="radio-inline containerh">Public<input name="privacy" value="public" checked="checked" required="" type="radio"><span class="checkmark"></span></label>
  <label class="radio-inline containerh">Private<input name="privacy" value="Private" required="" type="radio"><span class="checkmark"></span></label>
  <label class="radio-inline containerh">Personal<input name="privacy" value="Personal" required="" type="radio"><span class="checkmark"></span></label>
                    <label class="radio-inline containera"> <button class="btn btn-xs tooltips" data-container="body" data-placement="right" title=" 
                      Public means 'its shown for all users' ,
                      private means 'its shown for selected users' , 
                      Personal means 'its shown for personal invited users"> ? </button> </label>
              </div>
        <div class="col-xs-8 col-sm-4 desk-none tab-none mob-block">
    <label class="radio-inline containerh">Public<input name="privacy" value="public" required="" type="radio"><span class="checkmark"></span></label><br>
  <label class="radio-inline containerh">Private<input name="privacy" value="Private" required="" type="radio"><span class="checkmark"></span></label><br>
  <label class="radio-inline containerh">Personal<input name="privacy" value="Personal" required="" type="radio"><span class="checkmark"></span></label><br>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-4 col-sm-2" for="txt">Short Name:</label>
              <div class="col-xs-8 col-sm-9"> 
                  <input type="text" class="form-control" id="short-name" name="short_name" onblur="eventshortname('{{url('/checkshortname/event')}}')" required>
                  <div id="message"></div>

              </div>
            </div>
          
              </div>
              </div>
              @endif
  <div class="col-sm-offset-5 col-xs-offset-6 "><button class="btn btn-primary mybtn" type="reset">Cancel</button>
  <button class="btn btn-primary mybtn" id="saveevent">Save</button></a>
  @if(count($event_details)>0)
  @if($event_details[0]->ShortName == 'NA')
  <a href="{{url('eventtime/'.$event_id)}}" class="btn btn-primary mybtn disabled">Next</a>
  @else
  <a href="{{url('eventtime/'.$event_id)}}" class="btn btn-primary mybtn">Next</a>
  @endif
  @else
   <a href="{{url('eventtime/'.$event_id)}}" class="btn btn-primary mybtn disabled">Next</a>
   @endif
         </div>
         </form>
</div></div>
  </div>
   
                    </div>
          </div>
          </div>
          </div>
                  </div>
                </div>
              </div>
<script>
function readURL(input) {
   if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#eventimage').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
      }
      $("#imgUpload").change(function(){
        readURL(this);
        });
</script>
        @endsection
    
