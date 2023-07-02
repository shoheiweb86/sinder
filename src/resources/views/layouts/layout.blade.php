<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sinder') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="antialiased font-base bg-bg">
        <div class="min-h-screen pb-12">

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
