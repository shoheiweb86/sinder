@extends('layouts.layout')
@section('title', '募集を作成')

@section('content')
    <!-- コンテンツの記述 -->
    <form action="{{ route('seeking.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto">
      @csrf
    
      <div class="mb-4">
          <label for="title" class="block mb-2 font-semibold">Title:</label>
          <input type="text" name="title" id="title" maxlength="30" required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
      </div>
    
      <div class="mb-4">
          <label for="content" class="block mb-2 font-semibold">Content:</label>
          <textarea name="content" id="content" maxlength="200" required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"></textarea>
      </div>
    
      <div class="mb-4">
          <label for="seeking_thumbnail" class="block mb-2 font-semibold">Image:</label>
          <input type="file" name="seeking_thumbnail" id="seeking_thumbnail" required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
      </div>
    
      <button type="submit" class="px-4 py-2 bg-blue-500 rounded-md hover:bg-blue-600">Create</button>
    </form>
@endsection


