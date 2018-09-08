<!-- social Communication code starts here -->
@extends('layouts.main')
@section('content')

@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif

<div class="container" id="main-code">
 <section class="main" style="margin-top:20px">
   <section class="tab-content">
     <section class="tab-pane active fade in active">
       <div class="row" id="dashboard-mob">
         <div class="panel-body">
                   <div class="col-xs-12 col-sm-12">
                       <div class="panel panel-default magic-element isotope-item">
                                 <div class="panel-body-heading edituser_panel">
                                     <h4 class="pb-title" style="padding:5px">Friends [{{count($friends)}}]</h4>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" style="padding:20px">
        <h5 style="color:#fff;background-color:#46A6EA;padding:5px">Find Friends</h5>
        <form method="post" action="{{url('socialnetwork')}}">
          {{csrf_field()}}
         <input type="text" class="form-control" name="name" placeholder="Enter Name/Email"><br>
         <center><button class="btn btn-primary">Add to List</button></center>
       </form>
      </div>
    </div>
  </div>
  </div>
 </div>
 <div class="panel-body">
     <div>
   @foreach($friends as $friend)
     <div class="col-md-1">
       <a href="#">
         <img src="{{ url('public/images/sravan.jpeg') }}" alt="friend photo" width="60" height="60"/>
       </a>
       <br/>
       {{$friend->UserName}}
     </div>
     @endforeach
    </div>
     <p>
     <center><button class="btn btn-warning" data-toggle="modal" data-target="#myModal">Find Friends</button>&nbsp;&nbsp;&nbsp;
   <a href="{{ url('friendlist')}}"><button class="btn btn-primary">View All</button></a></center>
      </p>
 </div>
 </div>
 </div>
 <div class="col-xs-12 col-sm-12">
     <div class="panel panel-default magic-element isotope-item">
               <div class="panel-body-heading edituser_panel">
                   <h4 class="pb-title" style="padding:5px">Forum <span class="badge" id="badge"> {{count($questions)}}</span></h4>
                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal1">Ask Forum</button> 
<div class="modal fade" id="myModal1" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h5 style="color:#fff;background-color:#46A6EA;padding:5px;margin-top:30px">Ask Forum</h5>
<div class="modal-body">
<form class="form-horizontal" method="post" action="{{url('socialnetwork')}}">
  {{csrf_field()}}
  <div class="form-group">
    <label class="control-label col-sm-4" for="txt" style="color:#333">Category:</label>
    <div class="col-sm-6">
       <input type="text" class="form-control"  name="category" id="txt">
                      </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="txt" style="color:#333">Topic:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control"  name="topic" id="txt">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="txt"  style="color:#333">Question:</label>
    <div class="col-sm-6" style="right: 20px">
   <div style="margin:0 5px 0 25px;">
     <div class="form-group">
       <div class="col-md-6">
       <div class="md-editor" id="1525782794180" style="display: table;"><div class="md-header btn-toolbar"><div class="btn-group"><button class="btn-default btn-sm btn" type="button" title="Bold" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdBold" data-hotkey="Ctrl+B"><span class="glyphicon glyphicon-bold"></span> </button><button class="btn-default btn-sm btn" type="button" title="Italic" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdItalic" data-hotkey="Ctrl+I"><span class="glyphicon glyphicon-italic"></span> </button><button class="btn-default btn-sm btn" type="button" title="Heading" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdHeading" data-hotkey="Ctrl+H"><span class="glyphicon glyphicon-header"></span> </button></div><div class="btn-group"><button class="btn-default btn-sm btn" type="button" title="URL/Link" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdUrl" data-hotkey="Ctrl+L"><span class="glyphicon glyphicon-link"></span> </button><button class="btn-default btn-sm btn" type="button" title="Image" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdImage" data-hotkey="Ctrl+G"><span class="glyphicon glyphicon-picture"></span> </button></div><div class="btn-group"><button class="btn-default btn-sm btn" type="button" title="Unordered List" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdList" data-hotkey="Ctrl+U"><span class="glyphicon glyphicon-list"></span> </button><button class="btn-default btn-sm btn" type="button" title="Ordered List" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdListO" data-hotkey="Ctrl+O"><span class="glyphicon glyphicon-th-list"></span> </button><button class="btn-default btn-sm btn" type="button" title="Code" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdCode" data-hotkey="Ctrl+K"><span class="glyphicon glyphicon-asterisk"></span> </button><button class="btn-default btn-sm btn" type="button" title="Quote" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdQuote" data-hotkey="Ctrl+Q"><span class="glyphicon glyphicon-comment"></span> </div><div class="md-controls"><a class="md-control md-control-fullscreen" href="#"><span class="glyphicon glyphicon-fullscreen"></span></a></div></div>
        <textarea name="message" style="width: 310px" data-provide="markdown" rows="10" data-width="600" class="form-control md-input" name="Question" required="" resize: none;"></textarea><div class="md-fullscreen-controls"><a href="#" class="exit-fullscreen" title="Exit fullscreen"><span class="glyphicon glyphicon-fullscreen"></span></a></div></div>
       </div>
       </div>
        </div>
      <!--// <meta http-equiv="refresh" content="10;url=forum_answers.php" />-->
    </div>
  </div>

