//---------Подсказки, облегчения, общие функции

//Открыть/закрыть c помощью добавления класса "актив"
function OpenClose(el, active_class) {
    $(function () { $('.' + el).click(function () { $(this).addClass($(this).attr("class") !== active_class ? active_class : $(this).removeClass(active_class)); }); });
}
//Переключение активного элемента c помощью добавления класса "актив"
function ActiveEl(el, active_class) {
    $('.' + el).click(function (e) {
        let el_active = this;
        $('.' + el).each(function () {
            this.classList.remove(active_class);
            if (this == el_active) {
                this.classList.add(active_class);
            } else {
                this.classList.remove(active_class);
            }
        })
    });
};

function getTimeCodeFromNum(num) {
    let seconds = parseInt(num);
    let minutes = parseInt(seconds / 60);
    seconds -= minutes * 60;
    const hours = parseInt(minutes / 60);
    minutes -= hours * 60;

    if (hours === 0) return `${minutes}:${String(seconds % 60).padStart(2, 0)}`;
    return `${String(hours).padStart(2, 0)}:${minutes}:${String(
      seconds % 60
    ).padStart(2, 0)}`;
  }


//---------КОНЕЦ-------  Подсказки, облегчения, общие функции












function delete_characters(str, length) {

    if ((str.constructor === String) && (length > 0)) {
        document.writeln(str.slice(0, length));
    }
};

function forYouTxt_1() {
    btn = document.querySelector('#our_trainings_btn_1');
    txt = document.querySelector('#our_trainings_text_1');
    if (btn.style.transform == "rotate(-90deg)") {
        btn.style = "transform:rotate(90deg)";
        txt.classList.add("our_trainings_list");
        txt.classList.remove("our_trainings_list_onclick");
    }
    else {
        txt.classList.remove("our_trainings_list");
        txt.classList.add("our_trainings_list_onclick");
        btn.style = "transform:rotate(-90deg)";
    }
}
function forYouTxt_2() {
    btn = document.querySelector('#our_trainings_btn_2');
    txt = document.querySelector('#our_trainings_text_2');
    if (btn.style.transform == "rotate(-90deg)") {
        btn.style = "transform:rotate(90deg)";
        txt.classList.add("our_trainings_list");
        txt.classList.remove("our_trainings_list_onclick");
    }
    else {
        txt.classList.remove("our_trainings_list");
        txt.classList.add("our_trainings_list_onclick");
        btn.style = "transform:rotate(-90deg)";
    }
}
function forYouTxt_3() {
    btn = document.querySelector('#our_trainings_btn_3');
    txt = document.querySelector('#our_trainings_text_3');
    if (btn.style.transform == "rotate(-90deg)") {
        btn.style = "transform:rotate(90deg)";
        txt.classList.add("our_trainings_list");
        txt.classList.remove("our_trainings_list_onclick");
    }
    else {
        txt.classList.remove("our_trainings_list");
        txt.classList.add("our_trainings_list_onclick");
        btn.style = "transform:rotate(-90deg)";
    }
}







$('.stage_number input').on('input change paste', function () {
    $(this).val(this.value.replace(/[^0-9\-]/, '')); // запрещаем ввод любых символов, кроме цифр и знака минуса
});

$('.stage_number').each(function () {
    var numb = $(this),
        controls = numb.find('.number_controls div'),
        input = numb.find('input'),
        interval,
        timeout;
    controls.each(function () {
        var control = $(this);
        var pressed = false;
        control.on('mousedown', function () {
            timeout = setTimeout(function () {
                pressed = true;
            }, 51);
            var value = parseInt(input.val()) || 0;
            interval = setInterval(function () {
                if (pressed) {
                    if (control.hasClass('nc_minus')) {
                        value = changeValue(value, 'minus');
                    } else if (control.hasClass('nc_plus')) {
                        value = changeValue(value, 'plus');
                    }
                    input.val(value).change();
                }
            }, 150);
        });

        control.on('mouseup', function () {
            var value = parseInt(input.val()) || 0;
            if (control.hasClass('nc_minus')) {
                value = changeValue(value, 'minus');
            } else if (control.hasClass('nc_plus')) {
                value = changeValue(value, 'plus');
            }
            input.val(value).change();

            pressed = false;
            clearInterval(interval);
        });

        control.on('mouseout', function () {
            clearInterval(interval);
        });
    });

    function changeValue(val, type) {
        if (type == 'minus') {
            if (val <= 2) {
                val = 2;
            }
            else {
                val = val - 1;
            };
        } else if (type == 'plus') {
            if (val == 0) {
                val = val + 2;
            }
            else {
                val = val + 1;
            };
        }
        return val;
    }

});





