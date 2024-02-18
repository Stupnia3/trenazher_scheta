
<div class="right-block border_light">
    <nav>
        <ul>
            <li>
                <a href="{{route('profile.show')}}" class="avatar_img">
                        @if(auth()->check())
                            @if(auth()->user()->role === \App\Enums\RoleEnum::STUDENT->value)
                                <img src="{{ asset('storage/img/090ce25dad60c25fede97b855eea96ef.jpg') }}" alt="Профиль">
                            @elseif(auth()->user()->role === \App\Enums\RoleEnum::TEACHER->value)
                                <img src="{{asset('storage/img/5671246976c3f735d4528e2d3d1bdf71.jpg')}}" alt="Профиль">
                            @endif
                        @else
                            @yield('role')
                        @endif
                </a>
            </li>
            <li><a href="/add_child"><img src="{{asset('storage/img/icon (10).svg')}}" alt="Добавить ученика"></a></li>
            <li><a href="/settings"><img src="{{asset('storage/img/icon (9).svg')}}" alt="Настройки"></a></li>
            <li class="exit"><a href="{{route('logout')}}"><img src="{{asset('storage/img/icon (11).svg')}}" alt="Выход"></a></li>
        </ul>
    </nav>
</div>