@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margi-left:13px;">
    {!! session('message.content') !!}
    </div>
    @endif
    <div class="container">

        <div class="container">
        <h5 class="add_instructor"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Instructor</h5>
        <div class="row" style="border:1px solid #eee">
          <div class="board">
          <div class="board-inner instructor_tabs">
              <center><ul class="nav nav-tabs nav_info" id="myTab">
                  <div class="liner"></div>
                    <li>
                      <a href="#" class="tab-one" title="Basic Details">
                        <span class="round-tabs">
                          <i class="fa fa-info"></i>
                        </span>
                       </a>
                     </li>
                     <li>
                       <a href="#" title="Timings">
                          <span class="round-tabs">
                            <i class="fa fa-clock-o"></i>
                         </span>
                      </a>
                     </li>
                       <li>
                         <a href="#" title="Address">
                            <span class="round-tabs">
                              <i class="fa fa-map-marker"></i>
                           </span>
                        </a>
                       </li>
                       <li>
                         <a href="#" title="Experience">
                            <span class="round-tabs">
                              <i class="fa fa-globe"></i>
                           </span>
                          </a>
                        </li>
                        <li class="active">
                          <a href="#" title="Contact">
                            <span class="round-tabs">
                              <i class="fa fa-phone"></i>
                            </span>
                         </a>
                        </li>
                      </ul></center>
                        </div>
                        
          <div class="tab-pane fade in active" id="instrutor_contact">
      <form class="form-horizontal" method="post" action="{{url('instructorcontact/'.$id)}}" style="background:#fff;">
        {{csrf_field()}}
       @foreach($users as $user)
        <div class="col-sm-12">
          <div class="form-group">
   
<label class="control-label col-sm-4" for="email">Email:</label>
<div class="col-sm-6">
  <input type="email" class="form-control" id="email" value="" name="Email" onblur="shortName('{{url('checkmail/instructor')}}')" required>
  <div id="message"></div>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Phone 1:</label>
<div class="col-sm-6">
  <input type="text" class="form-control" id="phone1" value="{{$user->DayTimePhone}}"  pattern="([0-9]){10}" name="DayTimePhone" required > 
  <span id="message1" style="color: red;display: none">Phone Should contain 10 digits</span>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Phone 2:</label>
<div class="col-sm-6">
<input type="text" class="form-control" id="phone2" value="{{$user->EveningPhone}}" name="EveningPhone">
<span id="message2" style="color: red;display: none">Phone Should contain 10 digits</span>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-4" for="txt">Swimmiq contact:</label>
<div class="col-sm-6">
<input type="text" class="form-control" id="display" value="" name="ShortName" readonly>
</div>
</div>

<center>
   <button type="submit" class="btn btn-primary" id="instructor-contact">Submit</button>
 <br><br>
</div>

@endforeach
</form>

</div>
</center>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection