<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Services\seekingService;
use App\Services\likeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
  public function like(Request $request)
  {
    //likeされた募集を取得
    $seeking_id = $request->seeking_id;

    //likeしたユーザーを取得
    $like_from_user_id = Auth::id(); 

    //募集を作成したユーザーのidを取得
    $like_to_user_id = seekingService::getCreatorUserId($seeking_id);
    
    //ユーザーが気になるしているか判断
    $already_liked = likeService::checkAlreadyLike($like_from_user_id, $seeking_id);

    //ユーザーが気になるしていない場合
    if ($already_liked == false) { 
      Like::createLikeRecord($seeking_id, $like_from_user_id, $like_to_user_id);
    } else { 
      //もしこのユーザーがこの投稿に既にいいねしてたらdelete
      Like::deleteLikeRecord($seeking_id, $like_from_user_id, $like_to_user_id);
    }

    return;
  }

  public function match(Request $request)
  {
    $like_id = $request->like_id;
    Like::changeConnectedFlag($like_id);
    
    return redirect()->back()->with('success', 'マッチ成功！マッチ済みを確認してください！');
  }
}
