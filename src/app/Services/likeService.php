<?php
namespace App\Services;

use App\Models\Like;
use App\Models\Seeking;
use Illuminate\Support\Facades\Auth;
class likeService
{

  /**
   * ユーザーが気になるしているか判断
   *
   * @param int $user_id
   * @param int $seeking_id
   * @return bool
   */
  public static function checkAlreadyLike($user_id, $seeking_id)
  {
    //自分は気になるを押してある募集か判別
    if (Like::where('like_to_seeking_id', $seeking_id)
      ->where('like_from_user_id', $user_id)
      ->exists()) 
    {
      return true;
    }
    return false;
  }

  /**
   * 2人のユーザーがマッチしているか判定する
   *
   * @param int $user_1
   * @param int $user_2
   * @return bool
   */
  public static function checkConnected($user_1, $user_2) {
    //マッチしているレコードを取得
    $connected_likes =  Like::where('connected_flag', 1);

    //マッチしているか判定
    foreach ($connected_likes as $connected_like) {
      if (($connected_like->like_to_user_id == $user_1 && 
        $connected_like->like_from_user_id == $user_2) 
        ||
        $connected_like->like_to_user_id == $user_2 && 
        $connected_like->like_from_user_id == $user_1) 
      {
        return true;
      }
    }
    return false;
  }
}