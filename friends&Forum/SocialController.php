<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SocialController extends Controller
{
    public function index(Request $request) {
    	if($request->session()->has('user_id')){
    		$user_id = $request->session()->get('user_id');
    		$friends =DB::select('select distinct u.UserName,f.RequestReceiverID from users u INNER JOIN friendrequests f where f.RequestReceiverID=u.UserId and f.RequestorID=?',[$user_id]);
    		$questions = DB::select('select DISTINCT Question,QuestionId,Topic,View,DateTime from questions');
    		$topics = DB::Select('select DISTINCT Topic from questions');
    		return view('socialnetwork',['friends'=>$friends,'questions'=>$questions,'topics'=>$topics]);
    	}
      	else{
          $request->session()->flash('message.level','danger');
          $request->session()->flash('message.content','please login to continue..');
          return view('login');
      	}
    }
    public function addFriend(Request $request){
    	$name = $request->name;
    	$category = $request->category;
    	$topic = $request->topic;
    	$message = $request->message;
    	if($category!='' && $topic!='' && $message!=''){
    		$askforum = DB::insert('insert into questions(Category,Topic,Question,DateTime,View,UserId,TargetType,TargetId) values(?,?,?,?,?,?,?,?)',[$category,$topic,$question,$date,0,$userid,'NA',0]);
  			if($askforum){
  				$request->session()->flash('message.level','info');
  				$request->session()->flash('message.content','Question saved successfully');
  				return redirect('socialnetwork');
  			}
 			else{
   				$request->session()->flash('message.level','danger');
   				$request->session()->flash('message.content','Failed to post your question');
   				return redirect('socialnetwork');
 			}
    	}
    	else{
    	$sender_id = $request->session()->get('user_id');
    	$search = DB::select('select UserId,UserName,Email from users where UserName=? or Email=?',[$name,$name]);
    	if(count($search)>0){
    		$receiver_id = $search[0]->UserId;
    		$check_request = DB::select('select ApprovalStatus from friendrequests where RequestorID=? and RequestReceiverID=?',[$sender_id,$receiver_id]);
    		if(count($check_request)>0){
    			$request->session()->flash('message.level','info');
          		$request->session()->flash('message.content','Friend Request already sent waiting for response..');
          		return redirect('socialnetwork');
    		}
    		else{
    		$send_request = DB::table('friendrequests')->insertGetId(array('RequestorID'=>$sender_id,'RequestReceiverID'=>$receiver_id,'ApprovalStatus'=>'P'));
    		$addfriends = DB::table('friends')->insertGetId(array('FriendId'=>$receiver_id,'UserId'=>$sender_id,'FriendRequestId'=>$send_request,'Status'=>'P'));
    		$request->session()->flash('message.level','success');
          	$request->session()->flash('message.content','Friend Request has been sent...');
          	return redirect('socialnetwork');
          	}
    	}
    	else{
    		$request->session()->flash('message.level','danger');
          	$request->session()->flash('message.content','User Doesnot Exist...');
          	return redirect('socialnetwork');
    	}
    	}
    }
    public function newFriend(Request $request){
    	echo "string";
    	$id = $request->id;
    	$user_id = $request->session()->get('user_id');
    	$check_request = DB::select('select ApprovalStatus from friendrequests where RequestorID=? and RequestReceiverID=?',[$user_id,$id]);
    	if(count($check_request)>0){
    		$request_id = DB::select('select FriendRequestsID from friendrequests where RequestReceiverID=? and RequestorID=?',[$id,$user_id]);
    		$remove_request = DB::delete('delete from friendrequests where RequestReceiverID=? and RequestorID=?',[$id,$user_id]);
    		$remove_friend = DB::delete('delete from friends where FriendId=?',[$request_id[0]->FriendRequestsID]);
    	}
    	else{
    		$send_request = DB::table('friendrequests')->insertGetId(array('RequestorID'=>$user_id,'RequestReceiverID'=>$id,'ApprovalStatus'=>'P'));
    		$friends = DB::table('friends')->insertGetId(array('FriendId'=>$id,'UserId'=>$user_id,'FriendRequestId'=>$send_request,'Status'=>'P'));
    	}
    }

    public function friendList(Request $request){
    	if($request->session()->has('user_id')){
    	  $user_id = $request->session()->get('user_id');
    	  $allusers = DB::table('users')
    	  ->selectRaw('*,users.UserId,users.UserName')
    	  ->where('users.UserId','!=',[$user_id])
    	  ->orderBy('users.UserId')
    	  ->paginate(15);
    	  if(count($allusers)>0){
    	  	return view('friendlist',['allusers'=>$allusers]);
    	  }
    	  else{
    	  	$allusers = array();
    	  	$myfriends = array();
    	  	return view('friendlist',['allusers'=>$allusers]);
    	  }
    	  
    	}
    	else{
          $request->session()->flash('message.level','danger');
          $request->session()->flash('message.content','please login to continue..');
          return view('login');
      	}
    }
    public function myFriend(Request $request){
    	if($request->session()->has('user_id')){
    		$user_id = $request->session()->get('user_id');
    		$myfriends = DB::table('users')
    	  ->selectRaw('*,users.UserId,users.UserName')
    	  ->JOIN('friendrequests','users.UserId','=','friendrequests.RequestReceiverID')
    	  ->orderBy('users.UserId')
    	  ->paginate(15);
    	  if(count($myfriends)>0){
    	  	return view('myfriendlist',['friends'=>$myfriends]);
    	  }
    	  else{
    	  	$allusers = array();
    	  	$myfriends = array();
    	  	return view('myfriendlist',['friends'=>$myfriends]);
    	  }
    	}
    	else{
    	  $request->session()->flash('message.level','danger');
          $request->session()->flash('message.content','please login to continue..');
          return view('login');
    	}
    }
    public function searchfriend(Request $request){
    	$search = $request->search;
    	$allusers = DB::table('users')
    	->selectRaw('*,users.UserId,users.UserName')
    	->where('users.UserName','=',[$search])
    	->orderBy('users.UserId')
    	->paginate(15);
    	return view('friendlist',['allusers'=>$allusers]);
    }

    public function answers(Request $request){
    	if($request->session()->has('user_id')){
    		$question_id = $request->id;
    		$question = DB::select('select q.Topic,q.Question,q.DateTime,q.UserId,q.View,u.UserName FROM Questions q JOIN users u ON q.UserId=u.UserId WHERE q.QuestionId=?',[$question_id]);
    		$view_count = $question[0]->View;
    		$view = $view_count+1;
    		$answers = DB::select('select Answer from answers where QuestionId=?',[$question_id]);
    		//$recent_questions = DB::select('select Question from questions where max(View)');
    		//var_dump($recent_questions);
    		$topics = DB::select('select DISTINCT Topic from questions');
    		$update_viewcount = DB::update('update Questions SET View=? where QuestionId=?',[$view,$question_id]);
    		return view('forumanswers',['questions'=>$question,'question_id'=>$question_id,'answers'=>$answers,'topics'=>$topics]);
    	}
    	else{
    	  $request->session()->flash('message.level','danger');
          $request->session()->flash('message.content','please login to continue..');
          return view('login');
    	}
    }
    public function forumanswer(Request $request){
    	$question_id = $request->id;
    	$message = $request->message;
    	$user_id = $request->session()->get('user_id');
    	$insert_answer = DB::table('answers')->insertGetId(array('QuestionId'=>$question_id,'UserId'=>$user_id,'Answer'=>$message));
    	if($insert_answer){
    	  $request->session()->flash('message.level','success');
          $request->session()->flash('message.content','Answer posted Successfully...');
          return redirect('forumanswers/'.$question_id);
    	}
    	else{
    	  $request->session()->flash('message.level','failed');
          $request->session()->flash('message.content','Failed to post answer,Please Try again.');
          return redirect('forumanswers/'.$question_id);
    	}
    }
    public function forumquestions(Request $request){
    	$replymessages = DB::select('select a.Answer from questions q INNER JOIN answers a where a.QuestionId=q.QuestionId');
    	$topics = DB::Select('select DISTINCT Topic from questions');
    	$allquestions = DB::select('select Question from questions');
    	$question = DB::table('questions')
    	->selectRaw('*,Question,Topic,View,DateTime')
    	->orderBy('questions.QuestionId')
    	->paginate(6);
    	return view('questions',['questions'=>$question,'allquestions'=>$allquestions,'topics'=>$topics]);
    }
    public function questions(Request $request){
    	$search = $request->search;
    	$topics = DB::Select('select DISTINCT Topic from questions');
    	$allquestions = DB::select('select Question from questions');
    	$search_question = DB::select('select Question,View,Topic,QuestionId from questions where Question=?',[$search]);
    	return view('questions',['questions'=>$search_question,'topics'=>$topics]);
    }
}
