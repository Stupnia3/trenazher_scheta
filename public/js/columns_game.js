function startGame() {
    // Скрыть блок настроек
    document.getElementById('settings').style.display = 'none';

    // Получить количество столбцов
    let numColumns = parseInt(document.getElementById('numColumns').value, 10);

    // Сгенерировать столбцы
    generateColumns(numColumns);

    // Показать кнопку Submit
    document.getElementById('submitButton').style.display = 'block';
}

function generateColumns(numColumns) {
    let container = document.getElementById('gameContainer');
    container.innerHTML = ''; // Очистка контейнера перед генерацией
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
        answerInput.className = 'answer';
        column.appendChild(answerInput);

        container.appendChild(column);
    }
}

function getRandomNumber() {
    return Math.floor(Math.random() * 21) - 10;
}

function checkAnswers() {
    let columns = document.querySelectorAll('.column');
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
            answerInput.setAttribute('readonly', 'true'); // Блокировка результата
        } else {
            answerInput.classList.add('incorrect');
            answerInput.classList.remove('correct');
            answerInput.setAttribute('readonly', 'true');
            displayIncorrectAnswer(column, sum, expression); // Вывод сообщения только для неправильных ответов
        }
    });

    document.getElementById('submitButton').style.display = 'none';
}

function displayIncorrectAnswer(column, correctSum, expression) {
    let existingAnswerDisplay = column.querySelector('.solution');
    if (!existingAnswerDisplay) {
        let correctAnswerDisplay = document.createElement('div');
        correctAnswerDisplay.textContent = `Правильный результат: ${expression}`;
        correctAnswerDisplay.className = 'solution';
        column.appendChild(correctAnswerDisplay);
    }
}
