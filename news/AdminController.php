<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;


class AdminController extends Controller
{
  public function admindashboard(Request $request) {
    return view('admindashboard');
  }

  public function postNews(Request $request){
  	if($request->session()->has('user_id')){
  		$user_id = $request->session()->get('user_id');
  		$post_details = DB::table('advertisements')
      ->selectRaw('*,AdvertisementId,Subject,Url,PublishDate,ExpireDate,Message,Status,AdvertisementType')
      ->where('advertisements.UserId','=',[$user_id])
      ->orderBy('advertisements.AdvertisementId')
      ->paginate(10);
  		return view('postnews',['news'=>$post_details]);
  	}
  	else{
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Passwords didnot match. Please,Try again..');
        return redirect('register');
    }
  }
  public function saveNews(Request $request){
  	$user_id = $request->session()->get('user_id');
    $news_id = $request->news_id;
  	$subject = $request->subject;
  	$publish_date = $request->publish_date;
  	$expire_date = $request->expire_date;
  	$post_type = $request->post_type;
  	$description = $request->description;
  	$link = $request->link;
  	$image = $request->image;
    echo $image;
  	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = 20;
  	$post_details = DB::select('select AdvertisementId,Subject,Url,PublishDate,ExpireDate,Message,Status,AdvertisementType from advertisements where UserId=?',[$user_id]);
    if($news_id){

      $update_news = DB::table('advertisements')->where('AdvertisementId',$news_id)->update(array('AdvertisementType'=>$post_type,'Subject'=>$subject,'Url'=>$link,'Message'=>$description,'PublishDate'=>$publish_date,'ExpireDate'=>$expire_date));
      if(Input::hasFile('image')){
            $file = Input::file('image');
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $file->move('./public/images/admin', $randomString.".png");
            $image = url("public/images/admin/".$randomString.".png");
            $image_insert = DB::table('images')->where('ReferenceId',$news_id)->update(array('ImagePath'=>$image));
        }
        else {
            $image = "NA";
        }
      if($update_news || $image_insert){
        $request->session()->flash('message.level','success');
        $request->session()->flash('message.content','News/Advertisement Updated Successfully..');
        return redirect('postnews');
      }
      else{
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Failed to Update News/Advertisement..');
        return redirect('postnews');
      }
    }
    else{
    $add_post = DB::table('advertisements')->insertGetId(array('AdvertisementType'=>$post_type,'UserId'=>$user_id,'Subject'=>$subject,'Url'=>$link,'Message'=>$description,'ApproverId'=>0,'Status'=>'Pending','PublishDate'=>$publish_date,'ExpireDate'=>$expire_date));

  	if($add_post){
  		if(Input::hasFile('image')){
            $file = Input::file('image');
            $randomString = '';
            for ($i = 0; $i < 20; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $file->move('./public/images/admin', $randomString.".png");
            $image = url("public/images/admin/".$randomString.".png");
            $image_insert = DB::table('images')->insertGetId(array('ImagePath'=>$image,'ImageRefType'=>'Admin News','ReferenceId'=>$add_post));
        }
        else {
            $image = "NA";
        }
  		$request->session()->flash('message.level','success');
        $request->session()->flash('message.content','News/Advertisement Created Successfully..');
  		return redirect('postnews');
  	}
  	else{
  		$request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','News not Saved.Please Try Again.');
  		return view('postnews',['news'=>$post_details]);
  	}
   }
  }

  public function editNews(Request $request){
  	if($request->session()->get('user_id')){
  		$user_id = $request->session()->get('user_id');
  		$news_id = $request->id;
  		$post_details = DB::select('select AdvertisementId,Subject,Url,PublishDate,ExpireDate,Message,Status,AdvertisementType from advertisements where UserId=?',[$user_id]);
  		$news_details = DB::select('select a.AdvertisementId,a.Subject,a.Url,a.PublishDate,a.ExpireDate,a.Message,a.Status,a.AdvertisementType,i.ImagePath from advertisements a INNER JOIN images i where a.UserId=? and i.ImageRefType=? and i.ReferenceId=?',[$user_id,'Admin News',$news_id]);
  		return view('editnews',['news'=>$post_details,'details'=>$news_details]);
  	}
  	else{
        $request->session()->flash('message.level','danger');
        $request->session()->flash('message.content','Passwords didnot match. Please,Try again..');
        return redirect('register');
    }
  }
  public function saveEditNews(Request $request){
  	$user_id = $request->session()->get('user_id');
  	$subject = $request->subject;
  	$publish_date = $request->publish_date;
  	$expire_date = $request->expire_date;
  	$post_type = $request->post_type;
  	$description = $request->description;
  	$link = $request->link;
  	$image = $request->image;
  	$news_id = $request->id;
  	$update_news = DB::table('advertisements')->where('AdvertisementId',$news_id)->update(['AdvertisementType'=>$post_type,'Subject'=>$subject,'Url'=>$link,'Message'=>$description]);
  	if($update_news){
  		$request->session()->flash('message.level','success');
        $request->session()->flash('message.content','News Details Updated Successfully');
        return redirect('postnews');
  	}
  }

  public function deleteNews(Request $request){
  	$id = $request->id;
  	$deletenews = DB::delete('delete from advertisements where AdvertisementId=?',[$id]);
  	$deleteimage = DB::delete('delete from images where ImageRefType=? and ReferenceId=?',['Admin News',$id]);
  }

}
