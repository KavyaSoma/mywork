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
    <li ><a href=""> WHEN</a></li>
    <li ><a class="" data-toggle="tab" href="#menu1"> WHERE</a></li>
    <li class="active " style="margin-bottom:2px;"><a class="" data-toggle="tab" href="#menu2"> EVENT</a></li>
    
  </ul>
  <ul class="nav nav-tabs desk-none tab-none mob-block" style="border-bottom:0px">
  <li class="active " style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#mhome"><i class="fa fa-list" id="info_fa"> </i></a></li>
    <li style="margin-bottom:2px;"><a data-toggle="tab" class="" href="#home"><i class="fa fa-clock-o" id="info_fa"> </i> </a></li>
    <li><a class="" data-toggle="tab" href="#menu1"><i class="fa fa-map-marker" id="info_fa"> </i> </a></li>
    <li><a class="" data-toggle="tab" href="#menu2"><i class="fa fa-calendar" aria-hidden="true" id="info_fa"></i> </a></li>
    
  </ul>
  <div class="tab-content">  
    <div id="menu2" class="tab-pane fade in active">
     
        <div class="col-xs-12 col-sm-3 kin_photo">
     <div class="fb-profile" style="margin-top:8%;">
      @if(count($event_image)>0)
 <img class="thumbnail profile_image" src="{{$event_image[0]->ImagePath}}" alt="Profile image">
 @else
 <img class="thumbnail profile_image" src="{{url('public/images/event.jpg')}}" alt="Profile image">
 @endif     
</div>
</div>
<div class="col-sm-9 col-xs-12" style="border-left:1px solid #eee;padding:0">
                 <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                 <div class="board-inner">
            <ul class="nav nav-tabs nav_info" id="myTab">
                <div class="liner"></div>
                <li class="active"><a href="{{url('/subevent')}}" title="Sub Events">
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
                     

                      <li><a href="#" title="Conform">
                          <span class="round-tabs">
                               <i class="fa fa-check"></i>
                          </span> </a>
                      </li>
            <li style="padding:32px">@if(count($subevents)>0)
                               <button class=" btn btn-warning" data-toggle="modal" data-target="#myModalh"><i class="fa fa-bars"></i> Previous Entries</button>
                               @endif
                       </li>

                      </ul></div>
