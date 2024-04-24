@extends('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')

{{--    <style>--}}
{{--        .hidden {--}}
{{--            display: none;--}}
{{--        }--}}
{{--        #flashAnzanContainer {--}}
{{--            text-align: center;--}}
{{--            margin-top: 50px;--}}
{{--            font-size: 36px;--}}
{{--            font-weight: bold;--}}
{{--            height: 100vh;--}}
{{--            display: flex;--}}
{{--            justify-content: center;--}}
{{--            align-items: center;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <div id="settingsForm">--}}
{{--        <h2>Настройки игры:</h2>--}}
{{--        <label>Числа от:--}}
{{--            <input type="number" id="minNumber" min="1" max="9" value="1">--}}
{{--        </label>--}}
{{--        <label>до:--}}
{{--            <input type="number" id="maxNumber" min="1" max="9" value="9">--}}
{{--        </label><br>--}}
{{--        <label>Операции:--}}
{{--            <input type="checkbox" id="addition" checked> Сложение--}}
{{--            <input type="checkbox" id="subtraction" checked> Вычитание--}}
{{--            <input type="checkbox" id="multiplication"> Умножение--}}
{{--            <input type="checkbox" id="division"> Деление--}}
{{--        </label><br>--}}
{{--        <label>Разряды чисел:--}}
{{--            <input type="number" id="digits" min="1" max="4" value="2">--}}
{{--        </label><br>--}}
{{--        <label>Количество цифр:--}}
{{--            <input type="number" id="numDigits" min="1" max="10" value="5">--}}
{{--        </label><br>--}}
{{--        <label>Время показа (сек):--}}
{{--            <input type="number" id="displayTime" step="0.5" min="0.5" max="3" value="1">--}}
{{--        </label><br>--}}
{{--        <label>Отображать минус:--}}
{{--            <input type="checkbox" id="showNegative">--}}
{{--        </label><br>--}}
{{--        <label>Отображать дробь:--}}
{{--            <input type="checkbox" id="showFraction">--}}
{{--        </label><br><br>--}}
{{--        <button onclick="startGame()">Начать игру</button>--}}
{{--    </div>--}}

{{--    <div id="flashAnzanContainer" class="hidden"></div>--}}

{{--    <div id="answerInput" class="hidden">--}}
{{--        <input type="text" id="userAnswer" placeholder="Введите ответ">--}}
{{--        <button id="checkButton">Проверить</button>--}}
{{--    </div>--}}

{{--    <div id="result" class="hidden">--}}
{{--        <div id="resultMessage"></div>--}}
{{--        <div id="equation"></div>--}}
{{--    </div>--}}

<section class="training">
    <div class="training_wrapper">
        <div class="training_start">
            <h2 class="training_header">Онлайн-тренажер ментального счета</h2>
            <div class="training_settings">
                <div class="training_setting">
                    <h3 class="training_setting-title">РАЗРЯДНОСТЬ</h3>
                    <select id="bitness" class="training_selector input" value="1">
                        <option value="1">Единицы</option>
                        <option value="2">Десятки</option>
                        <option value="3">Сотни</option>
                        <option value="4">Тысячи</option>
                    </select>
                </div>
                <div class="training_setting">
                    <h3 class="training_setting-title" value="1">Правила</h3>
                    <select id="rules" class="training_selector input">
                        <option value="1">Просто</option>
                        <option value="2">Братья</option>
                        <option value="3">Друзья</option>
                        <option value="4">Анзан</option>
                    </select>
                </div>
                <div class="training_setting">
                    <h3 class="training_setting-title">Количество действий</h3>
                    <div class="training_counter" id="action_count">
                        <button class="training_counter-button minus" disabled>
                            <img
                                src="{{asset('storage/img/minus.svg')}}"
                                width="20"
                                height="20"
                                alt=""
                            />
                        </button>
                        <input
                            type="text"
                            class="training_counter-input input"
                            id="action_count-input"
                            value="2"
                        />
                        <button class="training_counter-button plus">
                            <img
                                src="{{asset('storage/img/plus.svg')}}"
                                width="20"
                                height="20"
                                alt=""
                            />
                        </button>
                    </div>
                </div>
                <div class="training_setting">
                    <h3 class="training_setting-title">Cкорость</h3>
                    <div class="training_counter" id="speed">
                        <button class="training_counter-button minus">
                            <img
                                src="{{asset('storage/img/minus.svg')}}"
                                width="20"
                                height="20"
                                alt=""
                            />
                        </button>
                        <input
                            type="text"
                            class="training_counter-input input"
                            id="speed-input"
                            value="1"
                        />
                        <button class="training_counter-button plus">
                            <img
                                src="{{asset('storage/img/plus.svg')}}"
                                width="20"
                                height="20"
                                alt=""
                            />
                        </button>
                    </div>
                </div>
                <div class="training_setting">
                    <h3 class="training_setting-title">Количество примеров</h3>
                    <div class="training_counter" id="examples">
                        <button class="training_counter-button minus" disabled>
                            <img
                                src="{{asset('storage/img/minus.svg')}}"
                                width="20"
                                height="20"
                                alt=""
                            />
                        </button>
                        <input
                            type="text"
                            class="training_counter-input input"
                            id="examples-input"
                            value="1"
                        />
                        <button class="training_counter-button plus">
                            <img
                                src="{{asset('storage/img/plus.svg')}}"
                                width="20"
                                height="20"
                                alt=""
                            />
                        </button>
                    </div>
                </div>
                <div class="training_setting">
                    <h3 class="training_setting-title">Режим:</h3>
                    <div id="mode">
                        <div class="training_radioinput">
                            <input
                                type="radio"
                                class="training_radio"
                                name="mode"
                                class="training_counter-input input"
                                id="mode-normal"
                                checked
                                value="normal"
                            />
                            <label class="training_label" for="mode-normal"
                            >Обычный</label
                            >
                        </div>
                        <div class="training_radioinput">
                            <input
                                type="radio"
                                class="training_radio"
                                name="mode"
                                class="training_counter-input input"
                                id="mode-flash"
                                value="flash"
                            />
                            <label class="training_label" for="mode-flash"
                            >Флешкарты</label
                            >
                        </div>
                    </div>
                </div>
            </div>
            <button class="training_button start">СТАРТ</button>
        </div>
        <div class="training_starting_counter">
{{--            <img src="images/dest/step1.jpg" alt="" />--}}
{{--            <img src="images/dest/step2.jpg" alt="" />--}}
{{--            <img src="images/dest/step3.jpg" alt="" />--}}
        </div>
        <div class="training_numbers">
            <p class="training_number">1</p>
        </div>
        <div class="training_imgs"></div>
        <div class="training_result">
            <div class="training_result_container">
                <h2 class="training_result-header">Введите ответ</h2>
                <div class="training_result-wrapper">
                    <form class="training_result-form">
                        <input type="text" class="input" />
                        <button class="training_button" type="submit">Готово</button>
                    </form>
                    <div class="training_result-anim win">
                        <img src="images/dest/win1.jpg" alt="" /><img
                            src="images/dest/win2.jpg"
                            alt=""
                        />
                    </div>
                    <img
                        src="images/dest/wait.jpg"
                        class="training_result-wait wait"
                        alt=""
                    />
                    <div class="training_result-anim fail">
                        <img src="images/dest/fail1.jpg" alt="" /><img
                            src="images/dest/fail2.jpg"
                            alt=""
                        />
                    </div>
                </div>
            </div>
            <button class="training_button restart">Заново</button>
        </div>
        <div class="training_statistic">
            <div class="training_statistic_container">
                <h2 class="training_statistic-header">Ваш результат</h2>
                <div class="training_statistic-wrapper">
                    <div class="training_statistic-item">
                        <h3 class="training_statistic-item-header">Правильно</h3>
                        <p class="training_statistic-result" id="right"></p>
                    </div>
                    <div class="training_statistic-item">
                        <h3 class="training_statistic-item-header">Неправильно</h3>
                        <p class="training_statistic-result" id="error"></p>
                    </div>
                </div>
            </div>
            <button class="training_button restart">Заново</button>
            <button class="training_button details">Посмотреть</button>
            <div class="training_details">
                <div class="training_details-info">
                    <p>Ваш ответ:</p>
                    <p>Правильный:</p>
                </div>
            </div>
            <button class="send_report" onclick="openPopup('open_send')">
                Отправить учителю
            </button>
        </div>
    </div>
    <div class="fullscreen"></div>
    <audio src="audio/tick.mp3" id="tick" preload="auto"></audio>
    <audio src="audio/fail.mp3" id="failaud" preload="auto"></audio>
    <audio src="audio/win.mp3" id="winaud" preload="auto"></audio>
    <template id="template">
        <div class="training_details-item">
            <div class="training_details-item_number ynumber"></div>
            <hr />
            <div class="training_details-item_number rnumber"></div>
            <div class="digits"></div>
        </div>
    </template>
</section>
<div class="popup send">
    <div class="container">
        <img
            src="{{asset('storage/img/close.png')}}"
            class="close"
            width="25"
            height="25"
            alt=""
            onclick="openPopup()"
        />
        <form action="report.php" id="popupform" class="popup-form">
            <label for="name">Имя:</label>
            <input type="text" name="name" id="username" required />
            <label for="secret">Кодовое слово:</label>
            <input type="text" name="secret" id="secret" />
            <p class="error"></p>
            <button class="training_button">Отправить</button>
        </form>
    </div>
</div>
<div class="popup success">
    <div class="container">
        <img
            src="{{asset('storage/img/close.png')}}"
            class="close"
            width="25"
            height="25"
            alt=""
            onclick="openPopup()"
        />
        <h3 class="popup-title">Данные успешно отправлены</h3>
    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
@endsection
