<?php

namespace App\Http\Controllers;

use App\Models\Seeking;
use Illuminate\Support\Facades\Auth;

use App\Services\userService;

class CommunicationController extends Controller
{
  public function index()
  {
    //ログインしていないユーザーをリダイレクト
    userService::redirectToLoginIfNotLoggedIn('ユーザーとやり取りするにはログインが必要です。');

    //ログインしているユーザーのID取得
    $user = Auth::user();
    $user_id = $user->id;
    $registered_sns_flag = $user->registered_sns_flag;

    //ログインユーザーがlikeした募集を取得
    $user_liked_seekings = Seeking::getLikedSeekingsByUser($user_id);

    //ログインユーザーのlikeされた募集を取得
    //likeしたユーザーも取得
    $received_likes_seekings = Seeking::getReceivedLikesSeekings($user_id);

    //マッチ済みの自分の募集を取得、マッチしたユーザーも紐づけて取得
    $connected_my_seekings = Seeking::getConnectedMySeekings($user_id);

    //マッチ済みの自分以外の募集を取得、マッチしたユーザーも紐づけて取得
    $connected_others_seekings =  Seeking::getConnectedOthersSeekings($user_id);

    return view('communication.communication', compact('user_liked_seekings', 'received_likes_seekings', 'connected_my_seekings', 'connected_others_seekings', 'registered_sns_flag'));
  }
}