@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
    <!-- venue code starts here -->
<div class="container">
  <h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Venue</h5>
      <div class="row" style="border:1px solid #eee">
             <div class="board">
                 <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                 <div class="board-inner  iconlist">
                 <ul class="nav nav-tabs nav_info" id="myTab">
                 <div class="liner"></div>
                  <li class="active">
                  <a href="{{url('addvenue')}}" data-toggle="tab" class="tab-one" title="Venue Summary">
                   <span class="round-tabs">
                           <i class="fa fa-list"></i>
                   </span>
               </a></li>

               <li><a href="#"  title="Pool Information">
                  <span class="round-tabs">
                      <i class="fa fa-info"></i>
                  </span>
        </a>
              </li>
              <li><a href="#" title="Address & Contact">
                  <span class="round-tabs">
                       <i class="fa fa-phone"></i>
                  </span> </a>
                  </li>

                  <li><a href="#" title="Open hours & Facilities">
                      <span class="round-tabs">
                           <i class="fa fa-clock-o"></i>
                      </span>
                  </a></li>
                  <li><a href="#" data-toggle="tab" title="Web site & Social Links">
                      <span class="round-tabs">
                           <i class="fa fa-share-alt"></i>
                      </span>
                  </a></li>

                  <li><a href="#" data-toggle="tab" title="Confirm Venue">
                      <span class="round-tabs">
                           <i class="fa fa-check"></i>
                      </span> </a>
                  </li>

                  </ul></div>

                  <div class="tab-content tab_details">
                   <div class="tab-pane fade in active" id="venuesummary">
                     <form class="form-horizontal" style="background:#fff;padding:35px" method="post" action="{{url('addvenue')}}">
                      {{csrf_field()}}
                           <div class="row">
                             <div class="form-group">
                                   <label class="control-label col-xs-4 col-sm-4" for="txt">Venue Name:</label>
                                   <div class="col-xs-7 col-sm-6">
                                     <input type="text" class="form-control" id="venue-name" name="venue_name" value="{{old('venue_name')}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                                     <span class="error" style="color: red;display: none;">Venu Name Should contain only 5-25 characters</span>
                                   </div>
                                 </div>
                                 
                      <div class="form-group">
                         <label class="control-label col-xs-4 col-sm-4" for="txt">Description:</label>
                         <div class="col-xs-7 col-sm-6">
                           <textarea class="form-control" id="txt" name="description" required> {{old('description')}}</textarea>
                         </div>
                       </div>
                       <div class="form-group">
                           <label class="control-label col-xs-4 col-sm-4" for="txt">Short Name:</label>
                           <div class="col-xs-7 col-sm-6">
                             <input type="text" class="form-control" id="venue-short-name" name="short_name" onblur="venueshortname('{{url('checkshortname/venue')}}')" value="{{old('short_name')}}" required>
                             <div id="message"></div>
                           </div>
                         </div>
                       <div class="form-group">
                         <label class="control-label col-xs-4 col-sm-4" for="file">Image:</label>
                         <div class="col-xs-7 col-sm-6">
                           <input type="file" class="form-control" id="file" name="imgUpload" required>
                         </div>
                       </div>
                        <div class="col-xs-offset-2 col-xs-10 col-sm-offset-5 col-sm-7">
       <a>
          <button class="btn btn-primary" type="reset">Cancel</button>
        </a>
       <button class="btn btn-primary" id="savevenue">Save and Continue</button>
</div>
    </form>
    </div>
      </div>
 </div>
</div>
</div>
</div>
</div>
<!-- venue code ends here -->
@endsection