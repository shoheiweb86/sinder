@extends('layouts.layout')
@section('title', 'メール認証')

@section('content')
  <div class="flex flex-col justify-center items-center bg-gray-100 pt-28">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
      <!-- ここでセッションのステータスメッセージを表示 -->
      @if (session('status') == 'verification-link-sent')
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
          メールを再送信しました。
        </div>
      @endif

      <p class="text-gray-700 mb-4">
        メールアドレス確認メールを<br>
        {{ $email }}<br>
        宛にに送信しました。
      </p>
      <p class="text-gray-700 mb-6">メールが届いていない場合は、以下のボタンをクリックして再送信してください。</p>

      <form method="post" action="{{ route('verification.send') }}" class="mb-6">
        @method('post')
        @csrf
        <div>
          <button type="submit"
            class="w-full bg-main text-white py-3 px-4 rounded hover:bg-main focus:outline-none focus:ring-2 focus:ring-main focus:ring-opacity-50">
            確認メールを再送信
          </button>
        </div>
      </form>

      <p class="text-sm text-center"><a href="/" class="text-main hover:underline">TOPに戻る</a></p>
    </div>
  </div>
@endsection
