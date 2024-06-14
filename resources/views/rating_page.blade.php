@extends('layouts.app')

@section('content')
    <section>
        <div class="profile_block">
            <h1 class="page_title border_bals">
                <div class="game">Рейтинг учеников</div>
            </h1>
            <div class="navigation_top">
                <a href="{{ url()->previous() }}">
                    <img src="{{ asset('storage/img/back.svg') }}" alt="Назад">
                </a>
            </div>
            <div class="table_container">
                @if ($students->isEmpty())
                    <p>У вас пока нет учеников.</p>
                @else
                    <table id="studentsTable" class="all_students_table">
                        <thead>
                        <tr>
                            <th>Пользователь</th>
                            <th>Флеш-анзан</th>
                            <th>Флеш-карты</th>
                            <th>Делитель</th>
                            <th>Умножайка</th>
                            <th>Столбцы</th>
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
                                        <div>{{ $student->middle_name }} {{ $student->first_name }}</div>
                                    </div>
                                </td>
                                <td>{{ $student->flash_anzan_score }}</td>
                                <td>{{ $student->flash_cards_score }}</td>
                                <td>{{ $student->division_score }}</td>
                                <td>{{ $student->multiplication_score }}</td>
                                <td>{{ $student->columns_score }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $students->links() }}
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#studentsTable th').on('click', function() {
                var table = $(this).parents('table').eq(0);
                var rows = table.find('tr:gt(0)').toArray().sort(compare($(this).index()));
                this.asc = !this.asc;
                if (!this.asc) { rows = rows.reverse(); }
                table.children('tbody').empty().html(rows);
                updateSortClasses(table, $(this));
            });

            function compare(index) {
                return function(a, b) {
                    var valA = getCellValue(a, index), valB = getCellValue(b, index);
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
                };
            }

            function getCellValue(row, index) {
                return $(row).children('td').eq(index).text();
            }

            function updateSortClasses(table, header) {
                table.find('th').removeClass('sort-asc sort-desc');
                header.addClass(header[0].asc ? 'sort-asc' : 'sort-desc');
            }
        });
    </script>
@endpush
