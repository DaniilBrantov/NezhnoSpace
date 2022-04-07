
<div class="wrapper-form">
    <div class="container">
        <div class="form-content">
            <div class="form-heading">
                <h2 id="form">
                    Получить консультацию
                </h2>
            </div>
<?php echo do_shortcode('[contact-form-7 id="215" title="Контактная форма e-i"]'); ?>
      </div>
    </div>
</div>


<!-- 
<div class="wrapper-form">
    <div class="container">
        <div class="form-content">
            <div class="form-heading">
                <h2 id="form">
                    Форма обратной связи
                </h2>
            </div>
            <form class="form" action="" method="post">
                    <input type="hidden" name="project_name" value="Eat Intelligent">
                    <input type="hidden" name="admin_email" value="support@eatintelligent.ru">      eatelligency@gmail.com
                    <input type="hidden" name="form_subject" value="Обратная связь">

                    <input class="form__item forms__name" type="text" name="Имя" placeholder="Ваше имя" maxlength=""/>
                    <input class="form__item forms__phone" type="text" name="Телефон" placeholder="Телефон" maxlength=""/>
                    <input class="form__item forms__mail" type="text" name="email" placeholder="Электронная почта" maxlength=""/>
                    <textarea class="form__item forms__massage" type="text" name="Сообщение" placeholder="Сообщение" cols="" rows="3"></textarea>
                    <input class="form__item form-btn " type="submit" value="Отправить">
            </form>
        </div>
    </div>
</div>
-->







<?php

// $method = $_SERVER['REQUEST_METHOD'];

// $c = true;
// if ( $method === 'POST' ) {
//   $project_name = trim($_POST["project_name"]);
//   $admin_email  = trim($_POST["admin_email"]);
//   $form_subject = trim($_POST["form_subject"]);

//   foreach ( $_POST as $key => $value ) {
//     if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
//       $message .= "
//       " . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
//         <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
//         <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
//       </tr>
//       ";
//     }
//   }
// } elseif ( $method === 'GET' ) {

//     $project_name = trim($_GET["project_name"]);
//     $admin_email  = trim($_GET["admin_email"]);
//     $form_subject = trim($_GET["form_subject"]);

//   foreach ( $_GET as $key => $value ) {
//     if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
//       $message .= "
//       " . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
//         <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
//         <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
//       </tr>
//       ";
//     }
//   }
// }

// $message = "<table style='width: 100%;'>$message</table>";

// function adopt($text) {
//     return '=?UTF-8?B?'.Base64_encode($text).'?=';
// }

// $headers = "Content-Type: text/html; charset=utf-8" . PHP_EOL .
// 'From: '.adopt($project_name).' <'.$admin_email.'>' . PHP_EOL .
// 'Reply-To: '.$admin_email.'' . PHP_EOL;
// $headers = "Date: ".date("D, d M Y H:i:s")." UT\r\n";

// $headers.= "MIME-Version: 1.0\r\n";

// $headers.= "Content-Type: text/html; charset=\"UTF-8\"\r\n";

// $headers.= "Content-Transfer-Encoding: 8bit\r\n";


// mail($admin_email, $form_subject, $message, $headers);
?>


