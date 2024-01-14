<?php

namespace App\Models;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Connection;
use App\Services\userService;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $guarded = [];

  protected $hidden = [
      'password',
      'remember_token',
  ];

  protected $casts = [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
  ];

  public function seekings()
  {
      return $this->hasMany(Seeking::class, 'user_id');
  }

  public function likes_from_users()
  {
      return $this->hasMany(Like::class, 'like_from_user_id');
  }

  public function likes_to_users()
  {
      return $this->hasMany(Like::class, 'like_to_user_id');
  }

  /**
   * idでユーザーを取得
   *
   * @param int $user_id
   * @return Collection
   */
  public static function getUserById($user_id)
  {
    $user = User::findOrFail($user_id);
    return $user;
  }

  /**
   * ユーザー名でユーザーを取得
   *
   * @param int $user_name
   * @return Collection
   */
  public static function getUserByName($user_name)
  {
    $user = User::where('name', $user_name)->first();
    return $user;
  }

  /**
   * SNS登録済みフラグを取得
   *
   * @param int $user_id
   * @return bool
   */
  public static function getRegisteredSnsFlag($user_id)
  {
    $user = User::findOrFail($user_id);
    return $user->registered_sns_flag;
  }

  /**
   * ユーザープロフィールを上書きする
   *
   * @param ProfileUpdateRequest $request
   * @param int $seeking_id
   * @return void
   */
  public static function updateProfile(ProfileUpdateRequest $request, $user_id)
  {
    //idで特定の募集を取得する
    $user = user::findOrFail($user_id);
    $user->fill($request->all());

    //サムネイルのパスを保存する処理
    if ($request->hasFile('avatar')) {
      $user->avatar =  time() . '.webp';
    } else {
      $user->avatar = 'default-avatar.webp';
    }

    //SNSフラグを更新
    $user->registered_sns_flag = userService::checkSNSLink($user_id);

    $user->save();
  }
}
