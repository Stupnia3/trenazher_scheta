@extends('layouts.app')

@section('content')

    <section>
        <div class="profile_block">
            <h1 class="page_title border_bals">
                <div class="game">{{ $student->middle_name }} {{ $student->first_name }}</div>
            </h1>
            <div class="navigation_top">
                <a href="{{ url()->previous() }}">
                    <img src="{{ asset('storage/img/back.svg') }}" alt="Назад">
                </a>
            </div>
            <div class="table_container">
                <h1>Флеш-анзан</h1>
                <button class="toggle-table-btn btn-student" data-target="#flash-anzan-table">Показать таблицу</button>
                <table id="flash-anzan-table" class="table game-table all_students_table" style="display: none;">
                    <thead>
                    <tr>
                        <th>Кол-во действий</th>
                        <th>Скорость</th>
                        <th>Кол-во примеров</th>
                        <th>Результат (баллы)</th>
                        <th>Дата игры</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($flashAnzanSettings as $setting)
                        @php
                            $result = $flashAnzanResults->first(function($result) use ($setting) {
                                return $result->created_at->diffInSeconds($setting->created_at) < 60;
                            });
                        @endphp
                        <tr>
                            <td>{{ $setting->action_count }}</td>
                            <td>{{ $setting->speed }}</td>
                            <td>{{ $setting->examples }}</td>
                            <td>{{ $result ? $result->score : 'N/A' }}</td>
                            <td>{{ $setting->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Флеш-карты -->
                <h1>Флеш-карты</h1>
                <button class="toggle-table-btn btn-student" data-target="#flash-cards-table">Показать таблицу</button>
                <table id="flash-cards-table" class="table game-table all_students_table" style="display: none;">
                    <thead>
                    <tr>
                        <th>Скорость</th>
                        <th>Кол-во примеров</th>
                        <th>Результат (баллы)</th>
                        <th>Дата игры</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($flashCardsSettings as $setting)
                        @php
                            $result = $flashCardsResults->first(function($result) use ($setting) {
                                return $result->created_at->diffInSeconds($setting->created_at) < 60;
                            });
                        @endphp
                        <tr>
                            <td>{{ $setting->speed }}</td>
                            <td>{{ $setting->examples }}</td>
                            <td>{{ $result ? $result->score : 'N/A' }}</td>
                            <td>{{ $setting->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Деление -->
                <h1>Деление</h1>
                <button class="toggle-table-btn btn-student" data-target="#division-table">Показать таблицу</button>
                <table id="division-table" class="table game-table all_students_table" style="display: none;">
                    <thead>
                    <tr>
                        <th>Кол-во действий</th>
                        <th>Скорость</th>
                        <th>Кол-во примеров</th>
                        <th>Результат (баллы)</th>
                        <th>Дата игры</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($divisionSettings as $setting)
                        @php
                            $result = $divisionResults->first(function($result) use ($setting) {
                                return $result->created_at->diffInSeconds($setting->created_at) < 60;
                            });
                        @endphp
                        <tr>
                            <td>{{ $setting->action_count }}</td>
                            <td>{{ $setting->speed }}</td>
                            <td>{{ $setting->examples }}</td>
                            <td>{{ $result ? $result->score : 'N/A' }}</td>
                            <td>{{ $setting->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Умножение -->
                <h1>Умножение</h1>
                <button class="toggle-table-btn btn-student" data-target="#multiplication-table">Показать таблицу</button>
                <table id="multiplication-table" class="table game-table all_students_table" style="display: none;">
                    <thead>
                    <tr>
                        <th>Кол-во действий</th>
                        <th>Скорость</th>
                        <th>Кол-во примеров</th>
                        <th>Результат (баллы)</th>
                        <th>Дата игры</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($multiplicationSettings as $setting)
                        @php
                            $result = $multiplicationResults->first(function($result) use ($setting) {
                                return $result->created_at->diffInSeconds($setting->created_at) < 60;
                            });
                        @endphp
                        <tr>
                            <td>{{ $setting->action_count }}</td>
                            <td>{{ $setting->speed }}</td>
                            <td>{{ $setting->examples }}</td>
                            <td>{{ $result ? $result->score : 'N/A' }}</td>
                            <td>{{ $setting->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Столбцы -->
                <h1>Столбцы</h1>
                <button class="toggle-table-btn btn-student" data-target="#columns-table">Показать таблицу</button>
                <table id="columns-table" class="table game-table all_students_table" style="display: none;">
                    <thead>
                    <tr>
                        <th>Результат (баллы)</th>
                        <th>Дата игры</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($columnsResults as $result)
                        <tr>
                            <td>{{ $result->score }}</td>
                            <td>{{ $result->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Переключение видимости таблиц
            const buttons = document.querySelectorAll('.toggle-table-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetTable = document.querySelector(this.dataset.target);
                    if (targetTable.style.display === 'none') {
                        targetTable.style.display = 'table';
                        this.textContent = 'Скрыть таблицу';
                    } else {
                        targetTable.style.display = 'none';
                        this.textContent = 'Показать таблицу';
                    }
                });
            });
        });
    </script>
@endsection
