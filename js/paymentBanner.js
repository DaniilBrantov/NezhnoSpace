
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
          const service = button.parentElement.querySelector('input[name="service_id"]');
          const service_id = service ? service.value : null;
          handleClick(service_id);
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
    
      const sliderOptions = {
        draggable: true,
        cellAlign: 'center',
        freeScroll: true,
        prevNextButtons: false,
        pageDots: false,
        initialIndex: 1,
        watchCSS: true
      };
    
      $('.account_payment-banner .pay-banner_options-slider').flickity(sliderOptions);
    
      this.adaptiveHeightBanner();
    
      window.addEventListener('resize', () => {
        this.adaptiveHeightBanner();
      });
    if(document.querySelector('.pay-banner_btnClose')){
            document.querySelector('.pay-banner_btnClose').addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelector('.subscription_payment-banner_background').style.display = 'none';
      });
    }

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
      window.location.href = 'payment';
    }
  });
});



const popupContainer = document.getElementById('popupContainer');


document.addEventListener('click', function(event) {
  if (!popupContainer.contains(event.target) && popupContainer.contains('show')) {
    popupContainer.style.display = 'none';
    popupContainer.classList.remove('show');
  }
});


function handleClick(service_id) {
  if (popupContainer) {
    popupContainer.style.display = 'block';
    const emailInput = popupContainer.querySelector('input[name="email"]');
    const phoneInput = popupContainer.querySelector('input[name="phone"]');
    const email = emailInput ? emailInput.value : null;
    const phone = phoneInput ? phoneInput.value : null;
    popupContainer.classList.add('show');

    // Hide the form when the area outside popupContainer is clicked
    // document.addEventListener('click', function(event) {
    //   if (!popupContainer.contains(event.target)) {
    //     popupContainer.style.display = 'none';
    //     popupContainer.classList.remove('show');
    //   }
    // });




    document.addEventListener('click', function(e) {
      if (e.target && e.target.id === 'mail-phone_btn') {
        // $("#mail-phone_btn").click(function(event) {
        e.preventDefault();
        const formData = new FormData();
        let emailValue = $('input[name="email"]').val();
        let phoneValue = $('input[name="phone"]').val();
        formData.append('service_id', service_id);
        formData.append('email', emailValue);
        formData.append('phone', phoneValue);
        
        $.ajax({
          url: "payment",
          type: "POST",
          dataType: "json",
          processData: false,
          contentType: false,
          cache: false,
          data: formData,
          success: function(data) {
            if(data.status){
              // console.log('ok')
              Pay(data.label, data.price, data.quantity, data.email, data.phone, data.period)
            }else{

              const showError = (value, textError) => {
                const inputElement = document.querySelector(`input[name="${value}"]`);
                const errorTextElement = document.querySelector(`.text-error_${value}`);
                inputElement.classList.add('error');
                errorTextElement.textContent = textError;
                errorTextElement.style.opacity = '1';
              };
              showError(data.input,data.msg);
            }
          },
          error: function(jqxhr, status, errorMsg) {
            uploadInfoShow(1, 'red', 'При загрузке произошла неизвестная ошибка!');
          },
        });
    // });
      }else{
      console.log(e.target.id)
        // hidePopupContainer(e);
      }
   });
  }
}





