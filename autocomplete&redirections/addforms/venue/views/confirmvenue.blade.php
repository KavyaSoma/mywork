@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin-left:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
    <div class="container">
  <h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Venue</h5>
      <div class="row" style="border:1px solid #eee">
             <div class="board">
                 <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                 <div class="board-inner  iconlist">
                 <ul class="nav nav-tabs nav_info" id="myTab">
                 <div class="liner"></div>
                  <li>
                  <a href="{{ url('editvenue/'.$venue_id) }}" title="Venue Summary">
                   <span class="round-tabs">
                           <i class="fa fa-list"></i>
                   </span>
               </a></li>

               <li><a href="{{ url('edit-venuepool/'.$venue_id) }}"  title="Pool Information">
                  <span class="round-tabs">
                      <i class="fa fa-info"></i>
                  </span>
        </a>
              </li>
              <li><a href="{{ url('edit-venueaddress/'.$venue_id) }}" title="Address & Contact">
                  <span class="round-tabs">
                       <i class="fa fa-phone"></i>
                  </span> </a>
                  </li>

                  <li><a href="{{ url('edit-venuetimings/'.$venue_id) }}" title="Open hours & Facilities">
                      <span class="round-tabs">
                           <i class="fa fa-clock-o"></i>
                      </span>
                  </a></li>
                  <li><a href="{{ url('edit-venuesociallinks/'.$venue_id) }}" title="Web site & Social Links">
                      <span class="round-tabs">
                           <i class="fa fa-share-alt"></i>
                      </span>
                  </a></li>

                  <li  class="active"><a href="{{url('confirmvenue/'.$venue_id)}}" title="Confirm Venue">
                      <span class="round-tabs">
                           <i class="fa fa-check"></i>
                      </span> </a>
                  </li>

                  </ul></div>

    <div class="tab-pane fade in active" id="venueconfirm">
     
<div class="table-responsive">
  <table class="table">
    <thead>
    <tr>
      <th>Pool Name</th>
      <th>Pool Area</th>
      <th>Length</th>
      <th>Width</th>
      <th>Deep End</th>
      <th>Shallow End</th>
    </tr>
  </thead>
   @foreach($pool_details as $pool)
    <tr>
      <td>{{$pool->PoolName}}</td>
      <td>{{$pool->Area}}</td>
      <td>{{$pool->Length}}</td>
      <td>{{$pool->Width}}</td>
      <td>{{$pool->MaximumDepth}}</td>
      <td>{{$pool->MinimumDepth}}</td>
    </tr>
    @endforeach
    <tr>
   
  </table>
</div>


<h5 style="color:#46A6EA"><b>Pool Description</b></h5>
@foreach($pool_details as $pool)
<p>{{$pool->SpecialRequirements}}</p>
@endforeach

<h5 style="color:#46A6EA"><b>Open Hours</b></h5>
@foreach($timings as $time)
<p>{{$time->Day}}({{$time->OpeningHours}}-{{$time->ClosingHours}})<br>
  </p>
  @endforeach
<h5 style="color:#46A6EA"><b>Address</b></h5>
@foreach($venue_address as $address)
<p>{{$address->AddressLine1}}<br>Post Code: {{$address->PostCode}}<br>{{$address->City}},{{$address->County}},{{$address->Country}}</p>
@endforeach
<h5 style="color:#46A6EA"><b>Contact</b></h5>
@foreach($venue_contact as $contact)
<p>Mobile:{{$contact->Phone}}<br>Email:{{$contact->Email}}</p>
@endforeach
<h5 style="color:#46A6EA"><b>Facilities</b></h5>
<p>Food Court<br>Gym<br>Instructors<br>Diving</p>
<hr>
<form method="post" action="{{url('confirmvenue/'.$venue_id)}}">
  {{csrf_field()}}
<center>
      <a href="{{ url('edit-venuesociallinks/'.$venue_id)}}" class="btn btn-primary">Back</a>
       
      <button class="btn btn-primary">Submit</button>
    </form>
</center>
   </div>
</div>
</div>
</div>

</div>
</div>
@endsection