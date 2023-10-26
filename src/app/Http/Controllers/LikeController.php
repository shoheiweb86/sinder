<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Seeking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
  public function like(Request $request)
  {
      //likeした人を取得
      $like_from_user_id = Auth::id(); 
      $seeking_id = $request->seeking_id;

      //募集を作成したユーザーのidを取得
      $seeking = Seeking::where('id', $seeking_id)->first();
      $like_to_user_id = $seeking->user_id;
      
      //ユーザーが気になるしているか判断
      $already_liked = Like::where('like_from_user_id', $like_from_user_id)->where('like_to_seeking_id', $seeking_id)->first();
  
      //ユーザーが気になるしていない場合
      if (!$already_liked) { 
          $like = new Like; 
          $like->like_to_seeking_id = $seeking_id;
          //likeした人と、likeされた人のidを入れる
          $like->like_from_user_id = $like_from_user_id;
          $like->like_to_user_id = $like_to_user_id;
          $like->save();
      } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
          Like::where('like_to_seeking_id', $seeking_id)->where('like_from_user_id', $like_from_user_id)->delete();
      }
      return;
  }
}
