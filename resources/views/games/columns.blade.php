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
                    <p>В этой игре на экране будут появляться числа, и ваша задача — посчитать их сумму.</p>
                    <p>В настройках игры доступны три параметра:</p>
                    <ul>
                        <li><strong>Количество действий:</strong> количество чисел, которые будут появляться на
                            экране и которые необходимо будет сложить.
                        </li>
                        <li><strong>Скорость:</strong> время, в течение которого каждое число будет отображаться
                            на экране.
                        </li>
                        <li><strong>Количество примеров:</strong> количество игровых сессий без перезапуска
                            игры.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="training_wrapper">
                <div class="training_start training_start_columns">
                    <h1 class="page_title border_bals">
                        <div class="game">Столбцы</div>
                    </h1>
                    <div id="settings">
                        <label for="numColumns">Выберите количество столбцов: </label>
                        <select id="numColumns"
                                class="training_counter-input input input_setting input_setting_columns">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <button class="training_button start btn-student" id="startButton" onclick="startGame()">
                            Начать
                        </button>
                    </div>

                    <div class="" id="gameContainer"></div>
                    <button class="training_button details btn-student" id="submitButton"
                            style="display:none; width: 100%; margin-top: 40px" onclick="checkAnswers()">Ответить
                    </button>
                </div>

                <div id="gameResults" style="display:none;">
                    <div class="training_details_columns">
                        <div class="training_points">
                            <h3 class="training_setting-title">Итоговые баллы</h3>
                            <p id="correctAnswersCount">0</p>
                        </div>
                        <div class="training_points">
                            <h3 class="training_setting-title">Штраф за неправильный пример</h3>
                            <p id="incorrectAnswersCount">0</p>
                        </div>
                    </div>
                    <button id="resetButton" style="display:none;" onclick="resetGame()" class="training_button restart">Заново</button>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/columns_game.js') }}"></script>
    <script>
        let initialNumColumns = parseInt(document.getElementById('numColumns').value, 10); // Хранение начального количества столбцов

        function startGame() {
            document.getElementById('settings').style.display = 'none';
            let numColumns = parseInt(document.getElementById('numColumns').value, 10);
            generateColumns(numColumns);
            document.getElementById('submitButton').style.display = 'block';
        }

        function generateColumns(numColumns) {
            let container = document.getElementById('gameContainer');
            container.innerHTML = '';
            for (let i = 1; i <= numColumns; i++) {
                let column = document.createElement('div');
                column.className = 'column';
                column.id = `col${i}`;

                for (let j = 0; j < 4; j++) {
                    let number = document.createElement('div');
                    number.className = 'number';
                    number.textContent = getRandomNumber();
                    column.appendChild(number);
                }

                let answerInput = document.createElement('input');
                answerInput.type = 'number';
                answerInput.className = 'answer column_answer';
                column.appendChild(answerInput);

                container.appendChild(column);
            }
        }

        function getRandomNumber() {
            return Math.floor(Math.random() * 21) - 10;
        }

        function checkAnswers() {
            let columns = document.querySelectorAll('.column');
            let correctAnswers = 0;
            let incorrectAnswersCount = 0;

            columns.forEach(column => {
                let numbers = column.querySelectorAll('.number');
                let sum = 0;
                let expression = '';

                numbers.forEach((number, index) => {
                    let num = parseInt(number.textContent, 10);
                    sum += num;
                    expression += (num >= 0 && index > 0 ? '+' : '') + num;
                });

                expression += `=${sum}`;

                let answerInput = column.querySelector('.answer');
                let userAnswer = parseInt(answerInput.value, 10);

                if (userAnswer === sum) {
                    answerInput.classList.add('correct');
                    answerInput.classList.remove('incorrect');
                    correctAnswers++;
                    displayCorrectAnswer(column, expression); // Выводим сообщение о правильном ответе
                } else {
                    answerInput.classList.add('incorrect');
                    answerInput.classList.remove('correct');
                    incorrectAnswersCount++; // Увеличиваем количество неправильных ответов
                    displayIncorrectAnswer(column, sum, expression); // Выводим сообщение только для неправильных ответов
                }

                answerInput.setAttribute('readonly', 'true');
            });

            document.getElementById('submitButton').style.display = 'none';
            displayGameResults(correctAnswers, incorrectAnswersCount);
        }

        function displayCorrectAnswer(column, expression) {
            // let correctAnswerDisplay = document.createElement('div');
            // correctAnswerDisplay.className = 'solution';
            // column.appendChild(correctAnswerDisplay);
        }

        function displayIncorrectAnswer(column, correctSum, expression) {
            let existingAnswerDisplay = column.querySelector('.solution');
            if (!existingAnswerDisplay) {
                let correctAnswerDisplay = document.createElement('div');
                correctAnswerDisplay.textContent = `${expression}`;
                correctAnswerDisplay.className = 'solution';
                column.appendChild(correctAnswerDisplay);
            }
        }

        function displayGameResults(correctAnswers, incorrectAnswersCount) {
            document.getElementById('gameResults').style.display = 'block';
            document.getElementById('correctAnswersCount').textContent = correctAnswers;
            document.getElementById('incorrectAnswersCount').textContent = incorrectAnswersCount;

            document.getElementById('resetButton').style.display = 'block';

            const sessionId = generateUUID();

            function generateUUID() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                    const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            }

            saveGameResults('columns', correctAnswers - incorrectAnswersCount, sessionId);
        }

        function saveGameResults(gameName, score, sessionId) {
            fetch('{{ route('save-game-results') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    game_name: gameName,
                    score: score,
                    session_id: sessionId
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function resetGame() {
            let numColumnsSelect = document.getElementById('numColumns');
            let currentNumColumns = parseInt(numColumnsSelect.value, 10); // Сохраняем текущее количество столбцов

            document.getElementById('gameResults').style.display = 'none';
            document.getElementById('resetButton').style.display = 'none';

            document.getElementById('correctAnswersCount').textContent = '0';
            document.getElementById('incorrectAnswersCount').textContent = '0';

            document.getElementById('gameContainer').innerHTML = '';

            // Восстанавливаем начальное количество столбцов
            numColumnsSelect.selectedIndex = currentNumColumns - 1;

            // Возвращаемся к настройкам перед началом игры
            document.getElementById('settings').style.display = 'block';
            document.getElementById('submitButton').style.display = 'none';
        }
    </script>
@endsection
