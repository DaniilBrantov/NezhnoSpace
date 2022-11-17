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
        audioName: 'ogranich_type'
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 1: Рекомендуемая система",
        audioName: 'smesh_type'
      },
      {
        title: "Дневник питания",
        text: "Тема 1: Дневник питания",
        audioName: 'ekstern_type'
      },
      {
        title: "Тренажер",
        text: "Тема 1: Тренажер",
        audioName: 'coldplay-paradise'
      },
    ],
    2: [
      {
        title: "Общее",
        text: "Тема 2: Общее",
        audioName: 'ogranich_type'
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 2: Рекомендуемая система",
        audioName: 'ekstern_type'
      },
      {
        title: "Дневник питания",
        text: "Тема 2: Дневник питания",
        audioName: 'smesh_type'
      },
      {
        title: "Тренажер",
        text: "Тема 2: Тренажер",
        audioName: 'coldplay-paradise'
      },
    ],
    3: [
      {
        title: "Общее",
        text: "Тема 3: Общее",
        audioName: 'ogranich_type'
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 3: Рекомендуемая система",
        audioName: 'ekstern_type'
      },
      {
        title: "Дневник питания",
        text: "Тема 3: Дневник питания",
        audioName: 'smesh_type'
      },
      {
        title: "Тренажер",
        text: "Тема 3: Тренажер",
        audioName: 'coldplay-paradise'
      },
    ],
    4: [
      {
        title: "Общее",
        text: "Тема 4: Общее",
        audioName: 'ogranich_type'
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 4: Рекомендуемая система",
        audioName: 'ekstern_type'
      },
      {
        title: "Дневник питания",
        text: "Тема 4: Дневник питания",
        audioName: 'coldplay-paradise'
      },
      {
        title: "Тренажер",
        text: "Тема 4: Тренажер",
        audioName: 'smesh_type'
      },
    ],
    5: [
      {
        title: "Общее",
        text: "Тема 5: Общее",
        audioName: 'ogranich_type'
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 5: Рекомендуемая система",
        audioName: 'ekstern_type'
      },
      {
        title: "Дневник питания",
        text: "Тема 5: Дневник питания",
        audioName: 'smesh_type'
      },
      {
        title: "Тренажер",
        text: "Тема 5: Тренажер",
        audioName: 'coldplay-paradise'
      },
    ],
    6: [
      {
        title: "Общее",
        text: "Тема 6: Общее",
        audioName: 'ogranich_type'
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 6: Рекомендуемая система",
        audioName: 'ekstern_type'
      },
      {
        title: "Дневник питания",
        text: "Тема 6: Дневник питания",
        audioName: 'smesh_type'
      },
      {
        title: "Тренажер",
        text: "Тема 6: Тренажер",
        audioName: 'coldplay-paradise'
      },
    ],
    7: [
      {
        title: "Общее",
        text: "Тема 7: Общее",
        audioName: 'ogranich_type'
      },
      {
        title: "Рекомендуемая система",
        text: "Тема 7: Рекомендуемая система",
        audioName: 'ekstern_type'
      },
      {
        title: "Дневник питания",
        text: "Тема 7: Дневник питания",
        audioName: 'smesh_type'
      },
      {
        title: "Тренажер",
        text: "Тема 7: Тренажер",
        audioName: 'coldplay-paradise'
      },
    ],
  };

  const list = document.querySelector(".trial_list");
  const text = document.querySelector(".trial_description-text");

  if (list) {
    document.addEventListener("DOMContentLoaded", function () {
      const subtitle = document.querySelectorAll(".trial_nested-list li");

      //desktop
      subtitle.forEach((li) => {
        li.addEventListener("click", function () {
          arrayThemes[li.closest(".trial_item").id].forEach((elem) => {
            if (elem.title === li.innerText) {
              //смена контента при клике на подтемы 
              text.querySelector("p").textContent = elem.text;
              document.querySelector('.audio').src = `wp-content/themes/my-theme/audio/${elem.audioName}.mp3`;
              document.querySelector('.player_title_text').innerText = elem.audioName;
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
            arrayThemes[list.querySelector(".trial_title.active").id].forEach(
              (elem) => {
                if (elem.title === li.innerText) {
                  ActiveEl("trial_nested-list_mobile p", "active");
                  //смена контента при клике на подтемы 
                  text.querySelector("p").textContent = elem.text;
                  document.querySelector('.audio').src = `wp-content/themes/my-theme/audio/${elem.audioName}.mp3`;
                  document.querySelector('.player_title_text').innerText = elem.audioName;
                }
              }
            );
          });
        });
        mobileTitle.forEach((title) => {
          //смена контента при клике на темы
          title.addEventListener("click", function () {
            arrayThemes[title.id].forEach((elem) => {
              if (elem.title === document.querySelector(".trial_nested-list_mobile p.active").textContent) {
                ActiveEl("trial_title", "active");
                text.querySelector("p").textContent = elem.text;
                document.querySelector('.audio').src = `wp-content/themes/my-theme/audio/${elem.audioName}.mp3`;
                document.querySelector('.player_title_text').innerText = elem.audioName;
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
                document.querySelector(".trial_description-title").textContent = evt.target.textContent;
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
              arrayThemes[evt.target.id].forEach((elem) => {
                if (
                  elem.title ===
                  evt.target
                    .closest(".trial_item")
                    .querySelector(".show-active").innerText
                ) {
                  text.querySelector("p").textContent = elem.text;
                  document.querySelector('.audio').src = `wp-content/themes/my-theme/audio/${elem.audioName}.mp3`;
                  document.querySelector('.player_title_text').innerText = elem.audioName;
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
      }
    });

    //начальная отрисовка тем
    Object.keys(arrayThemes).forEach((key) => {
      list.innerHTML += `
              <li class="trial_item" id=${key}>
                              <p id=${key} class="trial_title ${
        key == 1 ? "active" : ""
      }">Тема ${key}</p>
                              <ul class="trial_nested-list ${
                                key == 1 ? "active" : ""
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
  }
})();
