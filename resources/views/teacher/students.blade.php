@extends('layouts.app')

@section('content')
    <section>
        <div class="profile_block">
            <h1 class="page_title border_bals">
                <div class="game">Мои ученики</div>
            </h1>
            <div class="navigation_top">
                <a href="{{ url()->previous() }}">
                    <img src="{{ asset('storage/img/back.svg') }}" alt="Назад">
                </a>
                <a href="{{ route('showAllStudents') }}"><img src="{{asset('storage/img/add.svg')}}" alt="Добавить ученика"></a>
            </div>
            @if ($students->isEmpty())
                <p>У вас пока нет учеников.</p>
            @else
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
                                        <form class="toggle-activation-form">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="activation"
                                                   value="{{ $student->status === 'active' ? 'not_active' : 'active' }}">
                                            <button type="button" class="btn_status {{ $student->status === 'active' ? 'active' : 'inactive' }}" onclick="toggleActivation(event, {{$student->id}})">
                                                <div class="circle"></div>
                                            </button>
                                        </form>
                                        <form class="detach-teacher-form">
                                            @csrf
                                            @method('POST')
                                            <button class="btn_delete_user" type="button" class="detach_button" onclick="detachTeacher(event, {{$student->id}})">
                                                <img  src="{{ asset('storage/img/trash.svg') }}">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>

    <script>
        function toggleActivation(event, userId) {
            event.preventDefault();

            // Получаем данные формы
            var form = document.querySelector('.toggle-activation-form');
            var formData = new FormData(form);

            // Отправляем запрос AJAX
            fetch('/toggleActivation/' + userId, {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    // Обработка успешного ответа
                    if (response.ok) {
                        // Находим соответствующую кнопку
                        var button = event.target.closest('.btn_status');

                        // Получаем текущий статус из ответа
                        return response.json().then(data => {
                            // Обновляем класс кнопки в зависимости от нового статуса
                            button.classList.remove('active', 'inactive'); // Удаляем все классы активности
                            button.classList.add(data.status === 'active' ? 'active' : 'inactive');

                            // Находим соответствующий span
                            var statusSpan = document.getElementById('status-span-' + userId);

                            // Обновляем содержимое span с новым статусом
                            var newStatus = data.status === 'active' ? 'Активен' : 'Неактивен';
                            statusSpan.textContent = newStatus;

                            // Обновляем класс span в зависимости от нового статуса
                            statusSpan.classList.remove('text-success', 'text-danger'); // Удаляем все классы цвета текста
                            statusSpan.classList.add(data.status === 'active' ? 'text-success' : 'text-danger');
                        });
                    } else {
                        // Обработка ошибки
                        console.error('Ошибка при обработке запроса');
                    }
                })
                .catch(error => {
                    // Обработка ошибки сети
                    console.error('Ошибка при отправке запроса', error);
                });
        }
        function detachTeacher(event, studentId) {
            event.preventDefault(); // Предотвращаем стандартное действие кнопки

            // Отправляем запрос AJAX для удаления студента
            fetch('/detachTeacher/' + studentId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ teacherId: null }) // Отправляем null в качестве нового значения teacherId
            })
                .then(response => {
                    // Обработка успешного ответа
                    if (response.ok) {
                        // Удаляем строку таблицы
                        var studentRow = document.getElementById('student-row-' + studentId);
                        if (studentRow) {
                            studentRow.remove();
                        }

                        // Получаем данные ответа о статусе пользователя
                        return response.json().then(data => {
                            // Если статус пользователя "неактивен", то меняем его на "активен"
                            if (data.status === 'not_active') {
                                toggleActivation(event, studentId);
                            }
                        });
                    } else {
                        // Обработка ошибки
                        console.error('Ошибка при обработке запроса');
                    }
                })
                .catch(error => {
                    // Обработка ошибки сети
                    console.error('Ошибка при отправке запроса', error);
                });
        }


    </script>



@endsection

