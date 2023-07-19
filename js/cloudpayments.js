// this.pay = function (label, price, quantity, email, phone, period) {
//     var widget = new cp.CloudPayments();
//     var receipt = {
//             Items: [//товарные позиции
//                 {
//                     label: label, //наименование товара
//                     price: price, //цена
//                     quantity: quantity, //количество
//                     amount: price + quantity, //сумма
//                     vat: 0, //ставка НДС
//                     method: 0, // тег-1214 признак способа расчета - признак способа расчета
//                     object: 0, // тег-1212 признак предмета расчета - признак предмета товара, работы, услуги, платежа, выплаты, иного предмета расчета
//                 }
//             ],
//             taxationSystem: 0, //система налогообложения; необязательный, если у вас одна система налогообложения
//             email: email, //e-mail покупателя, если нужно отправить письмо с чеком
//             phone: phone, //телефон покупателя в любом формате, если нужно отправить сообщение со ссылкой на чек
//             isBso: false, //чек является бланком строгой отчетности
//             amounts:
//             {
//                 electronic: price + quantity, // Сумма оплаты электронными деньгами
//                 advancePayment: 0.00, // Сумма из предоплаты (зачетом аванса) (2 знака после запятой)
//                 credit: 0.00, // Сумма постоплатой(в кредит) (2 знака после запятой)
//                 provision: 0.00 // Сумма оплаты встречным предоставлением (сертификаты, др. мат.ценности) (2 знака после запятой)
//             }
//         };

//     var data = {};
//     data.CloudPayments = {
//         CustomerReceipt: receipt, //чек для первого платежа
//         recurrent: {
//          interval: 'Month',
//          period: period, 
//          customerReceipt: receipt //чек для регулярных платежей
//          }
//          }; //создание ежемесячной подписки

//     widget.charge({ // options
//         publicId: 'pk_3da4553acc29b450d95115b0918f7', //id из личного кабинета
//         description: 'Подписка на ежемесячный доступ к сайту nezhno.space', //назначение
//         amount: price + quantity, //сумма
//         currency: 'RUB', //валюта
//         invoiceId: sessionStorage['id'], //номер заказа  (необязательно)
//         accountId: email, //идентификатор плательщика (обязательно для создания подписки)
//         data: data
//     },
//     function (options) { // success
//         // переадресация на страницу "account"
//         window.location.href = "account";
//     },
//     function (reason, options) { // fail
//         // вывод причины ошибки в консоль
//         console.error("Payment failed:", reason); 
//     });
// };
