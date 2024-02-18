document.getElementById('toggleBtn').addEventListener('click', function() {
    let block = document.querySelector('.left-block');
    let textAndLogo = document.querySelectorAll('.text-link p, .logo');
    let button = document.getElementById('toggleBtn');

    block.classList.toggle('shrunken'); /* добавляем класс для уменьшения ширины блока */
    textAndLogo.forEach(function(element) {
        element.classList.toggle('hidden'); /* добавляем класс для скрытия текста и логотипа */
    });

    button.classList.toggle('rotated'); /* добавляем класс для поворота кнопки */
});

