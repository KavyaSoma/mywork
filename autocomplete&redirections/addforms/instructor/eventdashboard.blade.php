@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin:13px;text-align: center;">
    {!! session('message.content') !!}
    </div>
    @endif
 <!-- Dashboard code starts here -->
<div class="container" id="main-code">
  <section class="main" style="margin-top:20px">
    <div class="col-xs-12 col-sm-6">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default active col-md-12">
              <div class="panel-heading" style="margin-left:-15px;margin-right:-15px;background:#46A6EA;color:#fff"  role="tab" id="headingOne">
                  <h3 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <span class="glyphicon glyphicon-calendar"></span> 
                      Upcoming Events</a>
                  </h3>
              </div>
                <div id="collapseOne" class="panel-collapse collapse in"  role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body"  id="user_scroll">
                  <ul class="media-list">
                      <li class="media">
                          <div class="media-left">
                              <div class="panel panel-default text-center date">
                                  <div class="panel-heading month" style="background:#ff6600;color:#fff">
                                      <span class="panel-title strong">
                                          Mar
                                      </span>
                                  </div>
                                  <div class="panel-body day text-default" style="color:#46A6EA">
                                      23
                                  </div>
                              </div>
                          </div>
                          <div class="media-body">
                              <h4 class="media-heading">
                                  Swimming
                              </h4>
                              National Competitions
                            </div>
                          <div class="media-right">
                          <a href="#" class="icon-block"><i class="fa fa-edit" style="color:#ff6600" title="Edit"></i></a>
                              <p>
                          <a href="#" class="icon-block"><i class="fa fa-share-alt" style="color:  #46A6EA;"  title="Share"></i></a>
                              </p>
                          </div>
                      </li>
                      <li class="media">
                          <div class="media-left">
                              <div class="panel panel-default text-center date">
                                  <div class="panel-heading month" style="background:#ff6600;color:#fff">
                                      <span class="panel-title strong">
                                          Jan
                                      </span>
                                  </div>
                                  <div class="panel-body text-default day" style="color:#46A6EA">
                                      16
                                  </div>
                              </div>
                          </div>
                          <div class="media-body">
                              <h4 class="media-heading">
                                  Swimming
                              </h4>
                              National Competitions
                          </div>
                          <div class="media-right">
                          <a href="#" class="icon-block"><i class="fa fa-edit" style="color:#ff6600" title="Edit"></i></a>
                              <p>
                          <a href="#" class="icon-block"><i class="fa fa-share-alt" style="color:  #46A6EA;"  title="Share"></i></a>
                              </p>
                          </div>
                      </li>
                      <li class="media">
                          <div class="media-left">
                              <div class="panel panel-default text-center date">
                                  <div class="panel-heading month" style="background:#ff6600;color:#fff">
                                      <span class="panel-title strong all-caps">
                                          Dec
                                      </span>
                                  </div>
                                  <div class="panel-body text-default day" style="color:#46A6EA">
                                      8
                                  </div>
                              </div>
                          </div>
                          <div class="media-body">
                              <h4 class="media-heading">
                                  Swimming
                              </h4>
                              National Competitions
                            </div>
                          <div class="media-right">
                          <a href="#" class="icon-block"><i class="fa fa-edit" style="color:#ff6600" title="Edit"></i></a>
                              <p>
                          <a href="#" class="icon-block"><i class="fa fa-share-alt" style="color:  #46A6EA;"  title="Share"></i></a>
                              </p>
                          </div>
                      </li>
                  </ul>

              </div>
          </div>
          <!-- End fluid width widget -->
  </div>
  <div class="panel panel-default col-xs-12 col-sm-12">
        <div class="panel-heading" style="margin-left:-15px;margin-right:-15px;background:#46A6EA;color:#fff"  role="tab" id="headingTwo">
            <h3 class="panel-title">  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
  <span class="glyphicon glyphicon-calendar"></span> 
                Completed Events</a>
            </h3>
        </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body"  id="user_scroll">
            <ul class="media-list">
                <li class="media">
                    <div class="media-left">
                        <div class="panel panel-default text-center date">
                            <div class="panel-heading month"  style="background:#ff6600;color:#fff">
                                <span class="panel-title strong">
                                    Mar
                                </span>
                            </div>
                            <div class="panel-body day text-default" style="color:#46A6EA">
                                23
                            </div>
                        </div>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            Swimming
                        </h4>
                        National Competitions

                    </div>
                    <div class="media-right">
                    <a href="#" class="icon-block"><i class="fa fa-edit" style="color:#ff6600" title="Edit"></i></a>
                        <p>
                    <a href="#" class="icon-block"><i class="fa fa-share-alt" style="color:  #46A6EA;"  title="Share"></i></a>
                        </p>
                    </div>
                </li>
                <li class="media">
                    <div class="media-left">
                        <div class="panel panel-default text-center date">
                            <div class="panel-heading month"  style="background:#ff6600;color:#fff">
                                <span class="panel-title strong">
                                    Jan
                                </span>
                            </div>
                            <div class="panel-body text-default day" style="color:#46A6EA">
                                16
                            </div>
                        </div>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            Swimming
                        </h4>
                        National Competitions
                      </div>
                    <div class="media-right">
                    <a href="#" class="icon-block"><i class="fa fa-edit" style="color:#ff6600" title="Edit"></i></a>
                        <p>
                    <a href="#" class="icon-block"><i class="fa fa-share-alt" style="color:  #46A6EA;"  title="Share"></i></a>
                        </p>
                    </div>
                </li>
                <li class="media">
                    <div class="media-left">
                        <div class="panel panel-default text-center date">
                            <div class="panel-heading month"  style="background:#ff6600;color:#fff">
                                <span class="panel-title strong all-caps">
                                    Dec
                                </span>
                            </div>
                            <div class="panel-body text-default day" style="color:#46A6EA">
                                8
                            </div>
                        </div>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            Swimming
                        </h4>
                        National Competitions
                    </div>
                    <div class="media-right">
                    <a href="#" class="icon-block"><i class="fa fa-edit" style="color:#ff6600" title="Edit"></i></a>
                        <p>
                    <a href="#" class="icon-block"><i class="fa fa-share-alt" style="color:  #46A6EA;"  title="Share"></i></a>
                        </p>
                    </div>
                </li>
            </ul>

        </div>
    </div>
    <!-- End fluid width widget -->
  </div>
  </div>
  </div>
