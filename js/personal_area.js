// //Авторизация
// $("#auth_btn").click(function (e) {
//   //отключает стандартное поведение e(кнопки)
//   e.preventDefault();
//   $("input").removeClass("error");
//   //val()- взять инф-цию с данного эл-нта
//   let mail = $('input[name="mail"]').val();
//   let pass = $('input[name="pass"]').val();

//   let formData = new FormData();
//   formData.append("mail", mail);
//   formData.append("pass", pass);

//   //обьект ajax со св-ми ,как было у формы.
//   $.ajax({
//     url: "https://nezhno.space/auth-check/",
//     type: "POST",
//     //возращаем текст
//     dataType: "json",
//     processData: false,
//     contentType: false,
//     cache: false,
//     //обьект с нашими данными
//     data: formData,
//     //метод ,который передаёт ф-цию
//     success: function (data) {
//       if (data.status) {
//         document.location.href = "/uchebnaya-programma";
//       } else {
//         if (data.type === 1) {
//           data.fields.forEach(function (field) {
//             $(`input[name="${field}"]`).addClass("error");
//           });
//         }
//         $(".auth_msg").removeClass("none").text(data.message);
//       }
//     },
//     error: function (jqxhr, status, errorMsg) {
//       console.log(status, errorMsg);
//     },
//   });
// });

// //Регистрация

// //'$'-выбор эл-та по классу. И при клике выполняем функцию.
// // e или event это как this,указывает на то,с чем работаем.
// $(".reg_btn").click(function (e) {
//   //отключает стандартное поведение e(кнопки)
//   e.preventDefault();

//   $(`input`).removeClass("error");
//   //val()- взять инф-цию с данного эл-нта
//   var mail = $('input[name="mail"]').val();
//   var pass = $('input[name="pass"]').val();
//   var nname = $('input[name="nname"]').val();
//   var checkbox = $('input[name="reg_checkbox"]').val();
//   var order = $('input[name="order"]').val();

//   var formData = new FormData();
//   formData.append("mail", mail);
//   formData.append("pass", pass);
//   formData.append("nname", nname);
//   formData.append("checkbox", checkbox);
//   formData.append("order", order);

//   // обьект ajax со св-ми ,как было у формы.
//   $.ajax({
//     url: "https://nezhno.space/check/",
//     type: "POST",
//     dataType: "json",
//     processData: false,
//     contentType: false,
//     cache: false,
//     data: formData,
//     success: function (data) {
//       if (data.status) {
//         document.location.href = "/auth";
//       } else {
//         if (data.type === 1) {
//           data.fields.forEach(function (field) {
//             $(`input[name="${field}"]`).addClass("error");
//           });

//           $(".auth_msg").removeClass("none").text(data.message);
//         }
//       }
//     },
//   });
// });

function audioTxt() {
  btn = document.querySelector("#les_button");
  txt = document.querySelector("#les_audio_txt_cont");
  if (txt.style.display == "block") {
    txt.style = "display: none";
    btn.style = "transform:rotate(90deg)";
  } else {
    txt.style = "display: block;";
    timeVar = 1;
    btn.style = "transform:rotate(-90deg)";
  }
}
function SecondAudioTxt() {
  btn = document.querySelector("#second_les_button");
  txt = document.querySelector("#second_les_audio_txt_cont");
  if (txt.style.display == "block") {
    txt.style = "display: none";
    btn.style = "transform:rotate(90deg)";
  } else {
    txt.style = "display: block;";
    timeVar = 1;
    btn.style = "transform:rotate(-90deg)";
  }
}

function tgTxt() {
  btn = document.querySelector(".les_hw_link");
  txt = document.querySelector(".les_hw_link_txt");
  widthBtn = document.querySelector(".les_hw_content");
  if (txt.style.display == "block") {
    txt.style = "display: none";
    timeVar = 1;
    widthBtn.style = "width:125px;";
    timeVar = 1;
  } else {
    txt.style = "display: block;";
    timeVar = 1;
    widthBtn.style = "width:70%;";
    timeVar = 1;
  }
}

// Плавное появление блока при скролле

$(window).scroll(function () {
  var sTop = $(this).scrollTop();

  $(".what_get").each(function (i, el) {
    var pTop = $(el).offset().top;
    var height = $(el).height();

    var top = pTop - sTop + height;
    if (top > 0) {
      $(el).css({
        opacity: function () {
          var elementHeight = $(el).height();
          return 1 - top / 300 + height / 250;
        },
      });
    }
  });
});

