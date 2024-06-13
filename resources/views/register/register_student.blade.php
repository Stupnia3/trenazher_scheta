@extends('layouts.app')

@section('title')
    Регистрация ученик
@endsection

@section('role')
    @yield('role')
    <div class="register_container">
        <img src="{{ asset('storage/img/logo.svg') }}" alt="Логотип">

        <div class="all-form_container border_white">
            <div class="btn-select_form">
                <a href="{{ route('login') }}">Вход</a>
                <a href="#" class="btn-active_form">Регистрация</a>
            </div>
            <div class="form_container">
                <form id="registrationForm" action="{{ route('registration.student') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="first_name" placeholder="Введите ваше имя" required>
                        @error('first_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="surname">Фамилия</label>
                        <input type="text" id="surname" name="middle_name" placeholder="Введите вашу фамилию" required>
                        @error('middle_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="patronymic">Отчество</label>
                        <input type="text" id="patronymic" name="last_name" placeholder="Введите ваше отчество" required>
                        @error('last_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Введите ваш e-mail" required>
                        @error('email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="login">Логин</label>
                        <input type="text" id="login" name="login" placeholder="Введите ваш логин" required>
                        @error('login')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="name_parent">Имя родителя</label>
                        <input type="text" id="name_parent" name="parent_name" placeholder="Введите имя родителя" required>
                        @error('parent_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="surname_parent">Фамилия родителя</label>
                        <input type="text" id="surname_parent" name="parent_surname" placeholder="Фамилия родителя" required>
                        @error('parent_surname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="phone_parent">Телефон родителя</label>
                        <input type="tel" id="phone_parent" name="phone" placeholder="Телефон родителя" required>
                        @error('phone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="teacher_id">Выберите учителя</label>
                        <select name="teacher_id" id="teacher_id">
                            <option value="">Выберите учителя</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" required>
                        <span class="togglePassword"></span>
                        @error('password')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="confirm_password">Подтвердите пароль</label>
                        <input type="password" id="confirm_password" name="password_confirmation" required>
                        <span class="togglePassword"></span>
                        @error('password_confirmation')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="file-input-container">
                        <input type="file" id="file-input" name="profile_image" accept="image/jpeg, image/png, image/jpg, image/gif, image/webp" style="display: none;">
                        <label for="file-input" class="custom-file-upload">Выбрать файл</label>
                        <div id="file-preview" >
                            <img id="file-img"  src="#" alt="Выбранный файл" style="display: none;">
                        </div>
                        <span id="file-name" class="file-name">Файл не выбран</span>
                        @error('profile_image')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn-green"><p>Подтвердить</p></button>
                </form>
            </div>
            <div class="return-button">
                <a href="/"> < Вернуться назад</a>
            </div>

        </div>
    </div>


    <script src="{{asset('js/validate.js')}}"></script>

@endsection
