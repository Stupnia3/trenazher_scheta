@extends('layouts.app')

@section('title')
    Регистрация ученик
@endsection

@section('role')
    @yield('role')
    <div class="register_container ">
        <img src="{{ asset('storage/img/logo.svg') }}" alt="Логотип">

        <div class="all-form_container border_white">
            <div class="btn-select_form">
                <a href="{{route('login')}}" class="btn-active_form">Вход</a>
                <a href="/">Регистрация</a>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="form_container">
                <form action="{{route('auth')}}" method="post">
                    @csrf
                    <div>
                        <label for="login">Логин</label>
                        <input type="text" id="login" name="login" placeholder="Введите ваш логин" required>
                    </div>
                    <div>
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" required>
                        <span class="togglePassword"></span>
                    </div>
                    <button type="submit" class="btn-green"><p>Подтвердить</p></button>
                </form>
            </div>
            <div class="btn-teacher" style="margin-top: 20px; width: 100%;">
                <a href="/" style="font-size: 20px; font-weight: 900; line-height: 25px; text-align: center; color: rgba(255, 255, 255, 1); text-shadow: rgba(0, 0, 0, 0.2) 0 2px 3px; text-transform: uppercase;">Вернуться назад</a>
            </div>

        </div>
    </div>


    <script src="{{asset('js/validate.js')}}"></script>
@endsection
