function randomInteger(min, max) {
    // случайное число от min до (max+1)
    let rand = min + Math.random() * (max + 1 - min);
    return Math.floor(rand);
}
var historyGame = [];
localStorage.setItem('historyGame', '');
let username = localStorage.getItem('username');
let secret = localStorage.getItem('secret');
if (username) {
    document.querySelector("#username").value = username
}
if (secret) {
    document.querySelector("#secret").value = secret
}
class Train {
    constructor(setting) {
        this.setting_container = setting.setting_container
        this.counter_container = setting.counter_container
        this.counter = 1
        this.start_training = setting.start_training
        this.number_container = setting.number_container
        this.tr_number = setting.tr_number
        this.result_container = setting.result_container
        this.statistic_container = setting.statistic_container
        this.result_form = setting.result_form
        this.imgs_container = document.querySelector('.training_imgs');
        this.result_input = this.result_form.querySelector('input')
        this.answer = null
        this.stat_open = false
        this.img_path = setting.img_path
        this.stat_details = setting.stat_details
        this.details_button = this.statistic_container.querySelector('.training_button.details')
        let restarts = document.querySelectorAll('.restart')
        this.mode = 'normal'
        this.setting_container.addEventListener('click', (e) => {
            e.preventDefault();
        })
        this.details_button.addEventListener('click', () => {
            this.stat_open = !this.stat_open
            this.details_button.textContent = this.stat_open ? 'Скрыть' : 'Посмотреть'
            this.stat_details.style.display = this.stat_open ? 'flex' : 'none'

        })
        this.mode_cont = this.setting_container.querySelector('#mode');
        this.mode_cont.addEventListener('change', (ev) => {
            this.mode = ev.target.value;

            switch (this.mode) {
                case 'flash':
                    this.setting.rules.inputEl.closest('.training_setting').classList.add('disabled');
                    this.setting.action_count.inputEl.closest('.training_setting').classList.add('disabled');
                    this.setting.rules.value = 5;
                    this.setting.action_count.value = 1;
                    break;
                default:
                    this.setting.rules.inputEl.closest('.training_setting').classList.remove('disabled');
                    this.setting.action_count.inputEl.closest('.training_setting').classList.remove('disabled');
                    this.setting.rules.value = parseInt(this.setting.rules.inputEl.value);
                    this.setting.action_count.value = parseInt(this.setting.action_count.inputEl.value);
            }
        })
        this.mode_cont.addEventListener('click', (ev) => {
            ev.stopPropagation()

        })
        restarts.forEach(el => {
            el.addEventListener('click', () => {
                this.restart()
            })
        })
        this.result_input.addEventListener('input', (ev) => {
            if (ev.data == null) {
                return
            }
            console.log(parseInt(ev.data))
            if (isNaN(parseInt(ev.data))) {
                this.result_input.value = this.result_input.value.slice(0, this.result_input.value.length - 1)
            } else {
                this.answer = this.result_input.value
            }
        })
        this.result_form.addEventListener('submit', (ev) => {
            ev.preventDefault()
            if (this.answer) {
                this.checkAnswer()
            }

        })
        this.start_training.addEventListener('click', () => {
            this.startingTraining()
        })
        this.setting = {
            bitness: {
                value: 1,
                min: 1,
                max: null,
                input: "selector",
                type: "int",
                inputEl: document.querySelector('#bitness')
            },
            rules: {
                value: 1,
                min: 1,
                max: null,
                input: "selector",
                type: "int",
                inputEl: document.querySelector('#rules')
            },
            action_count: {
                value: 2,
                min: 2,
                max: null,
                input: "input",
                type: "int",
                step: 1,
                inputEl: document.querySelector('#action_count-input')
            },
            speed: {
                value: 1,
                min: 0.4,
                max: 4,
                step: 0.1,
                input: "input",
                type: "float",
                inputEl: document.querySelector('#speed-input')
            },
            examples: {
                value: 1,
                min: 1,
                max: null,
                input: "input",
                step: 1,
                type: "int",
                inputEl: document.querySelector('#examples-input')
            }
        }
        for (let el in this.setting) {
            let event = 'change'
            switch (this.setting[el].input) {
                case 'input':
                    event = 'input'
                    this.setting[el].plus = this.findEl('.plus', this.setting[el].inputEl)
                    this.setting[el].minus = this.findEl('.minus', this.setting[el].inputEl)
            }
            if (this.setting[el].plus) {
                this.setting[el].plus.addEventListener('click', (e) => {
                    e.preventDefault()
                    this.changeSetting(el, this.setting[el].value + this.setting[el].step)
                })
            }
            if (this.setting[el].minus) {
                this.setting[el].minus.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.changeSetting(el, this.setting[el].value - this.setting[el].step)
                })
            }
            this.setting[el].inputEl.addEventListener(event, (ev) => {
                if (this.setting[el].type == "float") {
                    switch (ev.target.value) {
                        case '0,':
                            ev.target.value = '0.'
                            return
                        case '0.':
                            return
                    }
                }
                this.changeSetting(el, ev.target.value)
            })
        }
    }
    restart() {
        this.result_container.style.display = 'none'
        this.statistic_container.style.display = 'none'
        this.setting_container.style.display = 'flex'
    }
    findEl(elname, el) {
        let parent = el.parentNode
        let needed = parent.querySelector(elname)
        if (parent == document.body) {
            return false
        }
        if (needed == undefined) {
            this.findEl(elname, parent)
        } else {
            return needed
        }
    }
    checkInput(setting) {
        if (setting.value <= setting.min) {
            setting.value = setting.min
            setting.minus.disabled = true
        } else {
            setting.minus.disabled = false
        }
        if (setting.max != null && setting.value >= setting.max) {
            setting.value = setting.max
            setting.plus.disabled = true
        } else {
            setting.plus.disabled = false
        }
        setting.inputEl.value = setting.value
    }
    checkAnswer() {
        this.results.push({
            answer: this.answer,
            right: this.numbers_array[this.count].reduce((a, b) => a + b, 0),
            result: this.answer == this.numbers_array[this.count].reduce((a, b) => a + b, 0),
        })
        let classname = this.results[this.count].result ? '.win' : '.fail';
        this.result_container.querySelector('.win').style.display = 'none'
        this.result_container.querySelector('.fail').style.display = 'none'
        let imgs = this.result_container.querySelectorAll(`${classname} img`)
        this.result_container.querySelector('.wait').style.display = 'none'
        let ind = 1
        imgs[0].parentNode.style.display = 'block'
        imgs[0].style.display = 'block'

        let inter = setInterval(() => {
            if (ind < imgs.length) {
                imgs[ind - 1].style.display = 'none'
                imgs[ind].style.display = 'block'
                ind++
            } else {
                imgs[ind - 1].style.display = 'none'
                imgs[0].style.display = 'block'
                ind = 1
            }
        }, 100)
        let aud = classname == '.win' ? '#winaud' : '#failaud';
        document.querySelector(aud).play()
        setTimeout(() => {
            clearInterval(inter);
            this.answer = null
            this.result_input.value = ''
            this.result_container.style.display = 'none'
            imgs.forEach(el => {
                el.style.display = 'none'
            });
            this.result_container.querySelector('.wait').style.display = 'block'
            if (this.count < this.setting.examples.value - 1) {
                imgs[0].parentNode.style.display = 'block'
                this.startTraining(this.count + 1)
            } else {
                this.showStatistic()
            }
        }, 1000)

    }
    showStatistic() {
        this.statistic_container.style.display = 'flex';
        this.statistic_container.querySelector('.training_details').style.display = "none";
        let right = this.results.reduce((prev, a) => {
            if (a.result) {
                return prev + 1;
            } else {
                return prev;
            }
        }, 0);
        let err = this.setting.examples.value - right;
        document.querySelector('#right').textContent = right;
        document.querySelector('#error').textContent = err;
        let temp = document.querySelector('#template');
        let item = temp.content.querySelector('.training_details-item');
        this.stat_details.style.display = 'none';
        this.stat_details.querySelectorAll('.training_details-item').forEach(el => {
            el.remove();
        });
        this.details_button.textContent = 'Подробнее';
        this.stat_open = false;
        let res = {};
        historyGame.res = [];
        historyGame.speed = this.setting.speed.value;
        if (this.mode == 'flash') {
            historyGame.mode = 'Флешкарты';
        } else {
            historyGame.mode = 'Обычный';
        }
        switch (this.setting.rules.value) {
            case 1:
                historyGame.rule = 'Просто';
                break;
            case 2:
                historyGame.rule = 'Братья';
                break;
            case 3:
                historyGame.rule = 'Друзья';
                break;
            case 4:
                historyGame.rule = 'Анзан';
                break;
        }
        historyGame.capasity = this.setting.bitness.value;
        this.results.forEach((el, ind) => {
            res = {};
            res.answer = el.answer;
            res.right = el.right;

            historyGame.res.push(res);

            let res_item = document.importNode(item, true);
            res_item.querySelector('.ynumber').textContent = el.answer;

            if (!el.result) {
                res_item.querySelector('.ynumber').classList.add('error');
            }
            res_item.querySelector('.rnumber').textContent = el.right;
            let digs = '<table>';
            for (let i = 0; i < this.setting.action_count.value; i += 8) {
                digs += '<tr>';
                this.numbers_array[ind].slice(i, i + 8).forEach(el1 => {
                    digs += `<td>${el1}</td>`;
                });
                digs += '</tr>';
            }
            digs += '</table>';
            res_item.querySelector('.digits').innerHTML = digs;
            this.stat_details.appendChild(res_item);
        });

        console.log(historyGame);

        // Отправка результатов игры на сервер
        fetch('/saveGameResult', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // Дополнительные заголовки, если необходимо
            },
            body: JSON.stringify({
                username: localStorage.getItem('username'), // Получаем имя пользователя из localStorage
                correct_answers: right, // Правильные ответы
                incorrect_answers: err, // Неправильные ответы
                game_mode: historyGame.mode, // Режим игры, возможно, вам нужно будет настроить это в соответствии с вашим кодом
                // Другие данные, которые нужно сохранить
            }),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data.message); // Выводим сообщение об успешном сохранении
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
    }

    changeSetting(propname, val) {
        let setting = this.setting[propname]
        if (val == "") {
            return
        }
        switch (setting.type) {
            case "int":
                setting.value = parseInt(val) ? parseInt(val) : setting.min
                break
            case "float":
                if (parseFloat(val) == 0) {
                    return
                }
                setting.value = parseFloat(val) ? parseFloat(val) : setting.min
                setting.value = Math.round(setting.value * 10) / 10
                break
        }
        if (setting.input == "input") {
            this.checkInput(setting)
        }
    }
    getAnswer(count) {
        this.imgs_container.style.display = 'none'
        this.number_container.style.display = 'none'
        this.result_container.style.display = 'flex'
        this.result_input.focus()
    }
    showNumbers(num) {
        num = num.toString();
        let code = ''
        for (let i = 0; i < num.length; i++) {
            code += `<img src="${this.img_path + num[i]}.svg" width="59" height="180" class="training_abakus">`
        }
        this.imgs_container.innerHTML = code
    }
    startTraining(count) {
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
    startingTraining() {
        this.setting_container.style.display = 'none'
        this.counter_container.style.display = 'flex'
        // this.counter_images = this.counter_container.querySelectorAll('img')
        // this.counter_images[2].style.display = 'block'
        // document.querySelector('#tick').play()
        this.results = []
        this.answer = null
        this.generateNumbers()
        let audio = document.querySelector('#tick')
        this.interval = setInterval(() => {
            // this.counter_images[this.counter + 1].style.display = 'none'
            if (this.counter >= 0) {
                // this.counter_images[this.counter].style.display = 'block'
                this.counter--;

            } else {
                this.counter = 1
                this.startTraining(0)
                clearInterval(this.interval)

            }
        }, 0)
    }
    getNumberWithoutRules(num, is_five = false) {
        num = Math.abs(num).toString()
        let res = '';
        let sign;
        let arr;
        switch (parseInt(num[0])) {
            case 1:
            case 5:
                sign = true
                break
            case 9:
                sign = false
                break
            default:
                sign = !!Math.round(Math.random())
        }
        let temp_arr;
        let posSeq = {
            0: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            1: [0, 1, 2, 3, 5, 6, 7, 8],
            2: [0, 1, 2, 5, 6, 7],
            3: [0, 1, 5, 6],
            4: [0, 5],
            5: [0, 1, 2, 3, 4],
            6: [0, 1, 2, 3],
            7: [0, 1, 2],
            8: [0, 1],
            9: [0],
        }
        let negSeq = {
            0: [0],
            1: [0, 1],
            2: [0, 1, 2],
            3: [0, 1, 2, 3],
            4: [0, 1, 2, 3, 4],
            5: [0, 5],
            6: [0, 1, 5, 6],
            7: [0, 1, 2, 5, 6, 7],
            8: [0, 1, 2, 3, 5, 6, 7, 8],
            9: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
        }
        if (sign) {
            arr = posSeq
            temp_arr = arr[num[0]].filter(el => el != 0)
        } else {
            arr = negSeq
            temp_arr = arr[num[0]].filter(el => ![0, parseInt(num[0])].includes(el))
            res = '-'
        }
        res += temp_arr[randomInteger(0, temp_arr.length - 1)]
        if (is_five) {
            if (parseInt(num[0]) < 5) {
                arr = posSeq
                res = randomInteger(5 - parseInt(num[0]), 4)
            } else {
                arr = negSeq
                res = "-" + randomInteger(parseInt(num[0]) - 4, 4).toString()

            }
        }
        for (let i = 1; i < num.length; i++) {
            res += arr[num[i]][randomInteger(0, arr[num[i]].length - 1)].toString()
        }
        return parseInt(res)
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
})
let is_open = false

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