//MOBILE FirstStage
if (window.innerWidth <= 1500) {
  $(".audio_meditation_img").prependTo(".section_audio_meditation");
  $(".recognized_yourself_img")
    .css("padding", "0")
    .prependTo(".recognized_yourself");
  $(".recognized_yourself").css("display", "block");
} else {
  $(".audio_meditation_img").appendTo(".wrapper_audio_meditation");
  $(".recognized_yourself_img")
    .css("padding-top", "200px")
    .appendTo(".recognized_yourself");
}
if (window.innerWidth <= 1050) {
  $(".practice_img").prependTo(".practice_cnt");
  $(".we_are_ready_img").prependTo(".we_are_ready");
}

$("#form_mail").change(function () {
  if (validateEmail(this.value)) {
    console.log("yes");
    $(".name_mail_form button").prop("disabled", false);
    $("#error_name").addClass("none");
  } else {
    console.log("no");
    $(".name_mail_form button").prop("disabled", true);
    $("#error_name").removeClass("none");
  }
});

function validateEmail(email) {
  var re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  return re.test(email);
}

//Опросник

var questionTree = function (selector) {
  var nowQuestion,
    arrayQuestions = [],
    self = this,
    select = document.querySelector(selector),
    quest = function (questions) {
      this.question = questions;
      this.arrAnswer = [1, 2, 3, 4, 5];
      this.arrToQuestion = [1, 2, 3, 4, 5];
    };

  this.addQuestion = function (questions) {
    arrayQuestions.push(new quest(questions));
  };

  var all_quest = 1;
  var name_val;
  var mail_val;
  var choice_array = [];

  this.startQuestions = function () {
    var NameStart = document.createElement("input");
    NameStart.type = "text";
    NameStart.classList.add("question_name");
    select.querySelector(".question").appendChild(NameStart);
    var NameLabel = document.createElement("label");
    NameLabel.innerHTML = "Имя";
    NameLabel.classList.add("question_name_label");
    select.querySelector(".question").appendChild(NameLabel);

    var buttonStart = document.createElement("input");
    buttonStart.type = "button";
    buttonStart.classList.add("question_btn_start");
    select.querySelector(".questionnaire_buttons").appendChild(buttonStart);
    nowQuestion = 0;
    buttonStart.disabled = true;

    NameStart.addEventListener("input", function (event) {
      buttonStart.disabled = NameStart.value == "";
    });
    buttonStart.addEventListener("click", function (event) {
      if (NameStart.value != "") {
        this.disabled = false;
        WriteEmail();
        name_val = NameStart.value;
      } else {
        NameStart.value = "";
        this.disabled = true;
      }
    });
  };
  function WriteEmail() {
    delButton(select.querySelector(".question"));
    var EmailError = document.createElement("p");
    var EmailStart = document.createElement("input");
    EmailStart.type = "email";
    EmailStart.classList.add("question_mail");
    select.querySelector(".question").appendChild(EmailStart);
    var EmailLabel = document.createElement("label");
    EmailLabel.innerHTML = "Email";
    EmailLabel.classList.add("question_name_label");
    select.querySelector(".question").appendChild(EmailLabel);
    var buttonStart = select.querySelector(".question_btn_start");
    buttonStart.disabled = true;
    EmailStart.addEventListener("input", function (event) {
      buttonStart.disabled = EmailStart.value == "";
    });
    buttonStart.addEventListener("click", function (event) {
      if (EmailStart.value != "") {
        this.disabled = false;
        mail_val = EmailStart.value;
        if (validateEmail(mail_val) == true) {
          WritePhone();
        } else if (EmailError.innerHTML == "") {
          select.querySelector(".question").appendChild(EmailError);
          EmailError.innerHTML =
            "Указанный адрес не является действительным адресом электронной почты.";
        }
      } else {
        EmailStart.value = "";
        this.disabled = true;
      }
    });
  }
  function WritePhone() {
    delButton(select.querySelector(".question"));
    var TelError = document.createElement("p");
    var TelStart = document.createElement("input");
    TelStart.id = "phone";
    TelStart.type = "tel";
    TelStart.classList.add("question_tel");
    select.querySelector(".question").appendChild(TelStart);
    var TelLabel = document.createElement("label");
    TelLabel.innerHTML = "Тел.";
    TelLabel.classList.add("question_name_label");
    select.querySelector(".question").appendChild(TelLabel);
    var buttonStart = select.querySelector(".question_btn_start");
    buttonStart.disabled = true;
    buttonStart.id = "payment_check_btn";
    TelStart.addEventListener("input", function (event) {
      buttonStart.disabled = TelStart.value.length < 11;
    });
    buttonStart.addEventListener("click", function (event) {
      if (TelStart.value != "") {
        this.disabled = false;
        tel_val = TelStart.value;
        tel_val = tel_val.substr(-10);
        if ($("#phone").intlTelInput("isValidNumber")) {
          printQuestion();
        } else if (TelError.innerHTML == "") {
          select.querySelector(".question").appendChild(TelError);
          TelError.innerHTML = "Указанный номер не является действительным.";
        }
      } else {
        TelStart.value = "";
        this.disabled = true;
      }
    });
  }
  function nextQuestion(choice) {
    nowQuestion++;
    printQuestion(choice);
  }

  function printQuestion(choice) {
    select.querySelector(".questionnaire_rules").classList.remove("none");
    var Questionnaire_done = document.querySelector(".questionnaire_done");
    if (all_quest <= 33) {
      Questionnaire_done.innerHTML = `Сделано: ${all_quest} / 33`;
      all_quest++;
    }
    select.querySelector(".question").innerHTML =
      arrayQuestions[nowQuestion].question;
    if (choice && choice != 0) {
      choice_array.push(choice);
    }
    if (
      arrayQuestions[nowQuestion].question !=
      "Твой аккаунт успешно создан.Проверяй почту,чтобы узнать логин и пароль"
    ) {
      printButton();
    } else {
      delButton(select.querySelector(".questionnaire_buttons"));
      QuestEnd();
    }
  }

  function printButton() {
    var q = 5,
      selectButton = select.querySelector(".questionnaire_buttons");
    delButton(selectButton);
    selectButton.classList.add("questionnaire_numbers");
    var QuestButton = document.createElement("input");
    QuestButton.type = "button";
    QuestButton.classList.add("question_btn");

    for (var i = 0; i < q; i++) {
      var val = arrayQuestions[nowQuestion].arrAnswer[i],
        nxt = arrayQuestions[nowQuestion].arrToQuestion[i],
        newButton = document.createElement("input");
      newButton.type = "radio";
      newButton.name = "choice";
      newButton.classList.add("number_btn");
      newButton.data = nxt;
      newButton.id = `choice_${nxt}`;

      newLabel = document.createElement("label");
      newLabel.htmlFor = `choice_${nxt}`;
      newLabel.innerHTML = newButton.data;

      QuestItem = document.createElement("div");
      QuestItem.classList.add("question_item");

      selectButton.appendChild(QuestItem);
      QuestItem.appendChild(newButton);
      QuestItem.appendChild(newLabel);

      QuestButton.disabled = true;
      newButton.addEventListener("click", OpenNextBtn);
    }
    selectButton.after(QuestButton);
  }
  function OpenNextBtn() {
    QuestButton = select.querySelector(".question_btn");
    if (this.checked == true) {
      QuestButton.disabled = false;
      var choice = this.data;
      QuestButton.onclick = function () {
        nextQuestion(choice);
      };
    } else {
      QuestButton.disabled = true;
    }
  }
  function delButton(selector) {
    while (selector.firstChild) {
      selector.removeChild(selector.firstChild);
    }
    if (select.querySelector(".question_btn")) {
      QuestButton = select.querySelector(".question_btn");
      QuestButton.remove();
    }
  }
  function QuestEnd() {
    var sum1 = 0;
    var sum2 = 0;
    var sum3 = 0;
    var q1 = 10;
    var q2 = 23;
    var q3 = 32;
    for (var i = 0; i < q1; i++) {
      sum1 += choice_array[i] / 10;
    }
    for (var i = q1; i < q2; i++) {
      sum2 += choice_array[i] / 13;
    }
    for (var i = q2; i <= q3; i++) {
      sum3 += choice_array[i] / 10;
    }
    let result;
    if (
      (sum1 > 2.4 && sum2 > 1.8 && sum3 > 2.7) ||
      (sum1 > 2.4 && sum2 > 1.8)
    ) {
      result = 4;
    } else if ((sum2 > 1.8 && sum3 > 2.7) || sum2 > 1.8) {
      result = 1;
    } else if ((sum1 > 2.4 && sum3 > 2.7) || sum1 > 2.4) {
      result = 3;
    } else {
      result = 2;
    }
    document.querySelector("#answer_input").value = result;
    document.querySelector("#user_name").value = name_val;
    document.querySelector("#user_mail").value = mail_val;
    document.querySelector("#user_tel").value = tel_val;
    document.querySelector(".answer_input_btn").click();
  }
};

