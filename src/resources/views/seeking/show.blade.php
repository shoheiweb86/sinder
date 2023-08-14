@extends('layouts.layout')

@section('content')
  <div class="container">
    <div class="w-full relative">
      <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="募集画像" class="w-full h-auto max-h-[520px] aspect-w-3 aspect-h-4 object-cover">
      {{-- ログインしているかどうか --}}
      @if ($logged_in)
        {{-- 他人の募集の場合 --}}
        @if (!$my_seeking)
          {{-- SNSを登録しているか --}}
          @if ($registered_sns_flag)
            {{-- 募集に気になるしているかどうか --}}
            @if ($my_like_check == 0)
              <span class="likes absolute bottom-3 right-3">
                <i class="fas fa-heart  text-gray fa-3x like-toggle" data-seeking-id="{{ $seeking->id }}"></i>
                <p class="text-white text-sm font-bold">気になる</p>
              </span>
            @else
              <span class="likes absolute bottom-3 right-3">
                <i class="fas fa-heart  text-gray fa-3x heart like-toggle liked" data-seeking-id="{{ $seeking->id }}"></i>
                <p class="text-white text-sm font-bold">気になる</p>
              </span>
            @endif
          @else
            <span class="likes absolute bottom-3 right-3">
              <a href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                <p class="text-white text-sm font-bold">気になる</p>
                <i class="fas fa-heart  text-gray fa-3x"></i>
              </a>
            </span>
          @endif
        @endif
      @else
        {{-- ログインページに遷移 --}}
        <span class="likes absolute bottom-3 right-3">
          <a href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
            <p class="text-white text-sm font-bold">気になる</p>
            <i class="fas fa-heart  text-gray fa-3x"></i>
          </a>
        </span>
      @endif
    </div>
    <div class="p-4 bg-white rounded-2xl -m-1 z-10 relative">
      <div class="flex items-center">
        <img src="{{ Storage::disk('s3')->url('avatar/' .$seeking->user->avatar) }}" alt="アイコン画像"
          class="w-8 h-8 rounded-full mr-2">
        <a href="{{ route('profile.show', ['user_name' => $seeking->user->name]) }}"
          class="text-dark-gray text-sm font-bold">
          {{ $seeking->user->name }}
        </a>
      </div>
      <h2 class="font-bold mt-4">{{ $seeking->title }}</h2>
      <p class="mt-2 text-sm">{{ $seeking->content }}</p>
      <p class="text-xs text-dark-gray mt-2">{{ $seeking->formatted_created_at }}</p>
      <ul class="flex mt-3">
        @if (isset($seeking->user->sex))
          <li class="text-main bg-bg text-xs font-bold py-1 px-3 rounded-3xl">{{ $seeking->user->sex }}</li>
        @endif
        @if (isset($seeking->user->grade))
          <li class="text-main bg-bg text-xs font-bold py-1 px-3 rounded-3xl ml-2">{{ $seeking->user->grade }}</li>
        @endif
        @if (isset($seeking->user->age))
          <li class="text-main bg-bg text-xs font-bold py-1 px-3 rounded-3xl ml-2">{{ $seeking->user->age }}歳</li>
        @endif
        @if (isset($seeking->user->faculty))
          <li class="text-main bg-bg text-xs font-bold py-1 px-3 rounded-3xl ml-2">{{ $seeking->user->faculty }}</li>
        @endif
      </ul>

      {{-- 自分の募集は編集できる --}}
      @if ($my_seeking)
        <div>
          <a href="{{ route('seeking.edit', $seeking->id) }}"
            class="block text-center bg-dark-gray hover:bg-dark-gray text-white rounded-lg py-4 font-bold w-full mt-4 mx-auto">募集を編集する</a>
        </div>
      @endif
    </div>

  </div>



  <script type="module">

      $(function () {
        let like = $('.like-toggle'); //like-toggleのついたiタグを取得し代入。
        let likeSeekingId; //変数を宣言（なんでここで？）
        like.on('click', function () { //onはイベントハンドラー
          let $this = $(this); //this=イベントの発火した要素＝iタグを代入
          likeSeekingId = $this.data('seeking-id'); //iタグに仕込んだdata-seekingw-idの値を取得
          //ajax処理スタート
          $.ajax({
            headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
              'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
            url: '/like', //通信先アドレスで、このURLをあとでルートで設定します
            method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
            data: { //サーバーに送信するデータ
              'seeking_id': likeSeekingId //いいねされた投稿のidを送る
            },
          })
          //通信成功した時の処理
          .done(function () {
            $this.toggleClass('liked'); //likedクラスのON/OFF切り替え。
          })
          //通信失敗した時の処理
          .fail(function () {
            console.log('fail'); 
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
