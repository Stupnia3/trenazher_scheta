@extends('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')
    <h2 class="mg-t110">Выберите тренажёр</h2>
<div class="games">
    <div class="border_bals">
        <div class="game">
            <img src="{{asset('storage/img/Group 50.png')}}" alt="Флеш-анзан">
            <a href="{{route('flash-anzan')}}"><div class="btn_game">Флеш-анзан</div></a>
        </div>
    </div>
    <div class="border_bals">
        <div class="game">
            <img src="{{asset('storage/img/Group 50 (1).png')}}" alt="Флеш-анзан">
            <a href="/"><div class="btn_game">Флеш-анзан</div></a>
        </div>
    </div>
    <div class="border_bals">
        <div class="game">
            <img src="{{asset('storage/img/Group 50 (2).png')}}" alt="Флеш-анзан">
            <a href="/"><div class="btn_game">Флеш-анзан</div></a>
        </div>
    </div>
    <div class="border_bals">
        <div class="game">
            <img src="{{asset('storage/img/Group 50 (3).png')}}" alt="Флеш-анзан">
            <a href="/"><div class="btn_game">Флеш-анзан</div></a>
        </div>
    </div>
    <div class="border_bals">
        <div class="game">
            <img src="{{asset('storage/img/Group 50 (4).png')}}" alt="Флеш-анзан">
            <a href="/"><div class="btn_game">Флеш-анзан</div></a>
        </div>
    </div>
</div>


@endsection
