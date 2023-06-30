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
      $user_id = Auth::user()->id; //1.ログインユーザーのid取得
      $seeking_id = $request->seeking_id; //2.投稿idの取得
      $already_liked = Like::where('user_id', $user_id)->where('seeking_id', $seeking_id)->first(); //3.
  
      if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
          $like = new Like; //4.Likeクラスのインスタンスを作成
          $like->seeking_id = $seeking_id; //Likeインスタンスにreview_id,user_idをセット
          $like->user_id = $user_id;
          $like->save();
      } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
          Like::where('seeking_id', $seeking_id)->where('user_id', $user_id)->delete();
      }
      return;
  }
}
