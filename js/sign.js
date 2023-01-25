const showError = (value, textError) => {
    document.querySelector(`input[name=${value}]`).classList.add('error');
    document.querySelector(`.text-error_${value}`).style.opacity = '1';
    document.querySelector(`.text-error_${value}`).innerText = textError;
}

const showModalError = () => {
    document.querySelector('.authorization_window-error').style.display = 'flex';
    document.querySelector('.authorization_window-error span').innerText = 'При загрузке произошла неизвестная ошибка! Пожалуйста, попробуйте позже.';

    document.querySelector('.authorization_window-error_btn').addEventListener('click', function () {
        document.querySelector('.authorization_window-error').style.display = 'none';
    }, false);
}

//Регистрация

$("#reg_btn").click(function (e) {

    //отключает стандартное поведение e(кнопки)
    e.preventDefault();
    $(`input`).removeClass("error");
    //val()- взять инф-цию с данного эл-нта
    var reg_nonce = $('#vb_new_user_nonce').val();
    var first_name = $('input[name="first_name"]').val();
    var mail = $('input[name="mail"]').val();
    var pass = $('input[name="pass"]').val();
    var pass_conf = $('input[name="pass_conf"]').val();
    var approval_check = $('input[name="approval_check"]').val();

    var formData = new FormData();
    formData.append("nonce", reg_nonce);
    formData.append("first_name", first_name);
    formData.append("mail", mail);
    formData.append("pass", pass);
    formData.append("pass_conf", pass_conf);
    formData.append("approval_check", approval_check);

    // обьект ajax со св-ми ,как было у формы.
    $.ajax({
        url: "check",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {
            //Успешно зарегистрорвался
            if (data.status) {
                window.location.href = 'activation';
            }
            //Выводить ошибки
            else {
                for (let key in data) {
                    if (key !== 'status') {
                        //console.log(key, data[key])
                        showError(key, data[key]);
                    }
                }
            }
        },
        error: function (jqxhr, status, errorMsg) {
            showModalError();
        },
    });
});

//Авторизация
$("#auth_btn").click(function (e) {
    //отключает стандартное поведение e(кнопки)
    e.preventDefault();
    $("input").removeClass("error");
    //val()- взять инф-цию с данного эл-нта
    let mail = $('input[name="mail"]').val();
    let pass = $('input[name="pass"]').val();
    let auth_btn = $('input[name="auth_btn"]').val();

    let formData = new FormData();
    formData.append("mail", mail);
    formData.append("pass", pass);
    formData.append("auth_btn", auth_btn);

    //обьект ajax со св-ми ,как было у формы.
    $.ajax({
        url: "auth-check",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {
            if (data.status) {
                window.location.href = 'account';
            } else {
                for (let key in data) {
                    if (key !== 'status') {
                        showError(key, data[key]);
                    }
                }
            }
        },
        error: function (jqxhr, status, errorMsg) {
            showModalError();
        },
    });
});

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
