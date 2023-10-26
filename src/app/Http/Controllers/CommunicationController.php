<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\Seeking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
  public function index()
  {
    //ログインしていない場合、ログインページにリダイレクト
    if (!Auth::check()) {
      return redirect()->route('login')->with('message', '他のユーザーとやりとりするには、ログインが必要です。');
    }

      //ログインしているユーザーのID取得
      $user = Auth::user();
      $user_id = $user->id;
      $registered_sns_flag = $user->registered_sns_flag;
  
      //自分が気になるした募集を取得
      $seekings = Seeking::whereHas('likes', function ($query) use ($user_id) {
          $query->where('like_from_user_id', $user_id);
      })
      ->with('likes')
      ->with('user')
      ->get();

      //気になるされた自分の募集を取得
      $liked_my_seekings = Seeking::where('user_id', $user_id)
      //likesリレーションで、検索条件にあるレコードを取得
      ->whereHas('likes', function ($query) use ($user_id) {
          $query->where('like_from_user_id', '!=', $user_id);
      })
      //気になるしたユーザーも取得
      ->with(['likes' => function ($query) use ($user_id) {
          $query->where('like_to_user_id', $user_id);
      }, 'likes.likes_to_users'])
      ->get();

      // マッチしているユーザーを募集に紐づけて取得
      //一旦、マッチしている募集を取得
      $connected_seekings = Seeking::whereHas('likes', function ($query) use ($user_id) {
          //マッチが成立している
          $query->where('connected_flag', 1)
              //自分がマッチに関与している
              ->where(function ($query) use ($user_id) {
                  $query->where('like_from_user_id', $user_id)
                        ->orWhere('like_to_user_id', $user_id);
              });
      })
      ->with('likes')
      ->get();

      /* 
        募集で回して、その中のconnectionで回して、ログインしているユーザー($user_id)ではない方のユーザーを、
        connected_usersにpushしている
      */
      foreach ($connected_seekings as $connected_seeking) {
        //募集に紐づけてマッチしているユーザーを取得する用
        $connected_users = collect();

        //ログインユーザーのidではない方を、pushする
        foreach ($connected_seeking->likes as $like) {
            if ($like->like_from_user_id == $user_id) {
                $connected_users->push($like->like_to_user_id);
            }
            if ($like->like_to_user_id == $user_id ) {
                $connected_users->push($like->like_from_user_id);
            }
          }
        $connected_seeking->connected_users = $connected_users;
      }

      return view('communication.communication', compact('seekings', 'liked_my_seekings', 'connected_seekings', 'registered_sns_flag'));
  }
}