if (document.querySelector(".questionTree")) {
  var question = new questionTree(".questionTree");

  question.addQuestion(
    "1. Если ваш вес начинает нарастать, вы едите меньше обычного? "
  );
  question.addQuestion(
    "2. Стараетесь ли вы есть меньше, чем вам хотелось бы во время обычного приёма пищи? "
  );
  question.addQuestion(
    "3. Часто ли вы отказываетесь от еды и питья из-за того, что беспокоитесь о своём весе?"
  );
  question.addQuestion(
    "4. Аккуратно ли вы контролируете количество съеденного?"
  );
  question.addQuestion(
    "5. Выбираете ли вы пищу преднамеренно , чтобы похудеть?"
  );
  question.addQuestion(
    "6. Если вы переели, будете ли вы на следующий день есть меньше?"
  );
  question.addQuestion(
    "7. Стараетесь ли вы есть меньше, чтобы не поправиться? "
  );
  question.addQuestion(
    "8. Часто ли вы стараетесь не есть между обычными приёмами пищи из-за того, что следите за своим весом?"
  );
  question.addQuestion(
    "9. Часто ли вы стараетесь не есть вечером из-за того, что следите за своим весом? "
  );
  question.addQuestion("10. Имеет ли значение ваш вес, когда вы едите?");
  question.addQuestion(
    "11. Возникает ли у вас желание есть, когда вы раздражены?"
  );
  question.addQuestion(
    "12. Возникает ли у вас желание есть, когда вам нечего делать?"
  );
  question.addQuestion(
    "13. Возникает ли у вас желание есть, когда вы подавлены или обескуражены?"
  );
  question.addQuestion(
    "14. Возникает ли у вас желание есть, когда вам одиноко?"
  );
  question.addQuestion(
    "15. Возникает ли у вас желание есть, когда вас кто-либо подвёл? "
  );
  question.addQuestion(
    "16. Возникает ли у вас желание есть, когда вам что либо препятствует, встаёт на вашем пути, или нарушаются ваши планы, либо что то не удаётся?"
  );
  question.addQuestion(
    "17. Возникает ли у вас желание есть, когда вы предчувствуете какую-либо неприятность?"
  );
  question.addQuestion(
    "18. Возникает ли у вас желание есть, когда вы встревожены, озабочены или напряжены? "
  );
  question.addQuestion(
    "19. Возникает ли у вас желание есть, когда «всё не так», «всё валится из рук»? "
  );
  question.addQuestion(
    "20. Возникает ли у вас желание есть, когда вы испуганы?"
  );
  question.addQuestion(
    "21. Возникает ли у вас желание есть, когда вы разочарованы, когда разрушены ваши надежды? "
  );
  question.addQuestion(
    "22. Возникает ли у вас желание есть, когда вы взволнованы, расстроены?"
  );
  question.addQuestion(
    "23. Возникает ли у вас желание есть, когда вы скучаете, утомлены, неспокойны? "
  );
  question.addQuestion(
    "24. Едите ли вы больше чем обычно, когда еда вкусная? "
  );
  question.addQuestion(
    "25. Если еда хорошо выглядит и хорошо пахнет, едите ли вы больше обычного? "
  );
  question.addQuestion(
    "26. Если вы видите вкусную пищу и чувствуете её запах, едите ли вы больше обычного?"
  );
  question.addQuestion(
    "27. Если у вас есть что-либо вкусное, съедите ли вы это немедленно? "
  );
  question.addQuestion(
    "28. Если бы проходите мимо булочной (кондитерской), хочется ли вам купить что-либо вкусное?"
  );
  question.addQuestion(
    "29. Если вы проходите мимо закусочной или кафе, хочется ли вам купить что либо вкусное? "
  );
  question.addQuestion(
    "30. Если вы видите, как едят другие, появляется ли у вас желание есть? "
  );
  question.addQuestion(
    "31. Можете ли вы остановиться, если едите что либо вкусное?"
  );
  question.addQuestion(
    "32. Едите ли вы больше чем обычно в компании (когда едят другие)? "
  );
  question.addQuestion("33. Когда вы готовите пищу, часто ли вы её пробуете?");
  question.addQuestion(
    "Твой аккаунт успешно создан.Проверяй почту,чтобы узнать логин и пароль"
  );

  question.startQuestions();
}

