(() => {
  let price944 = document.querySelector('.price_944')?.dataset.price || '3000';
  let price945 = document.querySelector('.price_945')?.dataset.price || '15000';
  let price946 = document.querySelector('.price_946')?.dataset.price || '25000';

  class PaymentBanner {
    constructor(banner, sliderPayment) {
      this.banner = banner;
      this.optionsPayment = {
        1: {
          duration: '1 месяц',
          price: price944 + ' ₽',
          value: '944',
          list: []
        },
        2: {
          duration: '6 месяцев',
          price: price945 + ' ₽',
          value: '945',
          list: []
        },
        3: {
          duration: '1 год',
          price: price946 + ' ₽',
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
                <input type="hidden" value="1" name="service_id">
                <input type="hidden" value="" name="promo" class='post-promocode-payment'>
                <button class='pay-banner_option-button' name="payment_btn" type="submit">хочу подписку</button>
              </form>
            </div>
          </li>
        `;
        let payList = document.querySelector(`#pay-banner_options-slide${option}`).querySelector('.pay-banner_option-list');
        this.optionsPayment[option].list.forEach(item => {
          payList.innerHTML += `<li>${item}</li>`;
        });
      }

      const paymentButtons = document.querySelectorAll('.pay-banner_option-button');
      paymentButtons.forEach(button => {
        button.addEventListener('click', (e) => {
          e.preventDefault();
          const formData = new FormData();
          const service_id = button.parentElement.querySelector('[name="service_id"]').value;
          formData.append('service_id', service_id);
          // Добавьте остальные данные, если необходимо

          // Выполнение AJAX-запроса
          $.ajax({
            url: 'payment',
            type: 'POST',
            dataType: 'html',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function (response) {
              // Обработка успешного ответа
              // response содержит полученный контент с сервера
              const jsonStr = JSON.stringify(response);
              console.log(response.serviceId);
              // pay(data.publicId, data.description, data.price, data.mail);
            },
            error: function (jqxhr, status, errorMsg) {
              // Обработка ошибки
              console.log(errorMsg);
            }
          });
        });
      });
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
      });
    }

  }

  document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.pay-banner_options-wrap')) {
      const bannerPay = new PaymentBanner(document.querySelector('#payment-banner'), document.querySelector('.pay-banner_options-wrap'));
      bannerPay.init();
    }
  });
})();

//Отправка данных и проверка их на стороне сервера
$(".pay-banner_promocode-btn").click(function (e) {
  e.preventDefault();
  $("input").removeClass("error");
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
        document.querySelectorAll('.post-promocode-payment').forEach((input) => (input.value = promo));
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
    }
  }).then((data) => {
    if (data.status) {
      console.log(data)
      //window.location.href = 'payment';
    }
  });
});


function pay(publicId, description, amount, accountId) {
  let language = "ru-RU";
  var widget = new cp.CloudPayments({
    language: language
  })
  widget.pay('auth', // или 'charge'
    { //options
      publicId: publicId, //id из личного кабинета
      description: description, //назначение
      amount: amount, //сумма
      currency: 'RUB', //валюта
      accountId: accountId, //идентификатор плательщика (необязательно)
      skin: "mini", //дизайн виджета (необязательно)
      autoClose: 3
    }, {
    onSuccess: function (options) { // success
      console.log('1')
      console.log(options)
    },
    onFail: function (reason, options) { // fail
      console.log(reason)
      console.log(options)
    },
    onComplete: function (paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
      //например вызов вашей аналитики Facebook Pixel

      console.log('3')
      console.log(options)
    }
  }
  )
}
