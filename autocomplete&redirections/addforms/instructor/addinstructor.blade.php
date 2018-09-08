@extends('layouts.main')
@section('content')
<div class="row1">
@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger }}" style="margin:13px;text-align: center;">
        {{ $error }}
        </div>
    @endforeach
@endif
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}">
    {!! session('message.content') !!}
    </div>
@endif
    <!-- profile starts here -->
    <div class="container">
    
        <div class="container">
        <h5 class="add_instructor"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Instructor</h5>
        <div class="row" style="border:1px solid #eee">
          <div class="board">
            <div class="board-inner instructor_tabs">
              <center><ul class="nav nav-tabs nav_info" id="myTab">
                  <div class="liner"></div>
                    <li class="active">
                      <a title="Basic Details">
                        <span class="round-tabs">
                          <i class="fa fa-info"></i>
                        </span>
                       </a>
                     </li>
                     <li>
                       <a title="Timings">
                          <span class="round-tabs">
                            <i class="fa fa-clock-o"></i>
                         </span>
                      </a>
                     </li>
                       <li>
                         <a title="Address">
                            <span class="round-tabs">
                              <i class="fa fa-map-marker"></i>
                           </span>
                        </a>
                       </li>
                       <li>
                         <a title="Experience">
                            <span class="round-tabs">
                              <i class="fa fa-globe"></i>
                           </span>
                          </a>
                        </li>
                        <li>
                          <a title="Contact">
                            <span class="round-tabs">
                              <i class="fa fa-phone"></i>
                            </span>
                         </a>
                        </li>
                      </ul></center>
                        </div>
                        <div class="tab-content tab_details">
                          <div class="tab-pane fade in active" id="instructor_basicdetails">
                            <form class="form-horizontal" id="form" method="post" action="{{ url('addinstructor') }}" style="background:#fff;"  enctype="multipart/form-data">
                              {{csrf_field()}}
                              <div class="col-sm-12">
                                <div class="form-group" id="input_field">
                              
              <label class="control-label col-sm-4" for="txt">First Name:</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="first-name" name="FirstName"  required>
               <span class="firstname-error" style="color: red;display: none"> FirstName should contain 4-25 characters</span>
              </div>
            </div>
   <div class="form-group">
      <label class="control-label col-sm-4" for="txt">Last Name:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="last-name" name="LastName"  required>
        <span class="lastname-error" style="display: none;color: red"> LastName should contain 4-25 characters </span>
      </div>
    </div>
     <div class="form-group">
        <label class="control-label col-sm-4" for="txt">Middle Name:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="middle-name" name="MiddleName"  required>
          <span class="middlename-error" style="display: none;color: red"> MiddleName should contain 4-25 characters </span>
        </div>
      </div>
       <div class="form-group">
      <label class="control-label col-sm-4" for="txt">Title:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="title" name="Title" required>
        <span id="title-error" style="display: none;color: red"> Title should contain 4-25 characters </span>
      </div>
    </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="file">Profile Image:</label>
    <div class="col-sm-6">
      <input type="file" class="form-control" id="imgUpload" name="imgUpload"  accept="image/*" required>
    </div>
  </div>

  <center>
    <button class="btn btn-primary" type="reset">Cancel</button>
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
  </div>

</form>
</div>
</div>
</div>
</div>
</div>
</center>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection