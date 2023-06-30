@extends('layouts.layout')

@section('content')
  <div class="container">
    <h1>募集一覧</h1>
    @foreach($seekings as $seeking)
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="font-bold">
            <a class="" href="{{ route('seeking.show', $seeking->id) }}">{{ $seeking->title }}</a>
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
      </div>

      {{-- ログインしている場合のみ気になるできる --}}
      @if ($logged_in)
          {{-- SNSを登録しているか --}}
          @if ($registered_sns_flag)
              {{-- 気になるしてるかどうか --}}
              @if ($seeking->likes->isEmpty())
                  <span class="likes">
                      <i class="fas fa-heart like-toggle" data-seeking-id="{{ $seeking->id }}"></i>
                  </span><!-- /.likes -->
              @else
                  <span class="likes">
                      <i class="fas fa-heart heart like-toggle liked" data-seeking-id="{{ $seeking->id }}"></i>
                  </span><!-- /.likes -->
              @endif
          @else
              <span class="likes">
                <a href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                    <i class="fas fa-heart"></i>
                </a>
              </span>
          @endif

      @else  
          <span class="likes">
              <a href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
                  <i class="fas fa-heart"></i>
              </a>
          </span>
      @endif

      <hr class="my-4">

    @endforeach
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
  color: pink;
  }
</style>
@endsection