function NoAccessLess(main_less_link) {
  main_less_link.forEach(function (entry) {
    const no_access = entry.parentElement;
    const curriculum_btn =
      no_access.parentElement.querySelector(".curriculum_btn");
    curriculum_btn.classList.add("none");
    no_access.classList.add("no_access");


    const main_less_img =
      no_access.parentElement.querySelector(".main_less_img");
    if (main_less_img) {
      main_less_img.style.background = "#a7a7a7";
    };
    var next_stage = document.createElement("p");
    var next_stage_txt = document.createTextNode("Доступ открывается каждую неделю");
    next_stage.classList.add("next_stage");
    next_stage.appendChild(next_stage_txt);
    no_access.appendChild(next_stage);


    entry.remove();
    if (window.innerWidth <= 720) {
      const mobile_no_access = no_access.parentElement.parentElement;
      mobile_no_access.style.background =
        "url(wp-content/themes/my-theme/images/padlock.svg) no-repeat center #212121a6";
      mobile_no_access.style.backgroundSize = "80px";
      mobile_no_access.classList.add("no_access");
    }
  });
}
var open_indiv_arr = [];
let open_main_arr = [];
function CloseIndivLess(individ_id) {
  if (individ_id) {
    const open_individ_arr = [];
    let individ_links;
    if (window.innerWidth <= 720) {
      individ_links = document.querySelectorAll(".mobile_individ_link");
    } else {
      individ_links = document.querySelectorAll(".individ_less_link");
    }

    const all_individ_link = Array.prototype.slice.call(individ_links);
    const individ_arr = Array.prototype.slice.call(individ_links);

    for (let i = 0; i < individ_id.length; i++) {
      const individ_link = Array.from(individ_links).find((e) =>
        e.href.includes(`individual_content?id=${individ_id[i]}`)
      );
      open_individ_arr.push(individ_link);
    }
    for (var i = 0; i < all_individ_link.length; i++) {
      for (var j = 0; j < open_individ_arr.length; j++) {
        if (all_individ_link[i] === open_individ_arr[j]) {
          const check_open_link = all_individ_link.indexOf(all_individ_link[i]);
          if (check_open_link !== -1) {
            all_individ_link.splice(check_open_link, 1);
          }
        }
      }
    }
    NoAccessLess(all_individ_link);
    open_indiv_arr = individ_arr.filter((x) => !all_individ_link.includes(x));
  } else {
    console.log("Нет индивид контента");
  }
}
function OpenStage(open_stage_num, individ_arr) {
  let individ_links;
  if (window.innerWidth <= 720) {
    main_list = document.querySelectorAll(".main_stage_link a");
  } else {
    main_list = document.querySelectorAll(".main_less_link");
  }
  const all_main_arr = Array.prototype.slice.call(main_list);
  const main_arr = Array.prototype.slice.call(main_list);
  main_arr.splice(0, open_stage_num);
  NoAccessLess(main_arr);
  open_main_arr = all_main_arr.filter((x) => !main_arr.includes(x));
  const individ_id = individ_arr.filter(function (item, pos) {
    return individ_arr.indexOf(item) == pos;
  });
  CloseIndivLess(individ_id);

  $(window).on("resize", function () {
    OpenStage(open_stage_num, individ_arr);
  });
  MainIndivStage();
}
function MainIndivStage() {
  let main = open_main_arr.toString().replace(/,/g, " ").split(" ");
  let individual = open_indiv_arr.toString().replace(/,/g, " ");
  let all_main = document.querySelectorAll(".main_less").length;
  var json = {
    main: main,
    individual: individual,
    all_main: all_main,
  };
  $.ajax({
    type: "POST",
    url: "https://nezhno.space/auth-check/",
    data: json,
    success: function (data) { },
  });
}

