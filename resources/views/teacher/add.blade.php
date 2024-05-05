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
                <div class="search_container">
                    <input type="text" id="searchInput" placeholder="Поиск..." oninput="searchStudents()">
                </div>
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
                                            <img src="{{ asset('storage/avatars/' . $student->profile_image) }}" alt="Профиль">
                                        </div>
                                        <div>{{ $student->last_name }} {{ $student->first_name }}</div>
                                    </div>
                                </td>
                                <td>
                    <span id="status-span-{{$student->id}}" class="{{ $student->status === 'active' ? 'text-success' : 'text-danger' }}">
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
                                            @if ($student->teacher_id) <!-- Проверяем, что ученик привязан к учителю -->
                                            @if ($student->teacher_id == auth()->user()->id)
                                                Привязан к вам
                                            @else
                                                <span style="color: red;">Привязан</span>
                                            @endif
                                            @else
                                                <button type="submit" class="addStudentButton"><img src="{{ asset('storage/img/add.svg') }}" alt="Добавить"></button>
                                                <span class="addedMessage" style="display: none;">Привязан</span>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                    @endforeach
                    </tbody>

                </table>
                <div class="pagination_container">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination" id="pagination">
                            {{-- Ссылка на предыдущую страницу --}}
                            <li class="page-item previous {{ $students->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="#" onclick="loadStudents({{ $students->currentPage() - 1 }})" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            {{-- Ссылки на страницы --}}
                            @for ($i = 1; $i <= $students->lastPage(); $i++)
                                <li class="page-item {{ $i === $students->currentPage() ? 'active' : '' }}" id="page-item-{{ $i }}">
                                    <a class="page-link" href="#" onclick="loadStudents({{ $i }})">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Ссылка на следующую страницу --}}
                            <li class="page-item next {{ $students->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="#" onclick="loadStudents({{ $students->currentPage() + 1 }})" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </section>

    <script>
        // Назначаем обработчик событий родительскому элементу, который существует на момент загрузки страницы
        document.addEventListener('submit', function(event) {
            // Проверяем, является ли целевой элемент формой с классом "addStudentForm"
            if (event.target && event.target.classList.contains('addStudentForm')) {
                event.preventDefault(); // Предотвращаем стандартное поведение формы

                var formData = new FormData(event.target);
                var button = event.target.querySelector('.addStudentButton');
                var addedMessage = event.target.querySelector('.addedMessage');

                fetch(event.target.action, {
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
            }
        });
        // Функция для поиска студентов по введенному тексту
        function searchStudents() {
            let searchInput = document.getElementById('searchInput');
            let searchValue = searchInput.value.trim(); // Получаем значение из поля ввода и удаляем начальные и конечные пробелы

            // Загружаем студентов с учетом введенного текста
            loadStudents(1, '', searchValue);

            // Скрываем пагинацию при выполнении поиска
            let paginationContainer = document.querySelector('.pagination_container');
            paginationContainer.style.display = 'none';
        }

        // Функция для отображения пагинации, если поле поиска пустое
        function showPaginationIfEmpty() {
            let searchInput = document.getElementById('searchInput');
            if (searchInput.value.trim() === '') {
                let paginationContainer = document.querySelector('.pagination_container');
                paginationContainer.style.display = 'block';
            }
        }

        // Загрузка студентов при загрузке страницы с учетом поискового запроса
        document.addEventListener("DOMContentLoaded", function() {
            let searchInput = document.getElementById('searchInput');
            let searchValue = searchInput.value.trim(); // Получаем значение поискового запроса и удаляем начальные и конечные пробелы
            loadStudents(1, '', searchValue); // Загружаем студентов с первой страницы и передаем поисковый запрос
        });

        // Отображаем пагинацию, если поле поиска пустое после завершения ввода
        document.getElementById('searchInput').addEventListener('input', showPaginationIfEmpty);

        // Функция для загрузки студентов с учетом поискового запроса
        function loadStudents(page, filter, search) {
            let url = "{{ route('loadStudents') }}?page=" + page;
            if (filter) {
                url += "&filter=" + filter;
            }
            if (search) {
                url += "&search=" + search; // Добавляем поисковый запрос в URL
            }
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    updateTable(data); // Обновляем только данные студентов
                    updatePagination(data); // Обновляем пагинацию
                })
                .catch(error => {
                    console.error('Ошибка при загрузке студентов', error);
                });
        }

        // Функция для обновления данных в таблице с учениками
        function updateTable(data) {
            let tbody = document.querySelector('.all_students_table tbody');

            // Очищаем только данные в tbody, не затрагивая thead
            tbody.innerHTML = '';

            // Если нет результатов поиска, отображаем сообщение "Пользователь не найден"
            if (data.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Пользователь не найден</td></tr>';
                return;
            }

            // Добавляем новые данные в tbody таблицы
            data.data.forEach(student => {
                let row = document.createElement('tr');
                let html = `
                <td>
                    <div class="flex">
                        <div class="avatar_img avatar_profile avatar_student">
                            <img src="{{ asset('storage/avatars/') }}/${student.profile_image}" alt="Профиль">
                        </div>
                        <div>${student.last_name} ${student.first_name}</div>
                    </div>
                </td>
                <td>
                    <span class="${student.status === 'active' ? 'text-success' : 'text-danger'}">
                        ${student.status === 'active' ? 'Активен' : 'Неактивен'}
                    </span>
                </td>
                <td>${student.flash_anzan_score}</td>
                <td>${student.flash_cards_score}</td>
                <td>
                    <div class="flex">
                        <form class="addStudentForm" action="{{ route('addStudent') }}" method="post">
                            @csrf
                <input type="hidden" name="teacher_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="student_id" value="${student.id}">
                            ${student.teacher_id ? `
                                ${student.teacher_id == {{ auth()->user()->id }} ? 'Привязан к вам' : '<span style="color: red;">Привязан</span>'}
                            ` : `
                                <button type="submit" class="addStudentButton">
                                    <img src="{{ asset('storage/img/add.svg') }}" alt="Добавить">
                                </button>
                                <span class="addedMessage" style="display: none;">Привязан</span>
                            `}
                        </form>
                    </div>
                </td>
            `;
                row.innerHTML = html;
                tbody.appendChild(row);
            });
        }

        // Функция для обновления пагинации
        function updatePagination(data) {
            document.querySelectorAll('.pagination .page-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector('#page-item-' + data.current_page).classList.add('active');
            const previousButton = document.querySelector('.pagination .previous');
            const nextButton = document.querySelector('.pagination .next');
            if (data.current_page === 1) {
                previousButton.classList.add('disabled');
            } else {
                previousButton.classList.remove('disabled');
            }
            if (data.current_page === data.last_page) {
                nextButton.classList.add('disabled');
            } else {
                nextButton.classList.remove('disabled');
            }
        }
    </script>


@endsection
