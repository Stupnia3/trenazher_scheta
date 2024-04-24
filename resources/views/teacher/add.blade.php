@extends('layouts.app')

@section('content')
    <section>
        <div class="profile_block">
            <h1 class="page_title border_bals">
                <div class="game">Добавить ученика</div>
            </h1>
            <div class="navigation_top">
                <a href="{{ url()->previous() }}">
                    <img src="{{ asset('storage/img/back.svg') }}" alt="Назад">
                </a>
            </div>

            <div class="table_container">
                <table class="all_students_table">
                    <thead>
                    <tr>
                        <th>Пользователь</th>
                        <th>Активация</th>
                        <th>Флеш-анзан</th>
                        <th>Флеш-карты</th>
                        <!-- Другие игры -->
                        <th>Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($students as $student)
                        @if ($student->teacher_id === auth()->user()->id)
                            <tr id="student-row-{{$student->id}}">
                                <td>
                                    <div class="flex">
                                        <div class="avatar_img avatar_profile avatar_student">
                                            <img src="{{ asset('storage/avatars/' . $student->profile_image) }}"
                                                 alt="Профиль">
                                        </div>
                                        <div>{{ $student->last_name }} {{ $student->first_name }}</div>
                                    </div>
                                </td>
                                <td>
                <span id="status-span-{{$student->id}}"
                      class="{{ $student->status === 'active' ? 'text-success' : 'text-danger' }}">
                    {{ $student->status === 'active' ? 'Активен' : 'Неактивен' }}
                </span>
                                </td>
                                <td>{{ $student->flash_anzan_score }}</td>
                                <td>{{ $student->flash_cards_score }}</td>
                                <td>
                                    <div class="flex">
                                        <span>Привязан</span>
                                    </div>
                                </td>
                            </tr>
                        @elseif (!$student->teacher_id)
                            <tr id="student-row-{{$student->id}}">
                                <td>
                                    <div class="flex">
                                        <div class="avatar_img avatar_profile avatar_student">
                                            <img src="{{ asset('storage/avatars/' . $student->profile_image) }}"
                                                 alt="Профиль">
                                        </div>
                                        <div>{{ $student->last_name }} {{ $student->first_name }}</div>
                                    </div>
                                </td>
                                <td>
                <span id="status-span-{{$student->id}}"
                      class="{{ $student->status === 'active' ? 'text-success' : 'text-danger' }}">
                    {{ $student->status === 'active' ? 'Активен' : 'Неактивен' }}
                </span>
                                </td>
                                <td>{{ $student->flash_anzan_score }}</td>
                                <td>{{ $student->flash_cards_score }}</td>
                                <td>
                                    <div class="flex">
                                        <form class="addStudentForm" action="{{ route('addStudent') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="teacher_id" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <button type="submit" class="addStudentButton"><img src="{{ asset('storage/img/add.svg') }}" alt="Добавить"></button>

                                            <span class="addedMessage" style="display: none;">Привязан</span>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach



                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script>
        document.querySelectorAll('.addStudentForm').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Предотвращаем стандартное поведение формы

                var formData = new FormData(form);
                var button = form.querySelector('.addStudentButton');
                var addedMessage = form.querySelector('.addedMessage');

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Ошибка при выполнении запроса');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            button.style.display = 'none'; // Скрываем кнопку
                            addedMessage.style.display = 'inline'; // Показываем сообщение "Привязан"
                        } else {
                            console.error('Ошибка при добавлении ученика');
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка при отправке запроса', error);
                    });
            });
        });
    </script>

@endsection