$(".reg_btn").prop("disabled", true);
$(".reg_checkbox_item").bind("change", function () {
  if ($(this).is(":checked")) {
    $(".reg_btn").prop("disabled", false);
  } else {
    $(".reg_btn").prop("disabled", true);
  }
});

if (document.querySelector(".les_hw")) {
  var doSomething = function (err, values) {
    function Repeats() {
      for (var b = 0; b < err.length; b++) if (err[b] !== false) return !1;
      return !0;
    }
    if (Repeats()) {
      val = values.join("^");
      $("#survey_value").val(val);
      $("#survey_btn").click();
    }
  };
  var url = window.location.href;
  var id = url.substring(url.lastIndexOf("id=") + 3);
  var admin = document.location.pathname;
  var schema = {
    options: {
      hideNotReq: true,
    },
    title: {
      label: "Тест",
      className: "survey_title",
    },
    submitButton: {
      label: "Отправить",
      className: "classic_btn",
      type: "submit",
    },
    onSubmit: doSomething,
  };
  if (id == 2) {
    schema.body = [
      {
        label: "Опиши кратко свою стратегию здесь, пожалуйста: ",
        tag: "textarea",
      },
      {
        label: "С чем в большей степени связана твоя стратегия?",
        tag: "radio",
        data: [
          { value: "1", label: "с определенными мыслями" },
          { value: "2", label: "с чувствами или эмоциональными состояниями" },
          { value: "3", label: "с внешними ситуациями или событиями" },
        ],
      },
    ];
  }
  if (id == 3) {
    schema.body = [
      {
        label:
          "Выдели свои вторичные выгоды. Что хорошее делает для тебя нарушение пищевого поведения?",
        tag: "checkbox",
        data: [
          {
            value: "1",
            label:
              "«дает разрешение» уйти от неприятной ситуации или от решения сложной проблемы",
          },
          {
            value: "2",
            label:
              "предоставляет возможность получить заботу, любовь, внимание окружающих",
          },
          {
            value: "3",
            label:
              "отпадает необходимость соответствовать тем высочайшим требованиям, которые предъявля­ют к вам окружающие и вы сами",
          },
        ],
      },
      {
        label:
          "Какого элемента оптимальной родительской позиции тебе не хватало больше всего?",
        tag: "radio",
        data: [
          { value: "1", label: "адекватность" },
          { value: "2", label: "гибкость" },
          { value: "3", label: "прогностичность" },
        ],
      },
      {
        label: "Какой стиль воспитания больше всего ты ощущал?",
        tag: "radio",
        data: [
          { value: "1", label: "авторитарный" },
          { value: "2", label: "демократический" },
          { value: "3", label: "попустительский" },
          { value: "4", label: "хаотический" },
          { value: "5", label: "опекающий" },
        ],
      },
    ];
  }
  if (id == 4) {
    schema.body = [
      {
        label:
          "Опиши идеал в форме и весе тела. Что оказало влияние на его формирование? Как он до сих пор поддерживается?",
        tag: "textarea",
      },
      {
        label:
          "Выпиши, пожалуйста, хотя бы 3 своих самых задевающих триггера, которые напоминают тебе о весе или необходимости контролировать себя с едой.",
        tag: "textarea",
      },
      {
        label:
          "В виде какого образа представляется та часть, которая стыдит? Чьим голосом она говорит?",
        tag: "radio",
        data: [
          { value: "1", label: "мама/папа" },
          {
            value: "2",
            label:
              "родственник: бабушка, тетя, двоюродный племянник троюродного деверя",
          },
          { value: "3", label: "друг/коллега/одноклассник/одногруппник" },
          {
            value: "4",
            label: "кто-то обладающий авторитетом: тренер, учитель, начальник",
          },
          { value: "5", label: "левый прохожий/селебрити/незнакомый образ" },
          { value: "6", label: "ты" },
        ],
      },
    ];
  }
  if (id == 5) {
    schema.body = [
      {
        label:
          "У тебя есть в опыте физическое/ сексуальное/ эмоциональное насилие/ буллинг",
        tag: "checkbox",
        data: [{ value: "1", label: "да" }],
      },
      {
        label:
          "Если ты хочешь поделиться с нами своим рассказом из упражнения “Офрендас”, напиши его здесь, пожалуйста:",
        tag: "textarea",
      },
      {
        label:
          "На каком уровне по пирамиде Дилтса лежит решение твоей проблемы?",
        tag: "radio",
        data: [
          { value: "1", label: "поведение" },
          { value: "2", label: "навыки" },
          { value: "3", label: "ценности" },
          { value: "4", label: "идентичность" },
          { value: "5", label: "миссия" },
        ],
      },
    ];
  }
  if (id == 6) {
    schema.body = [
      {
        label:
          "Отметь чувства, которые ты испытываешь из-за процесса легализации:",
        tag: "checkbox",
        data: [
          { value: "1", label: "тревога" },
          { value: "2", label: "злость" },
          { value: "3", label: "раздражение" },
        ],
      },
      {
        label:
          "В фазе легализации все немного набирают вес. Тело мстит за годы отказа и депривации. Поделись своими переживаниями с нами",
        tag: "textarea",
      },
      {
        label:
          "Удалось ли отследить изменения состояния от физического голода до насыщения в упражнении Вилка?",
        tag: "checkbox",
        data: [{ value: "1", label: "да" }],
      },
      {
        label:
          "Удалось ли почувствовать разные уровни насыщения в упражнении Вкусняшка?",
        tag: "checkbox",
        data: [{ value: "1", label: "да" }],
      },
    ];
  }
  if (id == 7) {
    schema.body = [
      { label: "Что я получила из опыта прохождения курса?", tag: "textarea" },
      {
        label:
          "Какой момент в курсе ты бы назвала поворотным? Этап или упражнение индивидуального маршрута, которое попало в самую точку и позволило дальше раскрутить клубок? Опиши свой опыт, пожалуйста:",
        tag: "textarea",
      },
      {
        label:
          "С чем мне было сложно справиться? Где требуется больше внимания? Выбери этап:",
        tag: "radio",
        data: [
          { value: "1", label: "2" },
          { value: "2", label: "3" },
          { value: "3", label: "4" },
          { value: "4", label: "5" },
          { value: "5", label: "6" },
        ],
      },
      { label: "Опиши свою трудность, пожалуйста:", tag: "textarea" },
    ];
  }
  if (id == 8) {
    schema.body = [
      {
        label: "Выдели моменты про тебя",
        tag: "checkbox",
        data: [
          {
            value: "1",
            label: "я плохо различаю/ редко обращаю внимания на сигналы тела",
          },
          {
            value: "2",
            label: "мне сложно получать удовольствие от физической активности",
          },
          { value: "3", label: "я плохо понимаю/чувствую размеры своего тела" },
          { value: "3", label: "мне сложно соединить эмоции и тело" },
          {
            value: "3",
            label: "я стыжусь себя и своего тела в сексуальном контакте",
          },
        ],
      },
    ];
  }
  new Survey().create(document.getElementById("survey"), schema);
}