// IMAGE STYLES
$(document).ready(function () {

    $("#image").change(function () {

        var f_name = [];

        for (var i = 0; i < $(this).get(0).files.length; ++i) {

            f_name.push($(this).get(0).files[i].name);

        }

        $(".image_btn").html(f_name.join(", "));
        $("#add_image_label").css('background', 'rgba(0, 255, 40, 0.19)');
    });
});


$(document).ready(function () {
    $("#audio").change(function () {
        var f_name = [];
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            f_name.push($(this).get(0).files[i].name);
        }
        if (f_name[0].split('').splice(-3).join('') === "mp3") {
            $("#audio_btn").html(f_name.join(", "));
            $("#add_audio_label").css('background', 'rgba(0, 255, 40, 0.19)');
            $(".check_mp").html("");
        }
        else {
            $(".check_mp").html("Сообщение должно быть в формате 'mp3'").css('color', 'rgb(216, 41, 57)');
        }
    });

});


$(document).ready(function () {
    $("#second_audio").change(function () {
        var s_name = [];
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            s_name.push($(this).get(0).files[i].name);
        }
        if (s_name[0].split('').splice(-3).join('') === "mp3") {
            $(".second_audio_btn").html('s_name');
            $("#second_audio_label").css('background', 'rgba(0, 255, 40, 0.19)');
            $(".check_mp").html("");
        }
        else {
            $(".check_mp").html("Сообщение должно быть в формате 'mp3'").css('color', 'rgb(216, 41, 57)');
        }
    });
});















// RESET PASSWORD

$(document).ready(function () {
    "use strict";
    //регулярное выражение для проверки email
    var pattern = /^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i;
    var mail = $('input[name=reset_email]');

    mail.blur(function () {
        if (mail.val() != '') {
            if (mail.val().search(pattern) == 0) {
                $('#valid_email_message').text('');
                $('input[type=submit]').attr('disabled', false);
            } else {
                $('#valid_email_message').text('Не правильный Email');
                $('input[type=submit]').attr('disabled', true);
            }
        } else {
            $('#valid_email_message').text('Введите Ваш email');
        }
    });
});










// Выбор определённого option через select value
$(document).ready(function () {
    $('.change_sex').each(function (index, id) {
        var theValue = $(this).attr('value');
        var theID = $(this).attr('id');
        $('.change_sex#' + theID + ' option[value=' + theValue + ']').attr('selected', true);
    });
});








// Choice Image
$(function () {
    $('.change_img_btn').click(function () {
        $('.choice_img').addClass('choice_img_active');
        $('.change_container').addClass('change_blur');
    });
    // $('.change_container').click(function () {
    //   $('.choice_img').removeClass('choice_img_active');
    //   $('.change_container').removeClass('change_blur');
    // });
});


$('.choice_img_item > :checkbox').on('change', function () {
    var checkbox = $(this);
    var name = checkbox.prop('name');
    if (checkbox.is(':checked')) {
        $(':checkbox[name="' + name + '"]').not($(this)).prop({
            'checked': false,
            'required': false
        });

    }
});


