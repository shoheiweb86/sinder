@extends('layouts.layout')
@section('title', 'プロフィール編集')

@section('content')

  @if (session('message'))
    <div class="text-red-400 mb-2">
      {{ session('message') }}
    </div>
  @endif

  <div>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
      @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="" enctype="multipart/form-data">
      @csrf
      @method('patch')

      <!-- アイコン -->
      <div>
        <label for="avatar" class="block relative bg-white w-48 h-64 ml-4 mt-4 rounded-2xl">
          <span class="absolute top-1/2 left-1/2 -translate-y-2/4 -translate-x-1/2 w-10 h-10"><img
              src="{{ asset('storage/materials/cross.png') }}" alt=""></span>
          <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
        </label>
        <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
      </div>

      @if ($user->avatar)
        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar">
      @else
        <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar">
      @endif

      <!-- 名前 -->
      <div>
        <input id="name" class="block px-4 py-3 border-none w-full placeholder-gray mt-4 text-sm" type="text"
          name="name" value={{ old('name', $user->name) }} required autofocus autocomplete="name"
          placeholder="名前またはニックネーム" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>

      <!-- 年齢 -->
      <div class="relative mt-2">
        <input type="number" id="age" class="text-sm w-full border-none px-4 placeholder-gray py-3" name="age"
          min="18" max="80" step="1" value="{{ old('age', $user->age) }}" autofocus autocomplete="age"
          placeholder="年齢">
        <x-input-error :messages="$errors->get('age')" class="mt-2" />
      </div>

      <!-- 学年 -->
      <div class="relative mt-2">
        <span class="arrow-bottom"></span>
        <select name="grade" id="grade" class="js-select w-full border-none px-4 relative py-3 text-sm"
          :value="old('grade', $user - > grade)">
          <option value="" disabled selected>学年</option>
          <option value="1年生" {{ old('grade', $user->grade) === '1年生' ? 'selected' : '' }}>1年生</option>
          <option value="2年生" {{ old('grade', $user->grade) === '2年生' ? 'selected' : '' }}>2年生</option>
          <option value="3年生" {{ old('grade', $user->grade) === '3年生' ? 'selected' : '' }}>3年生</option>
          <option value="4年生" {{ old('grade', $user->grade) === '4年生' ? 'selected' : '' }}>4年生</option>
          <option value="5年生" {{ old('grade', $user->grade) === '5年生' ? 'selected' : '' }}>5年生</option>
          <option value="6年生" {{ old('grade', $user->grade) === '6年生' ? 'selected' : '' }}>6年生</option>
          <option value="院1年生" {{ old('grade', $user->grade) === '院1年生' ? 'selected' : '' }}>院1年生</option>
          <option value="院2年生" {{ old('grade', $user->grade) === '院2年生' ? 'selected' : '' }}>院2年生</option>
        </select>
        <x-input-error :messages="$errors->get('grade')" class="mt-2" />
      </div>

      <!-- 学部 -->
      <div class="relative mt-2">
        <span class="arrow-bottom"></span>
        <select name="faculty" id="faculty" class="js-select text-sm w-full border-none px-4 bg-image py-3">
          <option value="" disabled selected>学部</option>
          <option value="人文学部" {{ old('faculty', $user->faculty) === '人文学部' ? 'selected' : '' }}>人文学部</option>
          <option value="教育学部" {{ old('faculty', $user->faculty) === '教育学部' ? 'selected' : '' }}>教育学部</option>
          <option value="法学部" {{ old('faculty', $user->faculty) === '法学部' ? 'selected' : '' }}>法学部</option>
          <option value="経済科学部" {{ old('faculty', $user->faculty) === '経済科学部' ? 'selected' : '' }}>経済科学部
          </option>
          <option value="理学部" {{ old('faculty', $user->faculty) === '理学部' ? 'selected' : '' }}>理学部</option>
          <option value="医学部医学科" {{ old('faculty', $user->faculty) === '医学部医学科' ? 'selected' : '' }}>医学部医学科
          </option>
          <option value="医学部保健学科" {{ old('faculty', $user->faculty) === '医学部保健学科' ? 'selected' : '' }}>医学部保健学科
          </option>
          <option value="歯学部" {{ old('faculty', $user->faculty) === '歯学部' ? 'selected' : '' }}>歯学部</option>
          <option value="工学部" {{ old('faculty', $user->faculty) === '工学部' ? 'selected' : '' }}>工学部</option>
          <option value="農学部" {{ old('faculty', $user->faculty) === '農学部' ? 'selected' : '' }}>農学部</option>
          <option value="創生学部" {{ old('faculty', $user->faculty) === '創生学部' ? 'selected' : '' }}>創生学部</option>
          <option value="教育実践学研究科" {{ old('faculty', $user->faculty) === '教育実践学研究科' ? 'selected' : '' }}>教育実践学研究科
          </option>
          <option value="現代社会文化研究科" {{ old('faculty', $user->faculty) === '現代社会文化研究科' ? 'selected' : '' }}>
            現代社会文化研究科</option>
          <option value="自然科学研究科" {{ old('faculty', $user->faculty) === '自然科学研究科' ? 'selected' : '' }}>自然科学研究科
          </option>
          <option value="保健学研究科" {{ old('faculty', $user->faculty) === '保健学研究科' ? 'selected' : '' }}>保健学研究科
          </option>
          <option value="医歯学総合研究科" {{ old('faculty', $user->faculty) === '医歯学総合研究科' ? 'selected' : '' }}>医歯学総合研究科
          </option>
        </select>
        <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
      </div>

      <!-- 性別 -->
      <div class="relative mt-2">
        <span class="arrow-bottom"></span>
        <select name="sex" id="sex" class="js-select text-sm w-full border-none px-4 placeholder-gray py-3">
          <option value="" disabled selected>性別</option>
          <option value="男性" {{ old('sex', $user->sex) === '男性' ? 'selected' : '' }}>男性</option>
          <option value="女性" {{ old('sex', $user->sex) === '女性' ? 'selected' : '' }}>女性</option>
        </select>
        <x-input-error :messages="$errors->get('sex')" class="mt-2" />
      </div>

      <!-- 自己紹介 -->
      <textarea id="self_introduction"
        class="block w-full h-56 mt-4 bg-gray-100 border-none px-4 py-2 text-sm placeholder-gray text-top"
        name="self_introduction" placeholder="趣味や学部など自己紹介で気になってもらおう🌿" maxlength="200">{{ old('self_introduction', $user->self_introduction) }}</textarea>
      <x-input-error :messages="$errors->get('self_introduction')" class="mt-2" />

      <!-- SNSリンク -->
      <!-- LINE -->
      <div class="mt-4">
        <input id="line_link" class="block text-sm w-full border-none px-4 placeholder-gray py-3" type="text"
          name="line_link" value="{{ old('line_link', $user->line_link) }}" autocomplete="line_link"
          placeholder="LINEのリンクを入力する" />
        <x-input-error :messages="$errors->get('line_link')" class="mt-2" />
      </div>

      <!-- Instagram -->
      <div class="mt-2">
        <input id="instagram_link" class="block text-sm w-full border-none px-4 placeholder-gray py-3" type="text"
          name="instagram_link" value="{{old('instagram_link', $user->instagram_link) }}" autocomplete="instagram_link"
          placeholder="Instagramのリンクを入力する" />
        <x-input-error :messages="$errors->get('instagram_link')" class="mt-2" />
      </div>

      <!-- Twitter -->
      <div class="mt-2">
        <input id="twitter_link" class="block text-sm w-full border-none px-4 placeholder-gray py-3" type="text"
          name="twitter_link" value="{{ old('twitter_link', $user->twitter_link) }}" autocomplete="twitter_link"
          placeholder="Twitterのリンクを入力する" />
        <x-input-error :messages="$errors->get('twitter_link')" class="mt-2" />
      </div>

      <div class="px-4">
        <p class="text-main font-bold mt-4">マッチしたユーザーのみSNSが解放されます</p>
        <p class="text-sm mt-1">マッチしたユーザーからの連絡を対応できるSNSのリンクを、<span class="font-bold">少なくとも１つ</span>ご入力ください。</p>
      </div>


      <div class="mt-8 pb-4 text-center">
        <button class="text-white bg-gray rounded-lg py-4 px-8 font-bold w-11/12">編集内容を保存する</button>

        @if (session('status') === 'profile-updated')
          <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600">{{ __('Saved.') }}</p>
        @endif
      </div>
    </form>
  </div>

  {{-- selectの初期の文字をグレーにする --}}
  <script type="module">
  $(function () {
  // 'js-select'クラスが付いている要素を全て取得
  const select = $(".js-select");
  // text-grayyクラスを付与
  select.addClass("text-gray");

  // selectのoptionを切り替え時
  select.on("change", function () {
    // option選択時
    if ($(this).val() !== "") {
      // text-grayクラスを削除
      $(this).removeClass("text-gray");
    } 
    // placeholder選択時
    else {
      // text-grayクラスを付与
      $(this).addClass("text-gray");
    }
  });
});
</script>

@endsection
