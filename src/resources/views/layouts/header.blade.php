<header>
  <div class="relative bg-main py-3">
    <a href="{{route('seeking.index')}}" class="font-logo font-bold text-white text-2xl tracking-tighter absolute top-1/2 left-3 transform -translate-y-1/2">
        Sinder
    </a>
    <h1 class="font-title font-bold text-white {{ Request::is('privacy-policy') ? 'text-xl' : 'text-2xl' }} text-center">@yield('title')</h1>

    @if (isset($cancel_button) && $cancel_button)
        <a href="{{ url()->previous() }}" class="font-base text-white text-sm absolute top-1/2 right-3 transform -translate-y-1/2">
            キャンセル
        </a>
    @endif
  </div>
</header>