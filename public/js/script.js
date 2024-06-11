// document.getElementById('toggleBtn').addEventListener('click', function() {
//     var block = document.querySelector('.left-block');
//     var textAndLogo = document.querySelectorAll('.text-link, .logo');
//     var button = document.querySelector('.btn-cont');
//
//     block.classList.toggle('shrunken');
//     textAndLogo.forEach(function(element) {
//         element.classList.toggle('hidden');
//     });
//
//     button.classList.toggle('rotated');
// });

// свернуть навигацию

document.addEventListener('DOMContentLoaded', function() {
    var block = document.querySelector('.left-block');
    var textAndLogo = document.querySelectorAll('.text-link, .logo');
    var button = document.querySelector('.btn-cont');
    var isShrunken = localStorage.getItem('isShrunken') === 'true';

    if (isShrunken) {
        block.classList.add('shrunken');
        textAndLogo.forEach(function(element) {
            element.classList.add('hidden');
        });
        button.classList.add('rotated');
    }

    document.getElementById('toggleBtn').addEventListener('click', function() {
        isShrunken = !isShrunken;
        localStorage.setItem('isShrunken', isShrunken.toString());

        block.classList.toggle('shrunken');
        textAndLogo.forEach(function(element) {
            element.classList.toggle('hidden');
        });
        button.classList.toggle('rotated');
    });
});


// Вернуться назад
function goBack() {
    window.history.back();
}






//игра флэш-анзан


