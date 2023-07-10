const blackList = ["!", "'", ';', '<', '>', '#', '%27', 'script', 'delete', 'DELETE', 'hack', '"', 'cookie', 'document', 'alert', '<script>', '</script>', 'document.cookie'];

export const phoneRegex = /^[0]{1}[9]{1}[0-9]{9}$/;
export const emailRegex = /^[a-z \d]{1,40}@[a-z \d]{1,40}\.[a-z]{2,10}$/i;


function createIconInput(parent, icon, color) {
    for (let child of parent.children) {
        if (child.tagName === 'I') {
            child.removeAttribute('class');
            child.classList.add(`fa-solid`, `fa-${icon}`, `${color}__default`);
        }
    }
}

function errorClass(parent, ...classes) {
    parent.classList.remove(classes[0]);
    parent.classList.add(classes[1]);
}

function blacklistFn(input) {
    let result = [];
    for (let black of blackList) {
        if (input.value.toLowerCase().match(black)) {
            // input.value = input.value.replace(black, '');
            result.push(black);
        }
    }
    return result;
}

export function required(elements) {
    let result = false;
    for (let element of elements) {
        let field = document.getElementsByName(element['name']);
        let messageBox = document.getElementById(`error-${element['name'].replace('_', '-')}`);
        if (field[0].value.trim().length === 0) {
            // allSelectorsError.push(element['name']);
            // allErrors[element['name']] = [...element['message'] ?? `وارد کردن ${element['attribute']} الزامی است`];
            messageBox.innerText = element['message'] ?? `وارد کردن ${element['attribute']} الزامی است`;
            errorClass(field[0].parentNode, 'border-success', 'border-red');
            createIconInput(field[0].parentNode, 'warning', 'red');

            result = true;
        } else {
            messageBox.innerText = '';
            errorClass(field[0].parentNode, 'border-red', 'border-success');
            createIconInput(field[0].parentNode, 'check', 'green');
        }

    }
    return result;
}

export function email(value) {
    let result = true;
    if (!emailRegex.test(value)) {
        result = false;
    }

    return result;
}

export function max(elements) {
    let result = false;
    for (let element of elements) {
        let field = document.getElementsByName(element['name']);
        let messageBox = document.getElementById(`error-${element['name'].replace('_', '-')}`);
        if (field[0].value > element.length) {
            messageBox.innerText = `عدد وارد شده باید کمتر از  ${element.length} باشد`;
            errorClass(field[0].parentNode, 'border-success', 'border-red');
            createIconInput(field[0].parentNode, 'warning', 'red');
            result = true;
        } else {
            messageBox.innerText = '';
            errorClass(field[0].parentNode, 'border-red', 'border-success');
            createIconInput(field[0].parentNode, 'check', 'green');
        }

    }
    return result;
}

export function min(elements) {
    let result = false;
    for (let element of elements) {
        let field = document.getElementsByName(element['name']);
        let messageBox = document.getElementById(`error-${element['name'].replace('_', '-')}`);
        if (field[0].value < element.length) {
            messageBox.innerText = `عدد وارد شده باید بیشتر از  ${element.length} باشد`;
            errorClass(field[0].parentNode, 'border-success', 'border-red');
            createIconInput(field[0].parentNode, 'warning', 'red');
            result = true;
        } else {
            messageBox.innerText = '';
            errorClass(field[0].parentNode, 'border-red', 'border-success');
            createIconInput(field[0].parentNode, 'check', 'green');
        }

    }
    return result;
}

export function phone(value) {
    let result = true;
    if (!phoneRegex.test(value)) {
        result = false;
    }
    return result;
}

export function maxLength(elements) {
    let result = false;
    for (let element of elements) {
        let field = document.getElementsByName(element['name']);
        let messageBox = document.getElementById(`error-${element['name'].replace('_', '-')}`);
        if (field[0].value.trim().length > element['length']) {
            // allSelectorsError.push(element['name']);
            // allErrors[element['name']] = [element['message']];
            messageBox.innerText = element['message'];
            errorClass(field[0].parentNode, 'border-success', 'border-red');
            createIconInput(field[0].parentNode, 'warning', 'red');
            result = true;
        } else {
            messageBox.innerText = '';
            // allSelectorsError.splice(allSelectorsError.indexOf(element['name']), 1);
            errorClass(field[0].parentNode, 'border-red', 'border-success');
            createIconInput(field[0].parentNode, 'check', 'green');
        }
    }
    return result;
}

