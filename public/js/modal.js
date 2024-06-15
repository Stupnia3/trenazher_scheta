// scripts.js
document.addEventListener('DOMContentLoaded', (event) => {
    var modal = document.getElementById('modal');
    var btn = document.getElementById('openModalBtn');
    var span = document.getElementsByClassName('close')[0];

    // Открыть модальное окно
    btn.onclick = function() {
        modal.style.display = 'block';
        btn.textContent = 'Как играть';
    }

    // Закрыть модальное окно при нажатии на <span> (x)
    span.onclick = function() {
        modal.style.display = 'none';
        btn.textContent = 'Как играть';
    }

    // Закрыть модальное окно при клике вне его
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
            btn.textContent = 'Как играть';
        }
    }
});
