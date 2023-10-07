@extends('layouts.layout')
@section('title', 'ログイン')

@section('content')
  @if (session('message'))
    <div class="text-red-400 mb-2">
      {{ session('message') }}
    </div>
  @endif

  <h2 class="text-main font-logo font-bold tracking-tighter text-5xl text-center mt-24">Sinder</h2>

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- 学籍番号を入力 jsでドメインを追加してる -->
    <div>
      <input id="email" class="block px-4 py-3 border-none w-full placeholder-gray mt-6 text-sm" type="text"
        name="email" required placeholder="学籍番号を小文字で入力してください" />
        @if ($errors->has('email'))
          <p class="text-sm text-vivid">正しい学籍番号(小文字)を入力してください。</p>
        @endif
    </div>

    <!-- パスワード -->
    <div>
      <input id="password" class="block px-4 py-3 border-none w-full placeholder-gray mt-2 text-sm" type="password"
        name="password" required autocomplete="password" placeholder="パスワードを入力してください" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- ログインボタン -->
    <div class="text-center">
      <button class="bg-white rounded-lg py-4 px-8 mt-6 font-bold w-11/12">ログインする</button>
    </div>

    <div class="flex items-center justify-center mt-4">
      @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md"
          href="{{ route('password.request') }}">
          パスワードを忘れた場合
        </a>
      @endif
    </div>

    <!-- 新規登録ボタン -->
    <div class="block text-center mt-10">
      <a href="{{route('register')}}" class="block bg-main text-white rounded-lg py-3 px-8 font-bold w-11/12 mx-auto">新規登録してSinderをはじめる</a>
    </div>

    <!-- ログインせずに見る -->
    <div class="text-center mt-2">
      <a href="{{route('seeking.index')}}" class="text-main underline" >ログインせずにSinderを見てみる</a>
    </div>
    
    
    <!-- 利用規約・プライバシーポリシー -->
    <div class="flex items-center justify-between mt-4 w-4/5 mr-auto ml-auto">
      <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md"
        href="{{ route('policy.index') }}">
        利用規約
      </a>
      <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md"
        href="{{ route('privacy-policy.index') }}">
        プライバシーポリシー
      </a>
      <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md"
        href="https://forms.gle/a6aN5RcvoJPEFPSt8" target="_blank">
        お問い合わせ
      </a>
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
