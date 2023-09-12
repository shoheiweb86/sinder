<div class="flex justify-between py-2 px-10 fixed bottom-0 w-full bg-white-90 z-50">
    <a href="{{route('seeking.index')}}">
        @if (Request::is('/'))
          <img src="{{ asset('storage/materials/home_active.png')}}" alt="ホームのアイコン" class="w-8 h-8">
        @else
          <img src="{{ asset('storage/materials/home.png')}}" alt="ホームのアイコン" class="w-8 h-8">
        @endif
    </a>

    <a href="{{route('seeking.create')}}">
        @if (Request::is('seeking*'))
          <img src="{{ asset('storage/materials/seeking_active.png')}}" alt="募集のアイコン" class="w-8 h-8">
        @else
          <img src="{{ asset('storage/materials/seeking.png')}}" alt="募集のアイコン" class="w-8 h-8">
        @endif
    </a>

    <a href="{{route('communication.index')}}">
        @if (Request::is('communication*'))
          <img src="{{ asset('storage/materials/bell_active.png')}}" alt="通知のアイコン" class="w-8 h-8">
        @else
          <img src="{{ asset('storage/materials/bell.png')}}" alt="通知のアイコン" class="w-8 h-8">
        @endif
    </a>    
    
    @if (auth()->check())
        <a href="{{route('profile.show', ['user_name' => auth()->user()->name])}}">
            @if (Request::is('profile*'))
                <img src="{{ asset('storage/materials/profile_active.png') }}" alt="プロフィールのアイコン" class="w-8 h-8">
            @else
                <img src="{{ asset('storage/materials/profile.png') }}" alt="プロフィールのアイコン" class="w-8 h-8">
            @endif
        </a>
    @else
        <a href="{{route('login')}}">
          <img src="{{ asset('storage/materials/profile.png')}}" alt="プロフィールのアイコン" class="w-8 h-8">
        </a>
    @endif
</div>
