<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
  use HasFactory;

  protected $fillable = ['like_from_user_id', 'like_to_user_id', 'like_to_seeking_id', 'connected_flag', 'connected_date'];

  // likeしたユーザーを取得
  public function likes_from_users()
  {
      return $this->belongsTo(User::class, 'like_from_user_id');
  }

  // likeされたユーザーを取得
  public function likes_to_users()
  {
      return $this->belongsTo(User::class, 'like_to_user_id');
  }

  // 募集へのリレーション
  public function seeking()
  {
      return $this->belongsTo(Seeking::class, 'like_to_seeking_id');
  }

  /**
   * likeのレコードを作成する
   *
   * @param int $seeking_id
   * @param int $like_from_user_id
   * @param int $like_to_user_id
   * @return void
   */
  public static function createLikeRecord($seeking_id, $like_from_user_id, $like_to_user_id)
  {
    $like = new Like; 
    $like->like_to_seeking_id = $seeking_id;
    //likeした人と、likeされた人のidを入れる
    $like->like_from_user_id = $like_from_user_id;
    $like->like_to_user_id = $like_to_user_id;
    $like->save();
  }

  /**
   * likeのレコードを削除する
   *
   * @param int $seeking_id
   * @param int $like_from_user_id
   * @return void
   */
  public static function deleteLikeRecord($seeking_id, $like_from_user_id)
  {
    Like::where('like_to_seeking_id', $seeking_id)
      ->where('like_from_user_id', $like_from_user_id)
      ->delete();
  }

  /**
   * マッチした処理
   *
   * @param int $like_id
   * @return void
   */
  public static function changeConnectedFlag($like_id)
  {
    $like = Like::find($like_id);

    //connected_flagを1に設定
    if ($like->connected_flag = 1) {
      $like->connected_flag = 0; 
    } else {
      $like->connected_flag = 1; 
    }
    $like->save(); 
  }
}
