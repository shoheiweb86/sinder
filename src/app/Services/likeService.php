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
}