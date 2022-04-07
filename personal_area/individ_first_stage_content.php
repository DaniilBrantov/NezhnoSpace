<?php 
    session_start();
    require_once 'connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    $user_id=$_SESSION['user']['id'];
    $route_value=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT `route_value` FROM `users` WHERE `id`='$user_id'"));
    $route_val=$route_value['route_value'];
    if ($route_val==0){
        header('Location: first_stage');
    }else{
        if($route_val==1 || $route_val==4){
            $image='purple_robot.png';
            $txt=[
                "1. <span>Вспомни</span> 2-3 последних эпизода, когда ты заела свой эмоциональный дискомфорт",
                "2. <span>Опиши</span> каждый по схеме ниже:
                <ul>
                    <li>
                        Какая ситуация его вызвала?
                    </li>
                    <li>
                        Какие эмоции и чувства ты испытала в этой ситуации? С помощью диаграммы эмоций попробуй найти и назвать эмоцию.
                    </li>
                    <li>
                        Есть ли закономерность в твоих действиях? Например, произошел стресс - я почувствовал гнев - я заел эмоцию сладким.
                    </li>
                </ul>"
            ];
            if($route_val==1){
                $audio='emotiog_type.mp3';
                $video='https://www.youtube.com/embed/chLq5gmvgX4';
            }else{
                $audio='smesh_type.mp3';
                $video='https://www.youtube.com/embed/9OfHQlmO4J8';
            }
        }else if($route_val==2){
            $image='purple_robot.png';
            $audio='ekstern_type.mp3';
            $video='https://www.youtube.com/embed/wToJbAcdBoQ';
            $txt=[
                "1. <span>Прохлопай</span> свое тело снизу вверх, начиная с ног, доходя до головы и лица, делай это ощутимо, но бережно к себе. Этот простой способ возвращает нас в осознанность.",
                "2. <span>Попробуй</span> закрыть глаза на пару минут. Пройдись мысленным сканером по каждому участку тела – и оно подскажет, что тебе на самом деле необходимо.",
                "3. <span>Вернись</span> в свое привычное положение, прислушайся к ощущениям. Может, у тебя затекла спина? ",
                "4. <span>Ответь</span> прямо сейчас на свою телесную потребность. Попробуй пройтись и размяться. Поменяй положение тела. Сделай глубокий вдох."
            ];
        }else if($route_val==3){
            $image='purple_robot.png';
            $audio='ogranich_type.mp3';
            $video='https://www.youtube.com/embed/0frR8ckE02E';
            $txt=[
                "1. <span>Выпиши</span> 5-6 областей твоей жизни, где тебе важен успех (вместе с формой и весом, контролем за питанием)",
                "2. <span>Ранжируй</span> элементы самооценки с точки зрения их важности. Спроси себя: 'Если что-то пойдет не так в этой области, насколько это мне повредит?'",
                "3. <span>Нарисуй</span> круговую диаграмму самооценки, сделав каждый элемент «кусочком» пирога.",
                "4. <span>Выпиши</span> 3 дела из областей помимо формы тела, которые ты сможешь осуществить уже в ближайшие 72 часа.",
                "5. <span>Выполни</span> эти 3 дела"
            ];
        }else if($route_val==4){
            
        }
    } ?>

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
                        <p>Человеку нужен человек и этот человек - он сам. Курс приведет к пониманию себя и своего тела через нейросети. </p>
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
                        <h2>Курсы</h2>
                        <p>Человеку нужен человек и этот человек - он сам. Курс приведет к пониманию себя и своего тела через нейросети. </p>
                    </div>
                    <div class="general_btn subscr_cours_btn">
                        <a href="cours">
                            <button id="our_trainings_btn_3">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                            </button>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

