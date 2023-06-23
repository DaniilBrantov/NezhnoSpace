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
                <input type="hidden" value="${option}" name="service_id">
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
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success: function (data) {
              // Обработка успешного ответа
              // response содержит полученный контент с сервера
              // console.log(data);
              pay(data.label, data.price, data.quantity, data.period, data.mail, data.publicId, data.description, data.invoiceId, data.startDate);
              // pay(label, amount, quantity, period, mail, publicId, description, invoiceId)
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










// Pay
function pay(label, amount, quantity, period, mail, publicId, description, invoiceId, apiKey, startDate) {
  var widget = new cp.CloudPayments();

  var receipt = {
    Items: [{
      label: label,
      price: amount,
      quantity: quantity,
      amount: amount * quantity,
      vat: 20,
      method: 0,
      object: 0
    }],
    taxationSystem: 0,
    email: mail,
    isBso: false,
    amounts: {
      electronic: amount * quantity,
      advancePayment: 0.00,
      credit: 0.00,
      provision: 0.00
    }
  };

  var data = {
    CloudPayments: {
      CustomerReceipt: receipt,
      recurrent: {
        interval: 'Month',
        period: period,
        customerReceipt: receipt
      }
    }
  };

  widget.charge({
    publicId: publicId,
    description: description,
    amount: amount * quantity,
    currency: 'RUB',
    invoiceId: invoiceId,
    accountId: mail,
    skin: "mini",
    requireConfirmation: true,
    startDate: startDate, // Установка выбранной даты начала списаний
    data: data
  },
    function (options) {
      // действие при успешной оплате
      // console.log('Платеж успешно выполнен:', options);
      // console.log('result:', widgetResult);
      const accountId = options.accountId;
      const publicId = options.publicId
      getSubscriptions(accountId, 'pk_3da4553acc29b450d95115b0918f7', '4b978f8af1e63cb76629acbb9d9caff0');


      // Получение SubscriptionId
      var subscriptionId = options.Model.SubscriptionId;
      console.log('SubscriptionId:', subscriptionId);

      // Вызов метода getSubscriptionStatus для получения информации о статусе подписки
      getSubscriptionStatus(subscriptionId, apiKey);
    },
    function (reason, options) {
      // действие при неуспешной оплате
      console.log('Ошибка при выполнении платежа:', reason, options);
    }
  );
}

// function getSubscriptionStatus(subscriptionId, apiKey) {
//   $.ajax({
//     url: 'https://api.cloudpayments.ru/subscriptions/get',
//     type: 'POST',
//     dataType: 'json',
//     headers: {
//       'Content-Type': 'application/json',
//       'Authorization': apiKey
//     },
//     data: JSON.stringify({
//       SubscriptionId: subscriptionId
//     }),
//     success: function (data) {
//       // Обработка успешного получения информации о статусе подписки
//       console.log('Информация о статусе подписки:', data);
//     },
//     error: function (jqxhr, status, errorMsg) {
//       // Обработка ошибки
//       console.log('Ошибка получения информации о статусе подписки:', errorMsg);
//     }
//   });
// }




















// Функция для приостановки подписки
function suspendSubscription(subscriptionId, suspendUntil) {
  // Формирование запроса к API CloudPayments
  var url = 'https://api.cloudpayments.ru/subscriptions/suspend';
  var requestData = {
    AccountId: subscriptionId,
    SuspendUntil: suspendUntil
  };

  // Отправка запроса
  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Basic ' + btoa('public_key:api_secret')
    },
    body: JSON.stringify(requestData)
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      // Обработка ответа
      if (data.Success) {
        // Приостановка подписки успешно выполнена
        console.log('Подписка приостановлена');
        // Дополнительные действия, если необходимо
      } else {
        // Приостановка подписки не удалась
        console.log('Ошибка при приостановке подписки:', data.Message);
        // Обработка ошибки
      }
    })
    .catch(function (error) {
      // Обработка ошибок
      console.log('Ошибка при выполнении запроса:', error);
    });
}



// Определение функции для отмены подписки
function cancelSubscription(subscriptionId) {
  fetch('https://api.cloudpayments.ru/subscriptions/cancel', {
    method: 'POST',
    headers: {
      Authorization: 'Bearer your_api_key', // Замените 'your_api_key' на ваш ключ API CloudPayments
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      Id: subscriptionId,
    }),
  })
    .then(response => response.json())
    .then(data => {
      if (data.Success) {
        console.log('Подписка успешно отменена');
      } else {
        console.error('Ошибка при отмене подписки:', data.Message);
      }
    })
    .catch(error => {
      console.error('Ошибка при выполнении запроса:', error);
    });
}

function getSubscriptions(accountId, publicId, apiKey) {
  const apiUrl = `https://api.cloudpayments.ru/subscriptions/list?AccountId=${accountId}`;

  const requestOptions = {
    method: 'GET',
    headers: {
      'Authorization': 'Basic ' + btoa(`${publicId}:${apiKey}`),
    },
  };

  fetch(apiUrl, requestOptions)
    .then(response => response.json())
    .then(data => {
      const subscriptions = data.Model;
      console.log('Список подписок:', subscriptions);
      // Дальнейшая обработка списка подписок
    })
    .catch(error => {
      console.error('Ошибка при получении списка подписок:', error);
    });
}

var subscriptionId = 'subscription_id';
var suspendUntil = '2023-06-31T00:00:00Z'; // Замените на желаемую дату и время

// suspendSubscription(subscriptionId, suspendUntil);
// cancelSubscription(subscriptionId);

// Вопрос: Где subscriptionId?









































// function pay(publicId, description, amount, mail) {
//   let language = "ru-RU";
//   var widget = new cp.CloudPayments({
//     language: language
//   });

//   let paymentOptions = {
//     publicId: publicId,
//     description: description,
//     amount: amount,
//     currency: 'RUB',
//     accountId: mail,
//     invoiceId: '1',
//     skin: "mini",
//     autoClose: 3
//   };

//   function makePayment() {
//     if (!widget.optionsPayment) {
//       widget.optionsPayment = paymentOptions;
//       widget.pay('auth', paymentOptions, {
//         onSuccess: function (options) {
//           console.log('Платеж успешно выполнен:', options);
//         },
//         onFail: function (reason, options) {
//           console.log('Ошибка при выполнении платежа:', reason, options);
//         },
//         onComplete: function (paymentResult, options) {
//           console.log('Платеж завершен:', paymentResult, options);
//         }
//       });
//     }
//   }

//   // Устанавливаем интервал повторения платежа каждый месяц (30 дней)
//   setInterval(makePayment, 30 * 24 * 60 * 60 * 1000);
// }
