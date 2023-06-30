<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- 名前 -->
        <div>
          <x-input-label for="name" value="名前" />
          <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name',  $user->name)" required autofocus autocomplete="name" />
          <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- 学年 -->
        <div>
            <x-input-label for="grade" value="学年" />
            <select name="grade" id="grade" :value="old('grade',  $user->grade)">
                <option value="" disabled selected>選択してください</option>
                <option value="学部1年生" {{ old('grade', $user->grade) === '学部1年生' ? 'selected' : '' }}>学部1年生</option>
                <option value="学部2年生" {{ old('grade', $user->grade) === '学部2年生' ? 'selected' : '' }}>学部2年生</option>
                <option value="学部3年生" {{ old('grade', $user->grade) === '学部3年生' ? 'selected' : '' }}>学部3年生</option>
                <option value="学部4年生" {{ old('grade', $user->grade) === '学部4年生' ? 'selected' : '' }}>学部4年生</option>
                <option value="学部5年生" {{ old('grade', $user->grade) === '学部5年生' ? 'selected' : '' }}>学部5年生</option>
                <option value="学部6年生" {{ old('grade', $user->grade) === '学部6年生' ? 'selected' : '' }}>学部6年生</option>
                <option value="大学院1年生" {{ old('grade', $user->grade) === '大学院1年生' ? 'selected' : '' }}>大学院1年生</option>
                <option value="大学院2年生" {{ old('grade', $user->grade) === '大学院2年生' ? 'selected' : '' }}>大学院2年生</option>
            </select>
            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
        </div>

        <!-- 学部 -->
        <div>
            <x-input-label for="faculty" value="学部" />
            <select name="faculty" id="faculty">
                <option value="" disabled selected>選択してください</option>
                <option value="人文学部" {{ old('faculty', $user->faculty) === '人文学部' ? 'selected' : '' }}>人文学部</option>
                <option value="教育学部" {{ old('faculty', $user->faculty) === '教育学部' ? 'selected' : '' }}>教育学部</option>
                <option value="法学部" {{ old('faculty', $user->faculty) === '法学部' ? 'selected' : '' }}>法学部</option>
                <option value="経済科学部" {{ old('faculty', $user->faculty) === '経済科学部' ? 'selected' : '' }}>経済科学部</option>
                <option value="理学部" {{ old('faculty', $user->faculty) === '理学部' ? 'selected' : '' }}>理学部</option>
                <option value="医学部医学科" {{ old('faculty', $user->faculty) === '医学部医学科' ? 'selected' : '' }}>医学部医学科</option>
                <option value="医学部保健学科" {{ old('faculty', $user->faculty) === '医学部保健学科' ? 'selected' : '' }}>医学部保健学科</option>
                <option value="歯学部" {{ old('faculty', $user->faculty) === '歯学部' ? 'selected' : '' }}>歯学部</option>
                <option value="工学部" {{ old('faculty', $user->faculty) === '工学部' ? 'selected' : '' }}>工学部</option>
                <option value="農学部" {{ old('faculty', $user->faculty) === '農学部' ? 'selected' : '' }}>農学部</option>
                <option value="創生学部" {{ old('faculty', $user->faculty) === '創生学部' ? 'selected' : '' }}>創生学部</option>
                <option value="教育実践学研究科" {{ old('faculty', $user->faculty) === '教育実践学研究科' ? 'selected' : '' }}>教育実践学研究科</option>
                <option value="現代社会文化研究科" {{ old('faculty', $user->faculty) === '現代社会文化研究科' ? 'selected' : '' }}>現代社会文化研究科</option>
                <option value="自然科学研究科" {{ old('faculty', $user->faculty) === '自然科学研究科' ? 'selected' : '' }}>自然科学研究科</option>
                <option value="保健学研究科" {{ old('faculty', $user->faculty) === '保健学研究科' ? 'selected' : '' }}>保健学研究科</option>
                <option value="医歯学総合研究科" {{ old('faculty', $user->faculty) === '医歯学総合研究科' ? 'selected' : '' }}>医歯学総合研究科</option>
            </select>
            <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
        </div>

        <!-- 年齢 -->
        <div>
            <x-input-label for="age" value="年齢" />
            <input type="number" id="age" name="age" min="18" max="80" step="1" value="{{ old('age', $user->age) }}" autofocus autocomplete="age">
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>

        <!-- 性別 -->
        <div>
          <x-input-label for="sex" value="性別" />
          <select name="sex" id="sex">
              <option value="" disabled selected>選択してください</option>
              <option value="男子" {{ old('sex', $user->sex) === '男子' ? 'selected' : '' }}>男子</option>
              <option value="女子" {{ old('sex', $user->sex) === '女子' ? 'selected' : '' }}>女子</option>
          </select>
          <x-input-error :messages="$errors->get('sex')" class="mt-2" />
        </div>

        <!-- 自己紹介 -->
        <div>
            <x-input-label for="self_introduction" value="自己紹介（200文字以内）" />
                <textarea id="self_introduction" name="self_introduction" maxlength="200" rows="4" cols="50">{{ old('self_introduction', $user->self_introduction) }}</textarea>
            <x-input-error :messages="$errors->get('self_introduction')" class="mt-2" />
        </div>

        <!-- アイコン -->
        <div>
            <x-input-label for="avatar" value="アイコン画像" />
            <input type="file" name="avatar" id="avatar" accept="image/*">
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        @if ($user->avatar)
            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar">
        @else
            <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar">
        @endif

        <!-- SNSリンク -->
        <!-- LINE -->
        <div>
            <x-input-label for="line_link" value="LINE" />
            <x-text-input id="line_link" class="block mt-1 w-full" type="text" name="line_link" :value="old('line_link',  $user->line_link)" autocomplete="line_link" />
            <x-input-error :messages="$errors->get('line_link')" class="mt-2" />
        </div>

        <!-- Instagram -->
        <div>
            <x-input-label for="instagram_link" value="Instagram" />
            <x-text-input id="instagram_link" class="block mt-1 w-full" type="text" name="instagram_link" :value="old('instagram_link',  $user->instagram_link)" autocomplete="instagram_link" />
            <x-input-error :messages="$errors->get('instagram_link')" class="mt-2" />
        </div>

        <!-- Twitter -->
        <div>
            <x-input-label for="twitter_link" value="Twitter" />
            <x-text-input id="twitter_link" class="block mt-1 w-full" type="text" name="twitter_link" :value="old('twitter_link',  $user->twitter_link)" autocomplete="twitter_link" />
            <x-input-error :messages="$errors->get('twitter_link')" class="mt-2" />
        </div>

        <!-- メールアドレス -->
        {{-- <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div> --}}

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
