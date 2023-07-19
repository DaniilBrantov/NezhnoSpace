const showError = (value, textError) => {
    const inputElement = document.querySelector(`input[name="${value}"]`);
    const errorTextElement = document.querySelector(`.text-error_${value}`);
    inputElement.classList.add('error');
    errorTextElement.textContent = textError;
    errorTextElement.style.opacity = '1';
};

const showModalError = () => {
    const errorWindow = document.querySelector('.authorization_window-error');
    const errorMessage = errorWindow.querySelector('span');
    const errorButton = errorWindow.querySelector('.authorization_window-error_btn');

    errorWindow.style.display = 'flex';
    errorMessage.textContent = 'При загрузке произошла неизвестная ошибка! Пожалуйста, попробуйте позже.';

    errorButton.addEventListener('click', () => {
        errorWindow.style.display = 'none';
    });
};

const handleRegistration = () => {
    document.addEventListener('DOMContentLoaded', () => {
        const regBtn = document.querySelector("#reg_btn");
        if (regBtn) {
            regBtn.addEventListener("click", (e) => {
                e.preventDefault();
                document.querySelectorAll('input').forEach(input => input.classList.remove("error"));

                const regNonce = document.querySelector('#vb_new_user_nonce').value;
                const firstName = document.querySelector('input[name="first_name"]').value;
                const mail = document.querySelector('input[name="mail"]').value;
                const pass = document.querySelector('input[name="pass"]').value;
                const passConf = document.querySelector('input[name="pass_conf"]').value;
                const approvalCheck = document.querySelector('input[name="approval_check"]').value;
                const get = new URLSearchParams(document.location.search);
                const token = get.get("token");

                const formData = new FormData();
                formData.append("nonce", regNonce);
                formData.append("first_name", firstName);
                formData.append("mail", mail);
                formData.append("pass", pass);
                formData.append("pass_conf", passConf);
                formData.append("approval_check", approvalCheck);
                formData.append("token", token);

                fetch("check", {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            window.location.href = 'subscription';
                        } else {
                            for (let key in data) {
                                if (key !== 'status') {
                                    showError(key, data[key]);
                                }
                            }
                        }
                    })
                    .catch(error => {
                        showModalError();
                    });
            });
        }
    });
};

const handleAuthentication = () => {
    // const authBtn = document.querySelector("#auth_btn");

    $("#auth_btn").click(function(e) {
        e.preventDefault();
        document.querySelectorAll("input").forEach(input => input.classList.remove("error"));

        const mail = document.querySelector('input[name="mail"]').value;
        const pass = document.querySelector('input[name="pass"]').value;
        const authBtnValue = document.querySelector('button[name="auth_btn"]').value;

        const formData = new FormData();
        formData.append("mail", mail);
        formData.append("pass", pass);
        formData.append("auth_btn", authBtnValue);


        fetch("auth-check", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    window.location.href = 'account';
                } else {
                    for (let key in data) {
                        if (key !== 'status') {
                            showError(key, data[key]);
                        }
                    }
                }
            })
            .catch(() => {
                showModalError();
            });
    });
};

// Регистрация
handleRegistration();

// Авторизация
handleAuthentication();







//Подтверждение почты
$("#activation_btn").click(function (e) {
    e.preventDefault();
    let activation_btn = $('input[name="activation_btn"]').val();

    let formData = new FormData();
    formData.append("activation_btn", activation_btn);

    //обьект ajax со св-ми ,как было у формы.
    $.ajax({
        url: "activation_check",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {
            let btn = document.querySelector('#activation_btn');
            btn.setAttribute('disabled', true);
            btn.style.opacity = "0.5";
            btn.style.cursor = "default";

            if (data) {
                btn.textContent = "Письмо отправлено";
            } else {
                btn.textContent = "Ошибка! Письмо не отправлено";
            }
        },
        error: function (jqxhr, status, errorMsg) {
            console.log(status, errorMsg);
        },
    });
});


