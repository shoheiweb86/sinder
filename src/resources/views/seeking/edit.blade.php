@extends('layouts.layout')
@section('title', '募集を編集')


@section('content')
  <div class="container">
    <form action="{{ route('seeking.update', $seeking->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- サムネイル -->
      <div>
        <label for="seeking_thumbnail" class="block relative bg-white w-48 h-64 ml-4 mt-4 rounded-2xl">
          <span class="absolute top-1/2 left-1/2 -translate-y-2/4 -translate-x-1/2 w-10 h-10"><img
              src="{{ asset('storage/materials/cross.png') }}" alt=""></span>
              <input type="file" name="seeking_thumbnail" id="seeking_thumbnail" accept="image/heic,image/*" class="hidden js-required-form">
        </label>
        <x-input-error :messages="$errors->get('seeking_thumbnail')" class="mt-2" />
      </div>

      <!-- タイトル -->
      <div>
        <input id="title" class="block font-bold px-4 py-3 border-none w-full placeholder-gray mt-4 text-sm js-required-form"
          type="text" name="title" required autofocus autocomplete="title" placeholder="キャッチーなタイトルで募集しよう🌿"
          value="{{ $seeking->title }}" />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
      </div>

      <!-- 募集文 -->
      <textarea id="content"
        class="block w-full h-56 mt-2 bg-gray-100 border-none px-4 py-2 text-sm placeholder-gray text-top js-required-form" name="content"
        placeholder="200文字以内で募集内容の詳細を書こう💭" maxlength="200">{{ $seeking->content }}</textarea>
      <x-input-error :messages="$errors->get('content')" class="mt-2" />

      <!--  登録ボタン -->
      <div class="text-center mt-10">
        <button class="bg-gray register-button text-white rounded-lg py-4 px-8 font-bold w-11/12">編集内容を保存する</button>
      </div>
    </form>

    <!--  削除ボタン -->
    <div class="text-center mt-4">
      <form action="{{ route('seeking.destroy', $seeking->id) }}" method="POST"
        onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit"
          class="bg-dark-gray hover:bg-dark-gray text-white rounded-lg py-4 px-8 font-bold w-11/12">募集を削除する</button>
      </form>
    </div>
  </div>
@endsection
