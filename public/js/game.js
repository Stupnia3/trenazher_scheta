class Train {
    constructor(options) {
        this.initializeElements(options);
        this.setupEventListeners();
    }

    initializeElements(options) {
        this.setting_container = options.setting_container;
        this.counter_container = options.counter_container;
        this.start_training = options.start_training;
        this.number_container = options.number_container;
        this.tr_number = options.tr_number;
        this.result_container = options.result_container;
        this.result_form = options.result_form;
        this.statistic_container = options.statistic_container;
        this.stat_details = options.stat_details;
        this.img_path = options.img_path;
        this.setupSettings();
    }

    setupEventListeners() {
        this.start_training.addEventListener('click', () => {
            this.startTraining();
        });

        this.result_form.addEventListener('submit', (event) => {
            event.preventDefault();
            this.handleSubmitResultForm();
        });
    }

    setupSettings() {
        this.settings = {
            bitness: { value: 1, min: 1 },
            rules: { value: 1, min: 1 },
            action_count: { value: 2, min: 2 },
            speed: { value: 1, min: 0.4 },
            examples: { value: 1, min: 1 }
        };
        this.setupSettingInputs();
    }

    setupSettingInputs() {
        for (let settingName in this.settings) {
            let setting = this.settings[settingName];
            setting.inputEl = document.querySelector(`#${settingName}`);
            this.setupSettingChangeHandlers(setting);
        }
    }

    setupSettingChangeHandlers(setting) {
        if (setting.inputEl) {
            setting.inputEl.addEventListener('input', (event) => {
                this.handleSettingInputChange(event, setting);
            });
        }
    }

    handleSettingInputChange(event, setting) {
        let value = parseInt(event.target.value);
        if (!isNaN(value) && value >= setting.min) {
            setting.value = value;
        }
    }

    generateNumbers() {
        this.numbers_array = []
        for (let i = 0; i < this.setting.examples.value; i++) {
            let newSequence = []
            let maxValue = Math.pow(10, this.setting.bitness.value)
            let minValue = Math.pow(10, this.setting.bitness.value - 1)
            if (this.setting.rules.value == 2) {
                maxValue = maxValue - minValue
            }
            let curValue = randomInteger(minValue, maxValue - 1)
            newSequence.push(curValue)
            for (let j = 1; j < this.setting.action_count.value; j++) {
                let compVal = 0
                switch (this.setting.rules.value) {
                    case 1:
                        compVal = this.getNumberWithoutRules(curValue)
                        break
                    case 2:
                        compVal = this.getNumberWithoutRules(curValue, true)
                        break
                    case 3:
                        if (curValue < maxValue) {
                            compVal = randomInteger(maxValue - curValue, maxValue - 1)
                        } else {
                            compVal = -randomInteger(curValue - maxValue + 1, maxValue - 1)
                        }
                        break
                    case 4:
                        let sign = !!Math.round(Math.random())
                        if (curValue == 1) {
                            sign = true
                        }
                        if (sign) {
                            compVal = randomInteger(1, maxValue - 1)
                        } else {
                            let mMax = (maxValue > curValue) ? curValue : maxValue
                            compVal = -randomInteger(1, mMax - 1)
                        }
                        break
                }
                newSequence.push(compVal)
                curValue += compVal
            }
            this.numbers_array.push(newSequence)
        }
    }

    startTraining() {
        historyGame = {};
        this.counter_container.style.display = 'none'
        this.result_container.querySelector('.win').style.display = 'none'
        this.result_container.querySelector('.fail').style.display = 'none'
        switch (this.mode) {
            case 'flash':
                this.imgs_container.style.display = 'flex'
                this.showNumbers(this.numbers_array[count][0]);
                break
            default:
                this.number_container.style.display = 'flex'
                this.tr_number.style.color = ''
                this.tr_number.textContent = this.numbers_array[count][0]
                break
        }

        this.curr_example = 1

        this.count = count

        this.numInterval = setInterval(() => {
            if (this.numbers_array[count].length > this.curr_example) {
                if (this.curr_example % 2) {
                    this.tr_number.style.color = "#000000"
                } else {
                    this.tr_number.style.color = ''
                }
                switch (this.mode) {
                    case 'flash':
                        this.showNumbers(this.numbers_array[count][this.curr_example]);
                        break;
                    default:
                        this.tr_number.textContent = this.numbers_array[count][this.curr_example];
                        break;
                }

                this.curr_example++
            } else {
                this.getAnswer(count)
                clearInterval(this.numInterval)
            }
        }, this.setting.speed.value * 1000)
    }

    handleSubmitResultForm() {
        // Получение данных формы
        let formData = new FormData(this.result_form);

        // Добавление данных из `historyGame` в FormData
        formData.append('hgame', JSON.stringify(historyGame));

        // Отправка данных на сервер
        fetch('/saveGameResult', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Обработка ответа сервера
                console.log(data);
                // Возможно, здесь нужно выполнить какие-то действия на основе ответа сервера
            })
            .catch(error => {
                // Обработка ошибок при отправке данных
                console.error('Ошибка:', error);
            });
    }

}

let train = new Train({
    setting_container: document.querySelector('.training_start'),
    counter_container: document.querySelector('.training_starting_counter'),
    start_training: document.querySelector('.training_button.start'),
    number_container: document.querySelector('.training_numbers'),
    tr_number: document.querySelector('.training_number'),
    result_container: document.querySelector('.training_result'),
    result_form: document.querySelector('.training_result-form'),
    statistic_container: document.querySelector('.training_statistic'),
    stat_details: document.querySelector('.training_details'),
    img_path: '/storage/img/'
});

// Функция открытия попапа
function openPopup(classname) {
    is_open = !is_open
    if (is_open) {
        document.body.classList.add(classname);
    } else {
        document.body.classList = '';
    }
}

let form = document.querySelector("#popupform");
let error = document.querySelector('.popup-form .error');
form.addEventListener('submit', function (e) {
    e.preventDefault();
    localStorage.setItem('username', form.name.value);
    localStorage.setItem('secret', form.secret.value);

    error.style.display = 'none';
    let formData = new FormData(form);
    formData.append('hgame', JSON.stringify(historyGame));

    // 1. Создаём новый XMLHttpRequest-объект
    let xhr = new XMLHttpRequest();

    // 2. Настраиваем его: GET-запрос по URL /article/.../load
    xhr.open('POST', '/report.php');

    // 3. Отсылаем запрос
    xhr.send(formData);

    // 4. Этот код сработает после того, как мы получим ответ сервера
    xhr.onload = function () {
        if (xhr.status != 200) { // анализируем HTTP-статус ответа, если статус не 200, то произошла ошибка
            alert(`Ошибка ${xhr.status}: ${xhr.statusText}`); // Например, 404: Not Found
        } else {
            let text = xhr.response
            if (text == 'OK') {
                openPopup()
                openPopup('open_success');
                historyGame = {};
                error.style.display = 'none'
                error.textContent = '';
            } else {
                error.style.display = 'block'
                error.textContent = '';
                error.textContent = text;
            }
        }
    };
})
