@extends('layouts.main')
@section('content')
@if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }}" style="margi-left:13px;">
    {!! session('message.content') !!}
    </div>
    @endif
  <!-- kin code starts here -->
    <div class="container">
        <h5 class="add_venue"><a href="{{url('addkin')}}"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Add Kin</h5>
  <div class="row" style="border:1px solid #eee">
      <div class="board">
        <div class="board-inner">
          <center><ul class="nav nav-tabs nav_info" id="myTab">
              <div class="liner"></div>
                <li class="active">
                  <a href="{{url('addkin')}}" class="tab-one" title="Kin Basic Details">
                    <span class="round-tabs">
                      <i class="fa fa-info"></i>
                    </span>
                   </a>
                 </li>
                   <li>
                     @foreach($participants as $participant)
                      <a href="{{url('editkincontact/'.$participant->ParticipantId)}}" class="tab-one" title="Emergency Contact">
                        <span class="round-tabs">
                          <i class="fa fa-phone"></i>
                        </span>
                     </a>
                    </li>
              </ul></center>
          </div>
          <div class="tab-content tab_details">
              <div class="tab-pane fade in active" id="kin_basicdetails">
               
                    <form class="form-horizontal" method="post" action="{{url('editkin/'.$participant->ParticipantId)}}" style="background:#fff;padding:35px">
                      {{csrf_field()}}
                        <div class="col-sm-12">
                          <div class="form-group">
                            <input type="hidden" value="{{$participant->ParticipantId}}">
                            <label class="control-label col-sm-4" for="txt">Kin Name:</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" id="txt" name="ParticipantName" value="{{$participant->ParticipantName}}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4" for="txt">Relation with User:</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" id="txt" name="Relationship" value="{{$participant->Relationship}}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4" for="dte">Date of birth:</label>
                            <div class="col-sm-4">
                              <input type="date" class="form-control" id="dte" onblur="getAge()" name="DateOfBirth" value="{{$participant->DateofBirth}}">
                            </div>
                           
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4" for="txt">Gender:</label>
                            <div class="col-sm-4">
                              @if($participant->Gender=="male")
                              <label class="radio-inline"><input type="radio" name="Gender" value="male" checked>Male</label>
                              <label class="radio-inline"><input type="radio" name="Gender" value="female">Female</label>
                              @else
                              <label class="radio-inline"><input type="radio" name="Gender" value="male">Male</label>
                              <label class="radio-inline"><input type="radio" name="Gender" value="female"  checked>Female</label>
                              @endif
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4" for="txt">Height:</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" id="txt" name="Height" value="{{$participant->Height}}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4" for="txt">Weight(kgs):</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" id="txt" name="Weight" value="{{$participant->Weight}}">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-4" for="txt">Is Disabled:</label>
                          <div class="col-sm-4">
                            @if($participant->IsDisabled=="yes")
                          <label class="radio-inline"><input type="radio" id="yes" name="IsDisabled" value="yes" checked>Yes</label>
                          <label class="radio-inline"><input type="radio" id="no" name="IsDisabled" value="no">No</label>
                          @else
                          <label class="radio-inline"><input type="radio" id="yes" name="IsDisabled" value="yes">Yes</label>
                          <label class="radio-inline"><input type="radio" id="no" name="IsDisabled" value="no" checked>No</label>
                          @endif
                          </div>
                          </div>

                          <div class="form-group" id="divdescription" style="display: none;">
                              <label class="control-label col-sm-4" for="txt">Disability Description:</label>
                              <div class="col-sm-4">
                       <textarea class="form-control" id="description" name="DisabilityDescription">{{$participant->DisabilityDescription}}</textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="txt">Special Requirements:</label>
                              <div class="col-sm-4">
                                <input type="text" class="form-control" id="txt" name="SpecialRequirements" value="{{$participant->SpecialRequirements}}">
                              </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="txt">Notes:</label>
                                <div class="col-sm-4">
                                  <textarea class="form-control" id="txt" name="Notes">{{$participant->Notes}}</textarea>
                                </div>
                              </div>
                              @endforeach
                              <center>
                                <a href="#">
                                  <button type="reset" class="btn btn-primary">Cancel</button>
                                </a>
                                 <a href="{{url('kincontact')}}">
                                   <button type="submit" class="btn btn-primary">Save</button>
                                 </a>
                                 <a href="#kin_contact" data-toggle="tab">
                                   <button class="btn btn-primary">Next</button><br><br>
                                 </a>
                              </div>
                            </form>
                          </div>
              </div>
          </div>
        </div>
      </div>
      <!-- kin code ends here -->
      @endsection