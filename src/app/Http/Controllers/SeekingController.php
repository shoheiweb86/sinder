<?php

namespace App\Http\Controllers;

use App\Models\Seeking;
use App\Models\User;
use App\Http\Requests\SeekingRequest;
use Illuminate\Support\Facades\Auth;

use App\Services\userService;
use App\Services\seekingService;
use App\Services\likeService;
class SeekingController extends Controller
{
  public function index()
  {    
    //ログインしているかチェック
    if (Auth::check()) {
      $user_id = Auth::id();

      //SNSが登録されているかチェック
      $registered_sns_flag = User::getRegisteredSnsFlag($user_id);

      //募集にlikeとuserを紐づけて取得
      $seekings = Seeking::getSeekingsBySexWithLikesAndUser($user_id, "all");

      //男性の募集にlikeとuserを紐づけて取得
      $man_seekings = Seeking::getSeekingsBySexWithLikesAndUser($user_id, "man");

      //女性募集にlikeとuserを紐づけて取得
      $woman_seekings = Seeking::getSeekingsBySexWithLikesAndUser($user_id, "woman");

    } else {
      //ログインしていない
      $registered_sns_flag = false;
      $user_id = null;

      //全ての募集を取得
      $seekings = Seeking::getSeekingsBySex("all");

      //男性の全ての募集を取得
      $man_seekings = Seeking::getSeekingsBySex("man");

      //女性の全ての募集を取得
      $woman_seekings = Seeking::getSeekingsBySex("woman");
    }
    return view('seeking.seekings', compact('user_id', 'seekings', 'man_seekings', 'woman_seekings', 'registered_sns_flag'));
  }

  public function create()
  { 
    //ログインしていないユーザーをリダイレクト
    userService::redirectToLoginIfNotLoggedIn('募集を作成するにはログインが必要です。');

    //SNS登録していない場合リダイレクト
    userService::redirectToLoginIfNotLSns('投稿するには連絡を受け取れるSNSを一つ登録してください。');

    return view('seeking.create');
  }

  public function store(SeekingRequest $request)
  {
    //募集をDBに保存
    Seeking::createSeeking($request);

    if ($request->hasFile('seeking_thumbnail')) {
      //画像を圧縮して.webpに変換
      $compressed_image  = seekingService::compressionImage($request->file('seeking_thumbnail'));
  
      //S3に画像をアップロード
      seekingService::uploadImageS3($compressed_image, 'seeking_thumbnail');
    }

    return redirect()->back()->with('success', '募集が作成されました！');
    }

  public function show($seeking_id)
  {
    //idから募集を取得
    $seeking = Seeking::getSeekingById($seeking_id);

    //created_atを相対時間表記に変換する
    $seeking->formatted_created_at = $seeking->formattedCreatedAt();

    //ログインしているかチェック
    if (Auth::check()) {
      $logged_in = true;
      $user_id = Auth::id();

      //SNSが登録されているかチェック
      $registered_sns_flag = User::getRegisteredSnsFlag($user_id);
      //自分の募集かチェック
      $my_seeking =  seekingService::checkMySeeking($seeking_id, $user_id);
      //自分が気になるしているかチェック
      $my_like_check = LikeService::checkAlreadyLike($seeking, $user_id);
    
    //ログインしていない場合は、全てfalse
    } else {
      $logged_in = false;
      $registered_sns_flag = false;
      $my_seeking = false;
      $my_like_check = false;
    }

    return view('seeking.show', compact('seeking', 'logged_in', 'my_seeking', 'my_like_check', 'registered_sns_flag'));
  }

  public function edit($seeking_id)
  {
    $seeking = Seeking::getSeekingById($seeking_id);

    return view('seeking.edit', compact('seeking'));
  }

  public function update(SeekingRequest $request, $seeking_id)
  {
    //募集をDBに保存
    Seeking::updateSeeking($request, $seeking_id);

    //画像を圧縮して.webpに変換
    $compressed_image  = seekingService::compressionImage($request->file('seeking_thumbnail'));

    //S3に画像をアップロード
    seekingService::uploadImageS3($compressed_image, "seeking_thumbnail");

    return redirect()->route('seeking.show', $seeking_id);
  }

  public function destroy($seeking_id)
  {
    if (Auth::check()) 
    {
      //募集の画像をS3から削除
      $seeking = Seeking::getSeekingById($seeking_id);
      seekingService::deleteImageS3("seeking_thumbnail", $seeking->seeking_thumbnail);

      //募集をDBから削除
      Seeking::deleteSeeking($seeking_id);

      //ユーザーのプロフィールにリダイレクト
      $user_id = Auth::id();
      return userService::redirectUserProfile($user_id);
    }

    //ログインしていないユーザーをリダイレクト
    return userService::redirectToLoginIfNotLoggedIn('募集を削除するにはログインが必要です。');
  }
}