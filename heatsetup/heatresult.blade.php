@extends('layouts.main')
@section('content')
<!-- mail box code starts here -->
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
<div class="container" style="margin-top:20px;" id="main-code">
   <ol class="breadcrumb" style="background:#46A6EA;">
  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
  @if($level_id == 1)
  <li class="breadcrumb-item active">Heat Results</li>
  @elseif($level_id == 2)
  <li class="breadcrumb-item active">Semifinal Results</li>
  @else
  <li class="breadcrumb-item active">Final Results</li>
  @endif
 </ol> 
   <div class="row text-center"> 
    @if( count($results)>0 )
    <table class='table table-striped' style="text-align:left;">
        <tr><th>Participant Name</th><th>RecordedTime</th><th>Result</th></tr>    
    @foreach($results as $result)
            <tr><td>{{ $result->ParticipantName }}</td><td>{{$result->RecordedTime}}</td><td>{{$result->Result}}</td></tr>
    @endforeach    
    </table>
    @else
    <h4>You have not created any events yet to setup Heats , <a href='{{ url('addevent') }}'>Click here</a> to create an event.</h4>
    @endif
</div>
</div>
</div>
</div>
<!-- mailbox code ends here -->
@endsection    