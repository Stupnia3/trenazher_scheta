@extends('layouts.app')

@section('title')
    Регистрация учитель
@endsection

@section('role')
    @yield('role')
    <div class="register_container ">
        <img src="{{ asset('storage/img/logo.svg') }}" alt="Логотип">

        <div class="all-form_container border_white">
            <div class="btn-select_form">
                <a href="{{route('login')}}">Вход</a>
                <a href="#" class="btn-active_form">Регистрация</a>
            </div>
            <div class="form_container">
                <form action="{{route('registration.teacher')}}" method="post">
                    @csrf
                    <div>
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="first_name" placeholder="Введите ваше имя" required>
                    </div>
                    <div>
                        <label for="surname">Фамилия</label>
                        <input type="text" id="surname" name="middle_name" placeholder="Введите вашу фамилию" required>
                    </div>
                    <div>
                        <label for="patronymic">Отчество</label>
                        <input type="text" id="patronymic" name="last_name" placeholder="Введите ваше отчество" required>
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
                        <input type="password" id="confirm_password" name="password_confirmation" required>
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