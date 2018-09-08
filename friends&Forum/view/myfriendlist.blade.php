@extends('layouts.main')
@section('content')
  <!-- Friends List code starts here -->
   <div class="container" id="main-code">
   <section class="main" style="margin-top:20px">
     <div class="col-xs-12 col-sm-12">
      <ul class="nav nav-tabs preview_tabs">
      <li ><a href="{{url('friendlist')}}">All Users</a></li>
      <li class="active"><a href="{{url('/myfriend')}}">My Friends</a></li>
        </ul>
        <div class="tab-content tab_details">
         <div class="tab-pane fade in active" id="myfriends">
          <div class="panel panel-default magic-element isotope-item">
          <div class="panel-body">
           <div class="row">
            @if(count($friends)>0)
           @foreach($friends as $friend)
            <div class="col-xs-12 col-sm-4">
              <div class="panel friend">
                    <tr>
                      <td class="mns">
                        <span class="mash">
                          <div class=" col-xs-4 col-sm-3">
                          <img src="{{ url('public/images/sravan.jpeg') }}" class="img-rounded pull-left" height="60px" width="60px"/></div>
                         <span class="col-xs-4 col-sm-4 frnd_name">{{$friend->UserName}}</span>
                              <button class="btn btn-default pull-right frnd col-xs-4 col-sm-4" onclick="friends('{{url('addfriend/'.$friend->UserId)}}')"><i class="fa fa-star fav"></i> Friends</button>
                            </span></td>
                      </tr>
                    </div>
                  </div>
                  @endforeach
                </div>
               
                    <center><ul class="pagination">
               {{ $friends->links() }}
             </ul></center>
             @else
             <h4>Friends not Added</h4>
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