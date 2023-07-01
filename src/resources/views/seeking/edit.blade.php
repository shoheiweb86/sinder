@extends('layouts.layout')
@section('title', '募集を編集')


@section('content')
  <div class="container">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="font-bold">編集</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('seeking.update', $seeking->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-4">
            <label for="title" class="block mb-2 font-semibold">タイトル:</label>
            <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" value="{{ $seeking->title }}">
          </div>

          <div class="mb-4">
            <label for="content" class="block mb-2 font-semibold">募集文:</label>
            <textarea name="content" id="content" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ $seeking->content }}</textarea>
          </div>

          <div class="mb-4">
            <label for="thumbnail" class="block mb-2 font-semibold">サムネイル:</label>
            <img src="{{ asset('storage/seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="募集画像" class="mb-4">
            <input type="file" name="thumbnail" id="thumbnail" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
          </div>

          <button type="submit" class="px-4 py-2 bg-blue-500 rounded-md hover:bg-blue-600">更新</button>
        </form>
      </div>
    </div>
  </div>
@endsection
