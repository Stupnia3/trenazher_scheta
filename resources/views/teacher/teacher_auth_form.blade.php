@extends('layouts.app')

@section('title')
    Регистрация учитель
@endsection

@section('content')
    @yield('role')
    <div class="register_container ">
        <img src="{{ asset('storage/img/logo.svg') }}" alt="Логотип">

        <div class="all-form_container border_white">
            <div class="btn-select_form">
                <a href="{{route('register.auth')}}" class="btn-active_form">Вход</a>
                <a href="#" class="btn-active_form">Регистрация</a>
            </div>
            <div class="form_container">
                <form action="" method="post">
                    <div>
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="name" placeholder="Введите ваше имя" required>
                    </div>
                    <div>
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Введите ваш e-mail" required>
                    </div>
                    <div>
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" required>
                        <span class="togglePassword"></span>
                    </div>
                    <div>
                        <label for="confirm_password">Повторите пароль</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
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
