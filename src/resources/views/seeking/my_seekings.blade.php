@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>My Seeking</h1>

        @if(count($seekings) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Thumbnail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seekings as $seeking)
                        <tr>
                            <td>{{ $seeking->title }}</td>
                            <td>{{ $seeking->content }}</td>
                            <td>
                                @if($seeking->seeking_thumbnail)
                                    <img src="{{ asset('storage/seeking_thumbnail/' . $seeking->seeking_thumbnail) }}" alt="Thumbnail" width="100">
                                @else
                                    No Thumbnail
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No seeking found.</p>
        @endif
    </div>
@endsection
