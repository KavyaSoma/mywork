<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use session;
use PDOConnection;
use Mail;

class EventController extends Controller
{
    public function events(Request $request) {
        
    $events = DB::table('events')
        ->selectRaw('*, events.EventId,events.EventName,events.ShortName')
              ->join('eventschedules', 'eventschedules.EventId', '=', 'events.EventId')
              ->where('eventschedules.isScheduled',['Y'])
              ->where('events.privacy',['public'])
              ->where('events.IsDeleted',['no'])
              ->orderBy('events.CreatedDate')
              ->paginate(12);
    return view('events',['events'=>$events,'show_count'=>'yes']);
    }
    public function myEvents(Request $request) {
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
            $myevents = DB::select('select events.EventId,events.EventName,eventschedules.StartDateTime from events INNER JOIN eventschedules where events.CreatedBy=? and eventschedules.EventId=events.EventId',[$userid]);
             $subscribeinvites = DB::select('select users.UserName,users.Image,users.UserType, eventsubscriptions.UserId,eventsubscriptions.EventId,eventsubscriptions.Status FROM users INNER JOIN eventsubscriptions ON users.UserId = eventsubscriptions.UserId WHERE eventsubscriptions.Status = "pending"');
             $completedrequests = DB::select('select users.UserName,users.Image,users.UserType, eventsubscriptions.UserId,eventsubscriptions.EventId,eventsubscriptions.Status FROM users INNER JOIN eventsubscriptions ON users.UserId = eventsubscriptions.UserId WHERE eventsubscriptions.Status = "accepted" or eventsubscriptions.Status ="rejected"');
             $flagevents = DB::select('select events.EventId,events.ShortName,events.EventName,eventschedules.StartDateTime,eventschedules.EndDateTime,eventflag.EventId,eventflag.UserId From events,eventschedules,eventflag where events.EventId = eventschedules.EventId and eventschedules.EventId = eventflag.EventId and events.CreatedBy = ?',[$userid]); 
            $upcomingevents =  DB::select('select events.*, eventschedules.* FROM events JOIN eventschedules on (events.eventID = eventschedules.eventID AND eventschedules.StartDateTime > CURDATE()) and events.CreatedBy = ?',[$userid]);
             $todayevents =  DB::select('select events.EventId,events.ShortName,events.EventName,images.ImagePath,eventschedules.StartDateTime,eventschedules.EndDateTime From events,images,eventschedules where events.EventId = images.ReferenceId and images.ReferenceId = eventschedules.EventId and eventschedules.StartDateTime = CURRENT_DATE');
            $completedevents =  DB::select('select events.*, eventschedules.* FROM events JOIN eventschedules on (events.eventID = eventschedules.eventID AND eventschedules.StartDateTime < CURDATE()) and events.CreatedBy = ?',[$userid]);
                return view('eventsdashboard',['myevents' => $myevents,'eventinvites' => $subscribeinvites,'completedrequests' => $completedrequests,'upcomingevents' => $upcomingevents,'completedevents'=>$completedevents,'todayevents'=>$todayevents,'flags'=>$flagevents]);
        }
      else{
        $request->session()->flash('message.level','danger');
            $request->session()->flash('message.content','please login to continue...');
            return view('login');
      }
    }
    public function searchEvents(Request $request) {
    $event = $request->event;
    $events = DB::table('events')
        ->selectRaw('*, events.EventId,events.EventName,events.ShortName')
              ->join('eventschedules', 'eventschedules.EventId', '=', 'events.EventId')
              ->where('eventschedules.isScheduled',['Y'])
              ->where('events.privacy',['public'])
              ->where('events.IsDeleted',['no'])
              ->where('events.EventName','like','%'.strtolower($event).'%')
              ->orderBy('events.CreatedDate')
              ->paginate(12);
    return view('events',['events'=>$events,'show_count'=>'no','search_term'=>$event]);
  }