<div class="col-xs-12 col-sm-6">
  <!-- /panel -->
<div class="panel panel-default magic-element isotope-item" style="margin-top:11px;">
  <div class="panel-body-heading" style="background: #46A6EA;margin-top:-20px;color:#fff">
    <h4 class="pb-title"style="padding:5px">My Events</h4>
  </div>
  <div class="panel-body">
    <div class="table table-responsive" id="user_scroll">
    <table class="table table-striped">
    <thead>
      <tr>
        <th>Event Name</th>
        <th>Schedule</th>
        <th>Subscribed</th>
        <th>View</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Backstroke</td>
        <td>26-Apr-2018</td>
        <td>26-Feb-2018</td>
        <td><button class="btn btn-primary view_btn">View</button></td>
      </tr>
      <tr>
        <td>Freestyle</td>
        <td>2-May-2018</td>
        <td>21-Mar-2018</td>
        <td><button class="btn btn-primary  view_btn">View</button></td>
      </tr>
      <tr>
        <td>Sppedo Pro Swimmers</td>
        <td>21-May-2018</td>
        <td>10-Apr-2018</td>
        <td><button class="btn btn-primary  view_btn">View</button></td>
      </tr>
      <tr>
        <td>Butterfly</td>
        <td>03-June-2018</td>
        <td>13-Apr-2018</td>
        <td><button class="btn btn-primary  view_btn">View</button></td>
      </tr>
      <tr>
        <td>Backstroke</td>
        <td>26-Apr-2018</td>
        <td>26-Feb-2018</td>
        <td><button class="btn btn-primary view_btn">View</button></td>
      </tr>
      <tr>
        <td>Butterfly</td>
        <td>03-June-2018</td>
        <td>13-Apr-2018</td>
        <td><button class="btn btn-primary  view_btn">View</button></td>
      </tr>
    </tbody>
  </table>
</div>

</div>
  </div>
