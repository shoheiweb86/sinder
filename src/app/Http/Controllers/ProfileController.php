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
        // スラッグを使用して該当するユーザーを検索
        $user = User::where('name', $user_name)->first();
    
        if (!$user) {
            abort(404); // ユーザーが見つからない場合は404エラーを返すなどの処理を行う
        }

        // 自分の募集を取得するクエリ
        $seekings = Seeking::where('user_id', $user->id)->get();

        // ユーザーのプロフィールページを表示するビューを返す
        return view('profile.show', compact('user', 'seekings'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
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
