@extends('layouts.layout')

@section('content')
  <div class="container">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="font-bold">{{ $seeking->title }}</h5>
      </div>
      <div class="card-body">
        <p class="mb-4">{{ $seeking->content }}</p>
        <img src="{{ asset('storage/seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="募集画像" class="mb-4">
        <div class="flex items-center">
          <img src="{{ asset('storage/avatars/' . $seeking->user->avatar) }}" alt="ユーザーアイコン" class="w-8 h-8 rounded-full mr-2">
          <p>投稿者: <a href="{{ route('profile.show', ['user_name' => $seeking->user->name]) }}" class="text-blue-500 hover:underline">{{ $seeking->user->name }}</a></p>
          <span>{{ $seeking->user->grade }}</span>
          <span>{{ $seeking->user->faculty }}</span>
          <span>{{ $seeking->user->sex }}</span>
        </div>

        {{-- 自分の募集は編集できる --}}
        @if($my_seeking)
          <a href="{{ route('seeking.edit', $seeking->id) }}" class="btn btn-primary mt-4">編集</a>
          <form action="{{ route('seeking.destroy', $seeking->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger mt-4" onclick="return confirm('本当に削除しますか？')">削除</button>
          </form>
        @endif
      </div>
    </div>
    </div>

    {{-- ログインしているかどうか --}}
    @if($logged_in)
        {{-- 他人の募集の場合--}}
        @if(!$my_seeking)
            {{-- SNSを登録しているか --}}
            @if ($registered_sns_flag)
                {{-- 募集に気になるしているかどうか --}}
                @if ($my_like_check == 0)
                    <span class="likes">
                        <i class="fas fa-heart like-toggle" data-seeking-id="{{ $seeking->id }}"></i>
                    </span>
                @else
                    <span class="likes">
                        <i class="fas fa-heart heart like-toggle liked" data-seeking-id="{{ $seeking->id }}"></i>
                    </span>
                @endif
            @else
                <span class="likes">
                  <a href="{{ route('profile.edit', ['like_no_sns' => 'like_no_sns']) }}" class="like-toggle">
                      <i class="fas fa-heart"></i>
                  </a>
                </span>
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