</div>
<div class="col-xs-12 col-sm-6">
                          <!-- /panel -->
                          <div class="panel panel-default magic-element isotope-item">
                                <div class="panel-body-heading" style="background: #46A6EA;margin-top:-20px;color:#fff">
                                    <h4 class="pb-title"style="padding:5px">Notifications</h4>
                                </div>
                          <div class="panel-body">
                            <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">150 M</a></li>
    <li><a data-toggle="tab" href="#menu1">50 M</a></li>
    <li><a data-toggle="tab" href="#menu2">30 M</a></li>

  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">

      <p><div class="table table-responsive" id="user_scroll">
                                  <table class="table table-striped">
        <thead>
          <tr>
            <th>Kin Name</th>
            <th>Time</th>
            <th>Swim Type</th>
            <th>View / Edit</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Rohith</td>
            <td>260 Sec</td>
            <td>freestyle</td>
            <td><button class="btn btn-primary view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Ashritha</td>
            <td>150 Sec</td>
            <td>backstroke</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Reva</td>
            <td>200 Sec</td>
            <td>freestyle</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Varchas</td>
            <td>230 Sec</td>
            <td>butterfly</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
            <tr>
              <td>Divya</td>
              <td>200 Sec</td>
              <td>freestyle</td>
            <td><button class="btn btn-primary view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Rudransh</td>
            <td>170 Sec</td>
            <td>butterfly</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
        </tbody>
      </table>
    </div></p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <p><div class="table table-responsive" id="user_scroll">
                                  <table class="table table-striped">
        <thead>
          <tr>
            <th>Kin Name</th>
            <th>Time</th>
            <th>Swim Type</th>
            <th>View / Edit</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Rohith</td>
            <td>260 Sec</td>
            <td>freestyle</td>
            <td><button class="btn btn-primary view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Ashritha</td>
            <td>150 Sec</td>
            <td>backstroke</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Reva</td>
            <td>200 Sec</td>
            <td>freestyle</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Varchas</td>
            <td>230 Sec</td>
            <td>butterfly</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
            <tr>
              <td>Divya</td>
              <td>200 Sec</td>
              <td>freestyle</td>
            <td><button class="btn btn-primary view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Rudransh</td>
            <td>170 Sec</td>
            <td>butterfly</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
        </tbody>
      </table>
    </div></p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <p><div class="table table-responsive" id="user_scroll">
                                  <table class="table table-striped">
        <thead>
          <tr>
            <th>Kin Name</th>
            <th>Time</th>
            <th>Swim Type</th>
            <th>View / Edit</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Rohith</td>
            <td>260 Sec</td>
            <td>freestyle</td>
            <td><button class="btn btn-primary view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Ashritha</td>
            <td>150 Sec</td>
            <td>backstroke</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Reva</td>
            <td>200 Sec</td>
            <td>freestyle</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Varchas</td>
            <td>230 Sec</td>
            <td>butterfly</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
            <tr>
              <td>Divya</td>
              <td>200 Sec</td>
              <td>freestyle</td>
            <td><button class="btn btn-primary view_btn">Edit</button></td>
          </tr>
          <tr>
            <td>Rudransh</td>
            <td>170 Sec</td>
            <td>butterfly</td>
            <td><button class="btn btn-primary  view_btn">Edit</button></td>
          </tr>
        </tbody>
      </table>
    </div></p>
    </div>

  </div>
</div>
  </div>
</div>
<div class="col-xs-12 col-sm-6">

    <div class="panel panel-default magic-element isotope-item">
          <div class="panel-body-heading" style="background: #46A6EA;margin-top:-20px;color:#fff">
              <h4 class="pb-title"style="padding:5px">Invitation</h4>
          </div>
    <div class="panel-body">
  <dd class="percentage percentage-11"><span class="text">Event 1</span></dd>
  <dd class="percentage percentage-49"><span class="text">Event 2</span></dd>
  <dd class="percentage percentage-16"><span class="text">Event 3</span></dd>
  <dd class="percentage percentage-5"><span class="text">Event 4</span></dd>
  <dd class="percentage percentage-2"><span class="text">Event 5</span></dd>
  <dd class="percentage percentage-2"><span class="text">Event 6</span></dd>
</dl>


</div>
</div>
</div>

<div class="col-xs-12 col-sm-6">
                          <!-- /panel -->
                          <div class="panel panel-default magic-element isotope-item">
                                <div class="panel-body-heading" style="background: #46A6EA;margin-top:-20px;color:#fff">
                                    <h4 class="pb-title"style="padding:5px">Flagged</h4>
                                </div>
                          <div class="panel-body">
                            <div class="table table-responsive" id="user_scroll">
                              <table class="table table-striped">
    <thead>
      <tr>
        <th>Kin Name-Instructor</th>
        <th>Stroke speed</th>
      <th>View</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Reva-Vamshi</td>
        <td>40 SPM</td>
        <td><button class="btn btn-primary view_btn">View</button></td>
      </tr>
      <tr>
        <td>Rudransh-Shashi</td>
        <td>20 SPM</td>
        <td><button class="btn btn-primary  view_btn">View</button></td>
      </tr>
      <tr>
        <td>Varchas-Vamshi</td>
        <td>10 SPM</td>
        <td><button class="btn btn-primary  view_btn">View</button></td>
      </tr>
      <tr>
        <td>Advith-Vamshi</td>
        <td>50 SPM</td>
        <td><button class="btn btn-primary  view_btn">View</button></td>
      </tr>
        <tr>
        <td>Ashritha-Dilip</td>
        <td>30 SPM</td>
        <td><button class="btn btn-primary view_btn">View</button></td>
      </tr>
      <tr>
        <td>Ishan-Dilip</td>
        <td>10 SPM</td>
        <td><button class="btn btn-primary  view_btn">View</button></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
  </div>
</div>
</div>
<!-- /panel -->
</div>
<!-- Dash board code ends here -->
 @endsection
