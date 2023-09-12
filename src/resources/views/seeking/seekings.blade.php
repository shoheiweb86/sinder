@extends('layouts.layout')
@section('title', '募集一覧')

@section('content')
  <ul class="flex items-center bg-white px-4 text-sm font-bold text-dark-gray">
    <li data-target="js-all-seeking" class="ml-4 py-2 category-active js-category">すべて</li>
    <li data-target="js-man-seeking" class="ml-4 py-2 js-category">男性からの募集</li>
    <li data-target="js-woman-seeking" class="ml-4 py-2 js-category">女性からの募集</li>
  </ul>
  <div class="px-3 py-1 grid grid-cols-2 gap-2 js-all-seeking">
    <div class="left">
      @foreach ($seekings as $index => $seeking)
        @if ($index % 2 === 0)
          <a class="block rounded-lg relative mt-2" href="{{ route('seeking.show', $seeking->id) }}">
            <div class="">
              <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="募集画像"
                class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
            </div>
            <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
              <h2 class="font-bold text-sm">{{ $seeking->title }}</h2>
              <p class="show-2-lines text-xs mt-2">{{ $seeking->content }}</p>
              <div class="flex items-center mt-4">
                <img src="{{ Storage::disk('s3')->url('avatar/' . $seeking->user->avatar) }}" alt="ユーザーアイコン"
                  class="w-8 h-8 rounded-full mr-2">
                <div href="{{ route('profile.show', ['user_name' => $seeking->user->name]) }}"
                  class="hover:underline text-xs">{{ $seeking->user->name }}</div>
              </div>
              {{-- ログインしている場合のみ気になるできる --}}
              @if ($logged_in)
                {{-- SNSを登録しているか --}}
                @if ($registered_sns_flag)
                  {{-- 気になるしてるかどうか --}}
                  @if ($seeking->likes->isEmpty())
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x like-toggle" data-seeking-id="{{ $seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @else
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x heart like-toggle liked" data-seeking-id="{{ $seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @endif
                @else
                  <span class="likes absolute top-2 right-2">
                    <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                      <i class="fas fa-heart text-bg fa-2x"></i>
                    </div>
                  </span>
                @endif
              @else
                <span class="likes absolute top-2 right-2">
                  <div href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
                    <i class="fas fa-heart text-bg fa-2x"></i>
                  </div>
                </span>
              @endif
            </div>
          </a>
        @endif
      @endforeach
    </div>

    <div class="right">
      @foreach ($seekings as $index => $seeking)
        @if ($index % 2 !== 0)
          <a class="block rounded-lg relative mt-2" href="{{ route('seeking.show', $seeking->id) }}">
            <div class="">
              <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="募集画像"
              class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
            </div>
            <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
              <h2 class="font-bold text-sm">{{ $seeking->title }}</h2>
              <p class="show-2-lines text-xs mt-2">{{ $seeking->content }}</p>
              <div class="flex items-center mt-4">
                <img src="{{ Storage::disk('s3')->url('avatar/' . $seeking->user->avatar) }}" alt="ユーザーアイコン"
                  class="w-8 h-8 rounded-full mr-2">
                <div href="{{ route('profile.show', ['user_name' => $seeking->user->name]) }}"
                  class="hover:underline text-xs">{{ $seeking->user->name }}</div>
              </div>
              {{-- ログインしている場合のみ気になるできる --}}
              @if ($logged_in)
                {{-- SNSを登録しているか --}}
                @if ($registered_sns_flag)
                  {{-- 気になるしてるかどうか --}}
                  @if ($seeking->likes->isEmpty())
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x like-toggle" data-seeking-id="{{ $seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @else
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x heart like-toggle liked" data-seeking-id="{{ $seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @endif
                @else
                  <span class="likes absolute top-2 right-2">
                    <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                      <i class="fas fa-heart text-bg fa-2x"></i>
                    </div>
                  </span>
                @endif
              @else
                <span class="likes absolute top-2 right-2">
                  <div href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
                    <i class="fas fa-heart text-bg fa-2x"></i>
                  </div>
                </span>
              @endif
            </div>
          </a>
        @endif
      @endforeach
    </div>
  </div>
  <div class="px-3 py-1 grid grid-cols-2 gap-2 js-man-seeking">
    <div class="left">
      @foreach ($man_seekings as $index => $man_seeking)
        @if ($index % 2 === 0)
          <a class="block rounded-lg relative mt-2" href="{{ route('seeking.show', $man_seeking->id) }}">
            <div class="">
              <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $man_seeking->seeking_thumbnail) }}" alt="募集画像"
                class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
            </div>
            <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
              <h2 class="font-bold text-sm">{{ $man_seeking->title }}</h2>
              <p class="show-2-lines text-xs mt-2">{{ $man_seeking->content }}</p>
              <div class="flex items-center mt-4">
                <img src="{{ Storage::disk('s3')->url('avatar/' . $man_seeking->user->avatar) }}" alt="ユーザーアイコン"
                  class="w-8 h-8 rounded-full mr-2">
                <div href="{{ route('profile.show', ['user_name' => $man_seeking->user->name]) }}"
                  class="hover:underline text-xs">{{ $man_seeking->user->name }}</div>
              </div>
              {{-- ログインしている場合のみ気になるできる --}}
              @if ($logged_in)
                {{-- SNSを登録しているか --}}
                @if ($registered_sns_flag)
                  {{-- 気になるしてるかどうか --}}
                  @if ($man_seeking->likes->isEmpty())
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x like-toggle" data-seeking-id="{{ $man_seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @else
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x heart like-toggle liked" data-seeking-id="{{ $man_seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @endif
                @else
                  <span class="likes absolute top-2 right-2">
                    <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                      <i class="fas fa-heart text-bg fa-2x"></i>
                    </div>
                  </span>
                @endif
              @else
                <span class="likes absolute top-2 right-2">
                  <div href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
                    <i class="fas fa-heart text-bg fa-2x"></i>
                  </div>
                </span>
              @endif
            </div>
          </a>
        @endif
      @endforeach
    </div>

    <div class="right">
      @foreach ($man_seekings as $index => $man_seeking)
        @if ($index % 2 !== 0)
          <a class="block rounded-lg relative mt-2" href="{{ route('seeking.show', $man_seeking->id) }}">
            <div class="">
              <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $man_seeking->seeking_thumbnail) }}" alt="募集画像"
              class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
            </div>
            <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
              <h2 class="font-bold text-sm">{{ $man_seeking->title }}</h2>
              <p class="show-2-lines text-xs mt-2">{{ $man_seeking->content }}</p>
              <div class="flex items-center mt-4">
                <img src="{{ Storage::disk('s3')->url('avatar/' . $man_seeking->user->avatar) }}" alt="ユーザーアイコン"
                  class="w-8 h-8 rounded-full mr-2">
                <div href="{{ route('profile.show', ['user_name' => $man_seeking->user->name]) }}"
                  class="hover:underline text-xs">{{ $man_seeking->user->name }}</div>
              </div>
              {{-- ログインしている場合のみ気になるできる --}}
              @if ($logged_in)
                {{-- SNSを登録しているか --}}
                @if ($registered_sns_flag)
                  {{-- 気になるしてるかどうか --}}
                  @if ($man_seeking->likes->isEmpty())
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x like-toggle" data-seeking-id="{{ $man_seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @else
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x heart like-toggle liked" data-seeking-id="{{ $man_seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @endif
                @else
                  <span class="likes absolute top-2 right-2">
                    <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                      <i class="fas fa-heart text-bg fa-2x"></i>
                    </div>
                  </span>
                @endif
              @else
                <span class="likes absolute top-2 right-2">
                  <div href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
                    <i class="fas fa-heart text-bg fa-2x"></i>
                  </div>
                </span>
              @endif
            </div>
          </a>
        @endif
      @endforeach
    </div>
  </div>
  <div class="px-3 py-1 grid grid-cols-2 gap-2 js-woman-seeking">
    <div class="left">
      @foreach ($woman_seekings as $index => $woman_seeking)
        @if ($index % 2 === 0)
          <a class="block rounded-lg relative mt-2" href="{{ route('seeking.show', $woman_seeking->id) }}">
            <div class="">
              <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $woman_seeking->seeking_thumbnail) }}" alt="募集画像"
                class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
            </div>
            <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
              <h2 class="font-bold text-sm">{{ $woman_seeking->title }}</h2>
              <p class="show-2-lines text-xs mt-2">{{ $woman_seeking->content }}</p>
              <div class="flex items-center mt-4">
                <img src="{{ Storage::disk('s3')->url('avatar/' . $woman_seeking->user->avatar) }}" alt="ユーザーアイコン"
                  class="w-8 h-8 rounded-full mr-2">
                <div href="{{ route('profile.show', ['user_name' => $woman_seeking->user->name]) }}"
                  class="hover:underline text-xs">{{ $woman_seeking->user->name }}</div>
              </div>
              {{-- ログインしている場合のみ気になるできる --}}
              @if ($logged_in)
                {{-- SNSを登録しているか --}}
                @if ($registered_sns_flag)
                  {{-- 気になるしてるかどうか --}}
                  @if ($woman_seeking->likes->isEmpty())
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x like-toggle" data-seeking-id="{{ $woman_seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @else
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x heart like-toggle liked" data-seeking-id="{{ $woman_seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @endif
                @else
                  <span class="likes absolute top-2 right-2">
                    <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                      <i class="fas fa-heart text-bg fa-2x"></i>
                    </div>
                  </span>
                @endif
              @else
                <span class="likes absolute top-2 right-2">
                  <div href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
                    <i class="fas fa-heart text-bg fa-2x"></i>
                  </div>
                </span>
              @endif
            </div>
          </a>
        @endif
      @endforeach
    </div>

    <div class="right">
      @foreach ($woman_seekings as $index => $woman_seeking)
        @if ($index % 2 !== 0)
          <a class="block rounded-lg relative mt-2" href="{{ route('seeking.show', $woman_seeking->id) }}">
            <div class="">
              <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $woman_seeking->seeking_thumbnail) }}" alt="募集画像"
                class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
            </div>
            <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
              <h2 class="font-bold text-sm">{{ $woman_seeking->title }}</h2>
              <p class="show-2-lines text-xs mt-2">{{ $woman_seeking->content }}</p>
              <div class="flex items-center mt-4">
                <img src="{{ Storage::disk('s3')->url('avatar/' . $woman_seeking->user->avatar) }}" alt="ユーザーアイコン"
                  class="w-8 h-8 rounded-full mr-2">
                <div href="{{ route('profile.show', ['user_name' => $woman_seeking->user->name]) }}"
                  class="hover:underline text-xs">{{ $woman_seeking->user->name }}</div>
              </div>
              {{-- ログインしている場合のみ気になるできる --}}
              @if ($logged_in)
                {{-- SNSを登録しているか --}}
                @if ($registered_sns_flag)
                  {{-- 気になるしてるかどうか --}}
                  @if ($woman_seeking->likes->isEmpty())
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x like-toggle" data-seeking-id="{{ $woman_seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @else
                    <span class="likes absolute top-2 right-2">
                      <i class="fas fa-heart text-bg fa-2x heart like-toggle liked" data-seeking-id="{{ $woman_seeking->id }}"></i>
                    </span><!-- /.likes -->
                  @endif
                @else
                  <span class="likes absolute top-2 right-2">
                    <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                      <i class="fas fa-heart text-bg fa-2x"></i>
                    </div>
                  </span>
                @endif
              @else
                <span class="likes absolute top-2 right-2">
                  <div href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
                    <i class="fas fa-heart text-bg fa-2x"></i>
                  </div>
                </span>
              @endif
            </div>
          </a>
        @endif
      @endforeach
    </div>
  </div>

  <script type="module">
      //気になる処理
    $(function () {
      let like = $('.like-toggle');
      let likeSeekingId;
      like.on('click', function () {
        let $this = $(this);
        likeSeekingId = $this.data('seeking-id');
        $.ajax({
          headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
          },
          url: '/like',
          method: 'POST',
          data: {
            'seeking_id': likeSeekingId
          },
          success: function () {
            $this.toggleClass('liked');
          },
          error: function () {
            console.log('通信に失敗しました。');
          }
        });
      });
    });
  </script>

  <style>
    .liked {
      color: #EB545D;
    }
  </style>
@endsection
