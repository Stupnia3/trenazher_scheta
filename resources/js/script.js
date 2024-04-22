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

// Валидация формы

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("registrationForm");
    const firstNameInput = document.getElementById("name");
    const middleNameInput = document.getElementById("surname");
    const parentNameInput = document.getElementById("name_parent");
    const parentSurnameInput = document.getElementById("surname_parent");
    const phoneInput = document.getElementById("phone_parent");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");

    form.addEventListener("submit", function(event) {
        let isValid = true;
        const namePattern = /^[А-ЯЁ][а-яё]*$/;
        const phonePattern = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/;

        if (!namePattern.test(firstNameInput.value)) {
            isValid = false;
            displayError(firstNameInput, "Имя должно начинаться с заглавной буквы и содержать только буквы русского алфавита.");
        }

        if (!namePattern.test(middleNameInput.value)) {
            isValid = false;
            displayError(middleNameInput, "Фамилия должна начинаться с заглавной буквы и содержать только буквы русского алфавита.");
        }

        if (parentNameInput.value && !namePattern.test(parentNameInput.value)) {
            isValid = false;
            displayError(parentNameInput, "Имя родителя должно начинаться с заглавной буквы и содержать только буквы русского алфавита.");
        }

        if (parentSurnameInput.value && !namePattern.test(parentSurnameInput.value)) {
            isValid = false;
            displayError(parentSurnameInput, "Фамилия родителя должна начинаться с заглавной буквы и содержать только буквы русского алфавита.");
        }

        if (phoneInput.value && !phonePattern.test(phoneInput.value)) {
            isValid = false;
            displayError(phoneInput, "Телефон должен соответствовать шаблону +7 (999) 999-99-99.");
        }

        if (passwordInput.value.length < 8) {
            isValid = false;
            displayError(passwordInput, "Пароль должен содержать не менее 8 символов.");
        }

        if (passwordInput.value !== confirmPasswordInput.value) {
            isValid = false;
            displayError(confirmPasswordInput, "Пароли не совпадают.");
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    function displayError(inputElement, message) {
        const errorElement = document.createElement("div");
        errorElement.className = "error-message";
        errorElement.textContent = message;

        const container = inputElement.parentElement;
        container.appendChild(errorElement);
    }
});
