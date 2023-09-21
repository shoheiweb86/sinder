@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>自分の募集一覧</h1>
        @foreach($seekings as $seeking)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="font-bold">
                        <a class="underline" href="{{ route('seeking.show', $seeking->id) }}">{{ $seeking->title }}</a>
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-4">{{ $seeking->content }}</p>
                    <img src="{{ Storage::disk('s3')->url('seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="趣味の友達募集や、サークルの募集などにも使用できる、新潟大学生限定マッチングアプリSinderの募集画像" class="mb-4">
                    <div class="flex items-center">
                        <img src="{{ Storage::disk('s3')->url('avatar/' . $seeking->user->avatar) }}" alt="趣味の友達募集や、サークルの募集などにも使用できる、新潟大学生限定マッチングアプリSinderのユーザー" class="w-8 h-8 rounded-full mr-2">
                        <span>{{ $seeking->user->name }}</span>
                    </div>
                </div>
                <hr class="my-4">
            </div>
        @endforeach
    </div>
@endsection
