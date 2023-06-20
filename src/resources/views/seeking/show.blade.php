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
@endsection
