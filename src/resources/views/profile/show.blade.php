@extends('layouts.layout')

@section('content')
    @if($my_profile)
        <h1 class="font-logo text-white text-2xl tracking-tighter absolute top-4 left-3">Sinder</h1>
    @else
      <a href="{{ url()->previous() }}" class="absolute top-4 left-3 ">
          <img src="{{ asset('storage/materials/arrow_left.png')}}" alt="左矢印のアイコン" class="w-5 h-5">
      </a>
    @endif


  <div class="">
      <!-- 名前 -->
      <div>
          <x-input-label for="name" value="名前" />
          <span class="block mt-1">{{ $profile_user->name }}</span>
      </div>

      <!-- 学年 -->
      <div>
          <x-input-label for="grade" value="学年" />
          <span class="block mt-1">{{ $profile_user->grade }}</span>
      </div>

      <!-- 学部 -->
      <div>
          <x-input-label for="faculty" value="学部" />
          <span class="block mt-1">{{ $profile_user->faculty }}</span>
      </div>

      <!-- 年齢 -->
      <div>
          <x-input-label for="age" value="年齢" />
          <span class="block mt-1">{{ $profile_user->age }}</span>
      </div>

      <!-- 性別 -->
      <div>
          <x-input-label for="sex" value="性別" />
          <span class="block mt-1">{{ $profile_user->sex }}</span>
      </div>

      <!-- 自己紹介 -->
      <div>
          <x-input-label for="self_introduction" value="自己紹介" />
          <span class="block mt-1">{{ $profile_user->self_introduction }}</span>
      </div>

      <!-- アイコン -->
      <div>
          <x-input-label for="avatar" value="アイコン画像" />
          @if ($profile_user->avatar)
              <img src="{{ asset('storage/avatars/' . $profile_user->avatar) }}" alt="Avatar">
          @else
              <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar">
          @endif
      </div>

      <!-- SNSリンク マッチしているユーザーのみ表示 -->
      <p>SNS</p>
      @if ($connected_flag)
          <!-- LINE -->
          <div>
              <x-input-label for="line_link" value="LINE" />
              <span class="block mt-1">{{ $profile_user->line_link }}</span>
          </div>

          <!-- Instagram -->
          <div>
              <x-input-label for="instagram_link" value="Instagram" />
              <span class="block mt-1">{{ $profile_user->instagram_link }}</span>
          </div>

          <!-- Twitter -->
          <div>
              <x-input-label for="twitter_link" value="Twitter" />
              <span class="block mt-1">{{ $profile_user->twitter_link }}</span>
          </div>
      @else
          <p>マッチしたらSNSを閲覧できます</p>
      @endif

      <!-- プロフィール編集ボタン -->
      @if ($logged_in && $my_profile)
          <div>
            <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              プロフィール編集
            </a>            
          </div>
      @endif

      <!-- 募集一覧 -->
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

          {{-- ログインしているかどうか --}}
          @if($logged_in)
              {{-- 他人の募集の場合--}}
              @if(!$my_profile)
                  {{-- 募集に気になるしているかどうか --}}
                  @if ($seeking->likes->isEmpty())
                      {{-- SNSを登録しているか --}}
                      @if ($registered_sns_flag)
                          <span class="likes">
                              <i class="fas fa-heart like-toggle" data-seeking-id="{{ $seeking->id }}"></i>
                          </span><!-- /.likes -->
                      @else 
                          <span class="likes">
                            <a href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                                <i class="fas fa-heart"></i>
                            </a>
                          </span>
                      @endif
                  @else
                      {{-- SNSを登録しているか --}}
                      @if ($registered_sns_flag)
                          <span class="likes">
                              <i class="fas fa-heart heart like-toggle liked" data-seeking-id="{{ $seeking->id }}"></i>
                          </span><!-- /.likes -->
                      @else
                          <span class="likes">
                            <a href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                                <i class="fas fa-heart liked"></i>
                            </a>
                          </span>
                      @endif
                  @endif
              @endif
          @else
              {{-- ログインページに遷移 --}}
              <span class="likes">
                  <a href="{{ route('login', ['like_no_login' => 'like_no_login']) }}" class="like-toggle">
                      <i class="fas fa-heart"></i>
                  </a>
              </span>
          @endif


          <hr class="my-4">
      </div>
  @endforeach
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
  color: pink;
  }
  </style>
@endsection