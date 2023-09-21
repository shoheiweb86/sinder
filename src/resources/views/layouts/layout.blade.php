<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Sinder(シンダー)は新潟大学生限定マッチングアプリです。恋愛だけでなく、趣味の友達募集や、サークルの募集などにも使用できます。">
        <title>{{ config('app.name', 'Sinder | 新潟大学生限定マッチングアプリ') }}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/materials/favicon.ico') }}">
        <link rel="apple-touch-icon" type="image/png" href="{{ asset('storage/materials/apple-touch-icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- サチコ -->
        <meta name="google-site-verification" content="_u2MfDNCPBFt22oLZxlQimJIfloBwn8o2eI3sLvohAg" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="antialiased font-base bg-bg">
        <div class="min-h-screen pb-20">

            @if (Request::routeIs('seeking.create') || Request::routeIs('seeking.edit'))
                @include('layouts.header', ['cancel_button' => true])

            @elseif (Request::routeIs('seeking.show') || Request::routeIs('profile.edit'))
                @include('layouts.header-small')

            @elseif (Request::routeIs('profile.show'))
                {{-- ヘッダーはseeking.showに直接書いた --}}
            @else

                @include('layouts.header')
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
            
            {{-- フッター呼び出し --}}
            @include('layouts.footer')
        </div>
    </body>
</html>
