@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
<!-- club-profile starts here -->
<div class="container" id="main-code">
     <br/>
     <h2 style="background-color:#46A6EA;color:#fff;padding:5px">Add Club</h2>
<div class="row">
  <div class="board">
<div class="tab-content tab_details">
  <div class="tab-pane fade in active" id="basicdetails">
     @foreach($clubinfo as $club)
    <form class="form-horizontal" style="background:#fff;padding:35px" method="post" action="{{url('/editclub/'.$club->ClubId)}}">
      {{csrf_field()}}
      <h5 style="background-color:#46A6EA;color:#fff;"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button> Club Details</h5>
      
      <div class="col-sm-12">
        <div class="form-group">
             <div class="col-sm-6">
              <input type="hidden" class="form-control" id="club-admin" name="club_admin_name" value="" readonly>
            </div>

        </div>
                     <input type="hidden" name="AddressId" value="{{$club->AddressId}}">

        <div class="form-group">
          <label class="control-label col-sm-4" for="txt">Club Name:</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="clubname" name="ClubName" value="{{$club->ClubName}}" pattern="([A-zÀ-ž\s]){3,25}" required>
              <span class="error-club" style="color:red;display:none;">Club Name should only contain 3-25 characters
              </span>
              <div id="display"></div>
            </div>
            
        </div>

        <div class="form-group">
          <label class="control-label col-sm-4" for="txt">Short Name:</label>
           <div class="col-sm-6">
              <input type="text" class="form-control" id="shortname" name="shortname" value="{{$club->ShortName}}">
               </div>
            </div>   
        <div class="form-group">
            <label class="control-label col-sm-4" for="txt">Club Type:</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="club-type" name="ClubType" value="{{$club->ClubType}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                <span class="error-type" style="color:red;display:none;">Club Type should only contain 3-25 characters</span>
              </div>
       </div>
       <div class="form-group">
          <label class="control-label col-sm-4" for="file"> Image:</label>
            <div class="col-sm-6">
              <input type="file" class="form-control" id="profile-image" name="image[]" value="">
            </div>
      </div>
        
      <div class="form-group">
          <label class="control-label col-sm-4" for="txt">Description:</label>
              <div class="col-sm-6">
                  <textarea class="form-control" id="club-descript" name="Description" required>{{$club->Description}}</textarea>
            </div>
    </div>
  
    <!-- address -->      
            <h5 style="background-color:#46A6EA;color:#fff;"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button> Club Address</h5>
            <div class="form-group">
              <label class="control-label col-sm-4" for="txt">Address:</label>
            <div class="col-sm-6">
             <textarea class="form-control" id="txt" name="AddressLine1" required>{{$club->AddressLine1}}</textarea>
           </div>
           </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="txt">City:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="club-city" name="City" value="{{$club->City}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                    <span class="error" style="color:red;display:none;">City Should contain only 3-25 characters</span>
                  </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="txt">Post code:</label>
                  <div class="col-sm-6">
                      <input type="text" class="form-control" id="post-code" name="PostCode" value="{{$club->PostCode}}" pattern="([0-9]){4,9}" placeholder="Eg:67543" required>
                      <span class="post-error" style="color:red;display:none;">Invalid Post Code(Only digits accepted)</span>
                  </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="txt">Town:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="club-town" name="Town" value="{{$club->County}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                    <span class="town-error" style="color:red;display:none;">Town Should contain only 3-25 characters</span>
                  </div>
           </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="txt">Country:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="club-country" name="Country" value="{{$club->Country}}" pattern="([A-zÀ-ž\s]){3,25}" required>
                      <span class="country-error" style="color:red;display:none;">Town Should contain only 3-25 characters</span>
                    </div>
            </div>
        <!-- club contact -->
        <h5 style="background-color:#46A6EA;color:#fff;"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button> Club Contact</h5>
        <div class="form-group">
              <label class="control-label col-sm-4" for="txt">Mobile Number:</label>
              <div class="col-sm-6">
                  <input type="text" class="form-control" id="club-mobile" name="MobilePhone" value="{{$club->MobilePhone}}" placeholder="Eg:9876543210" pattern="([0-9]){10}" required>
                  <span class="mobile-error" style="color:red;display: none">Mobile Number should contain 10 digits</span>
            </div>
          </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="email">Email:</label>
                  <div class="col-sm-6">
                      <input type="email" class="form-control" id="email" name="Email" value="{{$club->Email}}" required>
                  </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="txt">Web:</label>
                <div class="col-sm-6"> 
                  <input type="url" class="form-control" id="txt" name="Website" value="{{$club->Website}}" placeholder="www.example.com" required>
                </div>
           </div>
        <!-- club social -->
        <h5 style="background-color:#46A6EA;color:#fff;"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button> Club Social</h5>
        <div class="form-group">
          <label class="control-label col-sm-4" for="txt">Facebook:</label>
              <div class="col-sm-6">

                <input type="text" class="form-control" id="txt" name="Facebook" value="{{$club->Facebook}}" required>
              </div>
      </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="email">Google+:</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" id="email" name="GooglePlus" value="{{$club->GooglePlus}}" required>
                </div>
      </div>
      <div class="form-group">
            <label class="control-label col-sm-4" for="txt">Twitter:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="txt" name="Twitter" value="{{$club->Twitter}}" required>
                </div>
    </div>
     <div class="form-group">
        <label class="control-label col-sm-4" for="txt">Others:</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="txt" name="Others" value="{{$club->Others}}" required>
              </div>
    </div>
    <center>
      <a>
         <button class="btn btn-primary" type="reset">Cancel</button>
       </a>
       <a href="{{url('editclub/'.$club->ClubId)}}"> <button class="btn btn-primary">Save and Continue</button></a>
     
        <br><br>
    </div>
    @endforeach
  </form>
  </div>
 

</div>


</div>
</div>
</div>

@endsection