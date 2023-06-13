<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- 名前 -->
    <div>
      <x-input-label for="name" value="名前" />
      <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- 学部 -->
    <div>
        <x-input-label for="faculty" value="学部" />
        <select name="faculty" id="faculty" required>
            <option value="" disabled selected>選択してください</option>
            <option value="人文学部">人文学部</option>
            <option value="教育学部">教育学部</option>
            <option value="法学部">法学部</option>
            <option value="経済科学部">経済科学部</option>
            <option value="医学部医学科">医学部医学科</option>
            <option value="医学部保健学科">医学部保健学科</option>
            <option value="歯学部">歯学部</option>
            <option value="工学部">工学部</option>
            <option value="農学部">農学部</option>
            <option value="教育実践学研究科">教育実践学研究科</option>
            <option value="現代社会文化研究科">現代社会文化研究科</option>
            <option value="自然科学研究科">自然科学研究科</option>
            <option value="保健学研究科">保健学研究科</option>
            <option value="医歯学総合研究科">医歯学総合研究科</option>

        </select>
        <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
    </div>

    <!-- 年齢 -->
    <div>
        <x-input-label for="age" value="年齢" />
        <input type="number" id="numberInput" name="numberInput" min="18" max="80" step="1":value="old('age')" required autofocus autocomplete="age" >
        <x-input-error :messages="$errors->get('age')" class="mt-2" />
    </div>

    <!-- 性別 -->
    <div>
      <x-input-label for="sex" value="性別" />
      <select name="sex" id="sex" required>
          <option value="" disabled selected>選択してください</option>
          <option value="男">男</option>
          <option value="女">女</option>
          <option value="秘密">秘密</option>
      </select>
      <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
    </div>

    <!-- 自己紹介 -->
    <div>
        <x-input-label for="self_introduction" value="自己紹介（200文字以内）" />
            <textarea id="self_introduction" name="self_introduction" maxlength="200" rows="4" cols="50"></textarea>
        <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
    </div> --}}

</x-app-layout>
