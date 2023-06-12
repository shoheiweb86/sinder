<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- 名前 -->
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
      </div>

        <!-- メールアドレス -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- パスワード -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- パスワード確認 -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