export function minLength(elements) {
    let result = false;
    for (let element of elements) {
        let field = document.getElementsByName(element['name']);
        let messageBox = document.getElementById(`error-${element['name'].replace('_', '-')}`);
        if (field[0].value.trim().length < element['length']) {
            messageBox.innerText = element['message'];
            errorClass(field[0].parentNode, 'border-success', 'border-red');
            createIconInput(field[0].parentNode, 'warning', 'red');
            result = true;
        } else {
            messageBox.innerText = '';
            errorClass(field[0].parentNode, 'border-red', 'border-success');
            createIconInput(field[0].parentNode, 'check', 'green');
        }
    }
    return result;
}

export function checkBlacklist(names) {
    let result = [];
    for (let i = 0; i < names.length; i++) {
        let field = document.getElementsByName(names[i]);
        let messageBox = document.getElementById(`error-${names[i].replace('_', '-')}`);
        let black = blacklistFn(field[0]);
        if (black.length > 0) {
            let word = black.length === 1 ? 'کلمه' : 'کلمات';
            messageBox.innerText = `وارد کردن ${word} ${black.join(' , ')} مجاز نمی باشد`;
            errorClass(field[0].parentNode, 'border-success', 'border-red');
            createIconInput(field[0].parentNode, 'warning', 'red');
            result.push(true);
        } else {
            messageBox.innerText = '';
            errorClass(field[0].parentNode, 'border-red', 'border-success');
            createIconInput(field[0].parentNode, 'check', 'green');
            result.splice(i, 1);
        }
    }
    return result.includes(true);
}

export function checkPattern(rules) {
    let result = false;
    for (let rule of rules) {
        let field = document.getElementsByName(rule['name']);
        let messageBox = document.getElementById(`error-${rule['name'].replace('_', '-')}`);
        if (field[0].value.match(rule['regex'])) {
            messageBox.innerText = '';
            errorClass(field[0].parentNode, 'border-red', 'border-success');
            createIconInput(field[0].parentNode, 'check', 'green');
        } else {
            messageBox.innerText = rule['message'];
            errorClass(field[0].parentNode, 'border-success', 'border-red');
            createIconInput(field[0].parentNode, 'warning', 'red');
            result = true;
        }
    }
    return result;
}

export function isNumber(elements) {
    let result = false;
    for (let element of elements) {
        let field = document.getElementsByName(element['name']);
        let messageBox = document.getElementById(`error-${element['name'].replace('_', '-')}`);
        // typeof field[0].value !== 'number'
        if (field[0].value.match('/^[0-9]$/') || isNaN(field[0].value)) {
            messageBox.innerText = `${element['attribute']} باید عدد باشد`;
            errorClass(field[0].parentNode, 'border-success', 'border-red');
            createIconInput(field[0].parentNode, 'warning', 'red');
            result = true;
        } else {
            messageBox.innerText = '';
            errorClass(field[0].parentNode, 'border-red', 'border-success');
            createIconInput(field[0].parentNode, 'check', 'green');
        }

    }
    return result;
}

export function nationalCode(nationalCode, selector = 'national-code') {
    let messageBox = document.getElementById(`error-${selector}`);
    let result = false;
    let national = nationalCode.trim(' .');
    // $nationalCode = convertArabicToEnglish($nationalCode);
    // $nationalCode = convertPersianToEnglish($nationalCode);
    let bannedArray = ['0000000000', '1111111111', '2222222222', '3333333333', '4444444444', '5555555555', '6666666666', '7777777777', '8888888888', '9999999999'];

    if (national.length < 1) {
        result = false;
    } else if (national.length !== 10) {
        result = false;
    } else if (bannedArray.includes(national)) {
        result = false;
    } else {

        let sum = 0;
        let lastDigit;

        for (let i = 0; i < 9; i++) {
            sum += +national[i] * (10 - i);
        }

        let divideRemaining = sum % 11;

        if (divideRemaining < 2) {
            lastDigit = divideRemaining;
        } else {
            lastDigit = 11 - (divideRemaining);
        }

        result = +national[9] === lastDigit;

    }
    if (!result) {
        messageBox.innerText = 'کد ملی وارد شده معتبر نمی باشد';
    } else {
        messageBox.innerText = '';
    }

    return !result;
}

export function emptyInput(selectors) {
    selectors.map((item) => {
        $(`#error-${item}`).empty();
    });
}

export function showErrors(errors, selectors) {
    selectors.forEach((item) => {
        let selector = document.getElementById(`error-${item.replace('_', '-')}`);
        selector.innerText = '';
        selector.innerText = errors[item] !== undefined ? errors[item][0] : '';
    });
}

export function getData(selectors, type = {}) {
    let data = {};
    let element = 'input';
    let typeInput;
    selectors.forEach((item) => {
        typeInput = type[item] === 'checkbox' ? ':checked' : '';
        element = type[item] === 'textarea' ? 'textarea' : 'input';
        data[item] = $(`${element}[name=${item}] ${typeInput}`).val()
    });
    return data;
}

