@extends('layouts.main')
@section('content')
 <!-- forum question code starts here -->
 <div class="container" id="main-code">
   <section class="main" style="margin-top:20px">
      <div class="row" id="dashboard-mob">
        <div class="col-xs-12 col-sm-8">
                         <div class="panel panel-default magic-element isotope-item">
                                   <div class="panel-body-heading edituser_panel">
                                       <h4 class="pb-title" style="padding:5px">Forum Question</h4>
                                     </div>
                                     <div class="row" style="margin:0">
                                       <div class="col-lg-11">
                                         <div class="ui-block">
                                           <article class="hentry post">
                                             <div class="m-link">
           <a href="#"  target="_blank" style="color:#46A6EA;">
            @foreach($questions as $question)
             <h4>
            {{$question->Question}}</h4></a>
            @endforeach
         </div><hr>
         @foreach($answers as $answer)
         <div class="post__author author vcard inline-items">
           <img src="images/sravan.jpeg" alt="user" height="40px" width="40px">
           <small class="author-date">
             <a class="h6 post__author-name fn" href="#">User</a> |
             <small class="post__date">
               <time class="published" datetime="2004-07-24T18:18" style="font-size:12px">
                 Answered 5 min ago
               </time>
             </small>
           </small>
<div class="more">
  <a href="#">
  <span class="glyphicon glyphicon-option-vertical"></span>
  </a>
 </div>
</div>
<p>{{$answer->Answer}}
  </p>
  <div class="post-additional-info inline-items">
  <p><a href="#" class="btn btn-xs btn-default" id="answer"><span class="glyphicon glyphicon-pencil" style="color:#46A6EA;" id="answer"></span> Answer</a>
  </p>
  <p class="social-icons">
  <a href="#" class="btn btn-xs btn-default" style="color:#fff;background:#3b5998"><i class="fa fa-facebook"></i></a>
  <a href="#" class="btn btn-xs btn-default" style="color:#fff;background:#1DA1F2"> <i class="fa fa-twitter"></i></a>
</p>
</div>
</article><hr>
@endforeach
  </tr>
  <tr></tr>
  </tbody>
  </table>
  </div>
  </div>
</div>
<h3 style="margin:0">Post Answer</h3><br><br>
<div class="row">

                              <form method="post" class="form-horizontal" action="{{url('forumanswers/'.$question_id)}}" method="post">
                                {{csrf_field()}}
                                  <div style="margin:0 5px 0 25px;">
                                      <div class="form-group">

                                          <div class="col-md-6">
                                              <div class="md-editor" id="1525782794180" style="display: table;"><div class="md-header btn-toolbar"><div class="btn-group"><button class="btn-default btn-sm btn" type="button" title="Bold" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdBold" data-hotkey="Ctrl+B"><span class="glyphicon glyphicon-bold"></span> </button><button class="btn-default btn-sm btn" type="button" title="Italic" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdItalic" data-hotkey="Ctrl+I"><span class="glyphicon glyphicon-italic"></span> </button><button class="btn-default btn-sm btn" type="button" title="Heading" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdHeading" data-hotkey="Ctrl+H"><span class="glyphicon glyphicon-header"></span> </button></div><div class="btn-group"><button class="btn-default btn-sm btn" type="button" title="URL/Link" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdUrl" data-hotkey="Ctrl+L"><span class="glyphicon glyphicon-link"></span> </button><button class="btn-default btn-sm btn" type="button" title="Image" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdImage" data-hotkey="Ctrl+G"><span class="glyphicon glyphicon-picture"></span> </button></div><div class="btn-group"><button class="btn-default btn-sm btn" type="button" title="Unordered List" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdList" data-hotkey="Ctrl+U"><span class="glyphicon glyphicon-list"></span> </button><button class="btn-default btn-sm btn" type="button" title="Ordered List" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdListO" data-hotkey="Ctrl+O"><span class="glyphicon glyphicon-th-list"></span> </button><button class="btn-default btn-sm btn" type="button" title="Code" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdCode" data-hotkey="Ctrl+K"><span class="glyphicon glyphicon-asterisk"></span> </button><button class="btn-default btn-sm btn" type="button" title="Quote" tabindex="-1" data-provider="bootstrap-markdown" data-handler="bootstrap-markdown-cmdQuote" data-hotkey="Ctrl+Q"><span class="glyphicon glyphicon-comment"></span> </div><div class="md-controls"><a class="md-control md-control-fullscreen" href="#"><span class="glyphicon glyphicon-fullscreen"></span></a></div></div>
                                                <textarea name="message" data-provide="markdown" rows="10" data-width="600" class="form-control md-input" required="" style="width: 600px; resize: none;"></textarea><div class="md-fullscreen-controls"><a href="#" class="exit-fullscreen" title="Exit fullscreen"><span class="glyphicon glyphicon-fullscreen"></span></a></div></div>
                                          </div>
                                      </div>
                                      <div class="form-action">
                                          <button class="btn btn-primary">Submit</button>
                                        </div>
                                                                          </div>
                                  <!--// <meta http-equiv="refresh" content="10;url=forum_answers.php" />-->

                              </form>

                          </div><br>
</div>
</div>
<div class="col-sm-4">
  <div class="panel panel-default magic-element isotope-item">
            <div class="panel-body-heading edituser_panel">
              <h4 style="padding:5px">More Questions</h4>
            </div>
              <div class="table table-responsive">
              <table class="table table-striped">
                <tbody>
                    <tr>
                      <td>
<a href="#"  target="_blank" style="color:#46A6EA;">
<h5>How many members can participate in one event?</h5></a>
</td></tr>
<tr>
  <td>
<a href="#"  target="_blank" style="color:#46A6EA;">
<h5>how many swim styles are practised?</h5></a>
</td>
</tr>
<tr>
  <td>
<a href="#"  target="_blank" style="color:#46A6EA;">
<h5>address for jn venue?</h5></a>
</td>
</tr>
<tr>
  <td>
<a href="#"  target="_blank" style="color:#46A6EA;">
<h5>age below 10 are allowed?</h5></a>
</td>
</tr>
<tr>
  <td>
<a href="#"  target="_blank" style="color:#46A6EA;">
<h5>Do any one participate in other events in parallel?</h5></a>
</td>
</tr>
</tbody>
</table>
  </div>
  <center>
   <a href="{{url('questions')}}"> <button class="btn btn-primary">View More</button></a>
  </center><br>
</div>
<div class="panel panel-default magic-element isotope-item">
          <div class="panel-body-heading edituser_panel">
            <h4 style="padding:5px">Categories</h4>
          </div>
            <div class="table table-responsive">
            <table class="table table-striped">
              <tbody>
                @foreach($topics as $topic)
                  <tr>
                    <td>
<a href="#"  target="_blank" style="color:#46A6EA;">
<h5>{{$topic->Topic}}</h5></a>
</td></tr>

@endforeach
</tbody>
</table>
</div>
<center>
  <button class="btn btn-primary">View More</button>
</center><br>
</div>
</div>
</div>

</div>
</div>
</section>
</section>
  </section>
</div>
</div>
</div>
</section>
</div>
@endsection