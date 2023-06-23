<?php

namespace App\Http\Controllers;

use App\Models\Seeking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
  public function index()
  {
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

      
      return view('communication.communication', compact('seekings', 'liked_my_seekings'));
  }
  
}