(adsbygoogle = window.adsbygoogle || []).push({});

(function (i, s, o, g, r, a, m) {
  i["GoogleAnalyticsObject"] = r;
  (i[r] =
    i[r] ||
    function () {
      (i[r].q = i[r].q || []).push(arguments);
    }),
    (i[r].l = 1 * new Date());
  (a = s.createElement(o)), (m = s.getElementsByTagName(o)[0]);
  a.async = 1;
  a.src = g;
  m.parentNode.insertBefore(a, m);
})(window, document, "script", "//www.google-analytics.com/analytics.js", "ga");

ga("create", "UA-46156385-1", "cssscript.com");
ga("send", "pageview");

$(".form-switch input").click(function () {
  if (!$(this).is(":checked")) {
    $("#your_program").prop("disabled", true);
    $(".familiar p").fadeTo("slow", 0.5);
  } else {
    $("#your_program").prop("disabled", false);
    $(".familiar p").fadeTo("slow", 1);
  }
});

$(".q-answer").keyup(function () {
  this.value = this.value.replace(/\^/g, "");
  if (this.value.length > 1000) {
    this.value = this.value.substr(0, 1000);
  }
});

// Валидация перед оплатой
function isCorrectFIO(fio) {
  if (!fio) {
    return false;
  }
  var fioA = fio.split(" ");
  if (fioA.length !== 3) {
    return false;
  }
  for (var i = 0; i < 3; i++) {
    if (/[^-А-ЯA-Z\x27а-яa-z]/.test(fioA[i])) {
      return false;
    }
  }
  return true;
}

