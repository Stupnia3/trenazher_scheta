@extends('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')

    <section>
        <div class="profile_block">

            <div class="avatar">
                <div class="avatar_img avatar_profile">
                    <img src="{{ asset('storage/avatars/' . $user->profile_image) }}" alt="Профиль">
                </div>
            </div>

            @if ($showStudentsLink)
                <div class="all_students">
                    <a href="{{ route('teacher.students') }}">Мои ученики</a>
                </div>
            @endif

            <div class="info_profile">
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="first_name" placeholder="Введите ваше имя" value="{{ $user->first_name }}" required>
                        @error('first_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="surname">Фамилия</label>
                        <input type="text" id="surname" name="middle_name" placeholder="Введите вашу фамилию" value="{{ $user->middle_name }}" required>
                        @error('middle_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="patronymic">Отчество</label>
                        <input type="text" id="patronymic" name="last_name" placeholder="Введите ваше отчество" value="{{ $user->last_name }}" required>
                        @error('last_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Введите ваш e-mail" value="{{ $user->email }}" required>
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="login">Логин</label>
                        <input type="text" id="login" name="login" placeholder="Введите ваш логин" value="{{ $user->login }}" required>
                        @error('login')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" required>
                        <span class="togglePassword"></span>
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
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

                <div class="change_password_block">
                    <h2>Смена пароля</h2>
                    <form action="{{ route('profile.changePassword') }}" method="post" id="changePasswordForm">
                        @csrf
                        <div>
                            <label for="current_password">Текущий пароль</label>
                            <input type="password" id="current_password" name="current_password" required>
                            @error('current_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="new_password">Новый пароль</label>
                            <input type="password" id="new_password" name="new_password" required>
                            @error('new_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="confirm_new_password">Подтверждение нового пароля</label>
                            <input type="password" id="confirm_new_password" name="new_password_confirmation" required>
                        </div>

                        <button type="submit" class="btn-green"><p>Подтвердить</p></button>
                    </form>
                </div>
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

        @error('current_password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        @error('new_password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </section>

    <script src="{{ asset('js/validate.js') }}"></script>
    <script>
        document.getElementById('file-input').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('file-img').src = e.target.result;
                    document.getElementById('file-img').style.display = 'block';
                };
                reader.readAsDataURL(file);
                document.getElementById('file-name').textContent = file.name;
            }
        });

    </script>
@endsection
