@extends('layouts.app')

@section('title')
    Выбор роли
@endsection

@section('role')
    <div class="register_container ">
        <img src="{{ asset('storage/img/logo.svg') }}" alt="Логотип">

        <div class="all-form_container border_white">
            <div class="form_container">
                <a href="{{route('register.student')}}" class="btn-student">Ученик</a>
                <a href="{{route('register.teacher')}}" class="btn-teacher">Учитель</a>
            </div>
        </div>
    </div>


@endsection
