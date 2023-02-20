(() => {
  const optionsPayment = {
    1: {
      duration: '1 месяц',
      price: '3000 ₽',
      value: '944',
      list: [ '3000 ₽ / мес.' ]
    },
    2: {
      duration: '6 месяцев',
      price: '15000 ₽',
      value: '945',
      list: ['2500 ₽ / мес.']
    },
    3: {
      duration: '1 год',
      price: '25000 ₽',
      value: '946',
      list: ['2084 ₽ / мес.']
    }
  };

  function adaptiveHeightBanner() {
    if (document.querySelector('#payment-banner')) {
      if (document.querySelector('#payment-banner').clientHeight <= 780) {
        document.querySelector('#payment-banner').style.paddingTop = '50px';
        document.querySelector('.pay-banner_title').style.marginTop = '15px';
        document.querySelector('.pay-banner_title').style.marginBottom = '15px';
        document.querySelector('#payment-banner').paddingBottom = '5px';
      }

      if (window.screen.height > 800 && window.screen.width < 800) {
        document.querySelector('.subscription_payment-banner').style.height = '80vh';
      }

      if (document.querySelector('#payment-banner').clientHeight <= 700 && window.screen.width < 800) {
        document.querySelector('#payment-banner').style.height = 'max-content';
        document.querySelector('.subscription_payment-banner_background').style.overflowY = 'auto';
      }
    }
  }

  window.addEventListener('resize', (e) => {
    adaptiveHeightBanner();
  });

  document.addEventListener('DOMContentLoaded', function () {
    const sliderPayment = document.querySelector('.pay-banner_options-wrap');
    if (sliderPayment) {
      for (let option in optionsPayment) {
        sliderPayment.innerHTML += `
            <li class='pay-banner_option pay-banner_options-slide' id='pay-banner_options-slide${option}'>
              <div class='pay-banner_option-container'>
                  <span class='pay-banner_option-stroke'></span>
                  <div class='pay-banner_option-content'>
                      <div class='pay-banner_option-icon'></div>
                          <p class='pay-banner_option-title'>Начни заботится о&nbspсебе с&nbspНежно</p>
                          <div class='pay-banner_option-text'>
                          <p class='pay-banner_option-duration'>${optionsPayment[option].duration}</p>
                          <p class='pay-banner_option-price'>${optionsPayment[option].price}</p>
                          <ul class='pay-banner_option-list'>
                          </ul>
                          </div>
                  </div>
                  <form action="payment" method='post'>
                    <input type="hidden" value="${optionsPayment[option].value}" name="payment_id">
                    <input type="hidden" value="" name="promo" class='post-promocode-payment'>
                    <button class='pay-banner_option-button' name="payment_btn" type="submit">хочу подписку</button>
                  </form>
              </div>
            </li>
          `;
        let payList = document.querySelector(`#pay-banner_options-slide${option}`).querySelector('.pay-banner_option-list');
        optionsPayment[option].list.forEach(item => {
          payList.innerHTML += `<li>${item}</li>`;
        })
      };
    }
    adaptiveHeightBanner();
    //закрытие баннера
    if (document.querySelector('.subscription_payment-banner .pay-banner_btnClose')) {
      document.querySelector('.pay-banner_btnClose').addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('.subscription_payment-banner_background').style.display = 'none';
      })
    }

    //инициализация слайдера во всплывающем банере
    if (document.querySelector('.subscription_payment-banner_background')) {
      $('.subscription_payment-banner .pay-banner_options-slider').flickity({
        draggable: true,
        cellAlign: 'center',
        freeScroll: true,
        prevNextButtons: false,
        pageDots: false,
        initialIndex: 1,
        watchCSS: true
      });
    }

    //открытие баннера при клике на today_practice
    if (document.querySelector('.daily-practice_img-wrapper')) {
      if (document.querySelector('.subcscription_container').dataset.statusPayment == 'false') {
        let arr = [];
        arr.push(document.querySelector('.daily-practice_img-wrapper'));
        arr.push(document.querySelector('.daily-practice_btn-more'));
        arr.forEach((item) => {
          item.addEventListener('click', function (e) {
            e.preventDefault();
            if (document.querySelector('.subcscription_container').dataset.statusPayment === 'false') {
              e.preventDefault();
              document.querySelector('.subscription_payment-banner_background').style.display = 'block';
              if (document.querySelector('.pay-banner_options-slider.is-draggable')) {
                document.querySelectorAll('.pay-banner_option').forEach((elem) => elem.style.height = '100%');
              }
            }
          })
        })
      }
    }
  })
})();


//Отправка данных и проверка их на стороне сервера

$(".pay-banner_promocode-btn").click(function (e) {
  e.preventDefault();
  $(`input`).removeClass("error");
  var promo_btn = $('input[name="promo_btn"]').val();
  var promo = $('input[name="promo"]').val();

  var formData = new FormData();
  formData.append("promo_btn", promo_btn);
  formData.append("promo", promo);

  $.ajax({
    url: "promocode_check",
    type: "POST",
    dataType: "json",
    processData: false,
    contentType: false,
    cache: false,
    data: formData,
    success: function (data) {
      if (data.status) {
        showError('promo', "Промокод применён успешно. Выберите вариант подписки");
        document.querySelector('.pay-banner_promocode-input.error').style.borderColor = 'green';
        document.querySelector('.pay-banner_promocode-input.error').style.outline = '1px solid green';
        document.querySelector('.pay-banner_promocode-input-wrap .text-error_promo').style.color = 'green';
        hideError('promo');
        document.querySelectorAll('.post-promocode-payment').forEach((input) => input.value = promo);
      } else {
        for (let key in data) {
          if (key !== 'status') {
            showError('promo', data[key]);
            hideError('promo');
          }
        }
      }
    },
    error: function (jqxhr, status, errorMsg) {
      showError('promo', "Произошла непредвиденная ошибка");
      hideError('promo');
    },
  }).then((data) => {
    if (data.status) {
      //window.location.href = 'payment';
    }
  });
});