payment_check_btn = document.querySelector("#payment_check_btn");

$("#pay_mail").change(function (e) {
  let pay_mail = document.querySelector("#pay_mail");
  if (pay_mail.value != "") {
    mail_val = pay_mail.value;
    let EmailError = document.querySelector("#error_mail");
    if (validateEmail(mail_val)) {
      EmailError.classList.add("none");
      pay_mail.classList.remove("error");
      payment_check_btn.removeAttribute("disabled");
    } else {
      EmailError.classList.remove("none");
      pay_mail.classList.add("error");
      payment_check_btn.setAttribute("disabled", "true");
    }
  } else {
    EmailStart.value = "";
    payment_check_btn.setAttribute("disabled", "true");
  }
});
$("#full_name").change(function (e) {
  let full_name = $("#full_name"),
    errorMsg = $("#error_name");
  if (!isCorrectFIO(full_name.val())) {
    full_name.addClass("error");
    errorMsg.removeClass("none").text("Некорректный номер телефона");
    payment_check_btn.setAttribute("disabled", "true");
  } else {
    errorMsg.addClass("none");
    full_name.removeClass("error");
    payment_check_btn.removeAttribute("disabled");
  }
});

document.oninput = function () {
  var input = document.querySelector("#phone");
  if (input) {
    input.value = input.value.replace(/[^\+\d]/g, "");
    if (input.value.length > 12) {
      input.value = input.value.substring(0, 12);
    }
  }
};
var telInput = $("#phone"),
  errorMsg = $("#error_phone");

// инициализация плагина
if (document.querySelector("#phone")) {
  var iti = $("#phone").intlTelInput({
    formatOnDisplay: false,
    defaultCountry: "auto",
    geoIpLookup: function (callback) {
      $.get("https://ipinfo.io", function () { }, "jsonp").always(function (
        resp
      ) {
        var countryCode = resp && resp.country ? resp.country : "";
        callback(countryCode);
      });
    },
    utilsScript: "/wp-content/themes/my-theme/libs/phone/js/utils.js",
    onlyCountries: ["by", "ru", "ua"],
    preferredCountries: ["ru"],
    defaultCountry: "ru",
    nationalMode: true,
    // если в окне набора номера вписан код страны, то удалить его и переписать заново
    autoHideDialCode: false,
  });
}




// валидация при потере фокуса


