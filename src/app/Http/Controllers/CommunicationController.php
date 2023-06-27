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
      $userId = auth()->user()->id;
  
      //自分が気になるした募集を取得
      $seekings = Seeking::whereHas('likes', function ($query) use ($userId) {
          $query->where('user_id', $userId);
      })
      ->with('likes')
      ->with('user')
      ->get();

      //気になるされた自分の募集を取得
      $liked_my_seekings = Seeking::where('user_id', $userId)
      ->whereHas('likes', function ($query) use ($userId) {
          $query->where('user_id', '!=', $userId);
      })
      ->with(['likes' => function ($query) use ($userId) {
          $query->where('user_id', '!=', $userId);
      }, 'likes.user'])
      ->get();

      // マッチしたユーザーの情報を取得
      $connected_users = Connection::where(function ($query) use ($userId) {
        $query->where('user_id_1', $userId)
            ->orWhere('user_id_2', $userId);
      })
      ->with(['user1' => function ($query) use ($userId) {
          $query->where('id', '!=', $userId);
      }, 'user2' => function ($query) use ($userId) {
          $query->where('id', '!=', $userId);
      }])
      ->get();

      
      return view('communication.communication', compact('seekings', 'liked_my_seekings', 'connected_users'));
  }
  
}