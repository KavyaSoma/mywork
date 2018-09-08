@extends('layouts.main')
@section('content')

@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
<!-- settings information code starts here -->
  <div class="container" id="main-code">
     <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" id=kin_photo>
      @if($users[0]->Image == "NA")
     <div class="fb-profile"  style="margin-top:21%">
 <img class="thumbnail user_image"  src="{{url('public/images/profile.png')}}" alt="Profile image"/>
</div>
@else
 <div class="fb-profile"  style="margin-top:21%">
 <img class="thumbnail user_image"  src="{{$users[0]->Image}}" alt="Profile image"/>
</div>
@endif
<a href="{{url('editprofile')}}"><button class="btn btn-primary">Edit</button></a>
   @if(Session::get('user_type') == "User")   
  <a href="{{url('addkin')}}" class="btn btn-primary">Add Kin </a>
 
                         @endif
</div>
<div class="col-xs-12 col-sm-6 col-md-10" id="kin_info">
<form class="form-horizontal kin_info">

       <div class="well" style="background:#fff">
         <div class="container">
         <div class="row" style="width:73%">
           @if(Session::get('user_type') == "User")   
          <ul class="nav nav-tabs preview_tabs">
               <li><a  href="{{url('profile')}}"> <i class="fa fa-cog" aria-hidden="true" id="info_fa"></i> Account Settings</a></li>
               <li class="active"><a href="{{url('kindetails')}}"> <i class="fa fa-info" aria-hidden="true" id="info_fa"></i> Kin Details</a></li>

                </ul>
             @else
       <ul class="nav nav-tabs preview_tabs">
               <li class="active"><a data-toggle="tab" href="#accountsettings"> <i class="fa fa-cog" aria-hidden="true" id="info_fa"></i> Account Settings</a></li>
             </ul>
             @endif
              <div class="tab-content preview_details">
                <div id="kindetails" class="tab-pane fade in active">
                    

                      <div class="row" style="margin-top:10px">
                         @if(count($kins)>0)
                         @foreach($kins as $kin)
                        <div class="col-md-3 col-xs-6 col-sm-3 book-now-img" >
                          <a href="#">
                                      <div class="book-img-thumb">
                                        @if($kin->Image == "NA")
                                         <img src="{{url('public/images/user-200.png')}}"/>
                                         @else
                                        <img src="{{$kin->Image}}"/>
                                       @endif
                                     <div class="swim-curve">
                                         <div class="swim-curve-img">
                                         </div>
                                        
                                         <div class="swim-name">
                                             <span class="m-name">{{$kin->ParticipantName}}</span>
                                           </div>
                                         <div class="swim-lang">
                                             <span>{{$kin->Relationship}}</span>
                                         </div>
                                     <div class="swim-det">
                                         <div class="swim-genre">
                                              <ul class="list-inline">
                                                 <li>{{$kin->Height}}cms</li>
                                                 <li>{{$kin->Weight}}Kg</li>
                                                 
                                             </ul>
                                         </div>

                                      </div>
                                  </div>
                                  <a href="{{url('editkin/'.$kin->ParticipantId)}}" class="btn btn-primary edit_button col-xs-12 col-sm-6">
                                        <i class="fa fa-edit"></i>Edit
                                      </span>
                                   </a>
                                   <a href="{{url('kininformationpage/'.$kin->ParticipantId)}}" class=" btn btn-primary delete_button col-xs-12 col-sm-6">
                                          <i class="fa fa-eye"></i>  View
                                        </span>
                                    </a>
                         </div>
                     </div>
                              @endforeach
                 @if(count($kins)>0)
 <div class="text-center">
   <ul class="pagination">
{{ $kins->links() }}
 </ul>
 </div>
 @endif
           </div>
            @else
                      <h1>No Kins Available</h1>
                    @endif

                          </div>
                        </form>
                      </div>
                    </div>
                     </div>
                  </div>
                </div></div></div>
                @endsection