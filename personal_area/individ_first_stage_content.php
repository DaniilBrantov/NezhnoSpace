<?php 
    session_start();
    require_once 'connect.php';
    require_once 'individ_first_stage_check.php';

?>

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
            Твой первый шаг Индивидуального маршрута
        </h1>
        <hr>
        <div class="stage_youtube">
        <iframe src="<?php echo $video; ?>" title="Ciao, bella!" width="900" height="600" frameborder="0" allowfullscreen></iframe>
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
                            <span>Ты получишь 4 материала по теме месяца:</span>  
                            <p>1. Психообразование: подкаст.</p>
                            <p>2. Статья от приглашенного специалиста.</p>
                            <p>3. Гайд: подборка книг, фильмов и проектов.</p>
                            <p>4. Терапия: тесты и упражнения.</p>
                            <p><span class="doing_this">Оформи подписку.</span> Посмотри на важные контексты жизни, которые влияют на твои отношения с собой и миром.</p>
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
                            <span>Ты получишь:</span> 
                            <p>8 основных этапов с теорией, практикой и тестами.</p>
                            <p>Индивидуальный маршрут. Он уникален и будет создаваться специально под тебя.</p> 
                            <p>4 групповых онлайн занятия с психологами</p>
                            <p>Доступ к курсу будет открыт 8 недель.</p> 
                            <p><span class="doing_this"> Пройди курс.</span> Погрузись глубоко в причины твоих нарушений пищевого поведения и реши проблему комплексно.</p>
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
<div class="wrapper_practice">
    <div class="first_stage_container practice_flex">
        <div class="practice">
            <h2>
                Практика
            </h2>
            <div class="audio_cont practice_audio">
                <audio id="audio" controls preload="none">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $audio; ?>" type="audio/mpeg">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $audio; ?>" type="audio/ogg">
                    Ваш Браузер не поддерживает данный формат audio.
                </audio>
            </div>
            <div class="practice_cnt">
                <h3>
                    <span>Инструкция:</span>
                </h3>
                <div class="practice_txt">
                    <ul>
                        <li>
                            <p>
                                <?php echo $txt[0]; ?>
                            </p>
                        </li>
                        <li>
                            <p>
                                <?php echo $txt[1]; ?>
                            </p>
                        </li>
                        <li>
                            <p>
                            <?php echo $txt[2]; ?>
                            </p>
                        </li>
                        <li>
                            <p>
                            <?php echo $txt[3]; ?>
                            </p>
                        </li>
                        <li>
                            <p>
                            <?php echo $txt[4]; ?>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="practice_img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $image; ?>" alt="">
        </div>
    </div>
</div>
<div class="wrapper_subscr_cours">
    <div class="container">
        <div class="subscr_cours">
            <div class="subscr_cours_item subscr_item_link">
                <div class="subscr_cours_cnt">
                    <div class="subscr_cours_txt">
                        <h2>Подписка</h2>
                        <p>Оформи Подписку. Посмотри на важные контексты жизни, которые влияют на твои отношения с собой и миром.</p>
                    </div>
                    <div class="general_btn subscr_cours_btn">
                        <a href="subscription">
                            <button onclick="forYouTxt_3()" id="our_trainings_btn_3">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                            </button>
                        </a>
                        
                    </div>
                </div>
            </div>
            <div class="subscr_cours_item cours_item_link">
                <div class="subscr_cours_cnt">
                    <div class="subscr_cours_txt">
                        <h2>Курс</h2>
                        <p>Пройди Курс. Погрузись глубоко в причины твоих нарушений пищевого поведения и реши проблему комплексно.</p>
                    </div>
                    <div class="general_btn subscr_cours_btn">
                        <form action="https://eatintelligent.ru/payment" method='post'>
                                <input type="hidden" value="2" name="order">
                                <input type="hidden" value="7000" name="sum">
                                <button id="our_trainings_btn_3">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                                </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

