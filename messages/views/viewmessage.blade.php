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
      <li class="active"><a data-toggle="tab" href="#reply">Reply</a></li>
      <li><a href="#" onclick="history.go(-1)"> Back</a></li>
      <!--<li class="pull-right"><a data-toggle="tab" href=""><i class="fa fa-trash" style="color:#46A6EA"></i> Delete</a></li>-->
</ul>
  <div class="tab-content preview_details">
    <div id="reply" class="tab-pane fade in active">
        <div class="col-md-12">
           <div class="box-body"><hr>
             @if(Count($messages)==1)
          
          <div class="icons pull-right">
            <i class="fa fa-archive" onclick="archive('{{ url('archive/'.$sender_id.','.$message_id) }}')"></i>
            @foreach($messages as $message)
            <i class="fa fa-forward" aria-hidden="true" onclick="forward('{{$message->Subject}}','{{$message->Message}}')"></i>
           <a href="#myModl" data-toggle="modal">
   <i class="fa fa-trash"  title="delete" style="color: black;font-size:18px"></i></a>
        </div>
              <p><b>Subject :</b>{{$message->Subject}}</p>
              <p><b>From :</b>{{$message->Sender}} <br><p>
                <p><b>To :</b> {{$message->Receiver}} </p>
              <p>{{$message->Message}}</p><hr>
              @endforeach
              @else
              <div class="icons pull-right">
            @foreach($messages as $message)
            <i class="fa fa-forward" aria-hidden="true" onclick="forward('{{$message->Subject}}','{{$message->Message}}')"></i>
          <span class="glyphicon glyphicon-trash " id="delete-msg" onclick="deletemsg('{{$message->MessageId}}','{{url('deletemessage/'.$message->MessageId)}}')"></span> <a href="#myModl" data-toggle="modal">
   <i class="fa fa-trash"  title="delete" style="color: black;font-size:18px"></i></a>
        </div>
              <p><b>Subject: </b>{{$message->Subject}}</p>
              <p><b>From :</b>{{$message->Sender}} <br><b>To :</b> {{$message->Receiver}} </p>
              <p>{{$message->Message}}</p><hr>
              @endforeach
            @endif
            @if(count($replymessage)==1)
             @foreach($replymessage as $reply)
             <div class="icons pull-right">
              <i class="fa fa-forward" aria-hidden="true" onclick="forward('{{$reply->Subject}}','{{$reply->Message}}')"></i>
               <a href="#myModl" data-toggle="modal">
   <i class="fa fa-trash"  title="delete" style="color: black;font-size:18px"></i></a>
             </div>
              <p><b>Subject: </b>{{$reply->Subject}}</p>
              <p><b>From: </b>{{$reply->Sender}} <br><b>To :</b> {{$reply->Receiver}} </p>
              <p>{{$reply->Message}}</p><hr>
              @endforeach
              @else
               @foreach($replymessage as $reply)
             <div class="icons pull-right">
              <i class="fa fa-forward" aria-hidden="true" onclick="forward('{{$reply->Subject}}','{{$reply->Message}}')"></i>
               <a href="#myModl" data-toggle="modal">
   <i class="fa fa-trash"  title="delete" style="color: black;font-size:18px"></i></a>
             </div>
              <p><b>Subject: </b>{{$reply->Subject}}</p>
              <p><b>From: </b>{{$reply->Sender}} <br><b>To :</b> {{$reply->Receiver}} </p>
              <p>{{$reply->Message}}</p><hr>
              @endforeach
            @endif

    <!-- Button HTML (to Trigger Modal) -->
     

    <!-- Modal HTML -->
    <div id="myModl" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete???</p>
                 </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="deletemsg('{{$message_id}}','{{url('deletemessage/'.$message_id)}}')">Save changes</button>
                </div>
            </div>
        </div>
    </div>
            <form method="post" action="{{url('replymessage/'.$sender_id.','.$message_id)}}" id="reply-message">
              {{csrf_field()}}
              <div class="form-group">
                <input type="hidden" name="to_mail" value="{{$sender}}">
                <input class="form-control" placeholder="Subject" id="reply-subject" name="subject" value="{{$subject}}" readonly>
                <div class="replysubject" style="color: red;display: none"><span>subject should contain maximum of 100 characters</span></div>
              </div>
              <div class="form-group">
                  <textarea id="compose-textarea" class="form-control" name="message" style="height:80px" required></textarea>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" id="submit-reply">Reply</button>

              <button type="reset" class="btn btn-default" id="reply-reset">Cancel</button>
              </div>
               </form>
               <form method="post" action="{{url('sendmessage')}}" id="forwardmsg" style="display: none">
          {{csrf_field()}}
        <div class="col-md-12">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <input type="email" class="form-control" placeholder="To:" id="to_email" name="to_mail" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Subject:" id="forward-subject" name="subject" pattern="([A-zÀ-ž0-9\s]){3,100}" required>
                <div class="forward-sub-error" style="color: red; display: none"><span>Subject Should Contain maximum of 100 characters</span></div>
              </div>
              <div class="form-group">
                  <textarea id="forward-message" class="form-control" style="height: 100px" name="message" required></textarea>
              </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" id="forward-reply">Forward</button>

              <button type="reset" class="btn btn-default" id="reset-forward">Cancel</button>
              </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
         </form>

  <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
      <!--  
        <center>
          <ul class="pagination">

          <li><a href="#">Previous</a></li>
          <li><a href="#">1-6</a></li>
          <li><a href="#">Next</a></li>
        </ul></center>-->
    </div>
      </div>

</div>
<br><br>
</div>
</div>
</div>

<!-- mailbox code ends here -->
@endsection