function hidePopupContainer(e) {
  if (!popupContainer.contains(e.target)) {
      popupContainer.style.display = 'none';
      popupContainer.classList.remove('show');
  }
}
function Pay(label, price, quantity, email, phone, period) {
  var widget = new cp.CloudPayments();
  var receipt = {
          Items: [//товарные позиции
              {
                  label: label, //наименование товара
                  price: price, //цена
                  quantity: quantity, //количество
                  amount: price + quantity, //сумма
                  vat: 0, //ставка НДС
                  method: 0, // тег-1214 признак способа расчета - признак способа расчета
                  object: 0, // тег-1212 признак предмета расчета - признак предмета товара, работы, услуги, платежа, выплаты, иного предмета расчета
              }
          ],
          taxationSystem: 0, //система налогообложения; необязательный, если у вас одна система налогообложения
          email: email, //e-mail покупателя, если нужно отправить письмо с чеком
          phone: phone, //телефон покупателя в любом формате, если нужно отправить сообщение со ссылкой на чек
          isBso: false, //чек является бланком строгой отчетности
          amounts:
          {
              electronic: price + quantity, // Сумма оплаты электронными деньгами
              advancePayment: 0.00, // Сумма из предоплаты (зачетом аванса) (2 знака после запятой)
              credit: 0.00, // Сумма постоплатой(в кредит) (2 знака после запятой)
              provision: 0.00 // Сумма оплаты встречным предоставлением (сертификаты, др. мат.ценности) (2 знака после запятой)
          }
      };

  var data = {};
  data.CloudPayments = {
      CustomerReceipt: receipt, //чек для первого платежа
      recurrent: {
       interval: 'Month',
       period: period, 
       customerReceipt: receipt //чек для регулярных платежей
       }
  }; //создание ежемесячной подписки

  widget.charge({ // options
        publicId: 'pk_3da4553acc29b450d95115b0918f7',
        description: 'Подписка на ежемесячный доступ к сайту nezhno.space',
        amount: price + quantity,
        currency: 'RUB',
        invoiceId: sessionStorage['id'],
        accountId: email,
        returnUrl: 'pay_success',
        data: data
      }, {
        onSuccess: function(options) { // success
          window.location.href = 'pay_success';
        },
        onFail: function(reason, options) { // fail
          window.location.href = 'pay_success';
        },
        onComplete: function(paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
          var url = paymentResult.ReturnUrl.url; // Проверьте правильное свойство объекта
          window.location.href = url;
        }
  });
      
};













// Pay
// function pay(label, amount, quantity, period, mail, publicId, description, invoiceId, apiKey, startDate) {
//   var widget = new cp.CloudPayments();
//   var receipt = {
//     Items: [{
//       label: label,
//       price: amount,
//       quantity: quantity,
//       amount: amount * quantity,
//       vat: 20,
//       method: 0,
//       object: 0
//     }],
//     taxationSystem: 0,
//     email: mail,
//     isBso: false,
//     amounts: {
//       electronic: amount * quantity,
//       advancePayment: 0.00,
//       credit: 0.00,
//       provision: 0.00
//     }
//   };
//   var data = {
//     CloudPayments: {
//       CustomerReceipt: receipt,
//       recurrent: {
//         interval: 'Month',
//         period: period,
//         customerReceipt: receipt
//       }
//     }
//   };
//   widget.charge({
//     publicId: publicId,
//     description: description,
//     amount: amount * quantity,
//     currency: 'RUB',
//     invoiceId: invoiceId,
//     accountId: mail,
//     skin: "mini",
//     requireConfirmation: true,
//     startDate: startDate, // Установка выбранной даты начала списаний
//     data: data
//   },
//     function (options) {
//       // действие при успешной оплате
//       // console.log('Платеж успешно выполнен:', options);
//       console.log('Платеж успешно выполнен:', options);
//       // console.log('result:', widgetResult);
//       const accountId = options.accountId;
//       const publicId = options.publicId
//       getSubscriptions(accountId, 'pk_3da4553acc29b450d95115b0918f7', '4b978f8af1e63cb76629acbb9d9caff0');
//       // const accountId = options.accountId;
//       // const publicId = options.publicId
//       // getSubscriptions(accountId, 'pk_3da4553acc29b450d95115b0918f7', '4b978f8af1e63cb76629acbb9d9caff0');


//       // Получение SubscriptionId
//       var subscriptionId = options.Model.SubscriptionId;
//       console.log('SubscriptionId:', subscriptionId);
//       // var subscriptionId = options.Model.SubscriptionId;
//       // console.log('SubscriptionId:', subscriptionId);

//       // Вызов метода getSubscriptionStatus для получения информации о статусе подписки
//       getSubscriptionStatus(subscriptionId, apiKey);
//       // getSubscriptionStatus(subscriptionId, apiKey);
//     },
//     function (reason, options) {
//       // действие при неуспешной оплате
//       console.log('Ошибка при выполнении платежа:', reason, options);
//     }
//   );
// }
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