function ValNumber(check_btn) {
  if ($.trim(telInput.val())) {
    var check_btn = document.querySelector(check_btn);
    if (telInput.intlTelInput("isValidNumber")) {
      errorMsg.addClass("none");
      let full_name = $("#full_name").val();
      if (isCorrectFIO(full_name) && check_btn !== null) {
        check_btn.removeAttribute("disabled");
      }
    } else {
      telInput.addClass("error");
      errorMsg.removeClass("none").text("Некорректный номер телефона");
      if (check_btn !== null) {
        check_btn.setAttribute("disabled", "true");
      }
    }
  } else {
    telInput.addClass("error");
    errorMsg.removeClass("none").text("Введите номер телефона");
  }
}
telInput.blur(function () {
  var check_btn = "#payment_check_btn";
  ValNumber(check_btn);
});








// сброс при нажатии на клавишу
telInput.keydown(function () {
  telInput.removeClass("error");
  errorMsg.addClass("none");
});

$('input[name="rating-star2"]').click(function (e) {
  let individ_rating_btn = document.getElementById("individ_rating_btn");
  individ_rating_btn.style.opacity = "1";
  individ_rating_btn.removeAttribute("disabled");
});
$("#individ_rating_btn").click(function (e) {
  e.preventDefault();
  let rating;
  [].forEach.call(
    document.querySelectorAll('input[name="rating-star2"]'),
    function (el) {
      if (el.checked) {
        rating = el.value;
      }
    }
  );
  if (rating == undefined) {
    rating = 1;
  }
  var search = window.location.search.substr(1),
    keys = {};
  search.split("&").forEach(function (item) {
    item = item.split("=");
    keys[item[0]] = item[1];
  });
  keys["rating"] = rating;
  $.ajax({
    type: "POST",
    url: "https://nezhno.space/lesson_check/",
    data: keys,
    success: function (data) {
      $(".rating_success").html(
        '<div class="rating_success_item"><p>Моя оценка Индивидуальному этапу: ' +
        keys["rating"] +
        "</p></div>"
      );
    },
  });
});

//PUBLICATION   BTN

$(".publication_btn").click(function (e) {
  let publication_btn_val = JSON.parse("[" + this.value + "]");
  var publication_status = {
    publication_status: 1,
    publication_btn_val: publication_btn_val,
  };
  $.ajax({
    type: "POST",
    url: "https://nezhno.space/admin_check/",
    data: publication_status,
    success: function (data) {
      $(".publication_btn").html("Добавлено");
      $(".publication_btn").prop("disabled", true);
    },
  });
});

$(".form-switch").change(function (e) {
  let checkbox = document.querySelector(".form-switch input");
  if (checkbox.checked == true) {
    $.ajax({
      type: "POST",
      url: "https://nezhno.space/auth-check/",
      data: { route_val: 6 },
      success: function (data) { },
    });
  }
});



$(".recognized_yourself a").on("click", function (e) {
  e.preventDefault();
  var anchor = $(this).attr('href');
  $('html, body').stop().animate({
    scrollTop: $(anchor).offset().top - 60
  }, 800);
});



$("#promocode_btn").click(function (e) {

  e.preventDefault();

  $("input").removeClass("error");
  $(".promocode_msg").addClass("none");
  $("#error_phone").addClass("none");
  let promocode = $('input[name="promocode"]').val();
  let user_tel = $('input[name="user_tel"]').val();
  if (promocode === "") {
    $(".promocode_msg").removeClass("none").text("Введите промокод");
    $("#promocode_input").addClass("error");
  } else if (user_tel === "" || !telInput.intlTelInput("isValidNumber")) {
    if (user_tel === "") {
      $("#phone").addClass("error");
      $("#error_phone").removeClass("none").text("Введите номер телефона");
    } else {
      $("#error_phone").removeClass("none").text("Некорректный номер телефона");
    }
    $("#phone").addClass("error");
  } else {

    let formData = new FormData();
    formData.append("promocode", promocode);
    formData.append("user_tel", user_tel);

    $.ajax({
      url: "https://nezhno.space/promocode_check/",
      type: "POST",
      dataType: "json",
      processData: false,
      contentType: false,
      cache: false,
      data: formData,
      success: function (data) {
        if (data.status) {
          $(".promocode").fadeOut(500, function () {
            let success_txt = '<div class="promocode_title"><h2>Теперь Вам доступны уроки</h2></div>';
            let success_svg = $(".promocode_svg").html();
            $(".promocode").html(success_txt + success_svg);
            $(".promocode svg").removeClass('none');
            $('.promocode').css('text-align', 'center');
            $(".promocode").fadeIn(1000);
            setTimeout(function () {
              window.location.reload(1);
            }, 1500);
          });
        } else {
          if (data.type == 1) {
            $(".promocode_msg").removeClass("none").text(data.message);
            $("#promocode_input").addClass("error");
          }
          if (data.type == 2) {
            $("#error_phone").removeClass("none");
          }

        }
      },
      error: function (jqxhr, status, errorMsg) {
        console.log(status, errorMsg);
      },
    });
  };
});
