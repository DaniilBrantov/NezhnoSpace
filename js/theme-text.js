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
    2: [
      {
        title: "Общее",
        text: "Тема 2: Общее",
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 2: Рекомендуемая система",
      },
      {
        title: "Дневник питания",
        text: "Тема 2: Дневник питания",
      },
      {
        title: "Тренажер",
        text: "Тема 2: Тренажер",
      },
    ],
    3: [
      {
        title: "Общее",
        text: "Тема 3: Общее",
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 3: Рекомендуемая система",
      },
      {
        title: "Дневник питания",
        text: "Тема 3: Дневник питания",
      },
      {
        title: "Тренажер",
        text: "Тема 3: Тренажер",
      },
    ],
    4: [
      {
        title: "Общее",
        text: "Тема 4: Общее",
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 4: Рекомендуемая система",
      },
      {
        title: "Дневник питания",
        text: "Тема 4: Дневник питания",
      },
      {
        title: "Тренажер",
        text: "Тема 4: Тренажер",
      },
    ],
    5: [
      {
        title: "Общее",
        text: "Тема 5: Общее",
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 5: Рекомендуемая система",
      },
      {
        title: "Дневник питания",
        text: "Тема 5: Дневник питания",
      },
      {
        title: "Тренажер",
        text: "Тема 5: Тренажер",
      },
    ],
    6: [
      {
        title: "Общее",
        text: "Тема 6: Общее",
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 6: Рекомендуемая система",
      },
      {
        title: "Дневник питания",
        text: "Тема 6: Дневник питания",
      },
      {
        title: "Тренажер",
        text: "Тема 6: Тренажер",
      },
    ],
    7: [
      {
        title: "Общее",
        text: "Тема 7: Общее",
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 7: Рекомендуемая система",
      },
      {
        title: "Дневник питания",
        text: "Тема 7: Дневник питания",
      },
      {
        title: "Тренажер",
        text: "Тема 7: Тренажер",
      },
    ],
    8: [
      {
        title: "Общее",
        text: "Тема 8: Общее",
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 8: Рекомендуемая система",
      },
      {
        title: "Дневник питания",
        text: "Тема 8: Дневник питания",
      },
      {
        title: "Тренажер",
        text: "Тема 8: Тренажер",
      },
    ],
  };








  const list = document.querySelector(".trial_list");
  const text = document.querySelector(".trial_description-text");

  document.addEventListener("DOMContentLoaded", function () {
    const subtitle = document.querySelectorAll(".trial_nested-list li");

    //desktop
    subtitle.forEach((li) => {
      li.addEventListener("click", function () {
        arrayThemes[li.closest(".trial_item").id].forEach((elem) => {
          if (elem.title === li.innerText) {
            text.querySelector('p').textContent = elem.text;
          }
        });
      });
    });

    //dropdown
    var $window = $(window);
    //mobile
    const mobileSubtitle = document.querySelectorAll(".trial_nested-list_mobile li");
    const mobileTitle = document.querySelectorAll('.trial_title');

    if ($window.width() < 960) {
      mobileSubtitle.forEach((li) => {
        li.addEventListener("click", function () {
          arrayThemes[list.querySelector('.trial_title.active').id].forEach((elem) => {
            if (elem.title === li.innerText) {
              ActiveEl('trial_nested-list_mobile p', 'active');
              text.querySelector('p').textContent = elem.text;
            }
          });
        });
      });
      mobileTitle.forEach((title) => {
        title.addEventListener('click', function () {
          arrayThemes[title.id].forEach((elem) => {
            if (elem.title === document.querySelector('.trial_nested-list_mobile p.active').textContent) {
              ActiveEl('trial_title', 'active');
              text.querySelector('p').textContent = elem.text;
            }
          });
        })
      })
    } //desktop
    else if ($window.width() >= 960) {
      const list = document.querySelector(".trial_list");
      const elem = document.querySelectorAll(".trial_nested-list");
      if (elem) {
        elem.forEach((item) => {
          if (!item.classList.contains('active')) {
            item.style.display = 'none';
          }

          item.addEventListener('click', function (evt) {
            item.children.forEach((el) => el.classList.remove('show-active'));
            evt.target.parentNode.classList.add('show-active');

            if (evt.target instanceof HTMLParagraphElement) {
              document.querySelector(".trial_description-title").textContent = evt.target.textContent;
            }
          })
        })
      };

      if (list) {
        list.addEventListener("click", (evt) => {
          if (evt.target.classList.contains("trial_title")) {
            evt.target.classList.toggle("active");

            evt.target.parentNode.querySelector('.trial_nested-list').classList.toggle('active');
            evt.target.parentNode.querySelector('.trial_nested-list').style.display = '';
            document.querySelector(".trial_description-title").textContent = evt.target.parentNode.querySelector(".show-active").textContent;
            //изменение контента в зависимости от id
            arrayThemes[evt.target.id].forEach((elem) => {
              if (elem.title === evt.target.closest('.trial_item').querySelector('.show-active').innerText) {
                text.querySelector('p').textContent = elem.text;
              }
            });


            [...document.querySelectorAll(".trial_title")].map((el) => {
              if (el !== evt.target) {
                el.classList.remove("active");
                el.parentNode.querySelector('.trial_nested-list').classList.remove('active');
                el.parentNode.querySelector('.trial_nested-list').style.display = 'none';
              }
            });
          }
        });
      };
    }
  });

  //начальная отрисовка тем
  Object.keys(arrayThemes).forEach((key) => {
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
  });

  $.getJSON("processing",
    function (data) {
      console.log(data);
    });

})();
