@extends('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')
    <section class="training">
        <div class="profile_block">
            <button id="openModalBtn" class="btn-teacher">Как играть</button>
            <!-- Руководство пользователя -->
            <div id="modal" class="user_guide modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h4>Как играть:</h4>
                    <p>Перед началом игры нужно выбрать подходящие настройки</p>
                    <p>В настройках игры доступны три параметра:</p>
                    <ul style="list-style: inside; display: flex; flex-direction: column; gap: 20px;">
                        <li><strong>Количество действий:</strong> <strong style="color: #1c7430; text-decoration: underline;">количество чисел</strong>, которые будут появляться на
                            экране и которые необходимо будет сложить.
                        </li>
                        <img class="info_img" src="{{asset('storage/img/browser_w4qSaZrVSK.png')}}" alt="Количество действий">
                        <li><strong>Скорость:</strong> <strong style="color: #1c7430; text-decoration: underline;">время</strong>, в течение которого каждое число будет отображаться
                            на экране (от 1 до 4 секунд).
                        </li>
                        <img class="info_img" src="{{asset('storage/img/browser_aO17hH8CtU.png')}}" alt="Скорость">
                        <li><strong>Количество примеров:</strong> <strong style="color: #1c7430; text-decoration: underline;">количество игр</strong> которые будут продолжаться без перезапуска
                            игры.
                        </li>
                        <img class="info_img" src="{{asset('storage/img/browser_cfrlK06jCn.png')}}" alt="Количество примеров">
                    </ul>
                    <p>От кол-ва действий и скорости показа числа формируются баллы за правильный пример и баллы за штрафной пример:</p>
                    <img class="info_img" src="{{asset('storage/img/browser_TEwtXO9DIQ.png')}}" alt="баллы за правильный пример и баллы за штрафной пример">
                    <p>От кол-ва действий формируются итоговые баллы за все правильно решенные примеры:</p>
                    <img class="info_img" src="{{asset('storage/img/browser_fX2kQHOCfK.png')}}" alt="Количество действий">
                    <p>После выбора нужных настроек необходимо нажать <strong style="color: #1c7430; text-decoration: underline;">зеленую</strong> кнопку начать</p>
                    <p>Далее начнется игра и на экране будут отображаться поочередно числа (предел от -10 до 10). Цель <strong style="color: #1c7430; text-decoration: underline;">сложить</strong> все числа которые появлялись на экране.</p>
                    <p>Когда все числа отобразятся появиться поле ввода, в него необходимо написать результат, который игрок получил в ходе сложения всех показанных чисел.</p>
                    <img class="info_img" src="{{asset('storage/img/7ba84d11-6ab9-4c17-879e-a59c7fc95e7e.png')}}" alt="Количество действий">
                    <p>Когда игрок напишет число которое он посчитал, необходимо нажать кнопку "Готово".</p>
                    <p>В конце игры отобразятся кол-во правильных ответов и неправильных. Для того чтобы узнать более точную информацию о результатах нужно нажать кнопку "Подробнее".</p>
                    <img class="info_img" src="{{asset('storage/img/browser_G6OT71fQQ8.png')}}" alt="Количество действий">
                    <p>При наведении на ответ сверху появиться окно, где отображены числа за игру, исходя из которых вышел правильный ответ.</p>
                    <img class="info_img" src="{{asset('storage/img/browser_RQci7vMcrF.png')}}" alt="Количество действий">
                    <p>Игру можно начать заново с выбором других настроек, для этого нужно нажать на кнопку "Заново".</p>
                </div>
            </div>
            <div class="training_wrapper">
                <div class="training_start">
                    <h1 class="page_title border_bals">
                        <div class="game">Флеш-анзан</div>
                    </h1>
                    <div class="training_settings">
                        <div class="training_setting" style="display: none">
                            <h3 class="training_setting-title">РАЗРЯДНОСТЬ</h3>
                            <select id="bitness" class="training_selector input input_setting" value="1">
                                <option value="1">Единицы</option>
                                <option value="2">Десятки</option>
                                <option value="3">Сотни</option>
                                <option value="4">Тысячи</option>
                            </select>
                        </div>
                        <div class="training_setting" style="display: none">
                            <h3 class="training_setting-title" value="1">Правила</h3>
                            <select id="rules" class="training_selector input input_setting">
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
                                    -
                                </button>
                                <input
                                    type="text"
                                    class="training_counter-input input input_setting"
                                    id="action_count-input"
                                    value="2"
                                />
                                <button class="training_counter-button plus">
                                    +
                                </button>
                            </div>
                        </div>
                        <div class="training_setting">
                            <h3 class="training_setting-title">Cкорость</h3>
                            <div class="training_counter" id="speed">
                                <button class="training_counter-button minus" disabled>
                                    -
                                </button>
                                <input
                                    type="text"
                                    class="training_counter-input input input_setting"
                                    id="speed-input"
                                    value="1"
                                />
                                <button class="training_counter-button plus">
                                    +
                                </button>
                            </div>
                        </div>
                        <div class="training_setting">
                            <h3 class="training_setting-title">Количество примеров</h3>
                            <div class="training_counter" id="examples">
                                <button class="training_counter-button minus" disabled>
                                    -
                                </button>
                                <input
                                    type="text"
                                    class="training_counter-input input"
                                    id="examples-input"
                                    value="1"
                                />
                                <button class="training_counter-button plus">
                                    +
                                </button>
                            </div>
                        </div>
                        <div class="training_points">
                            <h3 class="training_setting-title">Итоговые баллы</h3>
                            <p id="total-points">0</p>
                        </div>
                        <div class="training_points">
                            <h3 class="training_setting-title">Баллы за один пример</h3>
                            <p id="points-per-example">0</p>
                        </div>
                        <div class="training_points">
                            <h3 class="training_setting-title">Штраф за неправильный пример</h3>
                            <p id="penalty-points">0</p>
                        </div>
                        <div class="training_setting" style="display: none">
                            <h3 class="training_setting-title">Режим:</h3>
                            <div id="mode">
                                <div class="training_radioinput">
                                    <input
                                        type="radio"
                                        class="training_radio"
                                        name="mode"
                                        class="training_counter-input input input_setting"
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
                                        class="training_counter-input input input_setting"
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
                    <button class="training_button start btn-student">Начать</button>
                </div>
                <div class="training_starting_counter" style="display: none">
                    <img src="" alt=""/>
                    <img src="" alt=""/>
                    <img src="" alt=""/>
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
                                <input type="text" class="input"/>
                                <button class="training_button btn-student" type="submit">Готово</button>
                            </form>
                            <div class="training_result-anim win">
                                <img src="" alt=""/><img
                                    src=""
                                    alt=""
                                />
                            </div>
                            <img
                                src=""
                                class="training_result-wait wait"
                                alt=""
                            />
                            <div class="training_result-anim fail">
                                <img src="" alt=""/><img
                                    src=""
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
                                <p class="training_statistic-result" id="right">0</p>
                            </div>
                            <div class="training_statistic-item">
                                <h3 class="training_statistic-item-header">Неправильно</h3>
                                <p class="training_statistic-result" id="error">0</p>
                            </div>
                        </div>
                    </div>
                    <button class="training_button details btn-student" id="show-points">Посмотреть баллы</button>
                    <div class="training_details">

                        <div class="training_points">
                            <h3 class="training_setting-title">Итоговые баллы</h3>
                            <p id="total-points-end">0</p>
                        </div>
                        <div class="training_points">
                            <h3 class="training_setting-title">Баллы за один пример</h3>
                            <p id="points-per-example-end">0</p>
                        </div>
                        <div class="training_points">
                            <h3 class="training_setting-title">Штраф за неправильный пример</h3>
                            <p id="penalty-points-end">0</p>
                        </div>
                        <div class="training_details-info">
                            <p>Ваш ответ:</p>
                            <p>Правильный:</p>
                        </div>
                    </div>
                    <button class="send_report" style="display: none" onclick="openPopup('open_send')">
                        Отправить учителю
                    </button>

                    <button class="training_button restart" id="restart_game">Заново</button>
                </div>
            </div>
        </div>
        <div class="fullscreen"></div>
        <audio src="" id="tick" preload="auto"></audio>
        <audio src="" id="failaud" preload="auto"></audio>
        <audio src="" id="winaud" preload="auto"></audio>
        <template id="template">
            <div class="training_details-item">
                <div class="training_details-item_number ynumber"></div>
                <hr/>
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
                <input type="text" name="name" id="username" required/>
                <label for="secret">Кодовое слово:</label>
                <input type="text" name="secret" id="secret"/>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let dataSaved = false;

            const actionCountInput = document.getElementById('action_count-input');
            const speedInput = document.getElementById('speed-input');
            const examplesInput = document.getElementById('examples-input');
            const totalPointsDisplay = document.getElementById('total-points');
            const pointsPerExampleDisplay = document.getElementById('points-per-example');
            const penaltyPointsDisplay = document.getElementById('penalty-points');
            const correctAnswersDisplay = document.getElementById('right');
            const incorrectAnswersDisplay = document.getElementById('error');

            const totalPointsEndDisplay = document.getElementById('total-points-end');
            const pointsPerExampleEndDisplay = document.getElementById('points-per-example-end');
            const penaltyPointsEndDisplay = document.getElementById('penalty-points-end');

            const actionCountPlusBtn = document.querySelector('#action_count .plus');
            const actionCountMinusBtn = document.querySelector('#action_count .minus');
            const speedPlusBtn = document.querySelector('#speed .plus');
            const speedMinusBtn = document.querySelector('#speed .minus');
            const examplesPlusBtn = document.querySelector('#examples .plus');
            const examplesMinusBtn = document.querySelector('#examples .minus');

            const sessionId = generateUUID();

            function generateUUID() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                    const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            }

            function updatePoints() {
                const actionCount = parseInt(actionCountInput.value, 10) || 0;
                const speed = parseFloat(speedInput.value) || 1;
                const examples = parseInt(examplesInput.value, 10) || 1;
                const correctAnswersCount = parseInt(correctAnswersDisplay.textContent) || 0;
                const incorrectAnswersCount = parseInt(incorrectAnswersDisplay.textContent) || 0;

                let totalPoints = 1;
                let pointsPerExample = 1;
                let penaltyPoints = 0;

                if (actionCount > 2) {
                    totalPoints += (actionCount - 2) * 0.5;
                }

                if (speed > 1) {
                    totalPoints /= speed;
                }

                pointsPerExample *= totalPoints;
                penaltyPoints = pointsPerExample / 2;
                totalPoints *= examples;

                const finalTotalPoints = correctAnswersCount * pointsPerExample - incorrectAnswersCount * penaltyPoints;
                const finalPointsPerExample = correctAnswersCount * pointsPerExample;
                const finalPenaltyPoints = incorrectAnswersCount * penaltyPoints * (-1);

                totalPointsEndDisplay.textContent = finalTotalPoints.toFixed(2);
                pointsPerExampleEndDisplay.textContent = finalPointsPerExample.toFixed(2);
                penaltyPointsEndDisplay.textContent = finalPenaltyPoints.toFixed(2);

                totalPointsDisplay.textContent = totalPoints.toFixed(2);
                pointsPerExampleDisplay.textContent = pointsPerExample.toFixed(2);
                penaltyPointsDisplay.textContent = penaltyPoints.toFixed(2);

                if (!dataSaved && (correctAnswersCount !== 0 || incorrectAnswersCount !== 0)) {
                    const gameName = 'flash-anzan';
                    dataSaved = true;
                    saveGameSettings();
                    saveGameResults(gameName); // Устанавливаем флаг после сохранения данных
                }
            }

            actionCountInput.addEventListener('input', updatePoints);
            speedInput.addEventListener('input', updatePoints);
            examplesInput.addEventListener('input', updatePoints);

            actionCountPlusBtn.addEventListener('click', function () {
                actionCountInput.value = parseInt(actionCountInput.value, 10);
                actionCountInput.dispatchEvent(new Event('input'));
            });

            actionCountMinusBtn.addEventListener('click', function () {
                actionCountInput.value = Math.max(0, parseInt(actionCountInput.value, 10));
                actionCountInput.dispatchEvent(new Event('input'));
            });

            speedPlusBtn.addEventListener('click', function () {
                speedInput.value = parseFloat(speedInput.value);
                speedInput.dispatchEvent(new Event('input'));
            });

            speedMinusBtn.addEventListener('click', function () {
                speedInput.value = Math.max(1, parseFloat(speedInput.value));
                speedInput.dispatchEvent(new Event('input'));
            });

            examplesPlusBtn.addEventListener('click', function () {
                examplesInput.value = parseInt(examplesInput.value, 10);
                examplesInput.dispatchEvent(new Event('input'));
            });

            examplesMinusBtn.addEventListener('click', function () {
                examplesInput.value = Math.max(1, parseInt(examplesInput.value, 10));
                examplesInput.dispatchEvent(new Event('input'));
            });

            function resetResults() {
                const totalPoints = totalPointsDisplay.textContent;
                const pointsPerExample = pointsPerExampleDisplay.textContent;
                const penaltyPoints = penaltyPointsDisplay.textContent;

                correctAnswersDisplay.textContent = '0';
                incorrectAnswersDisplay.textContent = '0';

                totalPointsEndDisplay.textContent = totalPoints;
                pointsPerExampleEndDisplay.textContent = pointsPerExample;
                penaltyPointsEndDisplay.textContent = penaltyPoints;

                totalPointsDisplay.textContent = totalPoints;
                pointsPerExampleDisplay.textContent = pointsPerExample;
                penaltyPointsDisplay.textContent = penaltyPoints;

                dataSaved = false; // Сбрасываем флаг для новой игры
            }

            document.getElementById('restart_game').addEventListener('click', function () {
                resetResults();
            });

            const observer = new MutationObserver(function (mutationsList, observer) {
                mutationsList.forEach(function (mutation) {
                    if (mutation.target.id === 'right' || mutation.target.id === 'error') {
                        const correctAnswersCount = parseInt(correctAnswersDisplay.textContent) || 0;
                        const incorrectAnswersCount = parseInt(incorrectAnswersDisplay.textContent) || 0;

                        if (correctAnswersCount !== 0 || incorrectAnswersCount !== 0) {
                            dataSaved = false; // Сброс флага при изменении значений на ненулевые
                            updatePoints();
                        }
                    }
                });
            });

            const targetNodes = document.querySelectorAll('#right, #error');
            targetNodes.forEach(function (node) {
                observer.observe(node, { childList: true, subtree: true });
            });

            function saveGameSettings() {
                const actionCount = document.getElementById('action_count-input').value;
                const speed = document.getElementById('speed-input').value;
                const examples = document.getElementById('examples-input').value;
                const gameName = 'flash-anzan';

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/save-game-settings', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            console.log('Game settings saved successfully!');
                        } else {
                            console.error('Failed to save game settings!');
                        }
                    }
                };
                xhr.send(JSON.stringify({ actionCount, speed, examples, gameName, session_id: sessionId }));
            }

            function saveGameResults(gameName) {
                const totalPoints = document.getElementById('total-points-end').textContent;

                fetch('/save-game-results', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        score: totalPoints,
                        game_name: gameName,
                        session_id: sessionId
                    })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to save game results!');
                        }
                    })
                    .catch(error => {
                        console.error(error.message);
                    });
            }

            updatePoints();
        });
    </script>
@endsection
