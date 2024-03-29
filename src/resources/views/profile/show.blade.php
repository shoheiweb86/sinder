@extends('layouts.layout')

@section('content')
  @if ($my_profile)
    <h1 class="font-logo text-white text-2xl tracking-tighter absolute top-4 left-3">Sinder</h1>
  @else
    <a href="{{ url()->previous() }}" class="absolute top-4 left-3 ">
      <img src="{{ asset('storage/materials/arrow_left.png') }}" alt="左矢印のアイコン" class="w-5 h-5">
    </a>
  @endif

  <div class="w-full relative">
    <img src="{{ Storage::disk('s3')->url('avatar/' . $profile_user->avatar) }}" alt="アイコン画像"
      class="w-full h-auto max-h-[520px] aspect-w-3 aspect-h-4 object-cover">

    <div class="p-4 bg-white rounded-2xl -m-1 z-10 relative">
      <h2 class="font-bold">{{ $profile_user->name }}</h2>
      <p class="mt-2 text-sm">{{ $profile_user->self_introduction }}</p>
      <ul class="flex mt-3">
        @if (isset($profile_user->sex))
          <li class="text-main bg-bg text-xs font-bold py-1 px-3 rounded-3xl">{{ $profile_user->sex }}</li>
        @endif
        @if (isset($profile_user->grade))
          <li class="text-main bg-bg text-xs font-bold py-1 px-3 rounded-3xl ml-2">{{ $profile_user->grade }}</li>
        @endif
        @if (isset($profile_user->age))
          <li class="text-main bg-bg text-xs font-bold py-1 px-3 rounded-3xl ml-2">{{ $profile_user->age }}歳</li>
        @endif
        @if (isset($profile_user->faculty))
          <li class="text-main bg-bg text-xs font-bold py-1 px-3 rounded-3xl ml-2">{{ $profile_user->faculty }}</li>
        @endif
      </ul>


      {{-- 自分のプロフィールは編集できる --}}
      @if ($logged_in && $my_profile)
        <div>
          <a href="{{ route('profile.edit') }}"
            class="block text-center bg-dark-gray hover:bg-dark-gray text-white rounded-lg py-4 font-bold w-full mt-4 mx-auto">
            プロフィールを編集する
          </a>
        </div>
      @endif
    </div>
    <div class="">
      <!-- SNSリンク マイプロフィールの表示 -->
      @if ($my_profile)
        <div class="px-4 py-2 bg-white mt-4">
          @if ($profile_user->line_link)
            <a href="{{ $profile_user->line_link }}"
              class="block bg-line text-white w-full rounded-xl py-4 text-center font-bold font-accent">LINEで連絡する</a>
          @endif
          @if ($profile_user->twitter_link)
            <a href="{{ $profile_user->twitter_link }}"
              class="block bg-twitter text-white w-full rounded-xl py-4 text-center font-bold font-accent mt-2">Twitterで連絡する</a>
          @endif
          @if ($profile_user->instagram_link)
            <a href="{{ $profile_user->instagram_link }}"
              class="block text-white w-full rounded-xl py-4 text-center font-bold font-accent mt-2 bg-gradient-to-r from-instagram-purple via-instagram-red to-instagram-yellow">Instagramで連絡する</a>
          @endif
          @if (empty($profile_user->line_link) && empty($profile_user->twitter_link) && empty($profile_user->instagram_link))
            <p class="text-sm text-center">※SNSが登録されていません。<br>全ての機能を開放するには、<br>マッチ後に連絡を取れるSNSを登録してください。</p>
          @endif
        </div>
      @endif

      <!-- SNSリンク マッチしているユーザーのみ表示 -->
      @if (!$my_profile)
        @if ($connected_flag)
          <div class="px-4 py-2 bg-white mt-4">
            @if ($profile_user->line_link)
              <a href="{{ $profile_user->line_link }}"
                class="block bg-line text-white w-full rounded-xl py-4 text-center font-bold font-accent">LINEで連絡する</a>
            @endif
            @if ($profile_user->twitter_link)
              <a href="{{ $profile_user->twitter_link }}"
                class="block bg-twitter text-white w-full rounded-xl py-4 text-center font-bold font-accent mt-2">Twitterで連絡する</a>
            @endif
            @if ($profile_user->instagram_link)
              <a href="{{ $profile_user->instagram_link }}"
                class="block text-white w-full rounded-xl py-4 text-center font-bold font-accent mt-2 bg-gradient-to-r from-instagram-purple via-instagram-red to-instagram-yellow">Instagramで連絡する</a>
            @endif
          </div>
        @else
          <img src="{{ asset('storage/materials/sns_lock.png') }}" alt="マッチ成立後SNSが解放されます" class="mt-4">
        @endif
      @endif

      <p class="bg-white py-2 px-4 mt-4 text-sm font-bold text-center">
        {{ $profile_user->name }}の募集一覧
      </p>
      @if (count($seekings) === 0)
        <p class="text-center text-sm mt-2">現在、掲載中の募集はありません。</p>
      @else
        <div class="px-3 py-1 grid grid-cols-2 gap-2">
          <div class="left">
            @foreach ($seekings as $index => $seeking)
              @if ($index % 2 === 0)
                <a class="block rounded-lg relative mt-2" href="{{ route('seeking.show', $seeking->id) }}">
                  <div class="">
                    <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $seeking->seeking_thumbnail) }}"
                      alt="趣味の友達募集や、サークルの募集などにも使用できる、新潟大学生限定マッチングアプリSinderの募集画像"
                      class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
                  </div>
                  <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
                    <h2 class="font-bold text-sm">{{ $seeking->title }}</h2>
                    <p class="show-2-lines text-xs mt-2">{{ $seeking->content }}</p>
                    <div class="flex items-center mt-4">
                      <img src="{{ Storage::disk('s3')->url('avatar/' . $seeking->user->avatar) }}" alt="アイコン画像"
                        class="w-8 h-8 rounded-full mr-2">
                      <div href="{{ route('profile.show', ['user_name' => $seeking->user->name]) }}"
                        class="hover:underline text-xs">{{ $seeking->user->name }}</div>
                    </div>
                    {{-- 自分の募集はlikeが表示されない --}}
                    @if ($login_user->id != $seeking->user->id)
                    {{-- ログインしている場合のみ気になるできる --}}
                    @if ($login_user->id)
                      {{-- SNSを登録しているか --}}
                      @if ($registered_sns_flag)
                        {{-- 気になるしてるかどうか --}}
                        @if ($seeking->likes->isEmpty())
                          <span class="likes absolute top-2 right-2 like-toggle" data-seeking-id="{{ $seeking->id }}">
                            <i class="fas fa-heart text-bg fa-2x"></i>
                          </span><!-- /.likes -->
                        @else
                          <span class="likes absolute top-2 right-2 like-toggle" data-seeking-id="{{ $seeking->id }}">
                            <i class="fas fa-heart text-bg fa-2x heart liked"></i>
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
                    <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $seeking->seeking_thumbnail) }}"
                      alt="趣味の友達募集や、サークルの募集などにも使用できる、新潟大学生限定マッチングアプリSinderの募集画像"
                      class="rounded-tl-lg rounded-tr-lg w-full min-h-[200px] object-cover">
                  </div>
                  <div class="bg-white p-2 rounded-bl-lg rounded-br-lg">
                    <h2 class="font-bold text-sm">{{ $seeking->title }}</h2>
                    <p class="show-2-lines text-xs mt-2">{{ $seeking->content }}</p>
                    <div class="flex items-center mt-4">
                      <img src="{{ Storage::disk('s3')->url('avatar/' . $seeking->user->avatar) }}" alt="アイコン画像"
                        class="w-8 h-8 rounded-full mr-2">
                      <div href="{{ route('profile.show', ['user_name' => $seeking->user->name]) }}"
                        class="hover:underline text-xs">{{ $seeking->user->name }}</div>
                    </div>

                    {{-- ログインしているかどうか --}}
                    @if ($logged_in)
                      {{-- 他人の募集の場合 --}}
                      @if (!$my_profile)
                        {{-- 募集に気になるしているかどうか --}}
                        @if ($seeking->likes->isEmpty())
                          {{-- SNSを登録しているか --}}
                          @if ($registered_sns_flag)
                            <span class="likes absolute top-2 right-2 like-toggle" data-seeking-id="{{ $seeking->id }}">
                              <i class="fas fa-heart text-bg fa-2x"></i>
                            </span><!-- /.likes -->
                          @else
                            <span class="likes absolute top-2 right-2">
                              <a href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}"
                                class="like-toggle">
                                <i class="fas fa-heart text-bg fa-2x like-toggle"></i>
                              </a>
                            </span>
                          @endif
                        @else
                          {{-- SNSを登録しているか --}}
                          @if ($registered_sns_flag)
                            <span class="likes absolute top-2 right-2 like-toggle"
                              data-seeking-id="{{ $seeking->id }}">
                              <i class="fas fa-heart heart like-toggle liked text-bg fa-2x"></i>
                            </span><!-- /.likes -->
                          @else
                            <span class="likes absolute top-2 right-2">
                              <a href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}"
                                class="like-toggle">
                                <i class="fas fa-heart liked text-bg fa-2x like-toggle"></i>
                              </a>
                            </span>
                          @endif
                        @endif
                      @endif
                    @else
                      {{-- ログインページに遷移 --}}
                      <span class="likes absolute top-2 right-2">
                        <a href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
                          <i class="fas fa-heart"></i>
                        </a>
                      </span>
                    @endif
                  </div>
                </a>
              @endif
            @endforeach
          </div>
        </div>
      @endif
      <script type="module">
        //気になる処理
        $(function() {
          let like = $('.like-toggle');
          let likeSeekingId;

          like.off('click').on('click', function(event) {
            event.stopPropagation(); // イベントの伝播を停止
            event.preventDefault(); // デフォルトのアクションを阻止

            let $this = $(this);
            likeSeekingId = $this.data('seeking-id');
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: '/like',
              method: 'POST',
              data: {
                'seeking_id': likeSeekingId
              },
              success: function() {
                $this.find('.fa-heart').toggleClass('liked');
              },
              error: function() {
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
