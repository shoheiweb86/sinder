<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class userService {


  /**
   * ログインしていないユーザーをリダイレクト
   *
   * @param string 
   * @return void
   */
  public static function redirectToLoginIfNotLoggedIn($message)
  {
    if (!Auth::check()) {
      return redirect()->route('login')->with('message', $message);
    }
  }

  /**
   * SNS登録していない場合リダイレクト
   *
   * @param string $message
   * @return void
   */
  public static function redirectToLoginIfNotLSns($message)
  {
    //SNS登録していない場合リダイレクト
    $user = Auth::user();
    if(!$user->registered_sns_flag) {
      return redirect()->route('profile.edit')->with('message', $message);
    }
  }

  /**
   * ユーザーのプロフィールにリダイレクト
   *
   * @return void
   */
  public static function redirectUserProfile($user_id)
  {
    $user = User::findOrFail($user_id);
    $user_name = $user->name;

    return redirect()->route('profile.show', ['user_name' => $user_name]);
  }
}