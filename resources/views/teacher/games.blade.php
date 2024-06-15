@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Игры студента: {{ $student->middle_name }} {{ $student->first_name }}</h1>

        <!-- Флеш-анзан -->
        <h2>Флеш-анзан</h2>
        <button class="toggle-table-btn" data-target="#flash-anzan-table">Показать таблицу</button>
        <table id="flash-anzan-table" class="table game-table" style="display: none;">
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
        <h2>Флеш-карты</h2>
        <button class="toggle-table-btn" data-target="#flash-cards-table">Показать таблицу</button>
        <table id="flash-cards-table" class="table game-table" style="display: none;">
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
        <h2>Деление</h2>
        <button class="toggle-table-btn" data-target="#division-table">Показать таблицу</button>
        <table id="division-table" class="table game-table" style="display: none;">
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
        <h2>Умножение</h2>
        <button class="toggle-table-btn" data-target="#multiplication-table">Показать таблицу</button>
        <table id="multiplication-table" class="table game-table" style="display: none;">
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
        <h2>Столбцы</h2>
        <button class="toggle-table-btn" data-target="#columns-table">Показать таблицу</button>
        <table id="columns-table" class="table game-table" style="display: none;">
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
