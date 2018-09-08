@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margin-left:13px;text-align:center ">
    {!! session('message.content') !!}
    </div>
    @endif
<div class="container">
  <h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Venue</h5>
      <div class="row" style="border:1px solid #eee">
             <div class="board">
                 <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                 <div class="board-inner  iconlist">
                 <ul class="nav nav-tabs nav_info" id="myTab">
                 <div class="liner"></div>
                  <li>
                  <a href="" class="tab-one" title="Venue Summary">
                   <span class="round-tabs">
                           <i class="fa fa-list"></i>
                   </span>
               </a></li>

               <li class="active"><a href="{{url('venuepool')}}" title="Pool Information">
                  <span class="round-tabs">
                      <i class="fa fa-info"></i>
                  </span>
        </a>
              </li>
              <li><a href=""  title="Address & Contact">
                  <span class="round-tabs">
                       <i class="fa fa-phone"></i>
                  </span> </a>
                  </li>

                  <li><a href="" title="Open hours & Facilities">
                      <span class="round-tabs">
                           <i class="fa fa-clock-o"></i>
                      </span>
                  </a></li>
                  <li><a href="" title="Web site & Social Links">
                      <span class="round-tabs">
                           <i class="fa fa-share-alt"></i>
                      </span>
                  </a></li>

                  <li><a href="" data-toggle="tab" title="Confirm Venue">
                      <span class="round-tabs">
                           <i class="fa fa-check"></i>
                      </span> </a>
                  </li>

                  </ul></div>
                   
                  <div class="tab-pane fade in active" id="venueinformation">
                    <form class="form-horizontal" style="background:#fff;" method="post" action="{{url('venuepool/'.$venue_id)}}">
                      {{csrf_field()}}
                      <div class="row">
                            <div class="form-group" id="field1">
                                  <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Pool Name:</label>
                                  <div class="col-xs-7 col-sm-6">
                                    <input type="text" class="form-control" id="pool-name" name="pool_name" pattern="([A-zÀ-ž\s]){5,25}" required>
                                    <span class="pool-error" style="color: red;display: none;">Pool Name should contain 5-25 characters</span>
                                  </div>
                                  <br><br>
                                </div>

                      <div class="form-group">
                          <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Pool Width:</label>
                          <div class="col-xs-4 col-sm-4">
                            <input type="text" class="form-control" id="pool-width" name="pool_width"  pattern="([0-9]){2,3}" required>
                            <span class="pool-width-error" style="color: red;display: none;">Pool Width should contain 2-3 Numeric Values</span>
                          </div>
                          <div class="col-xs-4 col-sm-2">
                            <select  class="form-control" id="sel" name="width_dimension">
                              <option>mt</option>
                              <option>cm</option>
                            </select>
                          </div>
                          <br>
                        </div>
                        <div class="form-group">
                            <label class="control-label  col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Pool Length:</label>
                            <div class="col-xs-4 col-sm-4">
                              <input type="text" class="form-control" id="pool-length" name="pool_length"  pattern="([0-9]){2,3}" required>
                              <span class="pool-length-error" style="color: red;display: none;">Pool Length should contain 2-3 Numeric Values</span>
                            </div>
                            <div class="col-xs-4 col-sm-2">
                              <select  class="form-control" id="sel" name="length_dimension">
                                <option>mt</option>
                                <option>cm</option>
                              </select>
                            </div>

                          </div>
                          <div class="form-group">
                              <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Shallow End:</label>
                              <div class="col-xs-4 col-sm-4">
                                <input type="text" class="form-control" id="shallow-end" name="shallow_end" pattern="([0-9]){2,3}" required>
                                <span class="shallow-end-error" style="color: red;display: none;">Shallow End should contain 2-3 Numeric Values</span>
                              </div>
                              <div class="col-xs-4 col-sm-2">
                                <select  class="form-control" id="sel" name="shallow_dimension">
                                  <option>mt</option>
                                  <option>cm</option>
                                </select>
                              </div>

                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Deep End:</label>
                                <div class="col-xs-4 col-sm-4">
                                  <input type="text" class="form-control" id="deep-end" name="deep_end" pattern="([0-9]){2,3}" required>
                                   <span class="deep-end-error" style="color: red;display: none;">Deep End should contain 2-3 Numeric Values</span>
                                </div>
                                <div class="col-xs-4 col-sm-2">
                                  <select  class="form-control" id="sel" name="deep_dimension">
                                    <option>mt</option>
                                    <option>cm</option>
                                  </select>
                                </div>

                              </div>
                              <div class="form-group">
                                  <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="txt">Pool Area:</label>
                                  <div class="col-xs-4 col-sm-4">
                                    <input type="text" class="form-control" id="pool-area" name="pool_area" pattern="([0-9]){2,5}" required>
                                    <span class="pool-area-error" style="color: red;display: none;">Pool Area should contain 2-5 Numeric Values</span>
                                  </div>
                                  <div class="col-xs-4 col-sm-2">
                                    <select  class="form-control" id="sel" name="area_dimension">
                                      <option>ft</option>
                                      <option>cm</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                         <label class="control-label col-xs-4 col-sm-offset-2 col-sm-2" for="description" required>Description:</label>
                         <div class="col-xs-7 col-sm-6">
                           <textarea class="form-control" id="txt" name="description"></textarea>
                         </div>
                       </div>
                                           </div><br>
                     
                      <div class="col-xs-offset-2 col-xs-10 col-sm-offset-6 col-sm-6">
                  
                             <button class="btn btn-primary add-pool">Save</button>
                             

                             </div>

                        </form>
                                </div>
                                </div>
                              </div>
  <div id="old_events">
                
                </div>
                            </div>
  <script>
$(document).ready(function() {
console.log('{{ url('getoldvenues/poolinfo/'.$venue_id) }}');
$.ajax({
    url: '{{ url('getoldvenues/poolinfo/'.$venue_id) }}',
    success: function(html) {
      if(html=="no") {
      } else {
        console.log(html);
        //$('#old_events').attr("src",html);
        $('#old_events').html(html);
      }
    },
    async:true
  });
              });
</script>                        

                              @endsection