</div>
<div class="modal-footer">
<center><button type="submit" class="btn btn-primary col-sm-offset-6 col-sm-2">Post</button></center></form>
</div></div>
</div></div>
</div>
</div><br>
 <div class="form-group">
                    <div class="col-sm-3">
                      <select class="form-control">
                        <option>Select Topic</option>
                        @foreach($topics as $topic)
                        <option onclick="topic('{{url('questions/'.$topic->Topic)}}')">{{$topic->Topic}}</option>
                        @endforeach
                      </select>
                    </div>
                      </div><br>
<div class="panel-body">
   <div class="table table-responsive table-container">
     <table class="table table-striped table-bordered table-hover" id="sample_3">
       <thead>
         <tr>
           <th> Questions</th>
           <th> Topic</th>
           <th> Replies </th>
           <th> Views </th>
         </tr>
       </thead>
       <tbody>
        @foreach($questions as $question)
        <tr>
         <td id="mns">
           <h5>
             <a id="mrs" href="{{url('forumanswers/'.$question->QuestionId)}}">
              {{$question->Question}}</a>
           </h5>
           <span id="mash">
           <img src="{{ url('public/images/sravan.jpeg') }}" class="img-circle" height="40px" width="40px"/>
             <i class="fa fa-calendar" style="color:#ff6600;font-size:18px"></i> <b style="color: #000;font-weight:normal; font-size:12px;"> {{$question->DateTime}} </b>
           </span></td>
           <td>
             {{$question->Topic}}
           </td>
         <td> <i class="fa fa-comments" style="color:#46A6EA;font-size:18px"> </i> &nbsp;7 </td>
     <td>
     <i class="fa fa-eye" style="color:#46A6EA;font-size:18px"></i>
      {{$question->View}}
     </td>
     @endforeach
     </tr>

     </table>
             </div>
            <center><a href="{{url('questions')}}"><button class="btn btn-primary">View All Questions</button></a></center>
           </div>
</div>
</div>
<div class="col-xs-12 col-sm-12">
   <div class="panel panel-default magic-element isotope-item">
             <div class="panel-body-heading edituser_panel">
                 <h4 class="pb-title" style="padding:5px;">Groups [2k Groups]</h4>
<!-- Modal -->
<div class="modal fade" id="myModal2" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h5 style="color:#fff;background-color:#46A6EA;padding:5px;margin-top:30px">Create Group</h5>
<div class="modal-body">
<form class="form-horizontal">
 <div class="form-group">
   <label class="control-label col-sm-4" for="txt" style="color:#333">Group Name:</label>
   <div class="col-sm-6">
     <input type="text" class="form-control" id="txt">
   </div>
 </div>
</form>
</div>
<div class="modal-footer">
<center><button class="btn btn-primary col-sm-offset-5 col-sm-4">Create Group</button></center>
</div></div></div>
</div>
</div>
</div><br>
<div class="panel-body">
@for($i=0;$i<=11;$i++)
<div class="col-sm-1">
<a href="#"><img src="{{url('public/images/group.jpg')}}" height="60px" width="60px" id="group_img" data-toggle="modal" data-target="#myModal4"/></a>
</div>
@endfor
<center><button class="btn btn-warning" data-toggle="modal" data-target="#myModal2">Create New Group</button>&nbsp;&nbsp;&nbsp;
   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">View All Groups</button></center>
</div>
</div>
 </div>

   <!-- Modal -->
   <div class="modal fade" id="myModal4" role="dialog">
   <div class="modal-dialog">
   <!-- Modal content-->
   <div class="modal-content" style="height:500px">
   <div class="modal-header">
 <div class="col-xs-12 col-sm-12" id="add_member">
     <div class="panel panel-default magic-element isotope-item">
               <div class="panel-body-heading edituser_panel">
                   <h4 class="pb-title" style="padding:12px">Group Name(0 members)
<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal5" style="border:1px solid #fff;margin-top:-10px" id="add_btn">Add Members</button></h4>
 <!-- Modal -->
 <div class="modal fade" id="myModal5" role="dialog">
 <div class="modal-dialog">
 <!-- Modal content-->
 <div class="modal-content">
 <div class="modal-header">
 <button type="button" class="close" data-dismiss="modal">&times;</button>

 <div class="modal-body">
 <form class="form-horizontal">
   <div class="form-group">
     <label class="control-label col-sm-4" for="txt" style="color:#333">Group Name:</label>
     <div class="col-sm-6">
       <input type="text" class="form-control" id="txt">
     </div>
   </div>
   <div class="form-group">
     <label class="control-label col-sm-4" for="txt" style="color:#333">Member Name:</label>
     <div class="col-sm-6">
       <input type="text" class="form-control" id="txt">
     </div>
   </div>
 </form>
 </div>
 <div class="modal-footer">
 <center><button class="btn btn-primary col-sm-offset-5 col-sm-4">Update Group</button></center>
 </div></div></div>
 </div>
 </div>
 </div>
</div>
</div>
</div>
</div>
</div>
</div>
 <br>
 <div class="panel-body">
 <div class="table table-responsive table-container">
 </div>
 </div>
 </div>
   </div>
 </section>
 </section>
 </section>
</div>
<!-- social Communication code ends here -->
 @endsection