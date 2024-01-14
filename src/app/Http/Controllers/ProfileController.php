<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Seeking;
use App\Models\User;
use App\Services\seekingService;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Exception;

class ProfileController extends Controller
{
    public function show($user_name)
    {
        $logged_in = false; //ログインしているか
        $my_profile = false; //自分のプロフィールか
        $connected_flag = false; //マッチしているか
        $registered_sns_flag = false; //SNSを登録しているか

        // スラッグを使用して該当するユーザーを検索
        $profile_user = User::where('name', $user_name)->first();
        $profile_user_id = $profile_user->id;
        if (!$profile_user) {
            abort(404); // ユーザーが見つからない場合は404エラーを返すなどの処理を行う
        }
      

         //ログインしているか
        if (Auth::check()) {
            $logged_in = true;
            $user = Auth::user();
            $registered_sns_flag = $user->registered_sns_flag;
            $logged_in_user_id =  $user->id;

            //自分のプロフィールかどうか
            if($profile_user_id === $logged_in_user_id) {
                $my_profile = true;
            }

            /* 
              マッチが成立しているレコードから、
              プロフィールユーザーが気になるを送っていた(from)の場合、
              気になるを受け取った(to)のユーザーidを全て取得する 
              逆も行う
            */
            $connected_like_from_users_id = $profile_user->likes_from_users()
                  ->where('connected_flag', 1)
                  ->pluck('like_to_user_id')
                  ->all();
            $connected_like_to_users_id = $profile_user->likes_to_users()
                    ->where('connected_flag', 1)
                    ->pluck('like_from_user_id')
                    ->all();

            //ログインユーザーのidが、マッチしているユーザーのidと一致した場合flag立てる
            if (in_array($logged_in_user_id, $connected_like_from_users_id) 
                || in_array($logged_in_user_id, $connected_like_to_users_id)) {
                $connected_flag = true;
            }
            
          // プロフィールユーザーの募集を取得するクエリ 「気になる」しているかも取得
          $seekings = Seeking::where('user_id', $profile_user_id)
              ->with(['likes' => function ($query) use ($logged_in_user_id) {
                $query->where(function ($query) use ($logged_in_user_id) {
                    $query->where('like_from_user_id', $logged_in_user_id)
                          ->orWhere('like_to_user_id', $logged_in_user_id);
                });
              }])
              ->with('user')
              ->orderBy('created_at', 'desc')
              ->get();
        } else {
          // 該当するユーザーの募集を取得するクエリ
          $seekings = Seeking::where('user_id', $profile_user_id)
              ->orderBy('created_at', 'desc')
              ->get();
        }

        // ユーザーのプロフィールページを表示するビューを返す
        return view('profile.show', compact('profile_user', 'seekings', 'logged_in', 'my_profile', 'connected_flag', 'registered_sns_flag'));
    }

  public function edit($user_id)
  {
    $user = User::getUserById($user_id);

    return view('profile.edit', compact('user'));
  }

  public function update(ProfileUpdateRequest $request): RedirectResponse
  {
    //user_idを取得
    $user_id = Auth::id();

    //プロフィールを更新
    User::updatedProfile($request, $user_id);

    //画像を圧縮して.webpに変換
    $compressed_image  = seekingService::compressionImage($request->file('avatar'));

    //S3に画像をアップロード
    seekingService::uploadImageS3($compressed_image, "avatar");

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
  }
}
