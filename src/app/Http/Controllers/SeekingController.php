<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Seeking;
use Illuminate\Http\Request;
use App\Http\Requests\SeekingRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
            $registered_sns_flag = $user->registered_sns_flag;
    
            //自分以外の募集を取得
            $seekings = Seeking::where('user_id', '!=', $user->id)
                //自分が気になるしているlikesモデルを取得
                ->with(['likes' => function ($query) use ($user){
                    $query->where('like_from_user_id', $user->id);
                }])
                //募集しているユーザーを取得
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();
    
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
        if (!Auth::check()) {
          return redirect()->route('login')->with('message', '投稿するにはログインが必要です。');
        }

        //SNS登録していない場合リダイレクト
        $user = Auth::user();
        if(!$user->registered_sns_flag) {
          return redirect()->route('profile.edit')->with('message', '投稿するには連絡を受け取れるSNSを一つ登録してください。');
        }
      

        return view('seeking.create');
    }

    public function store(SeekingRequest $request)
    {
      $seeking = new Seeking;
      $seeking->user_id = Auth::id();
      $seeking->title = $request->title;
      $seeking->content = $request->content;

      if ($request->hasFile('seeking_thumbnail')) {
          $seeking_thumbnail = $request->file('seeking_thumbnail');
          $filename = time() . '.webp';

          // Intervention Imageを使用して画像を圧縮する
          $image = Image::make($seeking_thumbnail)
            ->orientate()
            ->resize(750, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp')  // WebP形式に変換
            ->stream(); // 圧縮した画像のデータを取得

          try {
              // 画像をS3にアップロード
              Storage::disk('s3')->put('/seeking_thumbnail/' . $filename, (string) $image);
          } catch (Exception $e) {
              error_log('アップロードエラー: ' . $e->getMessage());
          }
          
          $seeking->seeking_thumbnail = $filename;
      } else {
          $seeking->seeking_thumbnail = 'default-thumbnail.png';
      }

      $seeking->save();

      return redirect()->back()->with('success', '募集が作成されました！');
      }

    public function show($seeking_id)
    {
        $seeking = Seeking::findOrFail($seeking_id);
        $my_seeking = false;
        $my_like_check = false;
        $logged_in = false;
        $registered_sns_flag = false;

        //ログインしている場合
        if (Auth::check()) {
          $logged_in = true;

          //ユーザー取得
          $user = Auth::user();
          $registered_sns_flag = $user->registered_sns_flag;

          //自分の募集かどうか
          $my_seeking = ($seeking->user->id === $user->id) ? true : false;

          //自分は気になるを押してある募集か判別
          $my_like_check = (Like::where('like_to_seeking_id', $seeking_id)->where('like_from_user_id', $user->id)->exists());

          // created_atを相対時間表記に変換する
          $seeking->formatted_created_at = $seeking->created_at->diffForHumans();

        }
        return view('seeking.show', compact('seeking', 'logged_in', 'my_seeking', 'my_like_check', 'registered_sns_flag'));
    }

    public function edit($id)
    {
        $seeking = Seeking::findOrFail($id);

        return view('seeking.edit', compact('seeking'));
    }

    public function update(Request $request, $id)
    {
        $seeking = Seeking::findOrFail($id);

        $seeking->title = $request->input('title');
        $seeking->content = $request->input('content');

        if ($request->hasFile('seeking_thumbnail')) {
            $seeking_thumbnail = $request->file('seeking_thumbnail');
            $filename = time() . '.webp';

            // Intervention Imageを使用して画像を圧縮する
            $image = Image::make($seeking_thumbnail)
                ->orientate()
                ->resize(750, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp')  // WebP形式に変換
                ->stream(); // 圧縮した画像のデータを取得

            try {
                // 画像をS3にアップロード
                Storage::disk('s3')->put('/seeking_thumbnail/' . $filename, (string) $image);
            } catch (Exception $e) {
                error_log('アップロードエラー: ' . $e->getMessage());
            }
            
            $seeking->seeking_thumbnail = $filename;
        }

        $seeking->save();

        return redirect()->route('seeking.show', $seeking->id);
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