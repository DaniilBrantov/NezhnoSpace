const showError = (value, textError) => {
    document.querySelector(`input[name=${value}]`).classList.add('error');
    document.querySelector(`.text-error_${value}`).style.opacity = '1';
    document.querySelector(`.text-error_${value}`).innerText = textError;
}

//Регистрация

$("#reg_btn").click(function (e) {

    //отключает стандартное поведение e(кнопки)
    e.preventDefault();
    $(`input`).removeClass("error");
    //val()- взять инф-цию с данного эл-нта
    var first_name = $('input[name="first_name"]').val();
    var mail = $('input[name="mail"]').val();
    var pass = $('input[name="pass"]').val();
    var pass_conf = $('input[name="pass_conf"]').val();
    var approval_check = $('input[name="approval_check"]').val();

    var formData = new FormData();
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
                        console.log(key, data[key])
                        showError(key, data[key]);
                    }
                }
            }
        },
        error: function (jqxhr, status, errorMsg) {
            console.log(status, errorMsg);
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
            console.log(status, errorMsg);
        },
    });
});

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

            if (data.status) {
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

