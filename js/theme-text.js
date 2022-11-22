(() => {
  const arrayThemes = {
    1: [
      {
        title: "Общее",
        text: `Тема 1: Общее  Цель гайда предложить тебе книги, фильмы, проекты, подкасты по принципу -
        ровно столько, сколько нужно.
        less is more Мозгу так легче сфокусироваться и сделать первый шаг.
        Цель гайда предложить тебе книги, фильмы, проекты, <span>подкасты</span>
        по принципу - ровно столько, сколько нужно. less is more. Мозгу так легче сфокусироваться и
        сделать
        первый
        шаг. Гайды Нежно Space - это не список литературы на лето. Ты можешь ограничиться цитатами
        из книг,
        которые`,
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 1: Рекомендуемая система",
      },
      {
        title: "Дневник питания",
        text: "Тема 1: Дневник питания",
      },
      {
        title: "Тренажер",
        text: "Тема 1: Тренажер",
      },
    ],
  };

  //Переменные
  const list = document.querySelector(".trial_list");
  const text = document.querySelector(".trial_description-text");

  //Выполнение функции при загрузке DOM
  document.addEventListener("DOMContentLoaded", function () {
    const subtitle = document.querySelectorAll(".trial_nested-list li");
    //Вывод объекта data из бд
    $.getJSON("processing", function (data) {
      data_db = data;
      // try_free_theme - это Тема,нажатая пользователем
      let try_free_theme = [];

      // Перебор объекта из бд.
      function EnumerationData(li) {
        $.each(data, function (i, val) {
          if (val.title == li.id) {
            try_free_theme.push(val);
          }
        });
      }

      //Разделение текста на обзацы
      var arrOfTxt;
      function SeparationTxt(txtToSplit) {
        text.querySelectorAll("p").forEach((el) => { el.remove() });
        arrOfTxt = txtToSplit.split('  ');
        return arrOfTxt
      }


      //desktop
      subtitle.forEach((li) => {
        li.addEventListener("click", function () {
          EnumerationData(li.closest(".trial_item"));

          //Определение активной подтемы
          try_free_theme.forEach((elem) => {
            if (elem.trial_theme === li.innerText) {
              SeparationTxt(elem.text).forEach((e) => {
                let create_txt = document.createElement('p');
                create_txt.innerHTML = e;
                text.append(create_txt);
                //try_free_theme = []
              })
              //text.querySelector("p").textContent = SeparationTxt(elem.text);
            }
          });
        });
      });

      //dropdown
      var $window = $(window);
      //mobile

      const mobileSubtitle = document.querySelectorAll(
        ".trial_nested-list_mobile li"
      );
      const mobileTitle = document.querySelectorAll(".trial_title");

      if ($window.width() < 960) {
        mobileSubtitle.forEach((li) => {
          li.addEventListener("click", function () {
            EnumerationData(list.querySelector(".trial_title.active"));

            //Определение активной подтемы
            try_free_theme.forEach((elem) => {
              if (elem.trial_theme === li.innerText) {
                mobileSubtitle.forEach((arr) => {
                  if (arr !== elem) arr.querySelector("p").classList.remove("active");
                });
                li.querySelector("p").classList.add("active");
                SeparationTxt(elem.text).forEach((e) => {
                  let create_txt = document.createElement('p');
                  create_txt.innerHTML = e;
                  text.append(create_txt);
                  try_free_theme = []
                })
                //text.querySelector("p").textContent = SeparationTxt(elem.text);
              }
            });
          });
        });
        mobileTitle.forEach((title) => {
          title.addEventListener("click", function () {
            EnumerationData(title);

            //Определение активной подтемы
            try_free_theme.forEach((elem) => {
              if (elem.trial_theme === document.querySelector(".trial_nested-list_mobile p.active").textContent) {
                mobileTitle.forEach((arr) => {
                  if (arr !== elem) arr.classList.remove("active");
                });
                title.classList.add("active");
                SeparationTxt(elem.text).forEach((e) => {
                  let create_txt = document.createElement('p');
                  create_txt.innerHTML = e;
                  text.append(create_txt);
                  try_free_theme = []
                })
                //text.querySelector("p").textContent = SeparationTxt(elem.text);
              }
            });
          });
        });
      } //desktop
      else if ($window.width() >= 960) {
        const list = document.querySelector(".trial_list");
        const elem = document.querySelectorAll(".trial_nested-list");
        if (elem) {
          elem.forEach((item) => {
            if (!item.classList.contains("active")) {
              item.style.display = "none";
            }

            item.addEventListener("click", function (evt) {
              item.children.forEach((el) => el.classList.remove("show-active"));
              evt.target.parentNode.classList.add("show-active");

              if (evt.target instanceof HTMLParagraphElement) {
                document.querySelector(".trial_description-title").textContent =
                  evt.target.textContent;
              }
            });
          });
        }

        if (list) {
          list.addEventListener("click", (evt) => {
            if (evt.target.classList.contains("trial_title")) {
              evt.target.classList.toggle("active");

              evt.target.parentNode
                .querySelector(".trial_nested-list")
                .classList.toggle("active");
              evt.target.parentNode.querySelector(
                ".trial_nested-list"
              ).style.display = "";
              document.querySelector(".trial_description-title").textContent =
                evt.target.parentNode.querySelector(".show-active").textContent;

              //изменение контента в зависимости от id

              EnumerationData(evt.target);

              try_free_theme.forEach((elem) => {
                if (
                  elem.trial_theme ===
                  evt.target
                    .closest(".trial_item")
                    .querySelector(".show-active").innerText
                ) {
                  SeparationTxt(elem.text).forEach((e) => {
                    let create_txt = document.createElement('p');
                    create_txt.innerHTML = e;
                    text.append(create_txt);
                    try_free_theme = []
                  })
                  //text.querySelector("p").textContent = SeparationTxt(elem.text);
                }
              });

              [...document.querySelectorAll(".trial_title")].map((el) => {
                if (el !== evt.target) {
                  el.classList.remove("active");
                  el.parentNode
                    .querySelector(".trial_nested-list")
                    .classList.remove("active");
                  el.parentNode.querySelector(
                    ".trial_nested-list"
                  ).style.display = "none";
                }
              });
            }
          });
        }
      };
    });
  });
  //начальная отрисовка тем
  Object.keys(arrayThemes).forEach((key) => {
    if (list) {
      list.innerHTML += `
              <li class="trial_item" id=${key}>
                              <p id=${key} class="trial_title ${key == 1 ? "active" : ""
        }">Тема ${key}</p>
                              <ul class="trial_nested-list ${key == 1 ? "active" : ""
        }">
                                  <li class="show-active">
                                      <p>Общее</p>
                                  </li>
                                  <li>
                                      <p class="trial_list-reference">Рекомендуемая система</p>
                                  </li>
                                  <li>
                                      <p class="trial_list-diary">Дневник питания</p>
                                  </li>
                              </ul>
                          </li>
              `;
    }
  });
})();
