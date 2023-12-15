<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Seeking;
use Illuminate\Http\Request;
use App\Http\Requests\SeekingRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Services\userService;
use App\Services\seekingService;
class SeekingController extends Controller
{
    public function index()
    {
        $logged_in = false;
        $registered_sns_flag = false;
        $man_seekings = [];
        $woman_seekings = [];
    
        if (Auth::check()) {
            $logged_in = true;
            $user = Auth::user();
            $user_id = Auth::id();

            //SNSが登録されているかチェック
            $registered_sns_flag = User::getRegisteredSnsFlag($user_id);
    
            //自分以外の募集を取得
            $seekings = Seeking::getSeekingsWithLikesAndUser($user_id);
    
            $man_seekings = $seekings->filter(function ($seeking) {
                return $seeking->user->sex === '男性';
            });
    
            $woman_seekings = $seekings->filter(function ($seeking) {
                return $seeking->user->sex === '女性';
            });
        } else {
            $seekings = Seeking::orderBy('created_at', 'desc')
                ->get();
    
            $man_seekings = $seekings->filter(function ($seeking) {
                return $seeking->user->sex === '男性';
            });
    
            $woman_seekings = $seekings->filter(function ($seeking) {
                return $seeking->user->sex === '女性';
            });
        }
    
        return view('seeking.seekings', compact('seekings', 'man_seekings', 'woman_seekings', 'logged_in', 'registered_sns_flag'));
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

      //画像を圧縮して.webpに変換
      $compressed_image  = seekingService::compressionImage($request->file('seeking_thumbnail'));

      //S3に画像をアップロード
      seekingService::uploadImageS3($compressed_image, "seeking_thumbnail");

      return redirect()->back()->with('success', '募集が作成されました！');
      }

    public function show($seeking_id)
    {
      //idから募集を取得
      $seeking = Seeking::findOrFail($seeking_id);
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
        $my_like_check = seekingService::checkMyLike($seeking, $user_id);
      
      //ログインしていない場合は、全てfalse
      } else {
        $logged_in = false;
        $registered_sns_flag = false;
        $my_seeking = false;
        $my_like_check = false;
      }

      return view('seeking.show', compact('seeking', 'logged_in', 'my_seeking', 'my_like_check', 'registered_sns_flag'));
    }

    public function edit($id)
    {
      $seeking = Seeking::findOrFail($id);

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

    public function destroy($id)
    {
        $seeking = Seeking::findOrFail($id);

        // ログインユーザーが募集の所有者であるかを確認
        if ($seeking->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this seeking.');
        }

        // 募集の画像を削除
        if ($seeking->seeking_thumbnail !== 'default-thumbnail.png') {
            Storage::disk('public')->delete('seeking_thumbnail/' . $seeking->seeking_thumbnail);
        }

        // 募集を削除
        $seeking->delete();

        return redirect()->route('profile.show', ['user_name' => auth()->user()->name]);
    }
}