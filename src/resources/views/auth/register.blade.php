@extends('layouts.layout')
@section('title', '新規登録')

@section('content')
  <h2 class="text-main font-logo font-bold tracking-tighter text-5xl text-center mt-24">Sinder</h2>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- 名前 -->
    <div>
      <input id="name" class="block px-4 py-3 border-none w-full placeholder-gray mt-6 text-sm js-required-form" type="text"
        name="name" required autofocus autocomplete="name" placeholder="名前またはニックネーム（あとから変更可能）" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- 学籍番号を入力 jsでドメインを追加してる -->
    <div>
      <input id="email" class="block px-4 py-3 border-none w-full placeholder-gray mt-2 text-sm js-required-form" type="text"
        name="email" required autofocus placeholder="学籍番号を入力してください" />
        @if ($errors->has('email'))
          <p class="text-sm text-vivid">その学籍番号は既に登録されています。</p>
        @endif
    </div>

    <!-- パスワード -->
    <div>
      <input id="password" class="block px-4 py-3 border-none w-full placeholder-gray mt-2 text-sm js-required-form" type="password"
        name="password" required autofocus autocomplete="password" placeholder="パスワードを設定してください" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- パスワード確認 -->
    <div>
      <input id="password_confirmation" class="block px-4 py-3 border-none w-full placeholder-gray mt-2 text-sm js-required-form" type="password"
        name="password_confirmation" required autofocus autocomplete="password_confirmation" placeholder="上記パスワード確認のため、もう一度入力してください" />
      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!--  新大生チェック -->
    <P class="text-sm text-center mt-8 flex justify-center items-center">あなたは新潟大学の生徒ですか<span class="text-xs text-main ml-">必須</span></P>
    <div class="flex justify-center items-center mt-1">
      <input type="checkbox" id="myCheckbox" name="myCheckbox" class="text-main rounded-full p-2 focus:border-main focus:ring-main bg-bg js-required-check" required>
      <label for="myCheckbox" class="ml-2">はい、そうです</label>
    </div>

    <!--  登録ボタン -->
    <div class="text-center">
      <button class="bg-gray register-button text-white rounded-lg py-4 px-8 mt-6 font-bold w-11/12">登録してSinderをはじめる</button>
    </div>
  </form>

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