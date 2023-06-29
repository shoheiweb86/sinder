<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Seeking;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show($user_name)
    {
        $logged_in = false; //ログインしているか
        $my_profile = false; //自分のプロフィールか
        $connected_flag = false; //マッチしているか

        // スラッグを使用して該当するユーザーを検索
        $profile_user = User::where('name', $user_name)->first();
        if (!$profile_user) {
            abort(404); // ユーザーが見つからない場合は404エラーを返すなどの処理を行う
        }
      

         //ログインしているか
        if (Auth::check()) {
            $logged_in = true;
            $logged_in_user_id =  auth()->user()->id;

            //自分のプロフィールかどうか
            if($profile_user->id === $logged_in_user_id) {
                $my_profile = true;
            }

            //マッチしているか
            $connected_users_1 = $profile_user->connections()->pluck('user_id_1')->all();
            $connected_users_2 = $profile_user->connections()->pluck('user_id_2')->all();

            if (in_array($logged_in_user_id, $connected_users_1) || in_array($logged_in_user_id, $connected_users_2)) {
                $connected_flag = true;
            }

          // プロフィールユーザーの募集を取得するクエリ 「気になる」しているかも取得
          $seekings = Seeking::where('user_id', $profile_user->id)
              ->with(['likes' => function ($query) {
                $query->where('user_id', auth()->user()->id);
              }])
              ->with('user')
              ->get();
        } else {
          // 該当するユーザーの募集を取得するクエリ
          $seekings = Seeking::where('user_id', $profile_user->id)->get();
        }

        // ユーザーのプロフィールページを表示するビューを返す
        return view('profile.show', compact('profile_user', 'seekings', 'logged_in', 'my_profile', 'connected_flag'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
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

        // ファイルが送信された場合、DBに保存する
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatars', $filename); // ファイルを保存するディレクトリを指定する
            $user->avatar = $filename;
        }
        
        // DBに保存
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
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
