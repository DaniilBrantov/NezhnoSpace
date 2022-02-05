<script type="module">
    import '/aos/dist/aos.css'; 
    AOS.init();
    AOS.init({
  offset: 3,
  easing: 'ease-in-sine',
  once: true
});
</script>







<div class="wrapper_stage_video">
    <div class="stage_video">
        <h1>
            Ciao, bella!
        </h1>
        <hr>
        <div class="stage_youtube">
        <iframe src="https://www.youtube.com/embed/ssH6KgZPdf4" title="Ciao, bella!" width="900" height="600" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>
<div class="wrapper_recognized_yourself">
        <h2>
            Поставьте галочки, где узнали себя:
        </h2>
    <div class="recognized_yourself">
        
        <div class="recognized_yourself_checkbox">
            <div data-aos="fade-right" class="recognized_yourself_checkbox_item">
                <input class="recognized_yourself_input" type="checkbox" id="1stage_1" />
                <label for="1stage_1"><span></span>  Мне неприятно и странно, когда люди активно выражают свои эмоции, вздыхаю, плачут, громко смеются</label> 
            </div>
            <div data-aos="fade-right" class="recognized_yourself_checkbox_item">
                <input class="recognized_yourself_input" type="checkbox" id="1stage_2" />
                <label for="1stage_2"><span></span>Мои чувства по поводу питания иногда мешают сконцентрироваться</label> 
            </div>
            <div data-aos="fade-right" class="recognized_yourself_checkbox_item">
                <input class="recognized_yourself_input" type="checkbox" id="1stage_3" />
                <label for="1stage_3"><span></span>Я откладываю сложные задачи и иду перекусить, попить чай</label> 
            </div>
            <div data-aos="fade-right" class="recognized_yourself_checkbox_item">
                <input class="recognized_yourself_input" type="checkbox" id="1stage_4" />
                <label for="1stage_4"><span></span>Когда я расстроен, не знаю, печален ли я, испуган или зол</label> 
            </div>
            <div data-aos="fade-right" class="recognized_yourself_checkbox_item">
                <input class="recognized_yourself_input" type="checkbox" id="1stage_5" />
                <label for="1stage_5"><span></span>Мои мысли по поводу тела заставляют тревожиться</label> 
            </div>
            <div data-aos="fade-right" class="recognized_yourself_checkbox_item">
                <input class="recognized_yourself_input" type="checkbox" id="1stage_6" />
                <label for="1stage_6"><span></span>Мне сложно распознавать и различать эмоции</label> 
            </div>
        </div>
        <div class="recognized_yourself_img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/recognized_yourself.png" alt="">
        </div>
    </div>
</div>
<div class="wrapper_what_get">
    <div class="first_stage_container">
        <div class="what_get">
            <h2>
            Что ты можешь <br> здесь получить 
            </h2>
            <div class="what_get_img">
                <img src="<?php echo get_template_directory_uri(); ?>/images/help_hands.png" alt="">
            </div>
        </div>
    </div>
</div>
<div class="wrapper_your_sebor">
    <div class="first_stage_container">
        <div class="free_access">
            <div class="free_access_cnt">
                    <p>
                        <span>Бесплатный доступ</span>  к первому этапу и <br> индивидуальному маршруту у тебя <br> будет на <span>14 дней</span> .
                    </p>
            </div>
        </div>
        <div class="begining_your_sebor"></div>
        <div class="show_your_sebor"></div>
        <div class="your_sebor">
            <div class="your_sebor_title">
                <p>
                    Дальше у тебя есть выбор:
                </p>
            </div>
            <div class="your_sebor_cnt">
                <div class="your_sebor_items">
                    <div class="your_sebor_item">
                        <div class="your_sebor_item_title">
                            <h3>Оформить подписку на месяц</h3>
                        </div>
                        <hr>
                        <div class="your_sebor_txt">
                            <p>
                            <span>Что ты получишь:</span>  каждый месяц тут будут появляться отдельные материалы: тексты и упражнения по теме нарушений пищевого поведения, а также приглашения на практические сессии с психологами и другими приглашенными специалистами онлайн. Но это не будет методично выстроенный курс, это такая форма поддержки и тестирования, как далеко ты готова зайти. 
                            </p>
                        </div>
                        <div class="your_sebor_price">
                            <p>300₽ <span>в месяц</span></p>
                        </div>
                        <div class="your_sebor_btn">
                            <form action="https://eatintelligent.ru/payment" method='post'>
                                <input type="hidden" value="1" name="order">
                                <input type="hidden" value="300" name="sum">
                                <button type="submit">Оформить</button>
                            </form>
                        </div>
                    </div>

                    <div class="your_sebor_item">
                        <div class="your_sebor_item_title">
                            <h3>Дальше проходить курс</h3>
                        </div>
                        <hr>
                        <div class="your_sebor_txt">
                            <p>
                            <span>Что ты получишь:</span> 8 основных этапов с теорией и практикой, после выполнения заданий и твоей обратной связи на каждом этапе тебе будет открываться задания индивидуального маршрута. Каждый маршрут уникален и будет создаваться специально под тебя нашей рекомендательной системой. Доступ к курсу будет открыт 8 недель, также тебе будут доступны психологическая и техническая поддержка, все материалы и мероприятия из подписки.
                            </p>
                        </div>
                        <div class="your_sebor_price">
                            <p>7000₽ </p>
                        </div>
                        <div class="your_sebor_btn">
                            <form action="https://eatintelligent.ru/payment" method='post'>
                                <input type="hidden" value="2" name="order">
                                <input type="hidden" value="7000" name="sum">
                                <button type="submit">Продолжить</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
        <div class="end_your_sebor"></div>
    </div>
