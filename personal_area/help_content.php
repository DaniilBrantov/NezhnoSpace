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
        <div class="what_questn_title">
            <div id="what_questn_technical" class="what_questn_title_item">
                <h3>Технический</h3>
            </div>
            <div id="what_questn_program" class="what_questn_title_item">
                <h3>По программе</h3>
            </div>
        </div>

        <form action="help_check" method="post" class="what_questn_form" >
            <div class="what_questn_content">
                <div class="what_questn_txt">
                    <input name="help_mess" type="text" class="what_questn_input" required>
                    <label class="what_questn_lbl">
                        <ion-icon name="search-outline"></ion-icon>
                        <p>Ваш вопрос...</p> </label>
                </div>
                <div class="curriculum_btn_mobile help_btn">
                    <button>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="support">
        <h2>Поддержка</h2>
        <div class="support_items">
            <div class="support_item">
                <h4>Техническая поддержка:</h4>
                <a href="daniil.brantov04@mail.ru">daniil.brantov04@mail.ru</a>
            </div>
            <div class="support_item">
                <h4>Поддержка по программе:</h4>
                <a href="eatelligency@gmail.com">eatelligency@gmail.com</a>
            </div>
        </div>
    </div>
</div>