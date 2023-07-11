@extends('layouts.layout')
@section('title', '募集を編集')


@section('content')
  <div class="container">
    <form action="{{ route('seeking.update', $seeking->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- サムネイル -->
      <div>
        <label for="seeking_thumbnail"
          class="block relative bg-white w-[200px] h-[267px] object-cover aspect-w-3 aspect-h-4 ml-4 mt-4 rounded-2xl">
          <img src="{{ asset('storage/seeking_thumbnail/default-thumbnail.png') }}" alt="デフォルトのサムネイル"
            class="rounded-2xl w-[200px] h-[267px] object-cover aspect-w-3 aspect-h-4 z-10 relative"
            id="seeking_thumbnail-preview">
          <button class="absolute z-20 top-0 right-0 w-9 h-9 rounded-full bg-black bg-opacity-40 text-white"
            id="js-clear-button" type="button">
            ✕
          </button>
          <span class="absolute top-1/2 left-1/2 -translate-y-2/4 -translate-x-1/2 w-10 h-10">
            <img src="{{ asset('storage/materials/cross.png') }}" alt="十字アイコン">
          </span>
          <input type="file" name="seeking_thumbnail" id="seeking_thumbnail" accept="image/*" class="hidden">
        </label>
        <x-input-error :messages="$errors->get('seeking_thumbnail')" class="mt-2" />
      </div>

      <!-- タイトル -->
      <div>
        <input id="title"
          class="block font-bold px-4 py-3 border-none w-full placeholder-gray mt-4 text-sm js-required-form"
          type="text" name="title" required autofocus autocomplete="title" placeholder="キャッチーなタイトルで募集しよう🌿"
          value="{{ $seeking->title }}" />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
      </div>

      <!-- 募集文 -->
      <textarea id="content"
        class="block w-full h-56 mt-2 bg-gray-100 border-none px-4 py-2 text-sm placeholder-gray text-top js-required-form"
        name="content" placeholder="200文字以内で募集内容の詳細を書こう💭" maxlength="200">{{ $seeking->content }}</textarea>
      <x-input-error :messages="$errors->get('content')" class="mt-2" />

      <!--  登録ボタン -->
      <div class="text-center mt-10">
        <button class="bg-gray register-button text-white rounded-lg py-4 px-8 font-bold w-11/12">編集内容を保存する</button>
      </div>
    </form>

    <!--  削除ボタン -->
    <div class="text-center mt-4">
      <form action="{{ route('seeking.destroy', $seeking->id) }}" method="POST"
        onsubmit="return confirm('募集を削除すると、この募集でマッチしたユーザーとはマッチが解消されます。');">
        @csrf
        @method('DELETE')
        <button type="submit"
          class="bg-dark-gray hover:bg-dark-gray text-white rounded-lg py-4 px-8 font-bold w-11/12">募集を削除する</button>
      </form>
    </div>
  </div>

  <script type="module">
    $(document).ready(function() {
      if ('{{ $seeking->seeking_thumbnail }}') {
        showUploadedThumbnail('{{ asset('storage/seeking_thumbnail/'.$seeking->seeking_thumbnail) }}');
      } else {
        showDefaultThumbnail();
      }
    });
  
    $('#seeking_thumbnail').change(function(e) {
      var file = e.target.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#seeking_thumbnail-preview').attr('src', e.target.result);
          $('#seeking_thumbnail-preview').show(); // 画像プレビューを表示する
          $('#js-clear-button').show(); // バツボタンを表示する
        }
        reader.readAsDataURL(file);
      } else {
        showDefaultThumbnail();
      }
      hideThumbnailError(); // バツボタンを押した際にエラーメッセージを非表示にする
    });
  
    $('#js-clear-button').click(function(e) {
      e.preventDefault();
      $('#seeking_thumbnail').val(null);
      $('#seeking_thumbnail-preview').hide();
      $('#js-clear-button').hide();
      hideThumbnailError(); // バツボタンを押した際にエラーメッセージを非表示にする
    });
  
    function showDefaultThumbnail() {
      $('#seeking_thumbnail-preview').attr('src', "{{ asset('storage/seeking_thumbnail/default-thumbnail.png') }}");
      $('#seeking_thumbnail-preview').show(); // 画像プレビューを表示する
      $('#js-clear-button').show(); // バツボタンを表示する
    }
  
    function showUploadedThumbnail(src) {
      $('#seeking_thumbnail-preview').attr('src', src);
      $('#seeking_thumbnail-preview').show(); // 画像プレビューを表示する
      $('#js-clear-button').show(); // バツボタンを表示する
    }
  
    function hideThumbnailError() {
      $('.js-required-form').removeClass('border-red-500'); // 必須フィールドの赤い枠を削除
      $('.js-required-form').siblings('.input-error').hide(); // エラーメッセージを非表示にする
    }
  </script>
  
@endsection