public function eventDetails(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->id;
            $user_id = $request->session()->get('user_id');
            $event_details = DB::select('select EventName,Description,Privacy,ShortName from events where EventId=?',[$event_id]);
            $sub_event = DB::select('select SubEventName,Swimstyle,Course,SpecialInstructions,AbleBodied,MinParticipants,MaxParticipants,MinimumAge,MaximumAge from subevents where EventId=?',[$event_id]);
            $contacts = DB::select('select b.ContactId,c.ContactId,c.FirstName,c.Phone,c.Email from bridgeeventcontact b INNER JOIN contacts c where EventId=? and CreatedBy=? and b.ContactId=c.ContactId',[$event_id,$user_id]);
            $clubs = DB::select('select c.ClubId,c.ClubName,c.MobilePhone,c.Email,c.Website from clubs c INNER JOIN bridgeeventclubs b where b.EventId=? and b.CreatedBy=? and c.ClubId=b.ClubId and c.CreatedBy=?',[$event_id,$user_id,$user_id]);
            $venues = DB::select('select a.AddressId,a.AddressLine1,a.City,a.PostCode,v.VenueId,v.VenueName from address as a inner join venue as v on v.AddressId=a.AddressId inner join bridgeeventvenues as b on b.VenueId = V.VenueId where b.EventId=? and b.CreatedBy=?',[$event_id,$user_id]);
            return view('eventspreview',['event_details'=>$event_details,'sub_event'=>$sub_event,'contacts'=>$contacts,'clubs'=>$clubs,'venues'=>$venues,'event_id'=>$event_id]);
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
public function ViewAllEvents(Request $request){
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
            $events = DB::table('events')
        ->selectRaw('*, events.EventId,EventName,events.Description,events.Privacy,events.ShortName')
        ->paginate(10);
      $users = DB::select('select UserId from Users Where UserId =?',[$userid]);
        
           return view('viewallevents',['events' => $events,'users' => $users]);    
        
        }
        else{
            $request->session()->flash('message.level','danger');
            $request->session()->flash('message.content','please login to continue...');
            return view('login');
        }
    }

    

    public function eventBasic(Request $request){
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
            $events = DB::select('select * from events where ShortName = ?',[$request->shortname]);
            $eventid = $events[0]->EventId;
            $subscribestatus = DB::select('select * from eventsubscriptions where UserId = ? and EventId=?',[$userid,$eventid]);
         return view('event',['events' => $events,'eventsubscriptions'=>$subscribestatus,'flag'=>'']);
        }
        else{
            $request->session()->flash('message,level','danger');
            $request->session()->flash('message.content','Please login to continue...');
            return view('login');
        }
    }

      public function viewsubEvent(Request $request){
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
          $events = DB::select('select * from events where ShortName=?',[$request->shortname]);
           $eventid = $events[0]->EventId;
            $subevents = DB::select('select SubEventName,SwimStyle,Course,SpecialInstructions,AbleBodied,MinParticipants,MaxParticipants,MinimumAge,MaximumAge from subevents where EventId=?',[$eventid]);
            $subscribestatus = DB::select('select * from eventsubscriptions where UserId = ? and EventId=?',[$userid,$eventid]);

            return view('viewsubevent',['events' => $events,'subevents' => $subevents,'eventsubscriptions'=>$subscribestatus]);
        }
        else{
            $request->session()->flash('message.level','danger');
            $request->session()->flash('message.content','please login to continue...');
            return view('login');
        }
      }

      public function vieweventSchedule(Request $request){
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
         $events = DB::select('select * from events where ShortName=?',[$request->shortname]);
         $eventid = $events[0]->EventId;
         $subscribestatus = DB::select('select * from eventsubscriptions where UserId = ? and EventId=?',[$userid,$eventid]);
               $date=date("Y-m-d");
          $upcomingevents =  DB::table('events')
        ->selectRaw('*, events.EventId,EventName,events.Description')
              ->join('eventschedules', 'events.EventId', '=', 'eventschedules.EventId')
              ->where('eventschedules.StartDateTime', '>', $date)
              ->paginate(2);
              
          $completedevents =  DB::table('events')
        ->selectRaw('*, events.EventId,EventName,events.Description')
              ->join('eventschedules', 'events.EventId', '=', 'eventschedules.EventId')
              ->where('eventschedules.StartDateTime', '<', $date)
              ->paginate(2);
              
            return view('viewschedule',['events' => $events,'eventsubscriptions'=>$subscribestatus,'upcomingevents' => $upcomingevents,'completedevents' => $completedevents]);
        }
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','please login to continue...');
        return view('login');
      }

      public function vieweventContact(Request $request){
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
       $events = DB::select('select * from events where ShortName=?',[$request->shortname]);  
       $eventid = $events[0]->EventId;
            $eventcontact = DB::select('select *,EventId from clubs inner join bridgeeventclubs as b on b.ClubId = clubs.ClubId where b.EventId=?',[$eventid]);
          $subscribestatus = DB::select('select * from eventsubscriptions where UserId = ? and EventId=?',[$userid,$eventid]);

            return view('eventcontact',['events' => $events,'eventcontact' => $eventcontact,'eventsubscriptions'=>$subscribestatus]);
        }
        else{
            $request->session()->flash('message.level','danger');
            $request->session()->flash('message.content','please login to continue...');
            return view('login');
        }
      }

      public function eventVenue(Request $request){
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
            $events = DB::select('select * from events where ShortName=?',[$request->shortname]);  
            $eventid = $events[0]->EventId;
             $eventvenue = DB::select('select a.AddressId,a.AddressLine1,a.AddressLine2,a.AddressLine3,a.City,a.PostCode,v.VenueId,v.VenueName from address as a inner join venue as v on v.AddressId=a.AddressId inner join bridgeeventvenues as b on b.VenueId = V.VenueId where b.EventId=?',[$eventid]);
          $subscribestatus = DB::select('select * from eventsubscriptions where UserId = ? and EventId=?',[$userid,$eventid]);
 
            return view('eventvenue',['events' => $events,'eventvenue' => $eventvenue,'eventsubscriptions'=>$subscribestatus]);
         }
         else{
            $request->session()->flash('message.level','danger');
            $request->session()->flash('message.content','please login to continue...');
            return view('login');
         }
      }

      public function subscribeEvent(Request $request){
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
           $events = DB::select('select * from events where ShortName=?',[$request->shortname]);  
        $eventid = $events[0]->EventId;
        $subscribestatus = DB::select('select * from eventsubscriptions where UserId = ? and EventId=?',[$userid,$eventid]);
        if(count($subscribestatus)){

            return view('event',['events'=>$events,'eventsubscriptions'=>$subscribestatus]);
        }
        else{
            $eventsubscribe = DB::insert('insert into eventsubscriptions(EventId,UserId,Status) values(?,?,?)',[$eventid,$userid,'pending']);
            if($eventsubscribe){
                return view('event',['events'=>$events,'eventsubscriptions'=>$subscribestatus]);
            }
        }
        }
        else{
            $request->session()->flash('message.level','danger');
            $request->session()->flash('message.content','please login to continue...');
            return view('login');
        }
      }

    public function EventDashboard(Request $request){
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
            $myevents = DB::select('select events.EventId,events.EventName,eventschedules.StartDateTime from events INNER JOIN eventschedules where events.CreatedBy=? and eventschedules.EventId=events.EventId',[$userid]);
             $subscribeinvites = DB::select('select users.UserName,users.Image,users.UserType, eventsubscriptions.UserId,eventsubscriptions.EventId,eventsubscriptions.Status FROM users INNER JOIN eventsubscriptions ON users.UserId = eventsubscriptions.UserId WHERE eventsubscriptions.Status = "pending"');
             $completedrequests = DB::select('select users.UserName,users.Image,users.UserType, eventsubscriptions.UserId,eventsubscriptions.EventId,eventsubscriptions.Status FROM users INNER JOIN eventsubscriptions ON users.UserId = eventsubscriptions.UserId WHERE eventsubscriptions.Status = "accepted" or eventsubscriptions.Status ="rejected"');
             $flagevents = DB::select('select events.EventId,events.ShortName,events.EventName,eventschedules.StartDateTime,eventschedules.EndDateTime,eventflag.EventId,eventflag.UserId From events,eventschedules,eventflag where events.EventId = eventschedules.EventId and eventschedules.EventId = eventflag.EventId and events.CreatedBy = ?',[$userid]); 
            $upcomingevents =  DB::select('select events.*, eventschedules.* FROM events JOIN eventschedules on (events.eventID = eventschedules.eventID AND eventschedules.StartDateTime > CURDATE()) and events.CreatedBy = ?',[$userid]);
             $todayevents =  DB::select('select events.EventId,events.ShortName,events.EventName,images.ImagePath,eventschedules.StartDateTime,eventschedules.EndDateTime From events,images,eventschedules where events.EventId = images.ReferenceId and images.ReferenceId = eventschedules.EventId and eventschedules.StartDateTime = CURRENT_DATE');
            $completedevents =  DB::select('select events.*, eventschedules.* FROM events JOIN eventschedules on (events.eventID = eventschedules.eventID AND eventschedules.StartDateTime < CURDATE()) and events.CreatedBy = ?',[$userid]);
                return view('eventsdashboard',['myevents' => $myevents,'eventinvites' => $subscribeinvites,'completedrequests' => $completedrequests,'upcomingevents' => $upcomingevents,'completedevents'=>$completedevents,'todayevents'=>$todayevents,'flags'=>$flagevents]);
        }
      else{
        $request->session()->flash('message.level','danger');
            $request->session()->flash('message.content','please login to continue...');
            return view('login');
      }
    }

      public function acceptEventRequest(Request $request){
        $userid = $request->session()->get('user_id');
        $acceptevent = DB::update('update eventsubscriptions set Status="accepted" where EventId = ?',[$request->id]);
        return redirect('myevents');
      }


    public function rejectEventRequest(Request $request){
       $userid = $request->session()->get('user_id');
       $acceptevent = DB::update('update eventsubscriptions set Status="rejected" where EventId = ?',[$request->id]);
       return redirect('myevents');
       
    }

    public function inviteParticipants(Request $request){
       if($request->session()->has('user_id')){
           $userid = $request->session()->get('user_id');
           $eventid = $request->eventid; 
           $search_term = '';
           if($request->has('search_term')) {
               $search_term = $request->search_term;
           }
           $events = DB::select('select events.EventId,events.EventName,eventschedules.StartDateTime from events INNER JOIN eventschedules where events.CreatedBy=? and eventschedules.EventId=events.EventId and events.EventId = ?',[$userid,$eventid]);
           if( count($events)>0 ) {
           if( $search_term == '') {
           $invite_friends = DB::table('participants')
                          ->selectRaw('*')
                          ->paginate(28);
           } else {
              $invite_friends = DB::table('participants')
                          ->selectRaw('*')
                          ->where('ParticipantName','like','%'.strtolower($search_term).'%')
                          ->paginate(28); 
           }
           $event_status = DB::select('select * from bridgeeventparticipants where EventId=? and CreatedBy=?',[$eventid,$userid]);
           return view('inviteparticipants',['events'=>$events,'participants'=>$invite_friends,'status'=>$event_status,'eventid'=>$eventid,'search_term'=>$search_term]);
       } else {
          $request->session()->flash('message.level','danger');
             $request->session()->flash('message.content','You tried to manage an Event which is not created by you...');
             return redirect('logout');  
       }
           
    }
       else{
             $request->session()->flash('message.level','danger');
           $request->session()->flash('message.content','please login to continue...');
           return view('login');
       }
   }
   
   public function manageParticipants(Request $request){
       if($request->session()->has('user_id')){
           $userid = $request->session()->get('user_id');
           $eventid = $request->eventid;
           $events = DB::select('select events.EventId,events.EventName,eventschedules.StartDateTime from events INNER JOIN eventschedules where events.CreatedBy=? and eventschedules.EventId=events.EventId and events.EventId = ?',[$userid,$eventid]);
           if(count($events)>0) {
           $event_status = DB::select('select * from bridgeeventparticipants where EventId=? and CreatedBy=?',[$eventid,$userid]);
           $manage_invites =  DB::table('bridgeeventparticipants')
       ->selectRaw('*')
             ->join('participants', 'participants.ParticipantId', '=', 'bridgeeventparticipants.ParticipantId')
             ->where('bridgeeventparticipants.EventId', $eventid)
             ->paginate(28);
           return view('manageparticipants',['events'=>$events,'manageinvites'=>$manage_invites,'status'=>$event_status,'eventid'=>$eventid]);
           } else {
             $request->session()->flash('message.level','danger');
             $request->session()->flash('message.content','You tried to manage an Event which is not created by you...');
             return redirect('logout');  
           }
       }
       else{
             $request->session()->flash('message.level','danger');
             $request->session()->flash('message.content','please login to continue...');
             return view('login');
       }
   }
    public function resultEntry(Request $request){
        if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
            return view('resultentry');
        }
        else{
            $request->session()->flash('message.level','danger');
            $request->session()->flash('message.content','please login to continue...');
            return view('login');
        }
    }
    public function editSchedule(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->event_id;
            $schedule_id = $request->schedule_id;
            $user_id = $request->session()->get('user_id');
            $schedule = DB::select('select SchedulerUIId,SubType,ScheduleType,StartTime,EndTime,StartDateTime,EndDateTime,WeekDay,RepeatNumber,RecurrenceNumber,Month from schedulerui where EventId=?',[$event_id]); 
            if(count($schedule)>0){
            $schedule_type = $schedule[0]->ScheduleType;
         //   $multiple_schedules = DB::select('select ')
            $Occurance = $schedule[0]->ScheduleType;
            $subtype = $schedule[0]->SubType;
            $recurring = DB::select('select StartDateTime,EndDateTime,StartTime,WeekDay,RepeatNumber from schedulerui where EventId=? and ScheduleType=?',[$event_id,'recuring']);
            return view('editscheduleevent',['event_id'=>$event_id,'event_details'=>$schedule,'occurance'=>$Occurance,'schedule_id'=>$schedule_id,'recuring'=>$recurring]);
            }
            else{
                $request->session()->flash('message.level', 'info');
                $request->session()->flash('message.content', 'Please Add Schedule to the event.');
                return view('scheduleevent',['event_id'=>$event_id]);
            }
        }
    } 
    public function saveEditSchedule(Request $request){
        $privacy = $request->privacy;
         $start_date = $request->start_date;
        $end_date = $request->end_date;
        $time = $request->time;
        $multiple_startdate = $request->multiple_startdate;
        $multiple_enddate = $request->multiple_enddate;
        $multiple_time = $request->multiple_time;
        $weekday = $request->weekday;
        $week_startdate = $request->week_startdate;
        $week_enddate = $request->week_enddate;
        $week_time = $request->week_time;

        $month_details = $request->month_details;
        $recuring_monthday = $request->recuring_monthday;
        $recure_monthday = $request->recure_monthday;
        $recuring_day = $request->recuring_day;
        $recure_month = $request->recure_month;
        $recur_month = $request->recur_month;
        $month_startdate = $request->month_startdate;
        $month_enddate = $request->month_enddate;
        $month_time = $request->month_time;

        $year = $request->year;
        $year_monthly_days = $request->year_monthly_days;
        $year_weekly_days = $request->year_weekly_days;
        $year_monthly = $request->year_monthly;
        $year_startdate = $request->year_startdate;
        $year_enddate = $request->year_enddate;
        $year_time = $request->year_time;
        $year_month_days = $request->year_month_days;
        $year_month = $request->year_month;
        $year_number = $request->year_number;
        $event_id  = $request->event_id;
        $user_id = $request->session()->get('user_id');
        if(($start_date == "") && ($end_date == "") && ($multiple_startdate == "") && ($multiple_enddate == "") && ($multiple_time == "")){          
            if(($weekday == "") && ($week_startdate == "") && ($week_enddate == "") && ($week_time == "")){
                if($month_details == ""){
                    if($year == ""){
                        $request->session()->flash('message.level', 'info');
                        $request->session()->flash('message.content', 'Event Schedule not Added.PleaseAdd Event Schedule..');
                        return view('scheduleevent',['event_id'=>$event_id]);
                    }
                    else{
                        if($year == "yearly"){
                        $get_schedulerid = DB::select('select SchedulerUIId from schedulerui where EventId=? and  SubType=? and CreatedBy=?',[$event_id,'year',$user_id]);
                        foreach($get_schedulerid as $scheduleid){
                            $delete_schedules = DB::delete('delete from eventschedules where SchedulerUIId=? and EventId=?',[$scheduleid->SchedulerUIId,$event_id]);
                            if($delete_schedules){
                               $delete_previous = DB::delete('delete from schedulerui where EventId=? and SubType=? and CreatedBy=?',[$event_id,'year',$user_id]);
                               $recuring_year = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $year_startdate, 'EndDate' => $year_enddate, 'SubType' => 'year', 'RecurrenceNumber' => $year_monthly_days, 'WeekDay' =>$year_weekly_days, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>$year_monthly, 'RepeatNumber'=>0, 'RepeatBy'=>$year_number, 'StartTime'=>$year_time, 'EndTime' =>$year_time,'CreatedBy'=>$user_id));
                        if($recuring_year){
                            DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                            $request->session()->flash('message.level', 'success');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence year added Successfully..');
                            return redirect('edit-scheduleevent/'.$event_id);
                        }
                        else{
                            $request->session()->flash('message.level', 'danger');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence year not added.Please, Try again.');
                          return redirect('edit-scheduleevent/'.$event_id);
                        }  
                            }
                            else{
                                $request->session()->flash('message.level', 'danger');
                                $request->session()->flash('message.content', 'Error updating Event Schedule.Please,try again..');
                                return redirect('edit-scheduleevent/'.$event_id);
                            }
                        }
                       
                        
                        
                        }
                        else{
                         $get_schedulerid = DB::select('select SchedulerUIId from schedulerui where EventId=? and  SubType=? and CreatedBy=?',[$event_id,'year',$user_id]);
                        foreach($get_schedulerid as $scheduleid){
                            $delete_schedules = DB::delete('delete from eventschedules where SchedulerUIId=? and EventId=?',[$scheduleid->SchedulerUIId,$event_id]);
                            if($delete_schedules){
                               $delete_previous = DB::delete('delete from schedulerui where EventId=? and SubType=? and CreatedBy=?',[$event_id,'year',$user_id]);
                               $recuring_year = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $year_startdate, 'EndDate' => $year_enddate, 'SubType' => 'year', 'RecurrenceNumber' => $year_monthly_days, 'WeekDay' =>$year_weekly_days, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>$year_monthly, 'RepeatNumber'=>0, 'RepeatBy'=>$year_number, 'StartTime'=>$year_time, 'EndTime' =>$year_time,'CreatedBy'=>$user_id));
                        if($recuring_year){
                            DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                            $request->session()->flash('message.level', 'success');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence year added Successfully..');
                            return redirect('edit-scheduleevent/'.$event_id);
                        }
                        else{
                            $request->session()->flash('message.level', 'danger');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence year not added.Please, Try again.');
                            return redirect('edit-scheduleevent/'.$event_id);
                        }  
                            }
                            else{
                                $request->session()->flash('message.level', 'danger');
                                $request->session()->flash('message.content', 'Error updating Event Schedule.Please,try again..');
                                return redirect('edit-scheduleevent/'.$event_id);
                            }
                        } 
                        }  
                    }
                }   
                else{
                    if($month_details == "monthly_day"){
                        $get_schedulerid = DB::select('select SchedulerUIId from schedulerui where EventId=? and  SubType=? and CreatedBy=?',[$event_id,'month',$user_id]);
                        if(count($get_schedulerid)>0){
                        foreach($get_schedulerid as $scheduleid){
                            $delete_schedules = DB::delete('delete from eventschedules where SchedulerUIId=? and EventId=?',[$scheduleid->SchedulerUIId,$event_id]);
                            if($delete_schedules){
                               $delete_previous = DB::delete('delete from schedulerui where EventId=? and SubType=? and CreatedBy=?',[$event_id,'month',$user_id]);
                        $week_day = $recuring_monthday." ".$recuring_day;
                        $recuring_month = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $month_startdate, 'EndDate' => $month_enddate, 'SubType' => 'month', 'RecurrenceNumber' =>$recuring_monthday, 'WeekDay' =>$recuring_day, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=> $week_day,'MonthNumber' =>0, 'Month'=>$recur_month, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$week_time, 'EndTime' =>$month_time,'CreatedBy'=>$user_id));
                        if($recuring_month){
                            DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                            $request->session()->flash('message.level', 'success');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence month added Successfully..');
                           return redirect('edit-scheduleevent/'.$event_id);
                        }
                        else{
                            $request->session()->flash('message.level', 'danger');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence month not added.Please, Try again.');
                            return redirect('edit-scheduleevent/'.$event_id);
                        }   
                        }
                        else{
                            $request->session()->flash('message.level', 'danger');
                            $request->session()->flash('message.content', 'Error updating Event Schedule.Please,try again..');
                            return redirect('edit-scheduleevent/'.$event_id);
                        } 
                        } 
                        }
                        else{
                        $week_day = $recuring_monthday." ".$recuring_day;
                        $recuring_month = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $month_startdate, 'EndDate' => $month_enddate, 'SubType' => 'month', 'RecurrenceNumber' =>$recuring_monthday, 'WeekDay' =>$recuring_day, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=> $week_day,'MonthNumber' =>0, 'Month'=>$recur_month, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$week_time, 'EndTime' =>$month_time,'CreatedBy'=>$user_id));
                        if($recuring_month){
                            DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                            $request->session()->flash('message.level', 'success');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence month added Successfully..');
                            return redirect('edit-scheduleevent/'.$event_id);
                        }
                        else{
                            $request->session()->flash('message.level', 'danger');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence month not added.Please, Try again.');
                            return redirect('edit-scheduleevent/'.$event_id);
                        }
                        }           
                    }
                    else{
                       $get_schedulerid = DB::select('select SchedulerUIId from schedulerui where EventId=? and  SubType=? and CreatedBy=?',[$event_id,'month',$user_id]);
                       if(count($get_schedulerid)>0){
                        foreach($get_schedulerid as $scheduleid){
                            $delete_schedules = DB::delete('delete from eventschedules where SchedulerUIId=? and EventId=?',[$scheduleid->SchedulerUIId,$event_id]);
                            if($delete_schedules){
                               $delete_previous = DB::delete('delete from schedulerui where EventId=? and SubType=? and CreatedBy=?',[$event_id,'month',$user_id]);
                        $week_day = $recuring_monthday." ".$recuring_day;
                        $recuring_month = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $month_startdate, 'EndDate' => $month_enddate, 'SubType' => 'month', 'RecurrenceNumber' =>$recuring_monthday, 'WeekDay' =>$recuring_day, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=> $week_day,'MonthNumber' =>0, 'Month'=>$recur_month, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$week_time, 'EndTime' =>$month_time,'CreatedBy'=>$user_id));
                        if($recuring_month){
                            DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                            $request->session()->flash('message.level', 'success');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence month added Successfully..');
                           return redirect('edit-scheduleevent/'.$event_id);
                        }
                        else{
                            $request->session()->flash('message.level', 'danger');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence month not added.Please, Try again.');
                            return redirect('edit-scheduleevent/'.$event_id);
                        }   
                        }
                        else{
                            $request->session()->flash('message.level', 'danger');
                            $request->session()->flash('message.content', 'Error updating Event Schedule.Please,try again..');
                           return redirect('edit-scheduleevent/'.$event_id);
                        }                 
                    }
                }
                else{
                     $week_day = $recuring_monthday." ".$recuring_day;
                    $recuring_month = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $month_startdate, 'EndDate' => $month_enddate, 'SubType' => 'month', 'RecurrenceNumber' =>$recuring_monthday, 'WeekDay' =>$recuring_day, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=> $week_day,'MonthNumber' =>0, 'Month'=>$recur_month, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$week_time, 'EndTime' =>$month_time,'CreatedBy'=>$user_id));
                    if($recuring_month){
                            DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                            $request->session()->flash('message.level', 'success');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence month added Successfully..');
                            return redirect('edit-scheduleevent/'.$event_id);
                    }
                    else{
                            $request->session()->flash('message.level', 'danger');
                            $request->session()->flash('message.content', 'Event Schedule for recurrence month not added.Please, Try again.');
                            return redirect('edit-scheduleevent/'.$event_id);
                    } 
                }
                }
                }
            }
            else{
                $get_schedulerid = DB::select('select SchedulerUIId from schedulerui where EventId=? and  SubType=? and CreatedBy=?',[$event_id,'week',$user_id]);
                 for($j=0;$j<count($get_schedulerid);$j++){
                   $delete_schedules = DB::delete('delete from eventschedules where SchedulerUIId=? and EventId=?',[$get_schedulerid[$j]->SchedulerUIId,$event_id]);
                   if($delete_schedules){
                   $delete_previous = DB::delete('delete from schedulerui where EventId=? and SubType=? and CreatedBy=?',[$event_id,'week',$user_id]);
               for($i=0;$i<count($weekday);$i++){
                $recuring_occuranace = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $week_startdate, 'EndDate' => $week_enddate, 'SubType' => 'week', 'RecurrenceNumber' => 0, 'WeekDay' =>$weekday[$i], 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>0, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$week_time, 'EndTime' =>$time,'CreatedBy'=>$user_id));
                }
                 if($recuring_occuranace){
                    DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS')); 
                    $request->session()->flash('message.level', 'success');
                    $request->session()->flash('message.content', 'Event Schedule for recurrence times added Successfully..');
                    return redirect('edit-scheduleevent/'.$event_id);
                }
                else{
                   $request->session()->flash('message.level', 'danger');
                    $request->session()->flash('message.content', 'Event Schedule for recurrence times not added.Please, Try again.');
                    return redirect('edit-scheduleevent/'.$event_id);
                } 
                }
                else{
                    $request->session()->flash('message.level', 'danger');
                    $request->session()->flash('message.content', 'Error updating Event Schedule.Please,try again..');
                    return redirect('edit-scheduleevent/'.$event_id);
                }
                }            
            }
        }
        else if(($multiple_startdate!="")&&($multiple_startdate!="")&&($multiple_time!="")){
             $get_schedulerid = DB::select('select SchedulerUIId from schedulerui where EventId=? and  SubType=? and CreatedBy=?',[$event_id,'NA',$user_id]);
                for($j=0;$j<count($get_schedulerid);$j++){
                   $delete_schedules = DB::delete('delete from eventschedules where SchedulerUIId=? and EventId=?',[$get_schedulerid[$i]->SchedulerUIId,$event_id]);
                   if($delete_schedules){
                   $delete_previous = DB::delete('delete from schedulerui where EventId=? and SubType=? and CreatedBy=?',[$event_id,'NA',$user_id]);
                        for($i = 0; $i < count($multiple_startdate); $i++){
                $multiple_occurence = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'MULTIPLE', 'StartDate' => $multiple_startdate[$i], 'EndDate' => $multiple_enddate[$i], 'SubType' => 'NA', 'RecurrenceNumber' => 0, 'WeekDay' =>'NA', 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>0, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$multiple_time[$i], 'EndTime' =>$time,'CreatedBy'=>$user_id));
            }
                if($multiple_occurence){
                    DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                    $request->session()->flash('message.level', 'success');
                    $request->session()->flash('message.content', 'Event Schedule for multiple times added Successfully..');
                    return redirect('edit-scheduleevent/'.$event_id);
                }
                else{
                    $request->session()->flash('message.level', 'danger');
                    $request->session()->flash('message.content', 'Event Schedule for multiple times not added.Please, Try again.');
                    return redirect('edit-scheduleevent/'.$event_id);
                }
            }
            else{
                $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.content', 'Error updating Event Schedule.Please,try again..');
                return redirect('edit-scheduleevent/'.$event_id);
            }
            }
        }
        else{
            $get_schedulerid = DB::select('select SchedulerUIId from schedulerui where EventId=? and  SubType=? and CreatedBy=?',[$event_id,'NA',$user_id]);
            foreach($get_schedulerid as $scheduleid){
            $delete_schedules = DB::delete('delete from eventschedules where SchedulerUIId=? and EventId=?',[$scheduleid->SchedulerUIId,$event_id]);
            if($delete_schedules){
            $delete_previous = DB::delete('delete from schedulerui where EventId=? and SubType=? and CreatedBy=?',[$event_id,'NA',$user_id]);
            $single_occurence = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => $privacy, 'StartDate' => $start_date, 'EndDate' => $end_date, 'SubType' => 'NA', 'RecurrenceNumber' => 0, 'WeekDay' =>'NA', 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>0, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$time, 'EndTime' =>$time,'CreatedBy'=>$user_id));
            if($single_occurence){
                DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Event Schedule for One time added Successfully..');
                return redirect('edit-scheduleevent/'.$event_id);
            }
            else{
                $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.content', 'Event Schedule for One time not added.Please, Try again.');
                return redirect('edit-scheduleevent/'.$event_id);
            }
            }
            else{
                $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.content', 'Error updating Event Schedule.Please,try again..');
                return redirect('edit-scheduleevent/'.$event_id);
            }
        }
        }
    }
        
    public function flagEvent(Request $request){
       if($request->session()->has('user_id')){
            $userid = $request->session()->get('user_id');
         
          $events = DB::select('select * from events where ShortName=?',[$request->shortname]);  
          $eventid = $events[0]->EventId;
           $subscribestatus = DB::select('select * from eventsubscriptions where UserId = ? and EventId=?',[$userid,$eventid]);
          $flag_status = DB::select('select * from eventflag where UserId = ? and EventId = ?',[$userid,$eventid]);
          if(count($flag_status)>0){
       return view('event',['events'=>$events,'flag'=>$flag_status,'eventsubscriptions'=>$subscribestatus]);    
      }
          else{
           $eventflag = DB::insert('insert into eventflag(UserId,EventId,ScheduleId,Flag) values(?,?,?,?)',[$userid,$eventid,1,'y']);
           if($eventflag){

               return redirect('flagevent/'.$request->shortname);
           }
          }
       }
        else{
           $request->session()->flash('message.level','danger');
           $request->session()->flash('message.content','please login to continue...');
           return view('login');
        }
     }
     
     public function inviteFriends(Request $request){
       if($request->session()->has('user_id')){
           $userid = $request->session()->get('user_id');
            $participantid = $request->participantid;
           $events = DB::select('select events.EventId,events.EventName,eventschedules.StartDateTime from events INNER JOIN eventschedules where  eventschedules.EventId=events.EventId and events.EventId = ?',[$request->id]);
       $invite_friends = DB::table('participants')
                          ->selectRaw('*')
                          ->paginate(16);

      $event_status = DB::select('select * from bridgeeventparticipants where EventId=? and ParticipantId=? and CreatedBy=?',[$request->id,$participantid,$userid]);

           $manage_invites =  DB::table('bridgeeventparticipants')
       ->selectRaw('*')
             ->join('participants', 'participants.ParticipantId', '=', 'bridgeeventparticipants.ParticipantId')
             ->where('bridgeeventparticipants.EventId', $request->id)
             ->paginate(16);
           return view('invitefriends',['events'=>$events,'participants'=>$invite_friends,'manageinvites'=>$manage_invites,'status'=>$event_status]);
       }
       else{
             $request->session()->flash('message.level','danger');
           $request->session()->flash('message.content','please login to continue...');
           return view('login');
       }
   }
   
    public function sendEventInvite(Request $request){
       if($request->session()->has('user_id')){
           $userid = $request->session()->get('user_id');
          $date=date("Y-m-d");
         $participantid = $request->participantid;
            $characters = '0123456789';
     $charactersLength = 5;
     $randomString = '';
     for ($i = 0; $i < 5; $i++) {
         $randomString .= $characters[rand(0, $charactersLength - 1)];
     }
        $events = DB::select('select events.EventId,events.EventName,events.CreatedBy,eventschedules.StartDateTime from events INNER JOIN eventschedules where events.CreatedBy=? and eventschedules.EventId=events.EventId and events.EventId = ?',[$userid,$request->id]);
       $invite_friends = DB::table('participants')
                          ->selectRaw('*')
                          ->paginate(16);

       $manage_invites =  DB::table('bridgeeventparticipants')
       ->selectRaw('*')
             ->join('participants', 'participants.ParticipantId', '=', 'bridgeeventparticipants.ParticipantId')
             ->where('bridgeeventparticipants.EventId', $request->id)
             ->paginate(16);
             $event_status = DB::select('select * from bridgeeventparticipants where EventId=? and ParticipantId=? and CreatedBy=?',[$request->id,$participantid,$userid]);
       if(count($event_status)>0){
         $request->session()->flash('message.level','danger');
         $request->session()->flash('message.content','Already you made a request');
       return redirect('invitefriends/'.$request->id);
       }
       else{
        $invite = DB::insert('insert into bridgeeventparticipants(EventId,ParticipantId,GroupId,Accepted,CreatedDate,CreatedBy,DeletedDate,DeletedBy,Invite,ConfirmCode,ApproverId,Status) values(?,?,?,?,?,?,?,?,?,?,?,?)',[$request->id,$participantid,0,'No',$date,$userid,$date,0,1,$randomString,$userid,1]);
        $users = DB::select('select RelatedToUserId,ParticipantName from participants   where ParticipantId=?',[$participantid]);
        $userid = $users[0]->RelatedToUserId;
        $usermail = DB::select('select * from users where UserId=?',[$userid]);
        $email = $usermail[0]->Email;
        $name = $usermail[0]->UserName;
         $activation_url = url("/acceptevent/".$request->id.'/'.$participantid);
         $data = array('event'=>$events,'activation_url'=>$activation_url);
    Mail::send('emailtemplates.eventinvitation', $data, function($mesage) use($email,$name) {
             $mesage->to($email, $name)->subject('Message Sent successfully');
              $mesage->from('chandragirimounika210@gmail.com','SwimmIQ');
             
            });
          
           $request->session()->flash('message.level','info');
         $request->session()->flash('message.content','Your request has sent Successfully');
        return redirect('invitefriends/'.$request->id);
       }
       }
   }

   public function accepteventInvitation(Request $request){
    $participantid = $request->participantid;
    $userid = $request->session()->get('user_id');
     $event_status = DB::select('select * from bridgeeventparticipants where EventId=? and ParticipantId=? and CreatedBy=?',[$request->id,$participantid,$userid]);  
        if(count($event_status)>0){
        $acceptevent = DB::update('update bridgeeventparticipants set Accepted = "yes" where EventId=? and ParticipantId=? and CreatedBy=?',[$request->id,$participantid,$userid]);
          return redirect('login');

        }
        else {
             $request->session()->flash('message.level', 'danger');
             $request->session()->flash('message.content', 'Error in accepting your invitation,please try again later..');
              return redirect('acceptevent/'.$request->id.'/'.$participantid);
                }
   }
    public function addEvent(Request $request){
        if($request->session()->has('user_id')){
            return view('addevent');
        }
        else{
            $url_id = $request->id;
            $request->session()->put('loginredirection', '/addclub/'.$url_id);
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return redirect('login');
        }
    }

    public function saveEvent(Request $request){
        $event_name = $request->event_name;
        $description = $request->description;
        $privacy = $request->privacy;
        $short_name = $request->short_name;
        if($request->session()->has('user_id')){
        $user_id = $request->session()->get('user_id');
            $shortname = strtolower($short_name);
            $addevent = DB::table('events')->insertGetId(array('EventName' => $event_name,'Description' => $description, 'Privacy' => $privacy,'EventStatus'=>'pending', 'Occurance' => 'NA', 'AgeGroup' => 'NA','EventOwnerId' => 0, 'ParaSwimmersAllowed' => 'NA', 'CreatedBy' => $user_id, 'UpdatedBy' => 'NA','NoOfStages'=>0, 'ShortName' => $short_name));
           if($addevent){
            if(Input::hasFile('imgUpload')){
            $file = Input::file('imgUpload');
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = 20;
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $file->move('./public/images', $randomString.".png");
            $bimage = url("public/images/".$randomString.".png");          
            }
            else {
            $bimage = "NA";
            }
            $event_image = DB::table('images')->insertGetId(array('ImagePath'=>$bimage,'ImageRefType'=>'Event','ReferenceId'=>$addevent));        
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Event added sucessfully...');
            return redirect('subevent/'.$addevent);
            }
            else{
                $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.content', 'Failed to add event, Please Try again......');
                return view('addevent');
            } 
        }
        else{
            $request->session()->put('loginredirection', '/addevent');
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }

    public function checkshortname(Request $request){
        $shortname = $request->shortname;
        if(count(DB::select('select EventId from events where ShortName=?',[$shortname]))>0){
            echo "error";
        }
        else{
            echo "success";
        }
    }
    public function subEvent(Request $request){
        if($request->session()->has('user_id')){
            $eventid = $request->id;
            $user_id = $request->session()->get('user_id');
            
                return view('subevent',['event_id'=>$eventid,'privacy'=>'']);
            
        }
        else{
            $request->session()->put('loginredirection', '/addevent');
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login'); 
        }
    }
    public function saveSubEvent(Request $request){
        $subevent_name = $request->subevent_name;
        $swim_style = $request->swim_styles;
        $course = $request->course;
        $description = $request->description;
        $min_participants = $request->min_participants;
        $max_participants = $request->max_participants;
        $disabled = $request->disabled;
        $min_age = $request->min_age;
        $max_age = $request->max_age;
        $eventid = $request->id;
        $user_id = $request->session()->get('user_id');
        if($max_participants!=''){            
        $add_subevent = DB::table('subevents')->insertGetId(array('SubEventName' => $subevent_name,'EventId' => $eventid ,'Course' => $course ,'SwimStyle'=> $swim_style,'Relay'=>'NA', 'MaxParticipants'=> $max_participants, 'MinParticipants' => $min_participants, 'MinimumAge' => $min_age, 'MaximumAge' => $max_age, 'SpecialInstructions' => $description, 'AbleBodied' => $disabled,'MembersPerTeam' => 0, 'CreatedBy' => $user_id));
        if($add_subevent){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Subevent Added (Scroll down to see previous entries) ,You can add another subevent or <a href="'.url('schedule-event/'.$eventid).'">click here to continue...</a>');
            return redirect('subevent/'.$eventid);
        }
        else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'SubEvent not added.Please, Try again..');
            return view('subevent');
        }
        }
        else{
          $add_subevent = DB::table('subevents')->insertGetId(array('SubEventName' => $subevent_name,'EventId' => $eventid ,'Course' => $course ,'SwimStyle'=> $swim_style,'Relay'=>'NA', 'MaxParticipants'=> 0, 'MinParticipants' => 0, 'MinimumAge' => 0, 'MaximumAge' => 0, 'SpecialInstructions' => $description, 'AbleBodied' => $disabled,'MembersPerTeam' => 0, 'CreatedBy' => $user_id));
        if($add_subevent){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Subevent Added (Scroll down to see previous entries) ,You can add another subevent or <a href="'.url('schedule-event/'.$eventid).'">click here to continue...</a>');
            return redirect('subevent/'.$eventid);
        }
        else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'SubEvent not added.Please, Try again..');
            return view('subevent');
        }
        }
    }

    public function scheduleEvent(Request $request){
        if($request->session()->has('user_id')){
            $eventid = $request->id;
            $previous_entries = DB::select('select EventId from schedulerui where EventId=?',[$eventid]);
            if(count($previous_entries) > 0) {
                //return view('scheduleevent',['event_id'=>$eventid]);
                return redirect('contact-event/'.$eventid);
            } else {
                return view('scheduleevent',['event_id'=>$eventid]);
            }
        }
        else{
            $request->session()->put('loginredirection', '/scheduleevent');
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
 public function saveScheduleEvent(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $time = $request->time;
        $event_id = $request->id;
        $user_id = $request->session()->get('user_id');
        $single_occurence = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'OneTime', 'StartDate' => $start_date, 'EndDate' => $end_date, 'SubType' => 'NA', 'RecurrenceNumber' => 0, 'WeekDay' =>'NA', 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>0, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$time, 'EndTime' =>$time,'CreatedBy'=>$user_id));
        if($single_occurence){
            DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS')); 
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Event Schedule for One time added Successfully..');
            return redirect('contact-event/'.$event_id);
        }
        else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Event Schedule for One time not added.Please, Try again.');
             return view('scheduleevent',['event_id'=>$event_id]);
        }
    }
    public function multipleevent(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->id;
            return view('multipleevent',['event_id'=>$event_id]);
        }
    }
    public function savemultipleevent(Request $request){
        echo "string";
        $user_id = $request->session()->get('user_id');
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $time = $request->time;
        $event_id = $request->id;
        var_dump($start_date);
        for($i = 0; $i < count($time); $i++){echo $i;
            $multiple_occurence = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'MULTIPLE', 'StartDate' => $start_date[$i], 'EndDate' => $end_date[$i], 'SubType' => 'NA', 'RecurrenceNumber' => 0, 'WeekDay' =>'NA', 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>0, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$time[$i], 'EndTime' =>$time[$i],'CreatedBy'=>$user_id));
        }
        if($multiple_occurence){
                DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Event Schedule for multiple times added Successfully..');
                return redirect('contact-event/'.$event_id);
            }
            else{
                $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.content', 'Event Schedule for multiple times not added.Please, Try again.');
                return view('scheduleevent',['event_id'=>$event_id]);
            }
    }
    public function recurringevent(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->id;
            return view('recurringevent',['event_id'=>$event_id]);
        }
    }
    public function saveweekevent(Request $request){
        $weekday = $request->weekday;
        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $time = $request->wtime;
        $event_id  = $request->id;
        $user_id = $request->session()->get('user_id');
        for($i=0;$i<count($weekday);$i++){
            $recuring_occuranace = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $startdate, 'EndDate' => $enddate, 'SubType' => 'ByWeek', 'RecurrenceNumber' => 0, 'WeekDay' =>$weekday[$i], 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>0, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$time, 'EndTime' =>$time,'CreatedBy'=>$user_id));
        }
        if($recuring_occuranace){
            DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Event Schedule for recurrence times added Successfully..');
            return redirect('contact-event/'.$event_id);
        }
        else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Event Schedule for recurrence times not added.Please, Try again.');
            return view('scheduleevent',['event_id'=>$event_id]);
        } 
    }
    public function savemonthevent(Request $request){
        $user_id = $request->session()->get('user_id');
        $event_id = $request->id;
        $month_details = $request->month_details;
        $recuring_monthday = $request->recuring_monthday;
        $recure_monthday = $request->recure_monthday;
        $recuring_day = $request->recuring_day;
        $recure_month = $request->recuring_month;
        $recur_month = $request->recuring_month;
        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $time = $request->time;
              if($month_details == "mothly_day"){
            $recuring_month = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $startdate, 'EndDate' => $enddate, 'SubType' => 'month', 'RecurrenceNumber' =>0, 'WeekDay' =>$recuring_day, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=> $recuring_monthday,'MonthNumber' =>0, 'Month'=>$recure_month, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$time, 'EndTime' =>$time,'CreatedBy'=>$user_id));
            if($recuring_month){
                DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Event Schedule for recurrence month added Successfully..');
                return redirect('contact-event/'.$event_id);
            }
            else{
               $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.content', 'Event Schedule for recurrence month not added.Please, Try again.');
                return view('scheduleevent',['event_id'=>$event_id]);
            }               
        }
        else{
            $recuring_month = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $startdate, 'EndDate' => $enddate, 'SubType' => 'month', 'RecurrenceNumber' => $recure_monthday, 'WeekDay' =>$recuring_day, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>$recur_month, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$time, 'EndTime' =>$time,'CreatedBy'=>$user_id));
            if($recuring_month){
                DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Event Schedule for recurrence month added Successfully..');
                return redirect('contact-event/'.$event_id);
            }
            else{
                $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.content', 'Event Schedule for recurrence month not added.Please, Try again.');
                return view('scheduleevent',['event_id'=>$event_id]);
            }                
        }
    }
    public function saveyearevent(Request $request){
        $year = $request->year;
        $year_monthly_days = $request->year_monthly_days;
        $year_weekly_days = $request->year_weekly_days;
        $year_monthly = $request->year_monthly;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $time = $request->time;
        $year_number = $request->year_number;
        $recurring_year = $request->recuring_year;
        $event_id  = $request->id;
        $user_id = $request->session()->get('user_id');
        if($year == "yearly"){
         $recuring_year = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $start_date, 'EndDate' => $end_date, 'SubType' => 'year', 'RecurrenceNumber' => $year_monthly_days, 'WeekDay' =>$year_weekly_days, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>$year_monthly, 'RepeatNumber'=>$recurring_year, 'RepeatBy'=>$year_number, 'StartTime'=>$time, 'EndTime' =>$time,'CreatedBy'=>$user_id));
         if($recuring_year){
           DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
           $request->session()->flash('message.level', 'success');
           $request->session()->flash('message.content', 'Event Schedule for recurrence year added Successfully..');
           return redirect('contact-event/'.$event_id);
         }
         else{
          $request->session()->flash('message.level', 'danger');
          $request->session()->flash('message.content', 'Event Schedule for recurrence year not added.Please, Try again.');
          return view('scheduleevent',['event_id'=>$event_id]);
         }  
        }
        else{
         $recuring_year = DB::table('schedulerui')->insertGetId(array('EventId'=>$event_id, 'ScheduleType' => 'RECURRING', 'StartDate' => $start_date, 'EndDate' => $end_date, 'SubType' => 'year', 'RecurrenceNumber' => 0, 'WeekDay' =>$year_monthly_days, 'WeekDayNumber'=>'NA', 'DayNumber'=>0, 'WeekofMonth'=>0,'MonthNumber' =>0, 'Month'=>$year_monthly, 'RepeatNumber'=>0, 'RepeatBy'=>'NA', 'StartTime'=>$time, 'EndTime' =>$time,'CreatedBy'=>$user_id));
         if($recuring_year){
           DB::select('call SP_GENERATE_SCHEDULE(?,?)',array($event_id,'@OP_STATUS'));
           $request->session()->flash('message.level', 'success');
           $request->session()->flash('message.content', 'Event Schedule for recurrence year added Successfully..');
           return redirect('contact-event/'.$event_id);
          }
          else{
           $request->session()->flash('message.level', 'danger');
           $request->session()->flash('message.content', 'Event Schedule for recurrence year not added.Please, Try again.');
           return view('scheduleevent',['event_id'=>$event_id]);
          } 
        } 
    }
    public function contactEvent(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->id;
            return view('contactevent',['event_id'=>$event_id]);
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveContactEvent(Request $request){
      if($request->session()->has('user_id')){
        $event_id = $request->id;
        $type = $request->type;
        $user_id = $request->session()->get('user_id');
        if( $type == "club") {
        $club_name = $request->club_name;
        $club_mobile = $request->club_mobile;
        $club_email = $request->club_email;
        $club_website = $request->club_website;
        $event_club = DB::table('clubs')->insertGetId(array('ClubName'=>$club_name, 'Description' => 'NA', 'ClubType' => 'NA', 'AddressId'=>0, 'Email' =>  $club_email,'MobilePhone' => $club_mobile, 'Website' => $club_website, 'OpeningHours' => '00:00:00', 'Facebook' => 'NA', 'Twitter' => 'NA', 'GooglePlus' => 'NA', 'Others' => 'NA', 'ClubOwner' =>$user_id , 'IsDeleted' => 'NA', 'CreatedBy' => $user_id, 'UpdatedBy' => $user_id, 'ShortName' => 'NA'));
        $bridege_event_club = DB::table('bridgeeventclubs')->insertGetId(array('EventId'=>$event_id,'ClubId'=>$event_club,'ScheduleId'=>0,'ApproveStatus'=>'pending','CreatedBy'=>$user_id,'DeletedBy'=>0));
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Club Details added [ scroll down to see previous entries]. You can add another club or contact details or <a href="'.url('venue-event/'.$event_id).'">click here to continue</a>');
        return redirect('contact-event/'.$event_id);        
        }
        if( $type == "contact") {
        $event_contact = $request->event_contact;
        $event_mobile = $request->event_mobile;
        $event_email = $request->event_email;    
        $event_contacts = DB::table('contacts')->insertGetId(array('FirstName'=> $event_contact,'LastName'=>'NA','Title'=>'NA','Email'=>$event_email,'Website'=>'NA','Phone'=>$event_mobile,'DayTimePhone'=>'NA','EveningPhone'=>'NA','PreferredContactMethod'=>'NA','EmergencyContactName'=>'NA','EmergencyContactNumber'=>'NA','AddressId'=>0));
        $bridge_event_contact = DB::table('bridgeeventcontact')->insertGetId(array('EventId'=>$event_id,'ContactId'=>$event_contacts,'CreatedBy'=>$user_id,'DeletedBy'=>0));
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Contact Details added [ scroll down to see previous entries]. You can add another club or contact details or <a href="'.url('venue-event/'.$event_id).'">click here to continue</a>');
        return redirect('contact-event/'.$event_id);        
        }       
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function venueEvent(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->id;
            $user_id = $request->session()->get('user_id');
            return view('venueevent',['event_id'=>$event_id]);
        }
        else{
            $request->session()->put('loginredirection', '/venueevent');
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveVenueEvent(Request $request){
        $venue_name = $request->venue_name;
        $venue_address = $request->venue_address;
        $venue_city = $request->venue_city;
        $venue_code = $request->venue_code;
        $user_id = $request->session()->get('user_id');
        $event_id = $request->id;
        
        $address_venue = DB::table('address')->insertGetId(array('AddressLine1'=>$venue_address,'AddressLine2'=>'NA','AddressLine3'=>'NA','City'=>$venue_city,'Country'=>'NA','County'=>'NA','Council'=>'NA','PostCode'=>$venue_code,'Latitude'=>0,'Longitude'=>0));
        $venue = DB::table('venue')->insertGetId(array('VenueName' => $venue_name,'Description' => 'NA','AddressId' => $address_venue,'Phone' => 'NA', 'Phone2' => 'NA','Mobile'=>'NA','Email' => 'NA', 'Website' => 'NA', 'Website2' => 'NA', 'Facebook' => 'NA','Twitter' => 'NA', 'GooglePlus' => 'NA','Others'=>'NA','Shower'=>'NA','Gym'=>'NA','Teachers'=>'NA','ParaSwimmingFacilities'=>'NA','LadiesOnlySwimming'=>'NA','LadiesOnlySwimTimes'=>'NA', 'Toilets' => 'NA','Diving'=>'NA','PrivateHire'=>'NA','VisitingGallery'=>'NA','Parking'=>'NA','SwimForKids'=>'NA','VenueOwner'=>$user_id,'ShortName'=>'NA'));
        $bridge_event_venue = DB::table('bridgeeventvenues')->insertGetId(array('EventId'=>$event_id,'VenueId'=>$venue,'ApproveStatus'=>'pending','ScheduleId'=>0,'CreatedBy'=>$user_id,'DeletedBy'=>0));     
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Venue Added [Scrolldown to see previous entries], You may add another venue or <a href="'.url('confirm-event/'.$event_id).'">clickhere to continue</a>');
        return redirect('venue-event/'.$event_id);
    }
    public function confirmEvent(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->id;
            $user_id = $request->session()->get('user_id');
            $event_details = DB::select('select e.EventName,e.Description,s.SwimStyle,s.MembersPerTeam,s.AbleBodied,s.MaximumAge,s.MinimumAge,s.MaxParticipants,s.MinParticipants from events e INNER JOIN subevents s where e.EventId=? and s.EventId=? and e.CreatedBy=? and s.CreatedBy=?',[$event_id,$event_id,$user_id,$user_id]);
            $event_descripiton = $event_details[0]->Description;
            $venues = DB::select('select a.AddressId,a.AddressLine1,a.City,a.PostCode,v.VenueId,v.VenueName from address as a inner join venue as v on v.AddressId=a.AddressId inner join bridgeeventvenues as b on b.VenueId = V.VenueId where b.EventId=? and b.CreatedBy=?',[$event_id,$user_id]);

            $schedule = DB::select('select ScheduleType,StartDate,EndDate,StartTime from schedulerui where EventId=?',[$event_id]);
            $contacts = DB::select('select b.ContactId,c.FirstName,c.Email,c.Phone from bridgeeventcontact b INNER JOIN contacts c where b.EventId=? and b.CreatedBy=? and b.ContactId=c.ContactId',[$event_id,$user_id]);
            return view('confirmevent',['event_id'=>$event_id,'event_details'=>$event_details,'event_descripiton'=>$event_descripiton,'venues'=>$venues,'schedulers'=>$schedule,'contacts'=>$contacts]);
        }
        else{
            $request->session()->put('loginredirection', '/confirmevent');
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveConfirmEvent(Request $request){
        $event_id = $request->id;
        $event_name = $request->event_name;
        $user_id = $request->session()->get('user_id');
        $name = $request->session()->get('name');
        $email = $request->session()->get('email');
        $update_event = DB::update('update events set EventStatus=? where EventId=? and CreatedBy=?',['Confirmed',$event_id,$user_id]);
        if($update_event){
            $data = array( 'email' => $email, 'name' => $name, 'event_name' => $event_name);
            Mail::send('emailtemplates.eventconfirmation', $data, function($message) use($email,$name) {
            $message->to($email, $name)->subject('Event has created Successfully');
            $message->from('swimiqmail@gmail.com','SwimmIQ');
            });
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Event Details Updated Sucessfully...');
            return redirect('confirm-event/'.$event_id);
        }
        else{
           $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Event Details Already Updated');
            return redirect('confirm-event/'.$event_id);
        }
    }
    //
    public function editEvent(Request $request){
        $event_id = $request->id;
        if($request->session()->has('user_id')){
            $user_id = $request->session()->get('user_id');
            $event_details = DB::select('select EventName,Description,Privacy,ShortName from events where EventId=? and CreatedBy=?',[$event_id,$user_id]);
            if( count($event_details) > 0 ) {
            return view('editevent',['event_details'=>$event_details,'event_id'=>$event_id]);
            } else {
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Unauthorized access detected, You need to login again to continue...');
            return redirect('logout');    
            }
        }
        else{
            $request->session()->put('loginredirection', '/editevent/'.$event_id);
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveEditEvent(Request $request){
        $event_name = $request->event_name;
        $description = $request->description;
        $privacy = $request->privacy;
        $short_name = $request->short_name;
        $e_image = $request->image;
        $event_id = $request->id;
        $user_id = $request->session()->get('user_id');
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = 20;
        $image_details = DB::select('select ImageId from images where ImageRefType=? and ReferenceId=?',['Event',$event_id]);
        $event_details = DB::select('select EventName,Description,Privacy,ShortName from events where EventId=?',[$event_id]);
        $update_event = DB::table('events')->where('EventId',$event_id)->update(['EventName'=>$event_name,'Description'=>$description,'Privacy'=>$privacy,'ShortName'=>$short_name]);
        if(Input::hasFile('image')){
            $file = Input::file('image');
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $file->move('./public/images/admin', $randomString.".png");
            $image = url("public/images/admin/".$randomString.".png");
            $image_insert = DB::update('update images set ImagePath=? where ImageId=?',[$image,$image_details[0]->ImageId]);
        }
        else {
            $image = "NA";
        }
        if($update_event){
            $sub_event = DB::select('select SubEventId from subevents where EventId=?',[$event_id]);
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Event updated sucessfully...');
            return redirect('edit-subevent/'.$event_id.'/'.$sub_event[0]->SubEventId);
            
        }
        else{
            $sub_event = DB::select('select SubEventId from subevents where EventId=?',[$event_id]);
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Either Failed to update or No new data to update, Try again or <a href="'.url('edit-subevent/'.$event_id.'/'.$sub_event[0]->SubEventId).'">click here to continue...</a>');
            return view('editevent',['event_details'=>$event_details,'event_id'=>$event_id]);
        }           
    }
    
    public function redirectSubEvent(Request $request) {
    $event_id = $request->event_id;    
    $sub_event = DB::select('select SubEventId from subevents where EventId=?',[$event_id]);
    $request->session()->flash('message.level', 'success');
    $request->session()->flash('message.content', 'Event updated sucessfully...');
    return redirect('edit-subevent/'.$event_id.'/'.$sub_event[0]->SubEventId);    
    }

    public function editSubEvent(Request $request){
        $event_id = $request->event_id;
        $sub_event_id = $request->sub_event_id;
        if($request->session()->has('user_id')){
            $sub_event = DB::select('select SubEventId,SubEventName,Swimstyle,Course,SpecialInstructions,AbleBodied,MinParticipants,MaxParticipants,MinimumAge,MaximumAge from subevents where SubEventId=? and EventId=?',[$sub_event_id,$event_id]);
            if(count($sub_event)>0){
                return view('editsubevent',['event_id'=>$event_id,'sub_event_id'=>$sub_event_id,'sub_events'=>$sub_event]);
            }
            else{
                $request->session()->flash('message.level', 'info');
                $request->session()->flash('message.content', 'Please Add SubEvent.');
                return view('subevent',['event_id'=>$event_id]);
            }
        }
        else{
            $request->session()->put('loginredirection', '/edit-subevent/'.$event_id.'/'.$sub_event_id);
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveEditSubEvent(Request $request){
        $subevent_name = $request->subevent_name;
        $swim_style = $request->swim_style;
        $course = $request->course;
        $description = $request->description;
        $min_participants = $request->min_participants;
        $max_participants = $request->max_participants;
        $disabled = $request->disabled;
        $min_age = $request->min_age;
        $max_age = $request->max_age;
        $event_id = $request->event_id;
        $sub_event_id = $request->sub_event_id;

        $subevent_names = $request->subevent_names;
        $swim_styles = $request->swim_styles;
        $courses = $request->courses;
        $descriptions = $request->descriptions;
        $min_participant = $request->min_participant;
        $max_participant = $request->max_participant;
        $disables = $request->disables;
        $min_ages = $request->min_ages;
        $max_ages = $request->max_ages;
        $user_id = $request->session()->get('user_id');
        $sub_event = DB::select('select SubEventId,SubEventName,Swimstyle,Course,SpecialInstructions,AbleBodied,MinParticipants,MaxParticipants,MinimumAge,MaximumAge from subevents where SubEventId=? and EventId=?',[$sub_event_id,$event_id]);
        $update_subevent = DB::update('update subevents set SubEventName=?,SwimStyle=?,Course=?,SpecialInstructions=?,MaxParticipants=?,MinParticipants=?,MinimumAge=?,MaximumAge=?,AbleBodied=? where EventId=? and SubEventId=?',[$subevent_name,$swim_style,$course,$description,$max_participants,$min_participants,$min_age,$max_age,$disabled,$event_id,$sub_event_id]);
        if($update_subevent){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'SubEvent updated sucessfully...');
            return redirect('edit-subevent/'.$event_id.'/'.$sub_event_id);
        }
        else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Either Failed to update or No new data to update, Try again or <a href="'.url('edit-eventschedule/'.$event_id).'"> Click here to continue...</a>');
            return redirect('edit-subevent/'.$event_id.'/'.$sub_event_id);
        }
     }
    public function editVenueEvent(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->event_id;
            $venue_id = $request->id;
            $user_id = $request->session()->get('user_id');
            $venues = DB::select('select a.AddressId,a.AddressLine1,a.City,a.PostCode,v.VenueId,v.VenueName from address as a inner join venue as v on v.AddressId=a.AddressId inner join bridgeeventvenues as b on b.VenueId = V.VenueId where b.EventId=? and b.CreatedBy=? and v.VenueId=?',[$event_id,$user_id,$venue_id]);
            return view('editvenueevent',['event_id'=>$event_id,'venues'=>$venues]);
         }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveEditVenueEvent(Request $request){
        $event_id = $request->id;
        $venue_id = $request->venue_id;
        $venue_name = $request->venue_name;
        $address_id = $request->address_id;
        $venue_address = $request->venue_address;
        $venue_city = $request->venue_city;
        $venue_code = $request->venue_code;
        $venue_names = $request->venue_names;
        $venue_addres = $request->venue_addres;
        $venue_cities = $request->venue_cities;
        $venue_codes = $request->venue_codes;
        $user_id = $request->session()->get('user_id');
        var_dump($address_id);
        if($venue_names!="" && $venue_addres!="" && $venue_cities!="" && $venue_codes!=""){
        for($i=0;$i<count($venue_names);$i++){
         $address_venue = DB::table('address')->insertGetId(array('AddressLine1'=>$venue_addres[$i],'AddressLine2'=>'NA','AddressLine3'=>'NA','City'=>$venue_cities[$i],'Country'=>'NA','County'=>'NA','Council'=>'NA','PostCode'=>$venue_codes[$i],'Latitude'=>0,'Longitude'=>0));
        $venue = DB::table('venue')->insertGetId(array('VenueName' => $venue_names[$i],'Description' => 'NA','AddressId' => $address_venue,'Phone' => 'NA', 'Phone2' => 'NA','Mobile'=>'NA','Email' => 'NA', 'Website' => 'NA', 'Website2' => 'NA', 'Facebook' => 'NA','Twitter' => 'NA', 'GooglePlus' => 'NA','Others'=>'NA','Shower'=>'NA','Gym'=>'NA','Teachers'=>'NA','ParaSwimmingFacilities'=>'NA','LadiesOnlySwimming'=>'NA','LadiesOnlySwimTimes'=>'NA', 'Toilets' => 'NA','Diving'=>'NA','PrivateHire'=>'NA','VisitingGallery'=>'NA','Parking'=>'NA','SwimForKids'=>'NA','VenueOwner'=>$user_id,'ShortName'=>'NA'));
        $bridge_event_venue = DB::table('bridgeeventvenues')->insertGetId(array('EventId'=>$event_id,'VenueId'=>$venue,'ApproveStatus'=>'pending','ScheduleId'=>0,'CreatedBy'=>$user_id,'DeletedBy'=>0));
        }
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Event Venue Details Added Sucessfully...');
        return redirect('edit-venueevent/'.$event_id);
        }
        else{
          for($i=0;$i<count($venue_name);$i++){
             $update_venue = DB::table('venue')->where('VenueId',$venue_id[$i])->update(['VenueName'=>$venue_name[$i]]);
             $update_address = DB::table('address')->where('AddressId',$address_id[$i])->update(['AddressLine1'=>$venue_address[$i],'City'=>$venue_city[$i],'PostCode'=>$venue_code[$i]]);        
           }
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Event Venue Details Updated Sucessfully...');
        return redirect('edit-venueevent/'.$event_id);
        }
    }


public function deleteEvent(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->id;
            $id = $request->contactid;
            $user_id = $request->session()->get('user_id');
            if(count(DB::select('select ClubId from clubs where ClubId=? and CreatedBy=?',[$id,$user_id]))){
            $clubs = DB::delete('delete from clubs where ClubId=? and CreatedBy=?',[$id,$user_id]);
            $bridge_club = DB::delete('delete from bridgeeventclubs where ClubId=? and EventId=? and CreatedBy=?',[$id,$event_id,$user_id]);
            return redirect('edit-contactevent/'.$event_id);
            }
            else{
                $contacts = DB::delete('delete from contact where ContactId=? and CreatedBy=?',[$id,$user_id]);
                $bridge_club = DB::delete('delete from bridgeeventcontact where ContactId=? and EventId=? and CreatedBy=?',[$id,$event_id,$user_id]);
                return redirect('edit-contactevent/'.$event_id);
            }
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }

    public function deleteSubEvent(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->event_id;
            $subevent_id = $request->subevent_id;
            $subevent = DB::delete('delete from subevents where SubEventId=?',[$subevent_id]);
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Subevent Deleted Sucessfully..');
            return redirect('subevent/'.$event_id);
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function deleteEventClub(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->event_id;
            $club_id = $request->id;
            $user_id = $request->session()->get('user_id');
            $remove_bridge = DB::delete('delete from bridgeeventclubs where ClubId=? and CreatedBy=?',[$club_id,$user_id]);
            $remove_clubs = DB::delete('delete from clubs where ClubId=?',[$club_id]);
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Event Club Deleted Sucessfully..');
            return redirect('contact-event/'.$event_id);
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function deleteEventContact(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->event_id;
            $contact_id = $request->id;
            $user_id = $request->session()->get('user_id');
            $remove_bridge = DB::delete('delete from bridgeeventcontact where ContactId=? and CreatedBy=?',[$contact_id,$user_id]);
            $remove_contact = DB::delete('delete from contacts where ContactId=?',[$contact_id]);
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Event Contact Deleted Sucessfully..');
            return redirect('contact-event/'.$event_id);
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function deleteschedule(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->event_id;
            $schedule_id = $request->id;
            $user_id = $request->session()->get('user_id');
            $remove_schedules = DB::delete('delete from eventschedules where EventId=? and SchedulerUIId=?',[$event_id,$schedule_id]);
            if($remove_schedules ){
              $remove_schedule = DB::delete('delete from schedulerui where SchedulerUIId=? and EventId=?',[$schedule_id,$event_id]);
              $request->session()->flash('message.level', 'success');
              $request->session()->flash('message.content', 'Event Schedule deleted sucessfully');
              return redirect('edit-scheduleevent/'.$event_id);  
            }
            else{
               $request->session()->flash('message.level', 'danger');
              $request->session()->flash('message.content', 'Error deleting schedule.Pleaes Try again..');
              return redirect('edit-scheduleevent/'.$event_id); 
            }
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }

    }
    public function deleteeventvenue(Request $request){
        $event_id = $request->event_id;
        $venue_id = $request->id;
        $remove_bridge = DB::delete('delete from bridgeeventvenues where EventId=? and VenueId=?',[$event_id,$venue_id]);
        $remove_venue = DB::delete('delete from venue where VenueId=?',[$venue_id]);
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Event Venue deleted sucessfully');
        return redirect('venue-event/'.$event_id);
    }
    public function getOldEntries(Request $request) {
        $type = $request->type;
        $id = $request->id;
        
        if($type == "subevents") {
            $subevents = DB::select("select SubEventId,SubEventName,EventId,Course,SwimStyle from subevents where EventId=?",[$id]);
            if(count($subevents) > 0) {
                echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Sub Event Name</td><td>Course</td><td>Swim Style</td><td>Edit</td><td>Delete</td></tr>";
                foreach($subevents as $subevent) {
                    echo "<tr><td>".$subevent->SubEventName."</td><td>".$subevent->Course."</td><td>".$subevent->SwimStyle."</td><td><a href=".url('/edit-subevent/'.$id.'/'.$subevent->SubEventId)." style='color:black;'>Edit</a></td><td><a href=".url('/delete-subevent/'.$id.'/'.$subevent->SubEventId)." style='color:black;'>Delete</a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            } else {
                echo "no";
            }
        }
        
        if($type == "contacts") {
            $clubs = DB::select("select c.ClubName,c.Email,c.ClubId from clubs c inner join bridgeeventclubs b on c.ClubId = b.ClubId  where b.EventId=?",[$id]);
            if(count($clubs) > 0) {
                echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Club Name</td><td>Email</td><td>Edit</td><td>Delete</td></tr>";
                foreach($clubs as $club) {
                    echo "<tr><td>".$club->ClubName."</td><td>".$club->Email."</td><td><a href=".url('/edit-eventclub/'.$id.'/'.$club->ClubId)."style='color:black;'>Edit</a></td><td><a href=".url('/delete-eventclub/'.$id.'/'.$club->ClubId)." style='color:black;'>Delete</a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            }
            $contacts = DB::select("select c.FirstName,c.Email,c.ContactId from contacts c inner join bridgeeventcontact b on c.ContactId = b.ContactId  where b.EventId=?",[$id]);
            if(count($contacts) > 0) { 
                echo '<br/><hr/>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Contact</td><td>Email</td><td>Edit</td><td>Delete</td></tr>";
                foreach($contacts as $contact) {
                    echo "<tr><td>".$contact->FirstName."</td><td>".$contact->Email."</td><td><a href=".url('/edit-eventcontact/'.$id.'/'.$contact->ContactId)." style='color:black;'>Edit</a></td><td><a href=".url('/delete-eventcontact/'.$id.'/'.$contact->ContactId)." style='color:black;'>Delete</a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            }
        }
        
        if($type == "venues") {
            $venues = DB::select("select v.VenueId,v.VenueName from venue v inner join bridgeeventvenues b on b.VenueId=v.VenueId where b.EventId=?",[$id]);
            if(count($venues) > 0) {
                echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><td>Venue Name</td><td>Edit</td><td>Delete</td></tr>";
                foreach($venues as $venue) {
                    echo "<tr><td>".$venue->VenueName."</td><td><a href=".url('/edit-eventvenue/'.$id.'/'.$venue->VenueId)." style='color:black;'>Edit</a></td><td><a href=".url('/delete-eventvenue/'.$id.'/'.$venue->VenueId)." style='color:black;'>Delete</td></tr>";
                }
                echo "</table>";
                echo '</div>';
            } else {
                echo "no";
            }
        }
        if($type == "schedule") {
            $schedulers = DB::select("select SchedulerUIId,ScheduleType,SubType,WeekDay,StartDate,EndDate from schedulerui where EventId=?",[$id]);
            if(count($schedulers) > 0) {
                echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><th>ScheduleType</th><th>SubType</th><th>WeekDay</th><th>StartDate</th><th>EndDate</th><th>Edit</th><th>Delete</th></tr>";
                foreach($schedulers as $scheduler) {
                    echo "<tr><td>".$scheduler->ScheduleType."</td><td>".$scheduler->SubType."</td><td>".$scheduler->WeekDay."</td><td>".$scheduler->StartDate."</td><td>".$scheduler->EndDate."</td><td><a href=".url('/edit-scheduleevent/'.$id)." style='color:black'>Edit</a></td><td><a href=".url('/delete-schedule/'.$id.'/'.$scheduler->SchedulerUIId)." style='color:black;'>Delete</a></td></tr>";
                }
                echo "</table>";
                echo '</div>';
            } else {
                echo "no";
            }
        }
        
    }
    
    public function editClubEvent(Request $request){
   if($request->session()->has('user_id')){
            $event_id = $request->event_id;
            $club_id = $request->id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $user_id = $request->session()->get('user_id');
            $clubs = DB::select('select ClubId,ClubName,MobilePhone,Email,Website from clubs where ClubId=? and CreatedBy=?',[$club_id,$user_id]);
            if(count($clubs)>0){
                return view('editclubevent',['clubs'=>$clubs,'event_id'=>$event_id]);
            }
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }  
}
public function saveEditClubEvent(Request $request){
    $event_id = $request->event_id;
    $club_id = $request->club_id;
    $club_name = $request->club_name;
    $club_mobile = $request->club_mobile;
    $club_email = $request->club_email;
    $club_website = $request->club_website;
    $clubname = $request->clubname;
    $clubmobile = $request->clubmobile;
    $clubemail = $request->clubemail;
    $clubwebsite = $request->clubwebsite;
    $user_id = $request->Session()->get('user_id');
    if($clubname!='' && $clubmobile!='' && $clubemail !='' && $clubwebsite!=''){
        $event_club = DB::table('clubs')->insertGetId(array('ClubName'=>$clubname, 'Description' => 'NA', 'ClubType' => 'NA', 'AddressId'=>0, 'Email' =>  $clubemail,'MobilePhone' => $clubmobile, 'Website' => $clubwebsite, 'OpeningHours' => '00:00:00', 'Facebook' => 'NA', 'Twitter' => 'NA', 'GooglePlus' => 'NA', 'Others' => 'NA', 'ClubOwner' =>$user_id , 'IsDeleted' => 'NA', 'CreatedBy' => $user_id, 'UpdatedBy' => $user_id, 'ShortName' => 'NA'));
        $bridege_event_club = DB::table('bridgeeventclubs')->insertGetId(array('EventId'=>$event_id,'ClubId'=>$event_club,'ScheduleId'=>0,'ApproveStatus'=>'pending','CreatedBy'=>$user_id,'DeletedBy'=>0));
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Event Contact Details Inserted Sucessfully');
        return redirect('edit-eventclub/'.$event_id);
    }
    else{
    $update_club = DB::table('clubs')->where('ClubId',$club_id)->update(['ClubName'=>$club_name,'MobilePhone'=>$club_mobile,'Email'=>$club_email,'Website'=>$club_website]);
    if($update_club){
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Event Club Details Updated Sucessfully');
        return redirect('edit-eventclub/'.$event_id);
    }
    else{
            $request->session()->flash('message.level', 'failed');
            $request->session()->flash('message.content', 'Event Club Details not updated.Please Try again...');
            return redirect('edit-eventclub/'.$event_id);
        }
    }
}
    public function editEventContact(Request $request){
        if($request->session()->has('user_id')){
            $contact_id = $request->id;
            $event_id = $request->event_id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $user_id = $request->session()->get('user_id');
            $contacts = DB::select('select ContactId,FirstName,Phone,Email from contacts where ContactId=?',[$contact_id]);
            if(count($contacts)>0){
                return view('editcontactevent',['contacts'=>$contacts,'event_id'=>$event_id]);
            }
        }
        else{
            $request->session()->flash('message.level', 'info');
            $request->session()->flash('message.content', 'Please login to continue...');
            return view('login');
        }
    }
    public function saveEditEventContact(Request $request){
        
        $contact_id = $request->contact_id;
        $event_contact = $request->event_contact;
        $event_mobile = $request->event_mobile;
        $event_email = $request->event_email;
        $event_id = $request->id;
        $eventcontact = $request->eventcontact;
        $eventmobile = $request->eventmobile;
        $eventemail = $request->eventemail;
        $user_id = $request->session()->get('user_id');
        if($eventcontact!='' && $eventmobile !='' && $eventemail !=''){
            $event_contact_details = DB::table('contacts')->insertGetId(array('FirstName'=> $eventcontact,'LastName'=>'NA','Title'=>'NA','Email'=>$eventemail,'Website'=>'NA','Phone'=>$eventmobile,'DayTimePhone'=>'NA','EveningPhone'=>'NA','PreferredContactMethod'=>'NA','EmergencyContactName'=>'NA','EmergencyContactNumber'=>'NA','AddressId'=>0));
            $bridge_event_contact = DB::table('bridgeeventcontact')->insertGetId(array('EventId'=>$event_id,'ContactId'=>$event_contact_details,'CreatedBy'=>$user_id,'DeletedBy'=>0));
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Event Contact Details Inserted Sucessfully');
            return redirect('edit-contactevent/'.$event_id);
        }
        else{   
        $update_contact = DB::table('contacts')->where('ContactId',$contact_id)->update(['FirstName'=>$event_contact,'Email'=>$event_email,'Phone'=>$event_mobile]);
        if($update_contact){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Event Contact Details Updated Sucessfully');
            return redirect('edit-contactevent/'.$event_id);
        }
        else{
            $request->session()->flash('message.level', 'failed');
            $request->session()->flash('message.content', 'Event Contact Details not updated.Please Try again...');
            return redirect('edit-contactevent/'.$event_id);
        }
        }

        
        
    }
    