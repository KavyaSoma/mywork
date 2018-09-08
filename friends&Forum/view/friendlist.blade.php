@extends('layouts.main')
@section('content')
  <!-- Friends List code starts here -->
   <div class="container" id="main-code">
   <section class="main" style="margin-top:20px">
     <div class="col-xs-12 col-sm-12">
      <ul class="nav nav-tabs preview_tabs">
      <li class="active"><a href="{{url('friendlist')}}" >All Users</a></li>
      <li><a href="{{url('myfriendlist')}}">My Friends</a></li>
        </ul>
        <div class="tab-content tab_details">
       <div class="tab-pane fade in active" id="allfriends">
       <div class="panel panel-default magic-element isotope-item">
          <div class="panel-body">

            <form method="post" action="{{url('friendlist')}}">
              {{csrf_field()}}
            <input type="text" class="form-control" name="search" placeholder="Search.."><br>
            <input type="submit" name="submit" style="display: none">
          </form>
            <div class="row">
               @if(count($allusers)>0)
              @foreach($allusers as $user)
            <div class="col-xs-12 col-sm-4">
              <div class="panel friend">
                    <tr>
                      <td class="mns">
                        <span class="mash">
                          <div class=" col-xs-4 col-sm-3">
                          <img src="{{ url('public/images/sravan.jpeg') }}" class="img-rounded pull-left" height="60px" width="60px"/></div>
                         <span class="col-xs-4 col-sm-4 frnd_name">{{$user->UserName}}</span>
                              <button class="btn btn-primary pull-right frnd col-xs-4 col-sm-4" onclick="addfriend('{{url('addfriend/'.$user->UserId)}}')">+Add Friends</button>
                            </span></td>
                      </tr>
                    </div>
                  </div>
                   @endforeach
                    </div>
                 
                 
                 
                   <center><ul class="pagination">
               {{ $allusers->links() }}
             </ul></center>
             @else
             <h4>No results Found</h4>
             @endif
              </div>
            </div>
          </div>
         </div>
         </div>            
</div>
</div>
</section>
</div>


<!--Friends List code ends here -->
@endsection