@extends('layouts.layout')
@section('title', 'パスワード設定')

@section('content')
<div class="bg-gray-100 pt-24">
    <div class="bg-white p-8 rounded-lg shadow-md w-96 mx-auto">

        <!-- Session Status -->
        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- 学籍番号を入力 jsでドメインを追加してる -->
            <div class="mb-4">
              <label for="email" class="mt-6 text-sm">学籍番号(小文字)</label>
              <input id="email" class="block px-4 py-2  mt-1 w-full placeholder-gray text-sm border-black rounded-md" type="text"
                name="email" required placeholder="" />
                @if ($errors->has('email'))
                  <p class="text-sm text-vivid">正しい学籍番号(小文字)を入力してください。</p>
                @endif
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm text-gray-700">再設定するパスワード(8文字以上)</label>
                <input id="password" class="block mt-1 w-full px-4 py-2 border-gray-300 rounded-md" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm text-gray-700">再設定するパスワードの確認</label>
                <input id="password_confirmation" class="block mt-1 w-full px-4 py-2 border-gray-300 rounded-md" type="password" name="password_confirmation" required autocomplete="new-password" />
                @error('password_confirmation')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-end mt-8">
                <button type="submit" class="font-bold w-full bg-main text-white py-2 px-4 rounded hover:bg-main focus:outline-none focus:ring-2 focus:ring-main focus:ring-opacity-50">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>

        <p class="text-sm text-center mt-4"><a href="{{ route('login') }}" class="text-main hover:underline">ログイン画面に戻る</a></p>
    </div>
</div>

  <script type="module">
    $(document).ready(function() {
        $('form').submit(function(e) {
            // フォーム送信を一時的に停止
            e.preventDefault();

            // メールアドレス入力欄の値を取得し、ドメインを追加
            var email = $('#email').val();
            var fullEmail = email + '@mail.cc.niigata-u.ac.jp';

            // フォームをコピーして、ユーザーが見えない場所に仮のフォームを作成
            var $formClone = $(this).clone();
            $formClone.css({
                display: 'none',
                position: 'absolute',
                top: 0,
                left: 0
            });

            // クローンしたフォームのメールアドレスを全てのメールアドレスに更新
            $formClone.find('#email').val(fullEmail);

            // bodyタグの最後にクローンを追加
            $('body').append($formClone);

            // クローンしたフォームを送信
            $formClone.submit();
        });
    });
  </script>
@endsection
