@extends('layouts.layout')

@section('content')
  <div class="mt-6 space-y-6">
      <!-- 名前 -->
      <div>
          <x-input-label for="name" value="名前" />
          <span class="block mt-1">{{ $user->name }}</span>
      </div>

      <!-- 学年 -->
      <div>
          <x-input-label for="grade" value="学年" />
          <span class="block mt-1">{{ $user->grade }}</span>
      </div>

      <!-- 学部 -->
      <div>
          <x-input-label for="faculty" value="学部" />
          <span class="block mt-1">{{ $user->faculty }}</span>
      </div>

      <!-- 年齢 -->
      <div>
          <x-input-label for="age" value="年齢" />
          <span class="block mt-1">{{ $user->age }}</span>
      </div>

      <!-- 性別 -->
      <div>
          <x-input-label for="sex" value="性別" />
          <span class="block mt-1">{{ $user->sex }}</span>
      </div>

      <!-- 自己紹介 -->
      <div>
          <x-input-label for="self_introduction" value="自己紹介" />
          <span class="block mt-1">{{ $user->self_introduction }}</span>
      </div>

      <!-- アイコン -->
      <div>
          <x-input-label for="avatar" value="アイコン画像" />
          @if ($user->avatar)
              <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar">
          @else
              <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar">
          @endif
      </div>

      <!-- SNSリンク -->
      <!-- LINE -->
      <div>
          <x-input-label for="line_link" value="LINE" />
          <span class="block mt-1">{{ $user->line_link }}</span>
      </div>

      <!-- Instagram -->
      <div>
          <x-input-label for="instagram_link" value="Instagram" />
          <span class="block mt-1">{{ $user->instagram_link }}</span>
      </div>

      <!-- Twitter -->
      <div>
          <x-input-label for="twitter_link" value="Twitter" />
          <span class="block mt-1">{{ $user->twitter_link }}</span>
      </div>

      <!-- メールアドレス -->
      <div>
          <x-input-label for="email" :value="__('Email')" />
          <span class="block mt-1">{{ $user->email }}</span>
      </div>

      <!-- 自分の募集一覧 -->
      @foreach($seekings as $seeking)
      <div class="card mb-4">
          <div class="card-header">
              <h5 class="font-bold">
                  <a class="underline" href="{{ route('seeking.show', $seeking->id) }}">{{ $seeking->title }}</a>
              </h5>
          </div>
          <div class="card-body">
              <p class="mb-4">{{ $seeking->content }}</p>
              <img src="{{ asset('storage/seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="募集画像" class="mb-4">
              <div class="flex items-center">
                  <img src="{{ asset('storage/avatars/' . $seeking->user->avatar) }}" alt="ユーザーアイコン" class="w-8 h-8 rounded-full mr-2">
                  <span>{{ $seeking->user->name }}</span>
              </div>
          </div>
          <hr class="my-4">
      </div>
  @endforeach
  </div>
@endsection