// Восстановление пароля
$("#reset_btn").click(function (e) {
    e.preventDefault();
    $("input").removeClass("error");

    let mail = $('input[name="mail"]').val();
    let reset_btn = $('input[name="reset_btn"]').val();

    let formData = new FormData();
    formData.append("mail", mail);
    formData.append("reset_btn", reset_btn);

    //обьект ajax со св-ми ,как было у формы.
    $.ajax({
        url: "send_link_reset_password",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {
            if (data === true) {
                document.querySelector('.reset_password_form.authorization_form').innerHTML = `
                    <span>Письмо было отправлено на введенный email адрес. Пожалуйста, проверьте Вашу почту!</span>
                `;
            } else {
                showError('mail', data);
            }
        },
        error: function (jqxhr, status, errorMsg) {
            console.log(status, errorMsg);
        },
    });
});


// Смена пароля
$("#set_pass_btn").click(function (e) {
    e.preventDefault();
    $("input").removeClass("error");

    let pass_token = $('input[name="pass_token"]').val();
    let pass = $('input[name="pass"]').val();
    let pass_conf = $('input[name="pass_conf"]').val();
    let set_pass_btn = $('input[name="set_pass_btn"]').val();


    let formData = new FormData();
    formData.append("pass_token", pass_token);
    formData.append("pass", pass);
    formData.append("pass_conf", pass_conf);
    formData.append("set_pass_btn", set_pass_btn);

    //обьект ajax со св-ми ,как было у формы.
    $.ajax({
        url: "update_password",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {
            if (data === true) {
                document.querySelector('.authorization_form').innerHTML = `
                    <span>Вы успешно сменили пароль</span>
                `;
                setTimeout(() => window.location.href = 'auth', 3000);
            } else {
                if (data === 'Повторный пароль введен не верно') {
                    showError('pass_conf', data);
                } else {
                    showError('pass', data);
                }
            }
        },
        error: function (jqxhr, status, errorMsg) {
            console.log(status, errorMsg);
        },
    });
});

//Валидация пароля
(() => {
    if (document.querySelector('.password-validation_progress')) {
        class PasswordValidation {
            constructor() {
                this.lowercaseLetters = false;
                this.capitalLetters = false;
                this.numbers = false;
                this.length = false;
            }
            sizeBar() {
                if (size < 0) {
                    size = 0;
                } else if (size > 100) {
                    size = 100;
                }
                if (size > 0 && size <= 25) {
                    colorProgress.style.background = '#FF1111';
                } else if (size > 25 && size <= 75) {
                    colorProgress.style.background = '#FFA011';
                } else if (size === 100) {
                    colorProgress.style.background = '#5DFF11';
                }

                progressBars.style.width = `${size}%`;
            }
            changeInput(valid, value) {
                if (valid) {
                    if (!this[value]) {
                        this[value] = true;
                        size += 25;
                        this.sizeBar();
                    }
                } else {
                    if (this[value]) {
                        this[value] = false;
                        size -= 25;
                        this.sizeBar();
                    }
                }

            }
        }

        const passwordValidation = new PasswordValidation();
        const inputPassword = document.querySelector('.pers_item .pers_input input[name="pass"]');
        const progressBars = document.querySelector('.password-validation_progress');
        let colorProgress = document.querySelector('.password-validation_progress');
        let size = Number(progressBars.dataset.size);

        inputPassword.addEventListener('keyup', function () {
            // Validate lowercase letters
            let lowerCaseLetters = /[a-z]/g;
            if (inputPassword.value.match(lowerCaseLetters)) {
                passwordValidation.changeInput(true, 'lowercaseLetters');
            } else {
                passwordValidation.changeInput(false, 'lowercaseLetters');
            }
            // Validate capital letters
            let upperCaseLetters = /[A-Z]/g;
            if (inputPassword.value.match(upperCaseLetters)) {
                passwordValidation.changeInput(true, 'capitalLetters');
            } else {
                passwordValidation.changeInput(false, 'capitalLetters');
            }
            // Validate numbers
            let numbers = /[0-9]/g;
            if (inputPassword.value.match(numbers)) {
                passwordValidation.changeInput(true, 'numbers');
            } else {
                passwordValidation.changeInput(false, 'numbers');
            }
            // Validate length
            if (inputPassword.value.length >= 8) {
                passwordValidation.changeInput(true, 'length');
            } else {
                passwordValidation.changeInput(false, 'length');
            }
        })
    }
})();