</div>
<div class="wrapper_stage_video">
    <div class="stage_video">
        <h2>
        Почему отношения с едой - база? <br>
        База любви к себе в первую очередь
        </h2>
        <hr>
        <div class="stage_youtube">
        <iframe width="900" height="600" src="https://www.youtube.com/embed/ssH6KgZPdf4" title="Ciao, bella!" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>
<div class="wrapper_practice">
    <div class="first_stage_container practice_flex">
        <div class="practice">
            <h2>
                Практика
            </h2>
            <div class="audio_cont practice_audio">
                <audio id="audio" controls preload="none">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $main_stages['audio']; ?>" type="audio/mpeg">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $main_stages['audio']; ?>" type="audio/ogg">
                    Ваш Браузер не поддерживает данный формат audio.
                </audio>
            </div>
            <div class="practice_cnt">
                <h3>
                    <span>Вот</span>  наша техника безопасности:
                </h3>
                <div class="practice_txt">
                    <ul>
                        <li>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/stop_icon.png" alt="">
                            <p>
                                <span>Ты</span> имеешь право сказать “стоп” - <br>я туда идти не готова
                            </p>
                        </li>
                        <li>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/hands_no.png" alt="">
                            <p>
                                <span>Ты</span> имеешь право сказать “нет” - <br>с этим я не хочу работать
                            </p>
                        </li>
                        <li>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/help_hands_icon.png" alt="">
                            <p>
                                <span>Ты</span> имеешь право получить помощь - <br>у тебя для этого есть чат с нами
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="practice_img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/purple_robot.png" alt="">
        </div>
    </div>
</div>
<div class="wrapper_psychology_resistane">
    <div class="first_stage_container">
        <div class="psychology_resistane">
            <div class="psychology_resistane_img">
                <img src="<?php echo get_template_directory_uri(); ?>/images/doodle.png" alt="">
            </div>
            <div class="psychology_resistane_cnt">
                <div class="psychology_resistane_txt">
                    <p> <span>Сопротивление в психологии никто не отменял</span>  и нет единого тумблера, чтобы его выключить.У тебя есть время походить и переварить материалы, написать за поддержкой.</p>
                </div>
                <div class="psychology_resistane_contacts">
                    <p>Написать на почту: <a href="kl@eatintelligent.ru">kl@eatintelligent.ru </a> <br>
                        Или в Инстаграм: <a href="https://www.instagram.com/eat.intelligent/">eat.intelligent </a> <br>
                        с темой : курс ei</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper_give_u">
    <div class="first_stage_container">
        <div data-aos="fade-up" data-aos-delay="150" data-aos-offset="500" data-aos-duration="1000" class="give_u">
            <h3>
            Я сейчас дам два базовых упражнения, чтобы вернуться в тело и помочь себе принять решение двигаться дальше.
            </h3>
        </div>
    </div>
</div>
<div class="wrapper_audio_meditation practice_flex">
    <div class="section_audio_meditation">
        <div class="audio_meditation">
            <div class="audio_meditation_cnt">
                <div class="audio_cont practice_audio">
                    <audio id="audio" controls preload="none">
                        <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/coldplay-paradise.mp3" type="audio/mpeg">
                        <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/coldplay-paradise.mp3" type="audio/ogg">
                        Ваш Браузер не поддерживает данный формат audio.
                    </audio>
                </div>
                <a href="<?php echo get_template_directory_uri(); ?>/personal_area/audio/coldplay-paradise.mp3" download="" title="EatIntelligent_stage_1">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/download_icon.png" alt="">
                </a>
            </div>
            
            <div class="audio_meditation_txt">
                <p>
                С этими базовыми навыками мы будем идти весь курс, также можно пользоваться магий вне Хогвартса - в обычной жизни. Попробуй прямо сейчас с этой медитацией. Также ты можешь скачать PDF с описанием этих упражнений ниже.
                </p>
            </div>
            <div class="audio_meditation_cnt">
                <div class="audio_cont practice_audio">
                    <audio id="audio" controls preload="none">
                        <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/coldplay-paradise.mp3" type="audio/mpeg">
                        <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/coldplay-paradise.mp3" type="audio/ogg">
                        Ваш Браузер не поддерживает данный формат audio.
                    </audio>
                </div>
                <a href="<?php echo get_template_directory_uri(); ?>/personal_area/audio/coldplay-paradise.mp3" download="" title="EatIntelligent_stage_1">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/download_icon.png" alt="">
                </a>
            </div>
            
        </div>
    </div>
    <div class="audio_meditation_img">
        <img src="<?php echo get_template_directory_uri(); ?>/images/girl_in_headphone.png" alt="">
    </div>
</div>
<div class="wrapper_we_are_ready">
    <div class="first_stage_container we_are_ready_flex">
        <div class="we_are_ready">
            <div class="we_are_ready_cnt">
                <div class="we_are_ready_txt">
                    <p>
                        <span>А сейчас</span> мы готовы начать погружение и ваши индивидуальные маршруты. Пройди опросник, и мы определим точку А, из которой отправляемся к гармоничным отношениям с едой, телом и собой.
                    </p>
                </div>
                <div class="we_are_ready_btn">
                    <a href=""> <p> Пройти </p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/account_btn_arrow.svg" alt="">
                    </a>
                </div>
            </div>
        </div>
        <div class="we_are_ready_img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/person_with_computer.png" alt="">
        </div>
    </div>
</div>