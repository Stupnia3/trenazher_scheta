// Валидация формы
document.addEventListener("DOMContentLoaded", function() {
    try {
        const nameInput = document.getElementById("name");
        const surnameInput = document.getElementById("surname");
        const patronymicInput = document.getElementById("patronymic");
        const parentNameInput = document.getElementById("name_parent");
        const parentSurnameInput = document.getElementById("surname_parent");
        const phoneInput = document.getElementById("phone_parent");

        if (nameInput && surnameInput && patronymicInput && parentNameInput && parentSurnameInput && phoneInput) {
            // Функция для преобразования первой буквы в верхний регистр
            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            // Функция для валидации имени, фамилии и отчества
            function validateNameInput(input) {
                if (input && input.value !== undefined) {
                    // Удаляем все символы, кроме букв, дефиса и пробела
                    input.value = input.value.replace(/[^а-яА-Я-\s]/g, "");
                    // Преобразуем первую букву в верхний регистр
                    input.value = capitalizeFirstLetter(input.value);
                }
            }

            // Функция для валидации телефонного номера
            function validatePhoneInput(input) {
                if (input && input.value !== undefined) {
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
            }

            // Вешаем обработчики событий на поля ввода
            nameInput.addEventListener("input", function() {
                try {
                    validateNameInput(nameInput);
                } catch (error) {
                    console.error('Ошибка валидации имени:', error);
                }
            });

            surnameInput.addEventListener("input", function() {
                try {
                    validateNameInput(surnameInput);
                } catch (error) {
                    console.error('Ошибка валидации фамилии:', error);
                }
            });

            patronymicInput.addEventListener("input", function() {
                try {
                    validateNameInput(patronymicInput);
                } catch (error) {
                    console.error('Ошибка валидации отчества:', error);
                }
            });

            parentNameInput.addEventListener("input", function() {
                try {
                    validateNameInput(parentNameInput);
                } catch (error) {
                    console.error('Ошибка валидации имени родителя:', error);
                }
            });

            parentSurnameInput.addEventListener("input", function() {
                try {
                    validateNameInput(parentSurnameInput);
                } catch (error) {
                    console.error('Ошибка валидации фамилии родителя:', error);
                }
            });

            phoneInput.addEventListener("input", function() {
                try {
                    validatePhoneInput(phoneInput);
                } catch (error) {
                    console.error('Ошибка валидации номера телефона:', error);
                }
            });
        } else {
            console.warn("Некоторые элементы формы не найдены.");
        }
    } catch (error) {
        console.error('Ошибка инициализации формы:', error);
    }
});

// Отслеживаем изменение input[type="file"] и обрабатываем его
document.addEventListener("DOMContentLoaded", function() {
    try {
        const fileInput = document.getElementById('file-input');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                try {
                    const file = this.files[0]; // Получаем выбранный файл
                    const fileReader = new FileReader(); // Создаем объект FileReader

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
                } catch (error) {
                    console.error('Ошибка обработки файла:', error);
                }
            });
        } else {
            console.warn("Элемент file-input не найден.");
        }
    } catch (error) {
        console.error('Ошибка инициализации загрузчика файла:', error);
    }
});

// глаз на пароль
document.addEventListener('DOMContentLoaded', function() {
    try {
        const eyeHide = document.querySelectorAll('.togglePassword');
        eyeHide.forEach(function(element) {
            element.addEventListener('click', function() {
                try {
                    const passwordInput = element.previousElementSibling;  // Находим поле пароля перед текущим элементом
                    if (passwordInput) {
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                        } else {
                            passwordInput.type = 'password';
                        }
                        element.classList.toggle('togglePasswordHide');
                    } else {
                        console.warn("Поле ввода пароля не найдено.");
                    }
                } catch (error) {
                    console.error('Ошибка переключения видимости пароля:', error);
                }
            });
        });
    } catch (error) {
        console.error('Ошибка инициализации видимости пароля:', error);
    }
});
