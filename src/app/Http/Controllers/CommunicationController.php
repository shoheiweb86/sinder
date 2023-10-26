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
      $userId = $user->id;
      $registered_sns_flag = $user->registered_sns_flag;
  
      //自分が気になるした募集を取得
      $seekings = Seeking::whereHas('likes', function ($query) use ($userId) {
          $query->where('user_id', $userId);
      })
      ->with('likes')
      ->with('user')
      ->get();

      //気になるされた自分の募集を取得
      $liked_my_seekings = Seeking::where('user_id', $userId)
      //likesリレーションで、検索条件にあるレコードを取得
      ->whereHas('likes', function ($query) use ($userId) {
          $query->where('user_id', '!=', $userId);
      })
      //気になるしたユーザーも取得
      ->with(['likes' => function ($query) use ($userId) {
          $query->where('user_id', '!=', $userId);
      }, 'likes.user'])
      ->get();


      // マッチしているユーザーを募集に紐づけて取得
      //一旦、マッチしている募集を取得
      $connected_seekings = Seeking::whereHas('connections', function ($query) use ($userId) {
        $query->where(function ($q) use ($userId) {
            $q->where('user_id_1', $userId)
                ->orWhere('user_id_2', $userId);
        });
      })
      ->with('connections')
      ->get();

      /* 
        募集で回して、その中のconnectionで回して、ログインしているユーザー($userId)ではない方のユーザーを、
        connected_usersにpushしている
       */
      foreach ($connected_seekings as $connected_seeking) {
        $connected_users = collect();

        foreach ($connected_seeking->connections as $connection) {
            if ($connection->user1->id != $userId && $connection->user2->id == $userId) {
                $connected_users->push($connection->user1);
            }
            if ($connection->user2->id != $userId && $connection->user1->id == $userId) {
                $connected_users->push($connection->user2);
            }
          }
        $connected_seeking->connected_users = $connected_users;
      }

      return view('communication.communication', compact('seekings', 'liked_my_seekings', 'connected_seekings', 'registered_sns_flag'));
  }
  
}