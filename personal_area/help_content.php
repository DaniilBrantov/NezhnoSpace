<?php

session_start();
require_once 'connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }

if(isset($_POST["help_btn"])){

  $mess= @trim(stripslashes($_POST["help_mess"]));
  $user_name=@trim(stripslashes($_SESSION["user"]["mail"]));


  if( isset( $_POST['what_questn'] ) ){
      switch( $_POST['what_questn'] ){
          case '1':
              $mail=@trim(stripslashes('eatintelligent@yandex.ru'));
          break;
          case '2':
              $mail=@trim(stripslashes('support@eatintelligent.ru'));
          break;
      }
  }



  $name       =$user_name ;
  $from       = "eatintelligent@yandex.ru";
  $subject    ="EatIntelligent Help";
  $message    ="EatIntelligent \n У {$user_name} возникла загвостка, проблемка, вопрос...   \n \n------------------ \n \nСообщение: {$mess}";
  $to         = $mail;

  $headers = "MIME-Version: 1.0";
  $headers .= "Content-type: text/plain; charset=UTF-8";
  $headers .= "From: {$name} <{$from}>";
  $headers .= "Reply-To: <{$from}>";
  $headers .= "Subject: {$subject}";
  $headers .= "X-Mailer: PHP/".phpversion();

  $success=mail($to, $subject, $message, $headers);

  if (!$success) {
      $errorMessage = error_get_last()['message'];
  }
  else{
      echo '<div class="help_success">
              <div class="help_success_cnt">
                <img src="'. get_template_directory_uri() .'/images/check.svg" alt="">
                <p>Сообщение успешно отправлено</p>
              </div>
            </div>';
  }
}

?>


<div class="wrapper_help">
    <div class="help_banner">
        <h1>Помощь</h1>
    </div>

    <section class="section">
      <div class="container">
        <h2 class="section__title">FAQ</h2>
        <div class="faq">
          <input type="checkbox" id="faq-1" class="faq__toggle">
          <label for="faq-1" class="faq__title">
            <span>Как много консультаций мне понадобится, чтобы решить мой вопрос?</span>
            <i class="faq__title-icon"></i>
          </label>
          <div class="faq__content">Зависит от запроса,
в среднем для первых результатов необходимо 6-8 сессий</div>
        </div>
        <div class="faq">
          <input type="checkbox" id="faq-2" class="faq__toggle">
          <label for="faq-2" class="faq__title">
            <span>Как это работает? </span>
            <i class="faq__title-icon"></i>
          </label>
          <div class="faq__content">Формулируем экологичный запрос. Выбираем мишени терапии:
эмоциональные реакции, паттерны поведения, телесные ощущения, убеждения. В
процессе консультирования обсуждаем сложности, проблемы и находим патологические
стратегии, меняем их.</div>
        </div>
        <div class="faq">
          <input type="checkbox" id="faq-3" class="faq__toggle">
          <label for="faq-3" class="faq__title">
            <span>Какие гарантии вы можете мне дать?</span>
            <i class="faq__title-icon"></i>
          </label>
          <div class="faq__content">Мы гарантируем безопасное пространство,
принятие, доказательные методы.</div>
        </div>
        <div class="faq">
          <input type="checkbox" id="faq-4" class="faq__toggle">
          <label for="faq-4" class="faq__title">
            <span>Как часто мне нужно ходить?</span>
            <i class="faq__title-icon"></i>
          </label>
          <div class="faq__content">Темп и интенсивность работы зависит от запроса и ваших
личных особенностей. Сессии могут проходить один раз в 1-2-3 недели.</div>
        </div>
        <div class="faq">
          <input type="checkbox" id="faq-5" class="faq__toggle">
          <label for="faq-5" class="faq__title">
            <span>Как мне подготовиться к консультации?</span>
            <i class="faq__title-icon"></i>
          </label>
          <div class="faq__content">Никак специально готовиться не нужно.
Позаботьтесь о комфортном месте на время сессии. Можно заранее приготовить ручку и
блокнот для записей.</div>
        </div>
      </div>
    </section>
    <div class="what_questn">
        <h2>Какой вопрос вас интересует?</h2>
        <form action="help" method="post" class="what_questn_form" >
          <div class="what_questn_title">
            <input id="what_questn_technical" type="radio" name="what_questn" value="1" checked>
            <label for="what_questn_technical" class="what_questn_title_item">
              <h3>Технический</h3>
            </label>
            <input id="what_questn_program" type="radio" name="what_questn" value="2">
            <label for="what_questn_program" class="what_questn_title_item">
              <h3>По программе</h3>
            </label>
          </div>

        
            <div class="what_questn_content">
                <div class="what_questn_txt">
                    <input name="help_mess" type="text" class="what_questn_input" required>
                    <label class="what_questn_lbl">
                        <ion-icon name="search-outline"></ion-icon>
                        <p>Ваш вопрос...</p> </label>
                </div>
                <div class="curriculum_btn_mobile help_btn">
                  <input name="help_btn" id="help_btn" type="submit">
                  <label for="help_btn">
                    <div class="help_button">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                    </div>
                  </label>
                </div>
            </div>
        </form>
    </div>
    <div class="support">
        <h2>Поддержка</h2>
        <div class="support_items">
            <div class="support_item">
                <h4>Техническая поддержка:</h4>
                <a href="tech@eatintelligent.ru">tech@eatintelligent.ru</a>
            </div>
            <div class="support_item">
                <h4>Поддержка по программе:</h4>
                <a href="support@eatintelligent.ru">support@eatintelligent.ru</a>
            </div>
        </div>
    </div>
</div>