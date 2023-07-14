@extends('layouts.layout')
@section('title', 'やりとり')

@section('content')
  <div class="container">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="alert alert-success">{{ session('error') }}</div>
    @endif

    {{-- カテゴリーリスト --}}
    <ul class="flex items-center bg-white px-4 text-sm font-bold text-dark-gray">
      <li data-target="js-liked-seeking" class="ml-4 py-2 category-active js-category">気になった募集</li>
      <li data-target="js-liked-my-seeking" class="ml-4 py-2 js-category">気になられた募集</li>
      <li data-target="js-connected-user" class="ml-4 py-2 js-category">マッチ済み</li>
    </ul>

    {{-- 気になった募集 --}}
    <div class="js-liked-seeking">
      @if ($seekings->count() > 0)
        <div class="px-3 py-2 grid grid-cols-2 gap-2">
          <div class="left">
            @foreach ($seekings as $index => $seeking)
              @if ($index % 2 === 0)
                <a class="block rounded-lg relative mt-2" href="{{ route('seeking.show', $seeking->id) }}">
                  <div class="">
                    <img src="{{ asset('storage/seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="募集画像"
                      class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
                  </div>
                  <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
                    <h2 class="font-bold text-sm">{{ $seeking->title }}</h2>
                    <p class="show-2-lines text-xs mt-2">{{ $seeking->content }}</p>
                    <div class="flex items-center mt-4">
                      <img src="{{ asset('storage/avatars/' . $seeking->user->avatar) }}" alt="ユーザーアイコン"
                        class="w-8 h-8 rounded-full mr-2">
                      <div href="{{ route('profile.show', ['user_name' => $seeking->user->name]) }}"
                        class="hover:underline text-xs">{{ $seeking->user->name }}</div>
                    </div>

                    {{-- 気になる機能 --}}
                    @if ($seeking->likes->isEmpty())
                      {{-- SNSを登録しているか --}}
                      @if ($registered_sns_flag)
                        <span class="likes absolute top-2 right-5">
                          <i class="fas fa-heart fa-2x like-toggle" data-seeking-id="{{ $seeking->id }}"></i>
                        </span><!-- /.likes -->
                      @else
                        <span class="likes absolute top-2 right-5">
                          <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                            <i class="fas fa-heart fa-2x"></i>
                          </div>
                        </span>
                      @endif
                    @else
                      {{-- SNSを登録しているか --}}
                      @if ($registered_sns_flag)
                        <span class="likes absolute top-2 right-5">
                          <i class="fas fa-heart fa-2x heart like-toggle liked"
                            data-seeking-id="{{ $seeking->id }}"></i>
                        </span><!-- /.likes -->
                      @else
                        <span class="likes absolute top-2 right-5">
                          <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                            <i class="fas fa-heart fa-2x liked"></i>
                          </div>
                        </span>
                      @endif
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
                    <img src="{{ asset('storage/seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="募集画像"
                      class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
                  </div>
                  <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
                    <h2 class="font-bold text-sm">{{ $seeking->title }}</h2>
                    <p class="show-2-lines text-xs mt-2">{{ $seeking->content }}</p>
                    <div class="flex items-center mt-4">
                      <img src="{{ asset('storage/avatars/' . $seeking->user->avatar) }}" alt="ユーザーアイコン"
                        class="w-8 h-8 rounded-full mr-2">
                      <div href="{{ route('profile.show', ['user_name' => $seeking->user->name]) }}"
                        class="hover:underline text-xs">{{ $seeking->user->name }}</div>
                    </div>

                    {{-- 気になる機能 --}}
                    @if ($seeking->likes->isEmpty())
                      {{-- SNSを登録しているか --}}
                      @if ($registered_sns_flag)
                        <span class="likes absolute top-2 right-5">
                          <i class="fas fa-heart fa-2x like-toggle" data-seeking-id="{{ $seeking->id }}"></i>
                        </span><!-- /.likes -->
                      @else
                        <span class="likes absolute top-2 right-5">
                          <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                            <i class="fas fa-heart fa-2x"></i>
                          </div>
                        </span>
                      @endif
                    @else
                      {{-- SNSを登録しているか --}}
                      @if ($registered_sns_flag)
                        <span class="likes absolute top-2 right-5">
                          <i class="fas fa-heart fa-2x heart like-toggle liked"
                            data-seeking-id="{{ $seeking->id }}"></i>
                        </span><!-- /.likes -->
                      @else
                        <span class="likes absolute top-2 right-5">
                          <div href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                            <i class="fas fa-heart fa-2x liked"></i>
                          </div>
                        </span>
                      @endif
                    @endif
                  </div>
                </a>
              @endif
            @endforeach
          </div>
        </div>
      @else
        <p class="mt-4 text-center">現在、気になった募集はありません。</p>
      @endif
    </div>

    {{-- 気になられた募集 --}}
    <div class="js-liked-my-seeking">
      @if ($liked_my_seekings->count() > 0)
        <ul class="px-3 pb-2">
          @foreach ($liked_my_seekings as $liked_seeking)
            <li class="rounded-lg bg-white mt-4">
              <a class="flex border-b border-1 border-solid border-gray" href="{{ route('seeking.show', $liked_seeking->id) }}">
                <div class="rounded-tl-lg rounded-tr-lg w-24 h-24 flex-shrink-0">
                  <img src="{{ asset('storage/seeking_thumbnail/' . $liked_seeking->seeking_thumbnail) }}" alt="募集画像"
                    class="w-24 h-24 object-cover object-center rounded-tl-lg">
                </div>
                <div class="py-2 px-4">
                  <h2 class="text-sm font-bold mb-2">{{ $liked_seeking->title }}</h2>
                  <p class="text-xs show-3-lines">{{ $liked_seeking->content }}</p>
                </div>
              </a>

              <div class="">
                @foreach ($liked_seeking->likes as $like)
                  <div class="flex justify-between items-center py-2 px-4 border-b border-1 border-solid border-gray">
                    <div class="flex items-center">
                      <img src="{{ asset('storage/avatars/' . $like->user->avatar) }}" alt="ユーザーアイコン"
                        class="w-9 h-9 rounded-full mr-2">
                      <a href="{{ route('profile.show', ['user_name' => $like->user->name]) }}"
                        class="text-xs font-bold">{{ $like->user->name }}
                      </a>
                    </div>
                    <form
                      action="{{ route('connection.create', ['seeking_id' => $liked_seeking->id, 'liked_user_id' => $like->user->id]) }}"
                      method="POST">
                      @csrf
                      <button type="submit"
                        class="bg-vivid rounded-full text-white text-xs py-2 px-6 font-bold">この人とマッチする</button>
                    </form>
                  </div>
                @endforeach
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <p class="mt-4 text-center">現在、気になられた募集はありません。</p>
      @endif
    </div>

    {{-- マッチ済み --}}
    <div class="js-connected-user">
      @if ($connected_seekings->count() > 0)
        <ul class="px-3 pb-2">
          @foreach ($connected_seekings as $connected_seeking)
            <li class="rounded-lg bg-white mt-4 overflow-hidden">
              <div class="flex border-b border-1 border-solid border-gray" href="{{ route('seeking.show', $connected_seeking->id) }}">
                <div class="rounded-tl-lg rounded-tr-lg w-24 h-24 flex-shrink-0">
                  <img src="{{ asset('storage/seeking_thumbnail/' . $connected_seeking->seeking_thumbnail) }}"
                    alt="募集画像" class="w-24 h-24 object-cover object-center rounded-tl-lg">
                </div>
                <div class="py-2 px-4">
                  <h2 class="text-sm font-bold show-1-lines">{{ $connected_seeking->title }}</h2>
                  <p class="text-xs mt-1 show-2-lines">{{ $connected_seeking->content }}</p>
                  <p class="text-xs text-main font-bold mt-1">マッチが成立しました</p>
                </div>
              </div>

              @foreach ($connected_seeking->connected_users as $connected_user)
                <div
                  class="flex justify-between items-center py-2 px-2 border-b border-1 border-solid border-gray bg-main">
                  <div class="flex items-center">
                    <img src="{{ asset('storage/avatars/' . $connected_user->avatar) }}" alt="ユーザーアイコン"
                      class="w-9 h-9 rounded-full mr-2">
                    <a href="{{ route('profile.show', ['user_name' => $connected_user->name]) }}"
                      class="text-xs font-bold text-white">{{ $connected_user->name }}
                    </a>
                  </div>
                  <div class="flex items-center">
                    @foreach ($connected_seeking->connections as $connection)
                      @if ($connection->user1_id === $connected_user->id || $connection->user2_id === $connected_user->id)
                        <form action="{{ route('connection.delete', ['connection_id' => $connection->id]) }}"
                          method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="bg-gray rounded-full text-white text-xs py-1 px-2">
                            マッチ解除
                          </button>
                        </form>
                      @endif
                    @endforeach
                    <a href="{{ route('profile.show', ['user_name' => $connected_user->name]) }}"
                      class="bg-vivid rounded-full text-white text-xs py-2 px-6 font-bold ml-2">
                      SNSで連絡する
                    </a>
                  </div>
                </div>
              @endforeach

            </li>
          @endforeach
        </ul>
      @else
        <p class="mt-4 text-center">現在、マッチしている人はいません。</p>
      @endif
    </div>

  </div>


  <script type="module">
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
