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

    <!-- メールアドレス -->
    <div>
      <input id="email" class="block px-4 py-3 border-none w-full placeholder-gray mt-6 text-sm" type="text"
        name="email" required autofocus autocomplete="email" placeholder="メールアドレスを入力してください" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- パスワード -->
    <div>
      <input id="password" class="block px-4 py-3 border-none w-full placeholder-gray mt-2 text-sm" type="password"
        name="password" required autofocus autocomplete="password" placeholder="パスワードを設定してください" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- ログインボタン -->
    <div class="text-center">
      <button class="bg-white rounded-lg py-4 px-8 mt-6 font-bold w-11/12">ログインする</button>
    </div>

    <div class="flex items-center justify-center mt-4">
      @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          href="{{ route('password.request') }}">
          パスワードを忘れた場合
        </a>
      @endif
    </div>

    <!-- 新規登録ボタン -->
    <div class="block text-center mt-16">
      <a href="{{route('register')}}" class="block bg-main text-white rounded-lg py-3 px-8 font-bold w-11/12 mx-auto">新規登録してSinderをはじめる</a>
    </div>

    <!-- ログインせずに見る -->
    <div class="text-center mt-2">
      <a href="{{route('seeking.index')}}" class="text-main underline" >ログインせずにSinderを見てみる</a>
    </div>

  </form>

@endsection
