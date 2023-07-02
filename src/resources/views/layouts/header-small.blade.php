<header>
    <div class="relative h-9 bg-main px-3 flex justify-center items-center">
        <a href="{{ url()->previous() }}" class="absolute top-1/2 left-3 transform -translate-y-1/2">
            <img src="{{ asset('storage/materials/arrow_left.png')}}" alt="左矢印のアイコン" class="w-5 h-5">
        </a>
        <h1 class="font-title text-white text-sm text-center">@yield('title')</h1>
    </div>
</header>