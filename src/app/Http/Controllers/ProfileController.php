<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Seeking;
use App\Models\User;
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
            //マッチが成立しているレコードから、
            //like_from_user_idとlike_to_user_idを配列で取得する
            $connected_like_from_users_id = $profile_user->likes_from_users()
                  ->where('connected_flag', 1)
                  ->pluck('like_from_user_id')
                  ->all();
            $connected_like_to_users_id = $profile_user->likes_to_users()
                    ->where('connected_flag', 1)
                    ->pluck('like_to_user_id')
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

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = Auth::user();

        //ログインしないで気になる押した場合
        if($request->query('like_no_sns')) {
            Session::flash('message', '「気になる」をするには連絡を取れるSNSを登録してください。');
        }
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // ユーザーのインスタンスを取得
        $user = $request->user();

        // リクエストのデータでユーザーオブジェクトの属性を設定
        $user->fill($request->validated());

        // メールアドレスを変更した場合に、認証時刻をnullにする
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // ファイルが送信された場合、S3に保存する
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.webp';

            // Intervention Imageを使用して画像を圧縮
            $image = Image::make($avatar)
                ->orientate()
                ->resize(750, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp')  // WebP形式に変換
                ->stream();  // 圧縮した画像のデータを取得

            try {
                // 画像をS3にアップロード
                Storage::disk('s3')->put('/avatar/' . $filename, (string) $image);
            } catch (Exception $e) {
                error_log('アップロードエラー: ' . $e->getMessage());
            }

            // S3上の画像URLを保存
            $user->avatar = $filename;
        } else {
            $user->avatar = 'default-avatar.png';
        }

        // SNSのリンク最低一つ登録されたらtrue
        if ($user->line_link || $user->twitter_link || $user->instagram_link) {
            $user->registered_sns_flag = true;
        } else {
            $user->registered_sns_flag = false;
        }

        // DBに保存
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    //ユーザー削除（実装していない）
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
