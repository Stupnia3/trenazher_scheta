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
            <div class="return-button">
                <a href="/"> < Вернуться назад</a>
            </div>

        </div>
    </div>


@endsection
