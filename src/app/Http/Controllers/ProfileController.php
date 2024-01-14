<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Seeking;
use App\Models\User;
use App\Services\likeService;
use App\Services\seekingService;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
  public function show($user_name)
  {
    $logged_in = false; //ログインしているか
    $my_profile = false; //自分のプロフィールか
    $registered_sns_flag = false; //SNSを登録している

    //表示するプロフィールのユーザーを取得
    $profile_user = User::getUserByName($user_name);
    $profile_user_id = $profile_user->id;

    if (Auth::check()) {
      $logged_in = true;
      $login_user = Auth::user();
      $login_user_id =  $login_user->id;
      $login_user_registered_sns_flag = $login_user->registered_sns_flag;

      //自分のプロフィールかどうか
      if($profile_user_id === $login_user_id) {
        $my_profile = true;
      }
      
      //ログインユーザーとプロフィールユーザーがマッチしているか
      $connected_flag = likeService::checkConnected($profile_user_id, $login_user_id);

      // プロフィールユーザーの募集を取得するクエリ 「気になる」しているかも取得
      $seekings = Seeking::getProfileUserSeekingsWithLike($login_user_id, $profile_user_id);

    } else {
      //プロフィールユーザーの募集を取得
      $seekings = Seeking::getSeekingsByUserId($profile_user_id);
    }

    // ユーザーのプロフィールページを表示するビューを返す
    return view('profile.show', compact('login_user', 'profile_user', 'seekings', 'logged_in', 'my_profile', 'connected_flag', 'registered_sns_flag'));
  }

  public function edit(Request $request)
  {
    $user = Auth::user();
    
    //ログインしないで気になる押した場合
    if($request->query('like_no_sns')) {
      Session::flash('message', '「気になる」をするには連絡を取れるSNSを登録してください。');
    }

    return view('profile.edit', compact('user'));
  }

  public function update(ProfileUpdateRequest $request): RedirectResponse
  {
    //user_idを取得
    $user_id = Auth::id();

    //プロフィールを更新
    User::updateProfile($request, $user_id);

    if ($request->hasFile('avatar')) {
      //画像を圧縮して.webpに変換
      $compressed_image  = seekingService::compressionImage($request->file('avatar'));
  
      //S3に画像をアップロード
      seekingService::uploadImageS3($compressed_image, "avatar");
    }

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
  }
}