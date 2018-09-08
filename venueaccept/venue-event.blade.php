@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
<center>
@if(count($event_details)>0)
<table>
	<tr>
		<th>EventName</th>
		<th>StartDate</th>
		<th>EndDate</th>
		<th>Accept/Reject</th>
	</tr>
	<form method="post" action="{{url('venueevents/'.$venue_id)}}">
		{{csrf_field()}}
@foreach($event_details as $event)
<tr>

	<td><input type="text" name="id[]" value="{{$event->Id}}">
		<input type="hidden" name="event_id[]" value="{{$event->EventId}}">
		<input type="hidden" name="event_id[]" value="{{$event->EventId}}">{{$event->EventId}} {{$event->EventName}}</td>
	<td><input type="hidden" name="start_date[]" value="{{$event->StartDateTime}}"> {{$event->StartDateTime}}</td>
	<td><input type="hidden" name="end_date[]" value="{{$event->EndDateTime}}">{{$event->EndDateTime}}</td>
	<td><input type="checkbox" name="bridge_id[]" value="{{$event->Id}}" @if($event->ApproveStatus == "Accepted") checked @endif></td>
</tr>
@endforeach
</table>

<input type="submit" name="submit">
</form>


@endif

@endsection