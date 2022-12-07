//Регистрация

$("#reg_btn").click(function (e) {

    e.preventDefault();
    $(`input`).removeClass("error");
    //val()- взять инф-цию с данного эл-нта
    var mail = $('input[name="mail"]').val();
    var pass = $('input[name="pass"]').val();
    var pass_conf = $('input[name="pass_conf"]').val();
    var first_name = $('input[name="first_name"]').val();
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
            console.log(data.status)
            if (data.status) {
                console.log(data.message)
            } else {
                console.log(data.status + data.message)
                // data.fields.forEach(function (field) {
                //     $(`input[name="${field}"]`).addClass("error");
                // });
                // $(".auth_msg").removeClass("none").text(data.message);
            }
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

    let formData = new FormData();
    formData.append("mail", mail);
    formData.append("pass", pass);

    //обьект ajax со св-ми ,как было у формы.
    $.ajax({
        url: "https://nezhno.space/auth-check/",
        type: "POST",
        //возращаем текст
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        //обьект с нашими данными
        data: formData,
        //метод ,который передаёт ф-цию
        success: function (data) {
            if (data.status) {
                document.location.href = "/uchebnaya-programma";
            } else {
                if (data.type === 1) {
                    data.fields.forEach(function (field) {
                        $(`input[name="${field}"]`).addClass("error");
                    });
                }
                $(".auth_msg").removeClass("none").text(data.message);
            }
        },
        error: function (jqxhr, status, errorMsg) {
            console.log(status, errorMsg);
        },
    });
});