<div class="tab-content tab_details">
    <div class="tab-pane fade in active" id="eventsummary">
      <form class="form-horizontal" style="background:#fff;padding:32px;" method="post" action="{{url('/subevent/'.$event_id)}}">
                  {{csrf_field()}}
                  @if(count($subevents)>0)
                  @foreach($subevents as $subevent)

                  <div class="row">
     <div class="form-group"  id="field1">
      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">SubEvent Name:</label>
      <div class="col-xs-7 col-sm-9">
        <input type="hidden" name="subevent_id" value="{{$subevent->SubEventId}}">
        <input type="text" class="form-control" id="sub-event" name="subevent_name" value="{{$subevent->SubEventName}}" required>
        <span class="error" style="color: red;display: none;">SubEvent Name should contain 5-25 characters</span>
      </div>
    </div>
  <div class="form-group mob-none">
                          <label class="control-label col-xs-5 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Gender :</label>
                              <div class="col-xs-7 col-sm-4">
      <label class="radio-inline containerh">Male<input type="radio" name="gender" value="Male" @if($subevent->Gender == "Male") checked @endif required><span class="checkmark"></span></label>
      <label class="radio-inline containerh">Female<input type="radio" name="gender" value="Female" @if($subevent->Gender == "Female") checked @endif required><span class="checkmark"></span></label>
      <label class="radio-inline containerh">Both<input type="radio" name="gender" value="Both" @if($subevent->Gender == "Both") checked @endif required><span class="checkmark"></span></label>
                                      
                              </div>
                        </div>
  
   <div class="form-group desk-none tab-none mob-block">
                          <label class="control-label col-xs-5  col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Gender :</label>
                              <div class="col-xs-7 col-sm-9">
                                      <label class="radio-inline containerh">Male<input type="radio" name="gender" value="public"  @if($subevent->Gender == "Male") checked @endif required><span class="checkmark"></span></label><br>
                                      <label class="radio-inline containerh">Female<input type="radio" name="gender" value="Female" @if($subevent->Gender == "Female") checked @endif required><span class="checkmark"></span></label><br>
                    <label class="radio-inline containerh">Both<input type="radio" name="privacy" value="Both"  @if($subevent->Gender == "Both") checked @endif required><span class="checkmark"></span></label><br>
                              </div>
                        </div>
    <div class="form-group">
      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="sel">Swim Style:</label>
      <div class="col-xs-7 col-sm-9">
        <select class="form-control" id="sel" name="swim_styles" required>
          <option value="Any" @if($subevent->Swimstyle == "Any") selected @endif>Any</option>
          <option value="Butterfly" @if($subevent->Swimstyle == "Butterfly") selected @endif>Butterfly</option>
          <option value="BackStroke" @if($subevent->Swimstyle == "BackStroke") selected @endif>BackStroke</option>
          <option value="Any" @if($subevent->Swimstyle == "Breaststroke") selected @endif>Breaststroke</option>
          <option value="Butterfly" @if($subevent->Swimstyle == "Combat sidestroke") selected @endif>Combat sidestroke</option>
          <option value="BackStroke" @if($subevent->Swimstyle == "Dog paddle") selected @endif>Dog paddle</option>
          <option value="FrontStroke" @if($subevent->Swimstyle == "Eggbeater kick") selected @endif>Eggbeater kick</option>
      <option value="Any" @if($subevent->Swimstyle == "Flutter kick") selected @endif>Flutter kick</option>
          <option value="Butterfly" @if($subevent->Swimstyle == "Free Colchian") selected @endif>Free Colchian</option>
          <option value="BackStroke" @if($subevent->Swimstyle == "Freestyle swimming") selected @endif>Freestyle swimming</option>
          <option value="FrontStroke" @if($subevent->Swimstyle == "Front crawl") selected @endif>Front crawl</option>
      <option value="Any" @if($subevent->Swimstyle == "FrontStroke") selected @endif>FrontStroke</option>
          <option value="Butterfly" @if($subevent->Swimstyle == "Georgian swimming") selected @endif>Georgian swimming</option>
          <option value="BackStroke" @if($subevent->Swimstyle == "Medley swimming") selected @endif>Medley swimming</option>
          <option value="FrontStroke" @if($subevent->Swimstyle == "Sidestroke") selected @endif>Sidestroke</option>
      <option value="FrontStroke" @if($subevent->Swimstyle == "Total Immersion") selected @endif>Total Immersion</option>
      <option value="FrontStroke" @if($subevent->Swimstyle == "Treading water") selected @endif>Treading water</option>
      <option value="FrontStroke" @if($subevent->Swimstyle == "Trudgen") selected @endif>Trudgen</option>
      <option value="FrontStroke" @if($subevent->Swimstyle == "Wading") selected @endif>Wading</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Course(mts):</label>
      <div class="col-xs-4 col-sm-5">
        <input type="text" class="form-control" id="course" name="course" value="{{$subevent->Course}}" required>
        <span class="course-error" style="color: red;display: none;">Course Should Contain Numeric Charaters</span>
      </div>
    <div class="col-xs-4 col-sm-4">
        <select class="form-control" id="sel" name="width_dimension">
        <option>Mts</option>
        <option>Kms</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Description:</label>
      <div class="col-xs-7 col-sm-9">
        <textarea type="text" class="form-control" id="txt" name="description" required>{{$subevent->SpecialInstructions}}</textarea>
      </div>
    </div>
    <div class="form-group">
                          <label class="control-label col-xs-5 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Disabled Only?:</label>
                              <div class="col-xs-7 col-sm-4">
                <input type="radio" name="disabled" id="yes" @if($subevent->AbleBodied == "yes") checked @endif/>
                <input type="radio" name="disabled" id="no" @if($subevent->AbleBodied == "no") checked @endif />
                <div class="switch radio-inline">
                  <label for="yes">Yes</label>
                  <label for="no">No</label>
                  <span></span>
                </div>
                                  
                              </div>
                        </div>
    @if($privacy[0]->Privacy == "Private")
    <hr>
    <h5 style="color:#46A6EA;text-align: center;"><b>Participants</b></h5>
                  <div class="form-group">
                    <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Minimum:</label>
                    <div class="col-xs-7 col-sm-9">
                      <input type="text" class="form-control" id="min-part" name="min_participants" value="{{old('min_participants')}}" pattern="([0-9]){1,3}" required>
                      <span class="min-part-error" style="color: red;display: none;">Minimum Participants should contain 2-3 Numeric values</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Maximum:</label>
                    <div class="col-xs-7 col-sm-9">
                      <input type="text" class="form-control" id="max-part" name="max_participants" value="{{old('max_participants')}}" pattern="([0-9]){1,3}" required>
                      <span class="max-part-error" style="color: red;display: none">Maximum partcipants should contain 2-3 Numeric values</span>
                      <span class="participant-error" style="color: red;display: none">Minimum partcipants should be less than Maximum participants</span>
                    </div>
                  </div>
                    <hr>
                    <h5 style="color:#46A6EA;text-align: center;"><b>Age</b></h5>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Minimum:</label>
                      <div class="col-xs-7 col-sm-9">
                        <input type="text" class="form-control" id="min-age" name="min_age" value="{{old('min_age')}}" pattern="([0-9]){1,3}" required>
                        <span class="min-age-error" style="color: red;display: none">Minimum Age should contain 1-2 Numeric values</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Maximum:</label>
                      <div class="col-xs-7 col-sm-9">
                        <input type="text" class="form-control" id="max-age" name="max_age" value="{{old('max_age')}}" pattern="([0-9]){1,3}" required>
                        <span class="max-age-error" style="color: red;display: none">Minimum Age should contain 1-2 Numeric values</span>
                        <span class="age-error" style="color: red;display:none">Minimum Age should be less than Maximum Age</span>
                      </div>
                    </div>
                    @endif
                     <div class="form-group">
              <label class="control-label col-xs-4 col-sm-2" for="imgUpload">Image:</label>
                <div class="col-xs-8 col-sm-9">
                    <input type="file" class="form-control myful" id="imgUpload" name="imgUpload"  accept="image/*">
                </div>
      
              </div>
        <div class="col-xs-offset-4 col-sm-offset-4 col-xs-4 col-sm-4 col-offset-sm-4 col-xs-offset-4 mypic mob-none" >
        <img src="{{ url('public/images/event.jpg') }}" alt="img" id="poolimage" class="img-thumbnail" style="height: 132px;" width="100%">
        </div>
        <div class="col-xs-offset-4 col-sm-offset-4 col-xs-4 col-sm-4 col-offset-sm-4 col-xs-offset-4 mypic desk-none tab-none mob-block" >
        <img src="{{ url('public/images/event.png') }}" alt="img" id="poolimage" class="img-thumbnail" style="height: 76px;" width="100%">
              </div> 
                        <!--  <button class="btn btn-primary pull-right" id="subevent"><i class="fa fa-plus"> Add Another Sub Event</i></button>-->
                      </div>
                      @endforeach
                      @else
                       <div class="row">
     <div class="form-group"  id="field1">
      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">SubEvent Name:</label>
      <div class="col-xs-7 col-sm-9">
        <input type="text" class="form-control" id="sub-event" name="subevent_name" value="{{old('subevent_name')}}" required>
        <span class="error" style="color: red;display: none;">SubEvent Name should contain 5-25 characters</span>
      </div>
    </div>
  <div class="form-group mob-none">
                          <label class="control-label col-xs-5 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Gender :</label>
                              <div class="col-xs-7 col-sm-4">
      <label class="radio-inline containerh">Male<input type="radio" name="gender" value="public" required><span class="checkmark"></span></label>
      <label class="radio-inline containerh">Female<input type="radio" name="gender" value="public" required><span class="checkmark"></span></label>
      <label class="radio-inline containerh">Both<input type="radio" name="gender" value="public" required><span class="checkmark"></span></label>
                                      
                              </div>
                        </div>
  
   <div class="form-group desk-none tab-none mob-block">
                          <label class="control-label col-xs-5  col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Gender :</label>
                              <div class="col-xs-7 col-sm-9">
                                      <label class="radio-inline containerh">Male<input type="radio" name="gender" value="public" required><span class="checkmark"></span></label><br>
                                      <label class="radio-inline containerh">Female<input type="radio" name="gender" value="public" required><span class="checkmark"></span></label><br>
                    <label class="radio-inline containerh">Both<input type="radio" name="gender" value="public" required><span class="checkmark"></span></label><br>
                              </div>
                        </div>
    <div class="form-group">
      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="sel">Swim Style:</label>
      <div class="col-xs-7 col-sm-9">
        <select class="form-control" id="sel" name="swim_styles" required>
          <option value="Any">Any</option>
          <option value="Butterfly">Butterfly</option>
          <option value="BackStroke">BackStroke</option>
          <option value="Any">Breaststroke</option>
          <option value="Butterfly">Combat sidestroke</option>
          <option value="BackStroke">Dog paddle</option>
          <option value="FrontStroke">Eggbeater kick</option>
      <option value="Any">Flutter kick</option>
          <option value="Butterfly">Free Colchian</option>
          <option value="BackStroke">Freestyle swimming</option>
          <option value="FrontStroke">Front crawl</option>
      <option value="Any">FrontStroke</option>
          <option value="Butterfly">Georgian swimming</option>
          <option value="BackStroke">Medley swimming</option>
          <option value="FrontStroke">Sidestroke</option>
      <option value="FrontStroke">Total Immersion</option>
      <option value="FrontStroke">Treading water</option>
      <option value="FrontStroke">Trudgen</option>
      <option value="FrontStroke">Wading</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Course(mts):</label>
      <div class="col-xs-4 col-sm-5">
        <input type="text" class="form-control" id="course" name="course" value=""required>
        <span class="course-error" style="color: red;display: none;">Course Should Contain Numeric Charaters</span>
      </div>
    <div class="col-xs-4 col-sm-4">
        <select class="form-control" id="sel" name="width_dimension">
        <option>M</option>
        <option>KM</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Description:</label>
      <div class="col-xs-7 col-sm-9">
        <textarea type="text" class="form-control" id="txt" name="description" required></textarea>
      </div>
    </div>
    <div class="form-group">
                          <label class="control-label col-xs-5 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Disabled Only?:</label>
                              <div class="col-xs-7 col-sm-4">
                <input type="radio" name="disabled" id="yes" />
                <input type="radio" name="disabled" id="no" checked/>
                <div class="switch radio-inline">
                  <label for="yes">Yes</label>
                  <label for="no">No</label>
                  <span></span>
                </div>
                                  
                              </div>
                        </div>
    @if($privacy[0]->Privacy == "Private")
    <hr>
    <h5 style="color:#46A6EA;text-align: center;"><b>Participants</b></h5>
                  <div class="form-group">
                    <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Minimum:</label>
                    <div class="col-xs-7 col-sm-9">
                      <input type="text" class="form-control" id="min-part" name="min_participants" value="{{old('min_participants')}}" required>
                      <span class="min-part-error" style="color: red;display: none;">Minimum Participants should contain 2-3 Numeric values</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Maximum:</label>
                    <div class="col-xs-7 col-sm-9">
                      <input type="text" class="form-control" id="max-part" name="max_participants" value="{{old('max_participants')}}" required>
                      <span class="max-part-error" style="color: red;display: none">Maximum partcipants should contain 2-3 Numeric values</span>
                      <span class="participant-error" style="color: red;display: none">Minimum partcipants should be less than Maximum participants</span>
                    </div>
                  </div>
                    <hr>
                    <h5 style="color:#46A6EA;text-align: center;"><b>Age</b></h5>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Minimum:</label>
                      <div class="col-xs-7 col-sm-9">
                        <input type="text" class="form-control" id="min-age" name="min_age" value="{{old('min_age')}}" required>
                        <span class="min-age-error" style="color: red;display: none">Minimum Age should contain 1-2 Numeric values</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-xs-4 col-sm-2" style="padding-left: 0;padding-right:0" for="txt">Maximum:</label>
                      <div class="col-xs-7 col-sm-9">
                        <input type="text" class="form-control" id="max-age" name="max_age" value="{{old('max_age')}}" required>
                        <span class="max-age-error" style="color: red;display: none">Minimum Age should contain 1-2 Numeric values</span>
                        <span class="age-error" style="color: red;display:none">Minimum Age should be less than Maximum Age</span>
                      </div>
                    </div>
                    @endif
                     <div class="form-group">
              <label class="control-label col-xs-4 col-sm-2" for="imgUpload">Image:</label>
                <div class="col-xs-8 col-sm-9">
                    <input type="file" class="form-control myful" id="imgUpload" name="imgUpload"  accept="image/*">
                </div>
      
              </div>
        <div class="col-xs-offset-4 col-sm-offset-4 col-xs-4 col-sm-4 col-offset-sm-4 col-xs-offset-4 mypic mob-none" >
        <img src="{{ url('public/images/event.jpg') }}" alt="img" id="poolimage" class="img-thumbnail" style="height: 132px;" width="100%">
        </div>
        <div class="col-xs-offset-4 col-sm-offset-4 col-xs-4 col-sm-4 col-offset-sm-4 col-xs-offset-4 mypic desk-none tab-none mob-block" >
        <img src="{{ url('public/images/event.png') }}" alt="img" id="poolimage" class="img-thumbnail" style="height: 76px;" width="100%">
              </div> 
                        <!--  <button class="btn btn-primary pull-right" id="subevent"><i class="fa fa-plus"> Add Another Sub Event</i></button>-->
                      </div>
                      @endif
                     
                  <div class="col-sm-offset-5 col-xs-offset-4">
              <a href="{{url('/venue-event/'.$event_id)}}" class="btn btn-primary mybtn">Back</a>
         <button class="btn btn-primary mybtn">Save</button>
         @if(count($subevents)>0)
         <a href="{{url('/schedule-event/'.$event_id)}}" class="btn btn-primary mybtn">Next</a>
         @else
         <a href="{{url('/schedule-event/'.$event_id)}}" class="btn btn-primary mybtn disabled">Next</a>
         @endif
</div><br><br>
                      </form>
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
                $('#poolimage').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
      }
         $("#imgUpload").change(function(){
        readURL(this);
      });
         $(document).ready(function() {
console.log('{{ url('getoldevents/subevents/'.$event_id) }}');
$.ajax({
    url: '{{ url('getoldevents/subevents/'.$event_id) }}',
    success: function(html) {
      if(html=="no") {
      } else {
        console.log(html);
        //$('#old_events').attr("src",html);
        $('#old_events').html(html);
      }
    },
    async:true
  });
              });
</script>
        @endsection
    
