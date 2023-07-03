@extends('layouts.layout')
@section('title', '募集を作成')

@section('content')
  @if (session('message'))
    <div class="text-red-400 mb-2">
      {{ session('message') }}
    </div>
  @endif
  <!-- コンテンツの記述 -->
  <form action="{{ route('seeking.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto">
    @csrf

    <!-- サムネイル -->
    <div>
      <label for="seeking_thumbnail" class="block relative bg-white w-48 h-64 ml-4 mt-4 rounded-2xl">
        <span class="absolute top-1/2 left-1/2 -translate-y-2/4 -translate-x-1/2 w-10 h-10"><img
            src="{{ asset('storage/materials/cross.png') }}" alt=""></span>
        <input type="file" name="seeking_thumbnail" id="seeking_thumbnail" accept="image/*" class="hidden js-required-form">
      </label>
      <x-input-error :messages="$errors->get('seeking_thumbnail')" class="mt-2" />
    </div>

    <!-- タイトル -->
    <div>
      <input id="title" class="block font-bold px-4 py-3 border-none w-full placeholder-gray mt-4 text-s js-required-form" type="text"
        name="title" required autofocus autocomplete="title" placeholder="キャッチーなタイトルで募集しよう🌿" />
      <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <!-- 募集文 -->
    <textarea id="content"
      class="block w-full h-56 mt-2 bg-gray-100 border-none px-4 py-2 text-sm placeholder-gray text-top js-required-form" name="content"
      placeholder="200文字以内で募集内容の詳細を書こう💭" maxlength="200" required></textarea>
    <x-input-error :messages="$errors->get('content')" class="mt-2" />

    <!--  新大生チェック -->
    <P class="text-sm text-center mt-6 flex justify-center items-center">あなたは新潟大学の生徒ですか<span
        class="text-xs text-main ml-">必須</span></P>
    <div class="flex justify-center items-center mt-1">
      <input type="checkbox" id="my_checkbox" name="my_checkbox"
        class="text-main rounded-full p-2 focus:border-main focus:ring-main bg-bg js-required-check">
      <label for="my_checkbox" class="ml-2 js-check-box">はい、そうです</label>
    </div>

    <!--  登録ボタン -->
    <div class="text-center">
      <button
        class="bg-gray register-button text-white rounded-lg py-4 px-8 mt-4 font-bold w-11/12">募集する</button>
    </div>
  </form>


@endsection
