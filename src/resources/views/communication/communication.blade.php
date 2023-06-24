@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-6">やりとり</h1>

        <h2 class="text-xl font-bold mb-4">気になった募集</h2>
        @if($seekings->count() > 0)
            <ul class="space-y-4">
                @foreach($seekings as $seeking)
                    <li class="border rounded p-4">
                        <h2 class="text-xl font-bold mb-2">{{ $seeking->title }}</h2>
                        <p>投稿者: <a href="{{ route('profile.show', ['user_name' => $seeking->user->name]) }}" class="text-blue-500 hover:underline">{{ $seeking->user->name }}</a></p>
                        <img src="{{ asset('storage/avatars/' . $seeking->user->avatar) }}" alt="ユーザーアイコン" class="w-8 h-8 rounded-full mr-2">
                        <p>Description: {{ $seeking->content }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No seekings found.</p>
        @endif

        <hr class="my-6">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-success">{{ session('error') }}</div>
        @endif

        <h2 class="text-xl font-bold mb-4">気になられた募集</h2>
        @if($liked_my_seekings->count() > 0)
            <ul class="space-y-4">
                @foreach($liked_my_seekings as $liked_seeking)
                    <li class="border rounded p-4">
                        <h2 class="text-xl font-bold mb-2">{{ $liked_seeking->title }}</h2>
                        <p>Description: {{ $liked_seeking->content }}</p>
                        <p>気になったユーザー:
                            @foreach($liked_seeking->likes as $like)
                                <a href="{{ route('profile.show', ['user_name' => $like->user->name]) }}" class="text-blue-500 hover:underline">{{ $like->user->name }}</a>
                                <a href="{{ route('connection.create', ['seeking_id' => $liked_seeking->id, 'liked_user_id' => $like->user->id]) }}" class="text-blue-500 hover:underline">この人とマッチする</a>
                                <br>
                            @endforeach
                        </p>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No seekings found.</p>
        @endif

        <hr class="my-6">

        <h2 class="text-xl font-bold mb-4">マッチしたユーザー</h2>
        @if($connected_users->count() > 0)
            <ul class="space-y-4">
                @foreach($connected_users as $connected_user)
                    <li class="border rounded p-4">
                        @if($connected_user->user1)
                            <p>
                              <span>{{ $connected_user->user1->name }}</span>
                              <a href="{{ route('profile.show', ['user_name' => $connected_user->user1->name]) }}" class="text-blue-500 hover:underline">
                                SNSで連絡する
                              </a>
                            </p>
                            <p>Connection Date: {{ $connected_user->connection_date }}</p>
                        @elseif($connected_user->user2)
                            <p>
                              <span>{{ $connected_user->user2->name }}</span>
                              <a href="{{ route('profile.show', ['user_name' => $connected_user->user2->name]) }}" class="text-blue-500 hover:underline">
                                SNSで連絡する
                              </a>
                            </p>
                            <p>Connection Date: {{ $connected_user->connection_date }}</p>
                        @else
                            <p>No user found.</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>No connections found.</p>
        @endif

    </div>
@endsection
