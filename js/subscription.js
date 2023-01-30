(() => {
  document.addEventListener('DOMContentLoaded', function() {
    let slidersInit = [
      $('.daily_practices_slider'),
      $('.recommendations_slider'),
      $('.month-theme_slider'),
    ];

    slidersInit.forEach((slider) => {
      slider.flickity({
        draggable: true,
        freeScroll: true,
        contain: true,
        prevNextButtons: false,
        pageDots: false,
        contain: true,
        cellAlign: 'left',
        imagesLoaded: true,
      });
    })

    //progress-bar
    // const progress_bars = document.querySelectorAll('.daily-practice_progress');
    // progress_bars.forEach(bar => {
    //   const { size } = bar.dataset;
    //   bar.style.width = `${size}%`
    // });

    function changeAddition(slide, addition, outline, visible, notvisible) {
      // slide.classList.toggle('slideActive');
      slide.querySelector('.blockSub-slide_wrapper-img').style.outline = outline;
      slide.querySelector('.blockSub-slide_after').style.display = visible;
      if (addition.getAttribute('status') === 'false') {
        slide.querySelector('.blockSub-slide_before').style.display = 'flex';
      } else {
        slide.querySelector('.blockSub-slide_before').style.display = (notvisible === 'none' ? notvisible : 'flex');
      }
      slide.querySelector('.subcscription_title-slide').style.display = notvisible;
      // document.querySelector('.blockSub-slide-more span').style.display = notvisible;
      addition.style.display = visible;
    }
    function findAddition(addition, slide) {
      addition.forEach((elem) => {
        if (elem.getAttribute('addition-key') === slide.getAttribute('key')) {
          elem.style.display = 'none';
        }
      })
    }

    const arraySliders = [
      {
        slider: document.querySelectorAll('.daily_practices_slide'),
        addition: document.querySelectorAll('.daily_practices_addition')
      },
      {
        slider: document.querySelectorAll('.recommendations_slide'),
        addition: document.querySelectorAll('.recommendations_addition')
      },
      {
        slider: document.querySelectorAll('.month-theme_slide'),
        addition: document.querySelectorAll('.month-theme_addition')
      },
    ];

    arraySliders.forEach((obj) => {
      let objSlider = obj.slider;
      let objAddition = obj.addition;

      //открытие и закрытие подробностей при клике на слайд
      objSlider.forEach((slide) => {
        slide.addEventListener('click', (e) => {
          objAddition.forEach((addition) => {
            if (addition.getAttribute('addition-key') === slide.getAttribute('key')) {
              slide.classList.toggle('slideActiveSubscription');

              //скрыть подробности у других, если было открыто
              objSlider.forEach((active) => {
                if (active.classList.contains('slideActiveSubscription') && active !== slide) {
                  active.classList.remove('slideActiveSubscription');
                  
                  changeAddition(active, addition, 'none', 'none', 'block');
                  findAddition(objAddition, active);
                }
              })

              if (slide.classList.contains('slideActiveSubscription')) {//показать подробности
                changeAddition(slide, addition, '5px #dde1f3 solid', 'block', 'none');
              } else { //скрыть подробности
                slide.classList.remove('slideActiveSubscription');
                changeAddition(slide, addition, 'none', 'none', 'block');
                findAddition(objAddition, slide);
              }
            }
          })
        })
      });

      //проверка, доступна ли тема для пользователя
      objAddition.forEach((addition) => {
        if (addition.getAttribute('status') === 'false') {
          addition.querySelector('.addition_image').innerHTML += `<div class="addition_image-befor">
          <div class="blockSub-slide_before_svgLock">
            <svg width="41" height="47" viewBox="0 0 41 47" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M36.6071 20.5625H34.4107V13.9531C34.4107 6.26055 28.1692 0 20.5 0C12.8308 0 6.58929 6.26055 6.58929 13.9531V20.5625H4.39286C1.96763 20.5625 0 22.5361 0 24.9688V42.5938C0 45.0264 1.96763 47 4.39286 47H36.6071C39.0324 47 41 45.0264 41 42.5938V24.9688C41 22.5361 39.0324 20.5625 36.6071 20.5625ZM27.0893 20.5625H13.9107V13.9531C13.9107 10.3088 16.8667 7.34375 20.5 7.34375C24.1333 7.34375 27.0893 10.3088 27.0893 13.9531V20.5625Z" fill="#FDFDFD"/>
            </svg>
            <div class="blockSub-slide_before_data">27 октября</div>
          </div>
          </div>`;
          addition.querySelector('.addition_btn').style.display = 'none';
        }
      });
    })

    //смена стилей, если тема недоступна
    const slideBefor = document.querySelectorAll('.blockSub-slide_before');
    const lessonTime = document.querySelectorAll('#blockSub_lesson-time');
    let timeLesson = '';

    slideBefor.forEach((befor) => {
      lessonTime.forEach((time) => {
        if (time.previousElementSibling === befor) {
          timeLesson = time.textContent;
          time.style.display = 'none';
        }
      })
      if (befor.getAttribute('status') === 'true') {
        befor.innerHTML += `<div class="blockSub-slide_before_svg">
        <div class="blockSub-slide_before_svgMusic">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 13C17 12.4696 17.2107 11.9609 17.5858 11.5858C17.9609 11.2107 18.4696 11 19 11C19.5304 11 20.0392 11.2107 20.4142 11.5858C20.7893 11.9609 21 12.4696 21 13V18.9999C21 19.5303 20.7893 20.0391 20.4142 20.4142C20.0392 20.7893 19.5304 20.9999 19 20.9999C18.4696 20.9999 17.9609 20.7893 17.5858 20.4142C17.2107 20.0391 17 19.5303 17 18.9999V13Z" stroke="#E8E8E8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 13C3 12.4696 3.21074 11.9609 3.58582 11.5858C3.96089 11.2107 4.46957 11 5 11C5.53043 11 6.03917 11.2107 6.41425 11.5858C6.78932 11.9609 7 12.4696 7 13V18.9999C7 19.5303 6.78932 20.0391 6.41425 20.4142C6.03917 20.7893 5.53043 20.9999 5 20.9999C4.46957 20.9999 3.96089 20.7893 3.58582 20.4142C3.21074 20.0391 3 19.5303 3 18.9999V13Z" stroke="#E8E8E8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M19 11V10C19 8.14348 18.2625 6.36305 16.9498 5.05029C15.637 3.73754 13.8565 3 12 3C10.1435 3 8.36305 3.73754 7.05029 5.05029C5.73754 6.36305 5 8.14348 5 10V11" stroke="#E8E8E8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div class="blockSub-slide_before_svgBook">
          <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.0039 3.33784C12.8878 2.25505 14.9394 1.49458 17.0739 1.08784C17.5549 0.972565 18.0562 0.970724 18.538 1.08247C19.0199 1.19421 19.4691 1.41641 19.8503 1.73164C20.2315 2.04686 20.5342 2.44645 20.7344 2.89875C20.9346 3.35105 21.0268 3.84374 21.0039 4.33784V13.3378C20.9738 14.4549 20.5705 15.5296 19.8582 16.3906C19.1458 17.2515 18.1656 17.8491 17.0739 18.0878C14.9394 18.4946 12.8878 19.255 11.0039 20.3378" stroke="#E8E8E8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M11.0034 3.33784C9.11951 2.25505 7.06799 1.49458 4.93348 1.08784C4.45247 0.972565 3.95122 0.970724 3.46937 1.08247C2.98752 1.19421 2.53829 1.41641 2.15711 1.73164C1.77594 2.04686 1.47323 2.44645 1.27302 2.89875C1.07281 3.35105 0.980504 3.84374 1.00343 4.33784V13.3378C1.0335 14.4549 1.43691 15.5296 2.14924 16.3906C2.86158 17.2515 3.84184 17.8491 4.93348 18.0878C7.06799 18.4946 9.11951 19.255 11.0034 20.3378" stroke="#E8E8E8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M11.0039 20.3379V3.33789" stroke="#E8E8E8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        </div>
        ${timeLesson.length > 0 ? `<div class="blockSub-slide_before_time">${timeLesson}</div>` : ''}
      `;} else {
        befor.innerHTML += `<div class="blockSub-slide_before_svgLock">
        <svg width="41" height="47" viewBox="0 0 41 47" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M36.6071 20.5625H34.4107V13.9531C34.4107 6.26055 28.1692 0 20.5 0C12.8308 0 6.58929 6.26055 6.58929 13.9531V20.5625H4.39286C1.96763 20.5625 0 22.5361 0 24.9688V42.5938C0 45.0264 1.96763 47 4.39286 47H36.6071C39.0324 47 41 45.0264 41 42.5938V24.9688C41 22.5361 39.0324 20.5625 36.6071 20.5625ZM27.0893 20.5625H13.9107V13.9531C13.9107 10.3088 16.8667 7.34375 20.5 7.34375C24.1333 7.34375 27.0893 10.3088 27.0893 13.9531V20.5625Z" fill="#FDFDFD"/>
        </svg>
        <div class="blockSub-slide_before_data">27 октября</div>
      </div>`;
      }
    })
  })
})();