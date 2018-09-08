@extends('layouts.main')
@section('content')
 <!-- social Communication code starts here -->
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
                                      <h4 class="pb-title" style="padding:5px">Post News</h4>
                                       </div>
                                      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModals" style="margin-right: 10px;"><i class="fa fa-plus"></i> Add</button>
   <div class="modal fade" id="myModals" role="dialog">
   <div class="modal-dialog">
 <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title"></h4>
       </div>
       <div class="modal-body" style="padding:20px">
         <form class="form-horizontal" method="post" action="{{ url('postnews') }}" id="addform" enctype="multipart/form-data">
          {{csrf_field()}}
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt" style="color:#333">Subject:</label>
             <div class="col-sm-6">
              
               <input type="text" class="form-control" name="subject" required>
               <span style="color: red;display: none">sdfsdf</span>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt" style="color:#333">Publish Date:</label>
             <div class="col-sm-6">
               <input type="date" class="form-control" name="publish_date"  required>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt" style="color:#333">Expire Date:</label>
             <div class="col-sm-6">
               <input type="date" class="form-control" name="expire_date"  required>
             </div>
           </div>
           <div class="form-group">
      <label for="sel" class="control-label col-sm-4" style="color:#333">Post Type:</label>
       <div class="col-sm-6">
      <select class="form-control" name="post_type" required>
        <option value="News">News</option>
        <option value="Advertisement">Advertisement</option>
      </select>
    </div>
  </div>
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt"  style="color:#333">Description:</label>
             <div class="col-sm-6">
               <textarea type="text" class="form-control" name="description" required></textarea>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt" style="color:#333">Website Link:</label>
             <div class="col-sm-6">
               <input type="url" class="form-control" name="link" required>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4" for="fle" style="color:#333">Image:</label>
             <div class="col-sm-6">
               <input type="file" class="form-control" name="image"  required>
             </div>
           </div>
         
         <center><button class="btn btn-primary" type="reset">Cancel</button>
            <button class="btn btn-primary">Save & Continue</button></center>
            </form>
            
       </div>
     </div>
   </div>
   </div>                     <div class="panel-body">
                                      <h4 style="color:#46A6EA;">My list</h4>
														<hr style="margin-top:0">

												<form>
                          @if(count($news)>0)
													
												<div class="row">
                          <table class="col-xs-12 col-sm-12">
                              <tr>
                                <th class="col-md-2">Subject</th>
                                <th class="col-md-2">Start Date</th>
                                <th class="col-md-2">Expire Date</th>
                                <th class="col-md-2">Description</th>
                                <th class="col-md-2">Status</th>
                                <th class="col-md-2">AdvertisementType</th>
                              </tr>
                              @foreach($news as $new)
                              <tr>
                                <td class="col-md-2" >{{$new->Subject}}</td>
                                <td class="col-md-2">{{$new->PublishDate}}</td>
                                <td class="col-md-2">{{$new->ExpireDate}}</td>
                                <td class="col-md-2">{{$new->Message}}</td>
                                <td class="col-md-2">{{$new->Status}}</td>
                                <td class="col-md-2">{{$new->AdvertisementType}}</td>
                                <td class="col-md-2"><i class="fa fa-edit" data-toggle="modal" data-target="#myModal" title="edit" onclick="editnews('{{$new->AdvertisementId}}','{{$new->Message}}','{{$new->Subject}}','{{$new->PublishDate}}','{{$new->ExpireDate}}','{{$new->Status}}','{{$new->AdvertisementType}}','{{$new->Url}}')" style="color:#46A6EA;font-size:18px"></i>
                                 <a href="#myModl" data-toggle="modal">
   <i class="fa fa-trash"  title="delete" style="color: #ff6600;font-size:18px"></i></a>  </td>
                              </tr>
                              @endforeach
                            </table><br>
													
                                                            <div class="col-md-2">
                                                            
                                                            </div>
                                                            <div class="col-md-2">
                                                            	<div class="bs-example">
    <!-- Button HTML (to Trigger Modal) -->
   

    <!-- Modal HTML -->
    <div id="myModl" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><br>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="margin-left: 10px;">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p style="margin-left: 10px;">Do you want to Delete the News/Advertisement?</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="deletenews('{{$new->AdvertisementId}}','{{url('deletenews/'.$new->AdvertisementId)}}')">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
                                                            </div>
                                                        </div>
                                                     </div>

<div class="row">
                        <center><ul class="pagination">
                          {{$news->links()}}
                        </ul></center>
                      </div>
										</div>
										 
                    @else
                    <h4>No News/Advertisements</h4>
                    @endif
												</form>
								              
										

										        </div>
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
         <form class="form-horizontal" method="post" action="{{ url('postnews') }}" id="addform" enctype="multipart/form-data">
         	{{csrf_field()}}
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt" style="color:#333">Subject:</label>
             <div class="col-sm-6">
             	<input type="hidden" name="news_id" id="news_id">
               <input type="text" class="form-control" name="subject" id="subject" required>
               <span style="color: red;display: none">sdfsdf</span>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt" style="color:#333">Publish Date:</label>
             <div class="col-sm-6">
               <input type="date" class="form-control" name="publish_date" id="publisheddate" required>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt" style="color:#333">Expire Date:</label>
             <div class="col-sm-6">
               <input type="date" class="form-control" name="expire_date" id="expireddate" required>
             </div>
           </div>
           <div class="form-group">
      <label for="sel" class="control-label col-sm-4" style="color:#333">Post Type:</label>
       <div class="col-sm-6">
      <select class="form-control" name="post_type" required>
        <option value="News">News</option>
        <option value="Advertisement">Advertisement</option>
      </select>
    </div>
  </div>
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt"  style="color:#333">Description:</label>
             <div class="col-sm-6">
               <textarea type="text" class="form-control" name="description" id="description" required></textarea>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-sm-4" for="txt" style="color:#333">Website Link:</label>
             <div class="col-sm-6">
               <input type="url" class="form-control" name="link" id="wesitelink" required>
             </div>
           </div>
           <!--<div class="form-group">
             <label class="control-label col-sm-4" for="fle" style="color:#333">Image:</label>
             <div class="col-sm-6">
               <input type="file" class="form-control" name="image"  required>
             </div>
           </div>-->
         
         <center>
            <button class="btn btn-primary">Save</button></center>
            </form>
            
       </div>
     </div>
   </div>
   </div>
 


  </div>
  <div class="panel-body">
  </div>
  </div>
  </div>
</section>
  </section>
  </section>
</div>
 <!-- social Communication code ends here -->
 <script type="text/javascript">
$(document).ready(function(){
    function alignModal(){
        var modalDialog = $(this).find(".modal-dialog");
        
        // Applying the top margin on modal dialog to align it vertically center
        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
    }
    // Align modal when it is displayed
    $(".modal").on("shown.bs.modal", alignModal);
    
    // Align modal when user resize the window
    $(window).on("resize", function(){
        $(".modal:visible").each(alignModal);
    });   
});
</script>
@endsection