<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="образование, онлайн-обучение, учебные курсы, уроки, школа, университет, изучение, навыки, веб-разработка, программирование, дизайн, маркетинг, английский язык, финансы, искусство, музыка">

    <link rel="shortcut icon" href="{{asset('storage/img/logo.svg')}}" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.min.css')}}" />
    <title>@yield('title')</title>
</head>
<body>
@if(auth()->check())
    @if(auth()->user()->role === \App\Enums\RoleEnum::STUDENT->value)
        <div class="all_blocks">
            @include('partials.navigation-left')
            <div class="container">
                @yield('content')
            </div>

            @include('partials.navigation-right', ['user' => auth()->user()])
        </div>
    @elseif(auth()->user()->role === \App\Enums\RoleEnum::TEACHER->value)
        <div class="all_blocks">
            @include('partials.navigation-left')
            <div class="container">
                @yield('content')
            </div>

            @include('partials.navigation-right', ['user' => auth()->user()])
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
