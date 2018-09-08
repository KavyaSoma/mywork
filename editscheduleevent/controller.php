<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use session;


class EventController extends Controller
{
  public function editSchedule(Request $request){
        if($request->session()->has('user_id')){
            $event_id = $request->event_id;
            $schedule_id = $request->schedule_id;
            $user_id = $request->session()->get('user_id');
            $schedule = DB::select('select SchedulerUIId,SubType,ScheduleType,StartTime,EndTime,StartDate,EndDate,WeekDay,RepeatNumber,RecurrenceNumber,Month from schedulerui where EventId=?',[$event_id]); 
            if(count($schedule)>0){
            $schedule_type = $schedule[0]->ScheduleType;
         //   $multiple_schedules = DB::select('select ')
            $Occurance = $schedule[0]->ScheduleType;
            $subtype = $schedule[0]->SubType;
            $recurring = DB::select('select StartDate,EndDate,StartTime,WeekDay,RepeatNumber from schedulerui where EventId=? and ScheduleType=?',[$event_id,'recuring']);
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
        public function oldSchedule(Request $request) {
        $type = $request->type;
        $id = $request->id;
        if($type == "schedule") {
            $schedulers = DB::select("select ScheduleType,SubType,WeekDay,StartDate,EndDate from schedulerui where EventId=?",[$id]);
            if(count($schedulers) > 0) {
                echo '<h5 class="add_venue"><a href="#"><button class="btn btn-primary" style="background-color:#fff;color:#46A6EA"><i class="fa fa-plus"></i></button></a> Previous Entries</h5>';
                echo '<div class="row" style="border:1px solid #eee">';
                echo "<table class='table table-striped'>";
                echo "<tr><th>ScheduleType</th><th>SubType</th><th>WeekDay</th><th>StartDate</th><th>EndDate</th></tr>";
                foreach($schedulers as $scheduler) {
                    echo "<tr><td>".$scheduler->ScheduleType."</td><td>".$scheduler->SubType."</td><td>".$scheduler->WeekDay."</td><td>".$scheduler->StartDate."</td><td>".$scheduler->EndDate."</td></tr>";
                }
                echo "</table>";
                echo '</div>';
            } else {
                echo "no";
            }
        }
    }