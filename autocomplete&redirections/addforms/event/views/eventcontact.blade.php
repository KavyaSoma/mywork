 @extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
<div class="container" id="main-code">
  <div class="row" id="eventpreview_tabs">
    <div class="col-sm-8">
      @if (count($events) > 0)
        <ul class="nav nav-tabs preview_tabs">
          <li><a href="{{url('event/'.$events[0]->ShortName)}}"> <i class="fa fa-list" aria-hidden="true" id="info_fa"></i> Basic Details</a></li>
          <li><a href="{{url('event/'.$events[0]->ShortName.'/subevent')}}"> <i class="fa fa-info" aria-hidden="true" id="info_fa"></i> Sub Event Details</a></li>
          <li><a href="{{url('event/'.$events[0]->ShortName.'/eventschedule')}}"> <i class="fa fa-calendar" aria-hidden="true" id="info_fa"></i> Schedule</a></li>
          <li  class="active"><a href="{{url('event/'.$events[0]->ShortName.'/eventcontact')}}"> <i class="fa fa-map-marker" aria-hidden="true" id="info_fa"></i> Contact</a></li>
          <li><a href="{{url('event/'.$events[0]->ShortName.'/eventvenue')}}"> <i class="fa fa-phone" aria-hidden="true" id="info_fa"></i> Venue</a></li>
      </ul>
      @endif
      @if (count($eventcontact) > 0 )
 <div id="eventpreview-contact" class="tab-pane fade in active">
                <div class="table table-responsive" style="margin-top: 3%">
         <table class="table table-bordered">
<thead>
<tr>
<th>Club Name</th>
<th>Email</th>
<th>Mobile Number</th>
<th>Description</th>
</tr>
</thead>
@foreach($eventcontact as $contact)
<tbody>
<tr>
<td>{{$contact->ClubName}}</td>
<td>{{$contact->Email}}</td>
<td>{{$contact->MobilePhone}}</td>
<td>{{$contact->Description}}</td>
</tr>
</tbody>
@endforeach
</table>
</div>
    </div>
@else
<h4>No Data Available</h4>
@endif      
</div>
 @include('eventsidebar')

</div></div></div>
@endsection