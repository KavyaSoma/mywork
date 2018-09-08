@extends('layouts.main')
@section('content')
  <div class="container" style="margin-top:20px">
  <div class="row" style="border:1px solid #eee">
    <div class="board">
     <div class="tab-content tab_details">
      <div class="tab-pane fade in active" id="stagesummary">
        <div class="col-sm-12">
          <div class="row" style="border:1px solid #eee">
            @if(count($event_details)>0)
<table class='table table-striped'>
  <tbody>
    <tr><th>Event Name</th><th>Heat Setup</th></tr>
    @foreach($event_details as $event)
    <tr>
      <td>{{$event->EventName}}</td>
      <td>@if(count($heat)>0) <a href="{{url('resultentry/'.$event->EventId)}}" style="color: black">Result Entry</a> @else <a href="{{url('heatsetup/'.$event->EventId)}}" style="color: black">Heat Setup</a> @endif</td>
    </tr>
    @endforeach
  </tbody>
</table>
  </div>
</div>

<div class="row">
  <center><ul class="pagination">
    {{$event_details->links()}}
  </ul></center>
</div>
@else
<h4> Event Not Added to Club</h4>
@endif
</div>
</div>
</div>
</div>
</div>
@endsection