// document.addEventListener('DOMContentLoaded', function () {
//     const checkButton = document.getElementById('checkButton');
//     checkButton.addEventListener('click', checkAnswer);
// });
// function loadSettings() {
//     const savedSettings = localStorage.getItem('flashAnzanSettings');
//     if (savedSettings) {
//         settings = JSON.parse(savedSettings);
//         for (const key in settings) {
//             const element = document.getElementById(key);
//             if (element.type === 'checkbox') {
//                 element.checked = settings[key];
//             } else {
//                 element.value = settings[key];
//             }
//         }
//     }
// }
//
// function saveSettings() {
//     for (const key in settings) {
//         const element = document.getElementById(key);
//         if (element.type === 'checkbox') {
//             settings[key] = element.checked;
//         } else {
//             settings[key] = parseFloat(element.value);
//         }
//     }
//     localStorage.setItem('flashAnzanSettings', JSON.stringify(settings));
// }
//
// function generateRandomNumber(min, max) {
//     return Math.floor(Math.random() * (max - min + 1)) + min;
// }
//
// function generateRandomOperator() {
//     const operators = ['+', '-', '*', '/'];
//     return operators[Math.floor(Math.random() * operators.length)];
// }
//
// function generateFlashAnzanProblem() {
//     const showNegative = settings.showNegative;
//     const showFraction = settings.showFraction;
//
//     let problem = '';
//     for (let i = 0; i < settings.numDigits; i++) {
//         if (i > 0) {
//             problem += generateRandomOperator();
//         }
//         let number = generateRandomNumber(settings.minNumber, settings.maxNumber);
//         if (showNegative && Math.random() < 0.5) {
//             problem += '-';
//             number *= -1;
//         }
//         if (showFraction && Math.random() < 0.5) {
//             let divisor = generateRandomDivisor(number);
//             if (divisor !== 0) {
//                 number /= divisor;
//                 problem += '/' + divisor;
//             }
//         }
//         problem += number;
//     }
//     return problem;
// }
//
// function generateRandomDivisor(number) {
//     const maxDivisor = Math.abs(number); // Определение максимального делителя по модулю
//     let divisor = generateRandomNumber(2, maxDivisor); // Генерация случайного делителя
//     while (number % divisor !== 0) {
//         divisor = generateRandomNumber(2, maxDivisor); // Повторная генерация делителя, если остаток от деления не равен 0
//     }
//     return divisor;
// }
//
//
// function startGame() {
//     saveSettings();
//     document.getElementById('settingsForm').classList.add('hidden');
//     document.getElementById('flashAnzanContainer').classList.remove('hidden');
//
//     const problem = generateFlashAnzanProblem();
//     flashDigits(problem, settings.displayTime);
// }
//
// let numbersAndOperators; // Объявляем переменную глобально
// let displayedNumbers; // Глобальная переменная для хранения отображенных чисел и операторов
//
// async function flashDigits(problem, displayTime) {
//     const flashContainer = document.getElementById('flashAnzanContainer');
//     flashContainer.innerHTML = ''; // Очистим контейнер перед началом показа чисел
//
//     displayedNumbers = ''; // Сбрасываем переменную перед началом показа чисел
//
//     let currentNumber = ''; // Переменная для хранения текущего числа
//
//     let i = 0;
//     while (i < problem.length) {
//         let currentCharacter = problem[i];
//         console.log(problem[i]);
//
//         if (['+', '-', '*', '/'].includes(currentCharacter)) {
//             // Если текущий символ - оператор, добавляем текущее число и оператор в контейнер
//             flashContainer.textContent += currentNumber + ' ';
//             flashContainer.textContent += currentCharacter + ' ';
//             displayedNumbers += currentNumber + ' ' + currentCharacter + ' '; // Добавляем текущее число и оператор в переменную
//             currentNumber = ''; // Сбрасываем текущее число
//         } else {
//             // Если текущий символ - число, добавляем его к текущему числу
//             currentNumber += currentCharacter;
//         }
//
//         i++;
//
//         // Если достигнут конец строки, добавляем последнее число к контейнеру
//         if (i === problem.length) {
//             flashContainer.textContent += currentNumber;
//             displayedNumbers += currentNumber; // Добавляем последнее число к переменной
//         }
//
//         await sleep(displayTime * 1000);
//         flashContainer.textContent = ''; // Очищаем контейнер перед отображением следующего числа или оператора
//         await sleep(displayTime * 1000);
//     }
//
//     // После завершения показа чисел и операторов мы можем показать блок с вводом ответа
//     document.getElementById('answerInput').classList.remove('hidden');
//
//     // Также сохраняем числа и операторы в глобальной переменной
//     numbersAndOperators = displayedNumbers.split(/\s+/);
// }
//
//
// async function checkAnswer() {
//     const userAnswer = parseInt(document.getElementById('userAnswer').value.trim(), 10);
//
//     const resultBlock = document.getElementById('result');
//     const answerInputBlock = document.getElementById('answerInput');
//
//     let sum = 0;
//     let operator = '+';
//     for (const item of numbersAndOperators) {
//         if (['+', '-', '*', '/'].includes(item)) {
//             operator = item; // Обновляем оператор, если встречаем новый
//         } else {
//             const number = parseInt(item, 10); // Преобразуем элемент в число
//             switch (operator) {
//                 case '+':
//                     sum += number;
//                     break;
//                 case '-':
//                     sum -= number;
//                     break;
//                 case '*':
//                     sum *= number;
//                     break;
//                 case '/':
//                     sum /= number;
//                     break;
//             }
//         }
//     }
//
//     if (userAnswer === sum) {
//         resultBlock.textContent = 'Правильный ответ: ' + sum + ' = ' + userAnswer;
//         console.log('Правильный ответ:', sum + ' = ' + userAnswer);
//     } else {
//         resultBlock.textContent = 'Неправильный ответ: ' + sum + ' != ' + userAnswer;
//         console.log('Неправильный ответ:', sum + ' != ' + userAnswer);
//     }
//
//     resultBlock.classList.remove('hidden');
//     answerInputBlock.classList.add('hidden');
// }
//
//
//
//
//
// function sleep(ms) {
//     return new Promise(resolve => setTimeout(resolve, ms));
// }
//
// loadSettings();





