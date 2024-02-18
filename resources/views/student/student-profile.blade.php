@extends('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')

    <section>
        <div class="profile_block">


            <div class="avatar">
                <div class="avatar_img avatar_profile">
                    <img src="{{ asset('storage/img/090ce25dad60c25fede97b855eea96ef.jpg') }}" alt="Профиль">
                </div>
            </div>

            <div class="all_students">
                <a href="">Мои ученики</a>
            </div>
            <div class="info_profile">
                <form action="{{ route('profile.update') }}" method="post">
                    @csrf
                    <div>
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="first_name" placeholder="Введите ваше имя" value="{{ $user->first_name }}" required>
                    </div>
                    <div>
                        <label for="surname">Фамилия</label>
                        <input type="text" id="surname" name="middle_name" placeholder="Введите вашу фамилию" value="{{ $user->middle_name }}" required>
                    </div>
                    <div>
                        <label for="patronymic">Отчество</label>
                        <input type="text" id="patronymic" name="last_name" placeholder="Введите ваше отчество" value="{{ $user->last_name }}" required>
                    </div>
                    <div>
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Введите ваш e-mail" value="{{ $user->email }}" required>
                    </div>
                    <div>
                        <label for="name_parent">Имя родителя</label>
                        <input type="text" id="name_parent" name="parent_name" placeholder="Введите имя родителя" value="{{ $user->parent_name }}" required>
                    </div>
                    <div>
                        <label for="surname_parent">Фамилия родителя</label>
                        <input type="text" id="surname_parent" name="parent_surname" placeholder="Фамилия родителя" value="{{ $user->parent_surname }}" required>
                    </div>
                    <div>
                        <label for="phone_parent">Телефон родителя</label>
                        <input type="tel" id="phone_parent" name="phone" placeholder="Телефон родителя" value="{{ $user->phone }}" required>
                    </div>
                    <div>
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" required>
                        <span class="togglePassword"></span>
                    </div>
                    <button type="submit" class="btn-green"><p>Подтвердить</p></button>
                </form>
            </div>
        </div>


        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    </section>

@endsection