//CHANGE SRC
$(function () {
    $('.color_skin_item_black').click(function () {
        $('.choice_img_item > input').each(function () {
            let val_check_img = $(this).prop('value');
            val_check_img = val_check_img.concat('_2');
            $(this).val(val_check_img)
        });

        $('.choice_img_item > label > img').each(function () {
            const imgSrc = $(this).attr('src');
            const last_imgSrc = imgSrc.slice(-6);
            if (last_imgSrc !== "_2.png") {
                $(this).attr('src', $(this).attr('src').replace(/\.png/, '_2.png'));
            }
        })
    });
    $('.color_skin_item_white').click(function () {
        $('.choice_img_item > input').each(function () {
            let val_check_img = $(this).prop('value');
            val_check_img = val_check_img.replace(/\_2/, '');
            $(this).val(val_check_img)
        });

        $('.choice_img_item > label > img').each(function () {
            const imgSrc = $(this).attr('src');
            const last_imgSrc = imgSrc.slice(-6);
            if (last_imgSrc == "_2.png") {
                $(this).attr('src', $(this).attr('src').replace(/\_2.png/, '.png'));
                $(this).val($(this).val().replace(/\_2/, ''));
            }
        })
    });
});


$(function () {
    $('.unsubscribe_btn button').click(function () {
        $('.unsubscribe_confirmation').addClass('unsubscribe_form_btns');
        $('.account').addClass('change_blur');
    });
});

$(function () {
    $('#unsubscribe_cancel').click(function (e) {
        e.preventDefault();
        $('.unsubscribe_confirmation').removeClass('unsubscribe_form_btns');
        $('.account').removeClass('change_blur');
    });
});


//TextShow


$(function () {
    const btn = document.querySelector('.trial_btn-show');
    if (btn) {
        btn.addEventListener('click', () => {
            btn.classList.toggle('trial_btn-close')
            if (btn.classList.contains('trial_btn-close')) {
                [...document.querySelector('.trial_text-wrap').children].forEach(el => el.classList.add('trial_text-show'));
            } else {
                [...document.querySelector('.trial_text-wrap').children].slice(1).forEach(el => el.classList.remove('trial_text-show'));
            }
        })
    }
});


// Intro Anxiety

(() => {
    document.addEventListener('DOMContentLoaded', function () {
        const anxietyItem = document.querySelectorAll('.it_bothers_me_item span');
        let anxietyBtn = document.querySelector('.intro_link-wrap');
        const local = [];
        const sessionStr = JSON.parse(sessionStorage.getItem('anxiety'));

        if (sessionStr) {
            sessionStr.forEach((arr) => {
                local.push(arr);
            })
        }

        anxietyItem.forEach((item) => {
            local.forEach((arr) => {
                if (arr === item.textContent) item.classList.add('intro_txt_active');
            });

            item.addEventListener('click', function () {
                item.classList.toggle('intro_txt_active');

                if (item.classList.contains('intro_txt_active')) {
                    local.push(item.textContent);
                } else {
                    local.forEach((arr) => {
                        if (arr === item.textContent) local.splice(local.indexOf(arr), 1);
                    })
                }
            })
        })

        if (anxietyBtn) {
            document.querySelector('.intro_link-wrap').addEventListener('click', function (e) {
                sessionStorage.setItem('anxiety', JSON.stringify(local))
            })
        }
    })
})();

//Header Navigation Active

$(function () {
    let nav_href = document.querySelectorAll(".nav_list li a");
    let url = document.location.href;
    nav_href.forEach((el) => { el.href === url ? el.classList.add("nav_active") : el.classList.remove("nav_active") })
});

//проверка нажатого чекбокса на странице регистрации
(() => {
    document.addEventListener('DOMContentLoaded', function () {
        const persApprovalCheckbox = document.querySelector("#pers_approval_checkbox");
        let btnSubmit = document.querySelector('.pers_btn .blue_btn');

        function changeBtn(opacity, bool, cursor) {
            btnSubmit.style.opacity = opacity;
            btnSubmit.disabled = bool;
            btnSubmit.style.cursor = cursor;
        }

        if (persApprovalCheckbox) {
            changeBtn('0.5', true, 'default');

            persApprovalCheckbox.addEventListener("change", function () {
                if (this.checked) {
                    changeBtn('1', false, 'pointer');
                } else {
                    changeBtn('0.5', true, 'default');
                }
            })
        }
    })
})();

// Show Password
$(function () {
    $('.pass_eye').click(function () {
        if ($('.pers_input input').attr('type') == 'password') {
            $(this).addClass('close_eye');
            $('.pers_input input').attr('type', 'text');
        } else {
            $(this).removeClass('close_eye');
            $('.pers_input input').attr('type', 'password');
        }
        return false;
    });
});

