@extends('layouts.main')
@section('content')
<!-- mail box code starts here -->
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
<div class="container" style="margin-top:20px;background-color:#fff" id="main-code">
  <ul class="nav nav-tabs preview_tabs">
      <li class="active"><a href="{{url('/inbox')}}">Inbox</a></li>
      <li><a href="{{url('/sendmessage')}}">Compose</a></li>
      <li><a href="{{ url('sentmessage') }}">Sent</a></li>
      <li><a href="{{ url('archivemessage') }}">Archive</a></li>
      <!--<li class="pull-right"><a href="{{ url('deletemessage')}}"><i class="fa fa-trash" style="color:#46A6EA"></i> Delete</a></li>-->
</ul>
  <div class="tab-content preview_details">
      <div id="inbox" class="tab-pane fade in active">
        <div class="col-md-12" style="margin-top:10px">
        <div class="chat_list">
            @if( count($incoming) > 0 )
          <ul class="list-group">
              
             @foreach($incoming as $inbox)
             <li class="list-group-item">
              <div class="pull-left">
                  <div>
                    <div class="checkbox">
<label><input type="checkbox" value=""><img class="img-circle"  alt="User1" src="{{ asset('public/images/swimm6.jpg') }}" id="mail_img"></label>
</div>
                  </div>
              </div>
              <a href="{{ url('replymessage/'.$inbox->UserId.','.$inbox->MessageId)}}" style="color: black">
                <small class="pull-right text-muted">{{$inbox->date}}</small>
                <div>
                    <p class="message_text"><b>From : </b> {{$inbox->Sender}} ({{$inbox->Subject}}) {{$inbox->Message}}</p>
                </div></a>
            </li>
             
            
              @endforeach
              

          </ul>
            @else
            <h4> No Messages Yet!</h4>
            @endif
            
      </div>
      <!--<center>
        <ul class="pagination">
        <li><a href="#">&laquo;</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">&raquo;</a></li>
      </ul>
    </center>-->
</div>
    </div>

     
    
</div>
<br><br>
</div>
</div>
</div>
<!-- mailbox code ends here -->
@endsection