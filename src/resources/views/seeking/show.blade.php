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
          <span>{{ $seeking->user->name }}</span>
        </div>
        @if($canEdit)
          <a href="{{ route('seeking.edit', $seeking->id) }}" class="btn btn-primary mt-4">編集</a>
        @endif
      </div>
    </div>
    </div>
    <!-- Review.phpに作ったisLikedByメソッドをここで使用 -->
    @if ($my_like_check == 0)
      <span class="likes">
          <i class="fas fa-heart like-toggle" data-seeking-id="{{ $seeking->id }}"></i>
      </span><!-- /.likes -->
    @else
      <span class="likes">
          <i class="fas fa-heart heart like-toggle liked" data-seeking-id="{{ $seeking->id }}"></i>
      </span><!-- /.likes -->
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
@endsection

<style>
  .liked {
  color: pink;
}
</style>

<script type=”module”>
  console.log(1111);
</script>