(() => {
  let price944, price945, price946;
  if (document.querySelector('.price_944')) {
    price944 = document.querySelector('.price_944').dataset.price;
  }
  if (document.querySelector('.price_945')) {
    price945 = document.querySelector('.price_945').dataset.price;
  }
  if (document.querySelector('.price_946')) {
    price946 = document.querySelector('.price_946').dataset.price;
  }
  class PaymentBanner {
    constructor(banner, sliderPayment) {
      this.banner = banner;
      this.optionsPayment = {
        1: {
          duration: '1 месяц',
          price: (price944 ? price944 : '3000') + ' ₽',
          value: '944',
          list: []
        },
        2: {
          duration: '6 месяцев',
          price: (price945 ? price945 : '15000') + ' ₽',
          value: '945',
          list: []
        },
        3: {
          duration: '1 год',
          price: (price946 ? price946 : '25000') + ' ₽',
          value: '946',
          list: []
        }
      };
      this.sliderPayment = sliderPayment;
    }
    addSlide() {
      for (let option in this.optionsPayment) {
        this.sliderPayment.innerHTML += `
            <li class='pay-banner_option pay-banner_options-slide' id='pay-banner_options-slide${option}'>
              <div class='pay-banner_option-container'>
                  <span class='pay-banner_option-stroke'></span>
                  <div class='pay-banner_option-content'>
                      <div class='pay-banner_option-icon'></div>
                          <p class='pay-banner_option-title'>Начни заботиться о&nbspсебе с&nbspНежно</p>
                          <div class='pay-banner_option-text'>
                          <p class='pay-banner_option-duration'>${this.optionsPayment[option].duration}</p>
                          <p class='pay-banner_option-price'>${this.optionsPayment[option].price}</p>
                          <ul class='pay-banner_option-list'>
                          </ul>
                          </div>
                  </div>
                  <form action="payment" method='post'>
                    <input type="hidden" value="${this.optionsPayment[option].value}" name="payment_id">
                    <input type="hidden" value="" name="promo" class='post-promocode-payment'>
                    <button class='pay-banner_option-button' name="payment_btn" type="submit">хочу подписку</button>
                  </form>
              </div>
            </li>
          `;
        let payList = document.querySelector(`#pay-banner_options-slide${option}`).querySelector('.pay-banner_option-list');
        this.optionsPayment[option].list.forEach(item => {
          payList.innerHTML += `<li>${item}</li>`;
        })
      };
    }
    adaptiveHeightBanner() {
      if (this.banner.clientHeight <= 780) {
        this.banner.style.paddingTop = '50px';
        document.querySelector('.pay-banner_title').style.marginTop = '15px';
        document.querySelector('.pay-banner_title').style.marginBottom = '15px';
        this.banner.paddingBottom = '5px';
      }

      if (window.screen.height > 800 && window.screen.width < 800) {
        document.querySelector('.subscription_payment-banner').style.height = '80vh';
      }

      if (this.banner.clientHeight <= 700 && window.screen.width < 800) {
        this.banner.style.height = 'max-content';
        document.querySelector('.subscription_payment-banner_background').style.overflowY = 'auto';
      }
    }
    init() {
      this.addSlide();
      $('.account_payment-banner .pay-banner_options-slider').flickity({
        draggable: true,
        cellAlign: 'center',
        freeScroll: true,
        prevNextButtons: false,
        pageDots: false,
        initialIndex: 1,
        watchCSS: true
      });
      this.adaptiveHeightBanner();

      window.addEventListener('resize', (e) => {
        this.adaptiveHeightBanner();
      });
      document.querySelector('.pay-banner_btnClose').addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('.subscription_payment-banner_background').style.display = 'none';
      })
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.pay-banner_options-wrap')) {
      const bannerPay = new PaymentBanner(document.querySelector('#payment-banner'), document.querySelector('.pay-banner_options-wrap'));
      bannerPay.init();
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