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

    <!-- メールアドレス -->
    <div>
      <input id="email" class="block px-4 py-3 border-none w-full placeholder-gray mt-2 text-sm js-required-form" type="text"
        name="email" required autofocus autocomplete="email" placeholder="メールアドレスを入力してください" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- パスワード -->
    <div>
      <input id="password" class="block px-4 py-3 border-none w-full placeholder-gray mt-2 text-sm js-required-form" type="password"
        name="password" required autofocus autocomplete="password" placeholder="パスワードを設定してください" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- パスワード確認 -->
    <div>
      <input id="password_confirmation" class="block px-4 py-3 border-none w-full placeholder-gray mt-2 text-sm js-required-form" type="password_confirmation"
        name="password_confirmation" required autofocus autocomplete="password_confirmation" placeholder="上記パスワード確認のため、もう一度入力してください" />
      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!--  新大生チェック -->
    <P class="text-sm text-center mt-28 flex justify-center items-center">あなたは新潟大学の生徒ですか<span class="text-xs text-main ml-">必須</span></P>
    <div class="flex justify-center items-center mt-1">
      <input type="checkbox" id="myCheckbox" name="myCheckbox" class="text-main rounded-full p-2 focus:border-main focus:ring-main bg-bg js-required-check">
      <label for="myCheckbox" class="ml-2">はい、そうです</label>
    </div>

    <!--  登録ボタン -->
    <div class="text-center">
      <button class="bg-gray register-button text-white rounded-lg py-4 px-8 mt-6 font-bold w-11/12">登録してSinderをはじめる</button>
    </div>
  </form>
@endsection
