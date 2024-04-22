@extends('layouts.app')

@section('content')
    <h1>Мои ученики</h1>

    @if ($students->isEmpty())
        <p>У вас пока нет учеников.</p>
    @else
        <ul>
            @foreach ($students as $student)
                <li>{{ $student->first_name }} {{ $student->last_name }} {{ $student->last_name }}</li>
            @endforeach
        </ul>
    @endif
@endsection
