<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('storage/img/logo.svg')}}" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.min.css')}}" />
    <title>@yield('title')</title>
</head>
<body>
{{--<div class="all_blocks">--}}
{{--    @include('partials.navigation-left')--}}
{{--    <div class="container">--}}
{{--    </div>--}}

{{--    @include('partials.navigation-right')--}}
{{--</div>--}}

@if(auth()->check())
    @if(auth()->user()->role === \App\Enums\RoleEnum::STUDENT->value)
        <div class="all_blocks">
            @include('partials.navigation-left')
            <div class="container">
                @yield('content')
            </div>

            @include('partials.navigation-right')
        </div>
    @elseif(auth()->user()->role === \App\Enums\RoleEnum::TEACHER->value)
        <div class="all_blocks">
            @include('partials.navigation-left')
            <div class="container">
                @yield('content')
            </div>

            @include('partials.navigation-right')
        </div>
    @endif
@else
    @yield('role')
@endif

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('jquery.mask.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
