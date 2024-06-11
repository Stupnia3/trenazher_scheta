// Валидация формы

document.addEventListener("DOMContentLoaded", function() {
    const nameInput = document.getElementById("name");
    const surnameInput = document.getElementById("surname");
    const patronymicInput = document.getElementById("patronymic");
    const parentNameInput = document.getElementById("name_parent");
    const parentSurnameInput = document.getElementById("surname_parent");
    const phoneInput = document.getElementById("phone_parent");

    // Функция для преобразования первой буквы в верхний регистр
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Функция для валидации имени, фамилии и отчества
    function validateNameInput(input) {
        // Удаляем все символы, кроме букв, дефиса и пробела
        input.value = input.value.replace(/[^а-яА-Я-\s]/g, "");
        // Преобразуем первую букву в верхний регистр
        input.value = capitalizeFirstLetter(input.value);
    }

    // Функция для валидации телефонного номера
    function validatePhoneInput(input) {
        // Удаляем все символы, кроме цифр
        let cleanedPhoneNumber = input.value.replace(/\D/g, "");
        // Ограничиваем количество цифр в номере до 11
        if (cleanedPhoneNumber.length > 11) {
            cleanedPhoneNumber = cleanedPhoneNumber.slice(0, 11);
        }
        // Добавляем +7 в начало номера
        if (!cleanedPhoneNumber.startsWith("7")) {
            cleanedPhoneNumber = "7" + cleanedPhoneNumber;
        }
        // Форматируем номер телефона в виде +7 (999) 999-99-99
        let formattedPhoneNumber = "+7";
        for (let i = 1; i < cleanedPhoneNumber.length; i++) {
            if (i === 1) {
                formattedPhoneNumber += " (" + cleanedPhoneNumber.charAt(i);
            } else if (i === 4) {
                formattedPhoneNumber += ") " + cleanedPhoneNumber.charAt(i);
            } else if (i === 7 || i === 9) {
                formattedPhoneNumber += "-" + cleanedPhoneNumber.charAt(i);
            } else {
                formattedPhoneNumber += cleanedPhoneNumber.charAt(i);
            }
        }
        input.value = formattedPhoneNumber;
    }



    // Вешаем обработчики событий на поля ввода
    nameInput.addEventListener("input", function() {
        validateNameInput(nameInput);
    });

    surnameInput.addEventListener("input", function() {
        validateNameInput(surnameInput);
    });

    patronymicInput.addEventListener("input", function() {
        validateNameInput(patronymicInput);
    });

    parentNameInput.addEventListener("input", function() {
        validateNameInput(parentNameInput);
    });

    parentSurnameInput.addEventListener("input", function() {
        validateNameInput(parentSurnameInput);
    });

    phoneInput.addEventListener("input", function() {
        validatePhoneInput(phoneInput);
    });
});

// Отслеживаем изменение input[type="file"] и обрабатываем его
document.getElementById('file-input').addEventListener('change', function() {
    const file = this.files[0]; // Получаем выбранный файл
    const fileReader = new FileReader(); // Создаем объект FileReader

    // Проверяем, выбран ли файл
    if (file) {
        const filePreview = document.getElementById('file-img');
        const fileDiv = document.getElementById('file-preview');
        filePreview.style.display = 'inline'; // Показываем предпросмотр
        fileDiv.style.display = 'inline'; // Показываем предпросмотр
        fileReader.onload = function() {
            filePreview.src = this.result; // Устанавливаем предпросмотр изображения
        };
        fileReader.readAsDataURL(file); // Читаем файл как Data URL
        document.getElementById('file-name').textContent = file.name; // Отображаем имя файла
        document.getElementById('file-name').style.display = 'none'; // Показываем имя файла
    } else {
        document.getElementById('file-name').textContent = 'Фото не выбрано'; // Показываем надпись "Файл не выбран"
        document.getElementById('file-preview').style.display = 'none';
    }
});


// глаз на пароль


document.addEventListener('DOMContentLoaded', function() {
    const eyeHide = document.querySelectorAll('.togglePassword');
    eyeHide.forEach(function(element) {
        element.addEventListener('click', function() {
            const passwordInput = element.previousElementSibling;  // Находим поле пароля перед текущим элементом
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
            element.classList.toggle('togglePasswordHide');
        });
    });
});
