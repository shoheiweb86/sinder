<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function create(Request $request, $seeking_id, $liked_user_id)
    {
        $userId = auth()->user()->id;

        // 既にマッチしているかどうかをチェックします
        $existingConnection = Connection::where(function ($query) use ($userId, $liked_user_id) {
          $query->where('user_id_1', $userId)->where('user_id_2', $liked_user_id);
        })->orWhere(function ($query) use ($userId, $liked_user_id) {
            $query->where('user_id_1', $liked_user_id)->where('user_id_2', $userId);
        })->first();

        if ($existingConnection) {
            return redirect()->back()->with('error', '既にマッチしています！');
        }


        $connection = new Connection();
        $connection->user_id_1 = auth()->user()->id; // 募集を投稿したユーザーのID
        $connection->user_id_2 = $liked_user_id; // 気になるユーザーのID
        $connection->connection_date = Carbon::now(); // 現在の時刻を格納
        $connection->save();

        // マッチング後の処理を追加する場合はここに記述

        return redirect()->back()->with('success', 'マッチングしました！');
    }
}
