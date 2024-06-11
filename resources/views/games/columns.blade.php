@extends('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')


        <section class="training">
            <div class="profile_block">
                <div class="training_wrapper">
                    <div class="training_start">
                        <h1 class="page_title border_bals">
                            <div class="game">Столбцы</div>
                        </h1>
                        <div id="settings">
                            <label for="numColumns">Выберите количество столбцов: </label>
                            <select id="numColumns">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                            <button id="startButton" onclick="startGame()">Start</button>
                        </div>

                        <div class="container" id="gameContainer"></div>
                        <button id="submitButton" style="display:none;" onclick="checkAnswers()">Submit</button>
                    </div>
                </div>
            </div>
        </section>

        <script src="{{asset('js/columns_game.js')}}"></script>
@endsection
