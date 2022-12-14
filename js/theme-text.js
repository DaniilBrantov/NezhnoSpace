(() => {
  const list = document.querySelector(".trial_list");
  const text = document.querySelector(".trial_description");

  if (list) {
    const dataBase = {};
    const dataTheme = {};

    function activeElement(array, elem, activeClass) {
      array.forEach((arr) => {
        if (arr !== elem) arr.classList.remove(activeClass);
      });
      elem.classList.add(activeClass);
    }

    //скрыть тему, если в ней нет контента
    function subtitleVisible(arrayTitle, id) {
      let themeArray = [];
      dataBase[id].forEach((elem) => {
        if (elem.text) {
          themeArray.push(elem.theme);
        }
      });
      arrayTitle.forEach((subtitle) => {
        if (!themeArray.includes(subtitle.querySelector("p").textContent)) {
          subtitle.style.display = "none";
        } else {
          subtitle.style.display = "";
        }
      });
    }

    //функция на изменение контента
    function changeContent(elem) {
      //удаление текущего текста
      text.querySelector(".trial_description-text").innerHTML = "";
      text.querySelector(".trial_text-wrap").innerHTML = "";

      let paragraphs = elem.text.split("  ");

      //1 вариант
      if (elem.audio && elem.text.length > 300 && paragraphs.length > 2) {
        let firstText, lastText;

        //делим обзацы примерно пополам и рубим его по пробелу
        half_paragraphs = Math.floor(paragraphs.length / 2);
        firstText = paragraphs.slice(0, half_paragraphs).join("  ");
        lastText = paragraphs
          .slice(half_paragraphs + 1, paragraphs.length)
          .join("  ");

        let firstArray = firstText.split("  ");

        for (let i = 0; i < firstArray.length; i++) {
          text.querySelector(".trial_description-text").innerHTML += `
            <p>${firstArray[i]}</p>
          `;
        }

        let lastArray = lastText.split("  ");

        for (let i = 0; i < lastArray.length; i++) {
          text.querySelector(".trial_text-wrap").innerHTML += `
            <p class='trial_text ${i === 0 ? "trial_text-show" : ""}'>${lastArray[i]
            }</p>
          `;
        }
      } else {
        let arrayText = elem.text.split("  ");
        if (arrayText) {
          for (let i = 0; i < arrayText.length; i++) {
            text.querySelector(".trial_description-text").innerHTML += `
              <p>${arrayText[i]}</p>
            `;
          }
        } else {
          text.querySelector(".trial_description-text").innerHTML += `
          <p>${elem.text}</p>
        `;
        }
      }

      //смена заголовка темы
      document.querySelector(".trial_description-title").innerText = elem.theme;

      //смена аудиофайла и его остановка
      document.querySelector("audio").pause();
      if (document.querySelector(".pause")) {
        document.querySelector(".pause").classList.replace("pause", "play");
      }

      //скрывать плеер, если аудиофайла нет
      if (elem.audio) {
        document.querySelector(".trial_audio").style.display = "";
        document.querySelector(".player_title_text").innerText =
          elem.audioTitle;
        document.querySelector(
          "audio"
        ).src = `wp-content/themes/my-theme/audio/${elem.audio}.mp3`;
      } else {
        document.querySelector(".trial_audio").style.display = "none";
      }

      //скрыть плюс если нет скрытого текста
      if (document.querySelector('.trial_btn-show')) {
        if (document.querySelectorAll('.trial_text-wrap .trial_text').length <= 1) {
          document.querySelector('.trial_btn-show').style.display = 'none';
        } else {
          document.querySelector('.trial_btn-show').style.display = '';
        }
      }
    }

    $.ajax({
      url: "processing",
      type: "POST",
      dataType: "json",
      data: { try_free: "try_free" },
      success: function (data) {
        //определение количества тем и их названия
        for (let key in data) {
          dataBase[data[key].title] = [];
          dataTheme[data[key].title] = "";
        }
        //формирование объекта с данными из полученных
        for (let id in dataBase) {
          for (let key in data) {
            if (data[key].title == id) {
              if (data[key].theme_title.length > 0) {
                dataTheme[data[key].title] = data[key].theme_title;
              }
              dataBase[data[key].title].push({
                theme_title: data[key].theme_title,
                title: data[key].title,
                text: data[key].text,
                audio: data[key].audio,
                audioTitle: data[key].audio_title,
                theme: data[key].trial_theme,
              });
            }
          }
        }
      },
    })
      .then(function () {
        //отрисовываем темы после полной обработки полученных данных
        for (let key in dataBase) {
          list.innerHTML += `
          <li class="trial_item" id=${key}>
              <p data-key=${key} class="trial_title ${key == 1 ? "active" : ""}">${dataTheme[key] ? dataTheme[key] : key}</p>
                <ul class="trial_nested-list ${key == 1 ? "active" : ""}">
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
        //по умолчанию выставляется первая тема "общее"
        dataBase[1].forEach((elem) => {
          if (elem.theme === "Общее") {
            changeContent(elem);
          }
        });
      })
      .then(function () {
        //вешаем обработчики после отрисовки DOM
        const $window = $(window);

        //desktop
        if ($window.width() >= 960) {
          const desktopTitle = document.querySelectorAll(".trial_title");
          const desktopSubtitle = document.querySelectorAll(
            ".trial_nested-list li"
          );
          subtitleVisible(desktopSubtitle, 1)

          desktopTitle.forEach((li) => {
            li.addEventListener("click", function () {
              //выделение активного заголовка
              li.closest(".trial_item")
                .querySelector(".trial_nested-list")
                .classList.toggle("active");
              li.classList.toggle("active");

              //скрытие неактивного заголовка
              desktopTitle.forEach((title) => {
                if (title !== li && title.classList.contains("active")) {
                  title.classList.remove("active");
                  title
                    .closest(".trial_item")
                    .querySelector(".trial_nested-list")
                    .classList.remove("active");
                }
              });

              subtitleVisible(
                li
                  .closest(".trial_item")
                  .querySelectorAll(".trial_nested-list li"),
                li.closest(".trial_item").id
              );
              //смена контента в зависимости от активного подзаголовка
              li.closest(".trial_item")
                .querySelectorAll(".trial_nested-list li")
                .forEach((item) => {
                  if (item.classList.contains("show-active")) {
                    dataBase[li.closest(".trial_item").id].forEach((elem) => {
                      if (elem.theme === item.querySelector("p").textContent) {
                        changeContent(elem);
                      }
                    });
                  }
                });
            });
          });
          desktopSubtitle.forEach((li) => {
            li.addEventListener("click", function () {
              //выделение активного подзаголовка
              activeElement(
                li
                  .closest(".trial_item")
                  .querySelectorAll(".trial_nested-list li"),
                li,
                "show-active"
              );
              //смена текста при клике на подзаголовок
              dataBase[li.closest(".trial_item").id].forEach((elem) => {
                if (elem.theme === li.innerText) {
                  changeContent(elem);
                }
              });
            });
          });
        } else if ($window.width() < 960) {
          //mobile
          const mobileTitle = document.querySelectorAll(".trial_title");
          const mobileSubtitle = document.querySelectorAll(
            ".trial_nested-list_mobile li"
          );
          subtitleVisible(mobileSubtitle, 1)

          mobileTitle.forEach((title) => {
            title.addEventListener("click", function () {
              //выделение активного заголовка
              activeElement(mobileTitle, title, "active");

              subtitleVisible(mobileSubtitle, title.getAttribute("data-key"));
              let sub;
              mobileSubtitle.forEach((subtitle) => {
                //смена контента в зависимости от активного подзаголовка
                if (subtitle.querySelector("p").classList.contains("active")) {
                  sub = subtitle.querySelector("p");
                  dataBase[title.getAttribute("data-key")].forEach((elem) => {
                    if (
                      elem.theme === subtitle.querySelector("p").textContent
                    ) {
                      changeContent(elem);
                    }
                  });
                }
              });

              if (text.querySelector(".trial_description-text p").textContent.length === 0) {
                sub.classList.remove('active');
                mobileSubtitle[0].querySelector('p').classList.add('active');
                dataBase[title.getAttribute("data-key")].forEach((elem) => {
                  if (
                    elem.theme === mobileSubtitle[0].querySelector("p").textContent
                  ) {
                    changeContent(elem);
                  }
                });
              }
            });
          });

          mobileSubtitle.forEach((sub) => {
            sub.addEventListener("click", function () {
              // выделение активного подзаголовка
              mobileSubtitle.forEach((item) => {
                if (
                  item !== sub &&
                  item.querySelector("p").classList.contains("active")
                ) {
                  item.querySelector("p").classList.remove("active");
                }
              });
              sub.querySelector("p").classList.add("active");

              // смена контента в зависимости от активного заголовка
              mobileTitle.forEach((title) => {
                if (title.classList.contains("active")) {
                  dataBase[title.getAttribute("data-key")].forEach((elem) => {
                    if (elem.theme === sub.querySelector("p").textContent) {
                      changeContent(elem);
                    }
                  });
                }
              });
            });
          });
          //слайдер тем в мобильной версии
          $('.themes_slider').flickity({
            draggable: true,
            freeScroll: true,
            prevNextButtons: false,
            pageDots: false,
            contain: true,
            imagesLoaded: true,
            watchCSS: true
          });
          
        }
      });
  }
})();
