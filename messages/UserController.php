<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    public function userdashboard(Request $request) {
      return view('userdashboard');
    }

    public function getFavourites(Request $request) {
      $type = $request->type;
      $id = $request->id;
      $uid = $request->uid;

      $total_favourites = DB::select('select count(FavouriteId) as count from favourites where UserId=? and FavouriteType=? and Attribute=? and Flag=?',[$uid,$type,$id,'Yes']);

      $is_user_favourite = DB::select('select FavouriteId from favourites where UserId=? and FavouriteType=? and Attribute=? and Flag=?',[$uid,$type,$id,'Yes']);

      if(count($is_user_favourite) > 0) {
        echo "yes,".$total_favourites[0]->count;
      } else {
        echo "no,".$total_favourites[0]->count;
      }
    }

    public function manageFavourites(Request $request) {
      $type = $request->type;
      $id = $request->id;
      $uid = $request->uid;

      $is_user_favourite = DB::select('select FavouriteId,Flag from favourites where UserId=? and FavouriteType=? and Attribute=?',[$uid,$type,$id]);

      if(count($is_user_favourite) > 0) {
        if($is_user_favourite[0]->Flag == "Yes") {
            DB::update('update favourites set Flag=? where UserId=? and FavouriteType=? and Attribute=?',['No',$uid,$type,$id]);
            echo 'no';
        } else {
           DB::update('update favourites set Flag=? where UserId=? and FavouriteType=? and Attribute=?',['Yes',$uid,$type,$id]);
           echo 'yes';
        }
      } else {
        DB::insert('insert into favourites(Flag,UserId,FavouriteType,Attribute) values (?,?,?,?)',['Yes',$uid,$type,$id]);
        echo "yes";
      }
    }

    public function getImages(Request $request) {
      $type = $request->type;
      $id = $request->id;
      $uid = $request->uid;

      $image = DB::select('select ImagePath from images where ImageRefType=? and ReferenceId=? and IsDeleted=?',[$type,$id,'N']);

      if(count($image) > 0) {
        if(file_exists('localhost/public/'.$image[0]->ImagePath)) {
            echo "public/".$image[0]->ImagePath;
        } else {
            echo "public/images/".$type.".jpg";
        }
      } else {
        echo "public/images/".$type.".jpg";
      }
    }
    
    public function mailbox(Request $request){
    	if($request->session()->has('user_id')){
    		$user_email = $request->session()->get('email');
    		$incoming_messages = DB::select('select DISTINCT m.Sender,m.MessageId,m.Subject,m.Message,m.date,m.Status,u.UserType,u.UserId from messages m INNER JOIN users u where m.Receiver=? and u.Email=m.Sender and m.isArchived=? ORDER BY MessageId DESC',[$user_email,"no"]);
    		return view('inbox',['incoming'=>$incoming_messages]);
    	}
    	else{
    		
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','please login to continue..');
  			return view('login');
  		}
    }
    public function sendMsg(Request $request){
    	if($request->session()->get('user_id')){
    	//	$check_mail = DB::select('SELECT UserName,Email FROM users WHERE UserName LIKE 'B%';')
    		return view('sendmessage',['show_values'=>'yes']);
    	}
    	else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','please login to continue..');
  			return view('login');
  		}
    }      
    public function sendMail(Request $request){
        $user_email = $request->session()->get('email');  
    	$to_mail = $request->to_mail;
    	$subject = $request->subject;
    	$message = $request->message;
    	$attachment = $request->attachment;
    	//echo $attachment;
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = 20;
    	$incoming_messages = DB::select('select m.MessageId,m.Sender,m.Subject,m.Message,m.date,u.UserType from messages m INNER JOIN users u where m.Receiver=? and u.Email=? ORDER BY MessageId DESC',[$user_email,$user_email]);
    	$send_mail = DB::table('messages')->InsertGetId(array('Receiver'=>$to_mail,'Sender'=>$user_email,'Subject'=>$subject,'Message'=>$message,'IsReceived'=>'no','RepliedTo'=>0,'isArchived'=>'no','Status'=>0));
    	if($send_mail){
    		if(Input::hasFile('attachment')){
            $file = Input::file('attachment');
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $file->move('./public/images/messages', $randomString);
            $image = url("public/images/messages/".$randomString);
            $image_insert = DB::table('images')->insertGetId(array('ImagePath'=>$image,'ImageRefType'=>'Message','ReferenceId'=>$send_mail));
        }
        else {
            $image = "NA";
        }
        	$request->session()->flash('message.level','success');
  			  $request->session()->flash('message.content','Message Send Sucessfully..');
        	return redirect('sentmessage');
    	}
    	else{
    		$request->session()->flash('message.level','info');
  			$request->session()->flash('message.content','Message not Send.Please, Try again..');
  			return view('mail',['incoming'=>$incoming_messages]);
    	}
    }
    public function sentMessage(Request $request){
    	if($request->session()->has('user_id')){
    		$user_email = $request->session()->get('email');
    		$outgoing_messages = DB::select('select m.MessageId,m.Receiver,m.Subject,m.Message,m.date,u.UserType,u.UserId from messages m INNER JOIN users u where m.Sender=? and m.isArchived=? and  u.Email=m.Receiver ORDER BY MessageId DESC',[$user_email,'no']);
    		return view('sentmessage',['outgoing'=>$outgoing_messages]);
    	}
    	else{
    		
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','please login to continue..');
  			return view('login');
  		}
    }
    public function archiveMessage(Request $request){
    	if($request->session()->get('user_id')){
    		$user_email = $request->session()->get('email');
    		$user_id = $request->session()->get('user_id');
    		$archive_messages = DB::select('select m.MessageId,m.Sender,m.Receiver,m.Subject,m.Message,m.date,u.UserType,u.UserId from messages m INNER JOIN users u where m.Receiver=? and m.isArchived=? and u.Email=m.Receiver ORDER BY MessageId DESC',[$user_email,'yes']);
    		if(count($archive_messages)>0){
    		$sender = $archive_messages[0]->Sender;
    		$receiver = $archive_messages[0]->Receiver;
    		$sender_details = DB::select('select UserId from users where Email=?',[$sender]);
    		$sender_id = $sender_details[0]->UserId;
    		$receiver_details = DB::select('select UserId from users where Email=?',[$receiver]);
    		$receiver_id = $receiver_details[0]->UserId;
    		return view('archievemessage',['archive_messages'=>$archive_messages,'sender_id'=>$sender_id,'receiver_id'=>$receiver_id,'user_id'=>$user_id,'user_email'=>$user_email]);
    		}
    		else{
    			$request->session()->flash('message.level','info');
  				$request->session()->flash('message.content','No messages are archived ');
  				return redirect('inbox');
    		}
    	}
    	else{
    		
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','please login to continue..');
  			return view('login');
  		}
    }

    public function viewmessage(Request $request){
    	if($request->session()->has('user_id')){
    		$user_email = $request->session()->get('email');
    		$pieces = explode(',',$request->id);
    		$sender_id = $pieces[0];
    		$message_id = $pieces[1];
    		$sender_mail = DB::select('select Email from users where UserId=?',[$sender_id]);
    		if(count($sender_mail)>0){
    		$sender = $sender_mail[0]->Email;
    		$messages = DB::select('select MessageId,Sender,Receiver,Subject,Message,date,isArchived from messages where MessageId=?',[$message_id]);
        $subject = $messages[0]->Subject;
    		$reply_messages = DB::select('select MessageId,Sender,Receiver,Subject,Message,date ,isArchived from messages where RepliedTo=?',[$message_id]);

    		if(count($messages)>0){
    		$update_status = DB::update('update messages set Status=? where (Sender=? and Receiver=?) or (Receiver=? and Sender=?)',[1,$sender,$user_email,$sender,$user_email]);
    		$archive = $messages[0]->isArchived;
    		$msgcount = count($messages);
    		$outgoing_messages = DB::select('select MessageId,Receiver,Subject,Message,date from messages where Sender=?',[$user_email]);
    		return view('viewmessage',['messages'=>$messages,'outgoing'=>$outgoing_messages,'sender_id'=>$sender_id,'message_id'=>$message_id,'archive'=>$archive,'sender'=>$sender,'msgcount'=>$msgcount,'user_email'=>$user_email,'replymessage'=>$reply_messages,'subject'=>$subject]);
    		}
    		else{
    			$request->session()->flash('message.level','danger');
  				$request->session()->flash('message.content','Conversation not started with the user..');
    			return redirect('inbox');
    		}
    		}
    	}
    	else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','please login to continue..');
  			return view('login');
  		}
    }
    public function sendReply(Request $request){
    	$url_id = $request->id;
    	$pieces = explode(',',$request->id);
    	$sender_id = $pieces[0];
    	$message_id = $pieces[1];
    	$user_email = $request->session()->get('email');
    	$subject = $request->subject;
    	$message = $request->message;
    	$to_mail = $request->to_mail;
    	$attachment = $request->attachment;
    	
    	$send_reply = DB::table('messages')->InsertGetId(array('Receiver'=>$to_mail,'Sender'=>$user_email,'Subject'=>$subject,'Message'=>$message,'IsReceived'=>'no','RepliedTo'=>$message_id,'isArchived'=>'no','Status'=>0));
    	if($send_reply){
    		$request->session()->flash('message.level','success');
  			$request->session()->flash('message.content','Message Send Sucessfully..');
        	return redirect('replymessage/'.$url_id);
    	}
    	else{
    		$request->session()->flash('message.level','info');
  			$request->session()->flash('message.content','Message not Send.Please, Try again..');
  			return redirect('replymessage/'.$url_id);
    	}
    }

    public function archive(Request $request){
    	if($request->session()->has('user_id')){
    		$user_id = $request->session()->get('user_id');
    		$pieces = explode(',',$request->id);
    		$sender_id = $pieces[0];
    		$message_id = $pieces[1];
    		$check_archive = DB::select('select isArchived,Sender,Receiver from messages where MessageId=?',[$message_id]);
    		if(count($check_archive)>0){
    		$archive_info = $check_archive[0]->isArchived;
    		$sender = $check_archive[0]->Sender;
    		$receiver = $check_archive[0]->Receiver;
    		if($archive_info == "no"){ 
    		$archieve_msg = DB::update('update messages set isArchived=? where (Sender=? and Receiver=?) or (Sender=? and Receiver=?)',['yes',$sender,$receiver,$receiver,$sender]);
    		if($archieve_msg){
    		$request->session()->flash('message.level','success');
  			$request->session()->flash('message.content','Conversation has been archived');
        	}
        	}
        	else{
        	$archive_msg = DB::update('update messages set isArchived=? where (Sender=? and Receiver=?) or (Sender=? and Receiver=?)',['no',$sender,$receiver,$receiver,$sender]);
        	if($archive_msg){
    		$request->session()->flash('message.level','success');
  			$request->session()->flash('message.content','Conversation has been removed from archived');
        	
        	}
        	}
        	}
        	else{
        		$request->session()->flash('message.level','danger');
  				$request->session()->flash('message.content','Message doesnot Exist..');
        	}
    	}
    	else{
    		
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','please login to continue..');
  			return view('login');
  		}
    }
    public function deleteMessage(Request $request){
    	if($request->session()->has('user_id')){
    		$message_id = $request->id;
    		$delete_message = DB::delete('delete from messages where MessageId=?',[$message_id]);
    		$request->session()->flash('message.level','info');
  			$request->session()->flash('message.content','Message deleted Successfully.');
    	}
    	else{
  			$request->session()->flash('message.level','danger');
  			$request->session()->flash('message.content','please login to continue..');
  			return view('login');
  		}
    }

    public function emailSuggestions(Request $request){
     $q = $request->id;
     $to_mail = DB::select('select Email as to_mail from users where Email like "%'.$q.'%"');
     var_dump($to_mail);
     if(count($to_mail)>0) {
       //echo json_encode($to_mail);
     	return response()->json(response);
     }
    }




}
