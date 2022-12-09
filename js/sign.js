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
                console.log(data.status)
            }
            //Выводить ошибки
            else {
                console.log(data)
                // data.fields.forEach(function (field) {
                //     $(`input[name="${field}"]`).addClass("error");
                // });
                // $(".auth_msg").removeClass("none").text(data.message);
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
            console.log(data)
            if (data.status) {

            } else {
                //     data.fields.forEach(function (field) {
                //         $(`input[name="${field}"]`).addClass("error");
                //     });
                // $(".auth_msg").removeClass("none").text(data.message);
            }
        },
        error: function (jqxhr, status, errorMsg) {
            console.log(status, errorMsg);
        },
    });
});

