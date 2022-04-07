<?php
    $price= mysqli_query($bd_connetction,"SELECT * FROM `cours-ei`");
    while($allprice=mysqli_fetch_assoc($price)){
        $tarif[] = $allprice;   
    }
$reverse_tarif = array_reverse($tarif);
$count_price=0;
    
?>

<div class="wrapper-cours">
    <div class="container cours">
        <div class="cours_img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/cours-ei.png" alt="">
        </div>
        <div class="cours-content">
            <p class="cours-start">старт 
                <?php $the_query = new WP_Query('p=192'); ?>
                    <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                        <?php the_title(); ?>   
                    <?php endwhile; ?>
                    <?php wp_reset_postdata();?>
            </p>
            <div class="cours-text">
                <h1>Курс ei</h1>
                <p>
                    Человеку нужен человек и этот человек - он  сам. Курс приведет к пониманию себя и  своего тела через нейросети.
                </p>
            </div>
        </div>
    </div>
</div>
<!--<div class="wrapper_cours-video">
    <div class="container">
        <div class="cours-video">
            <video controls preload="metadata" src="errors/bg.mp4">
            </video>
        </div>
        <div class="wrapper_cours-btn">
            <a href="#rates"><button class="course-btn">Записаться</button></a>
        </div>
    </div>
</div>-->
<div class="wrapper-base">
    <div class="container">
        <h2>БАЗА ГАРМОНИЧНЫХ ОТНОШЕНИЙ С ЕДОЙ, СОБОЙ И МИРОМ</h2>
        <div class="base">
            <div class="base-item">
                <div class="base-item_content">
                    <h3>Зацикленность на еде, теле, диете.</h3>
                    <p>Что я поем? Когда я поем? Сколько кг наберу или скину? Постоянный подсчет съеденного после еды занимают слишком много нашего жизненного пространства. Времени жить, наслаждаться, строить планы не остается.</p>
                </div>
            </div>
            <div class="base-item">
                <img src="<?php echo get_template_directory_uri(); ?>/images/course-base1.jpg" alt="X">
            </div>
            <div class="base-item">
                <img src="<?php echo get_template_directory_uri(); ?>/images/course-base2.jpg" alt="X">
            </div>
            <div class="base-item">
                <div class="base-item_content">
                    <h3>Сложно сделать выбор,</h3>
                    <p>начиная от блюда в ресторане, заканчивая вопросом “кто я?”, “кем я хочу быть”, “чего я на самом деле хочу”.</p>
                </div>
            </div>
            <div class="base-item">
                <div class="base-item_content">
                    <h3>Игнорировать свои потребности</h3>
                    <p>во благо окружающих и выйти в выходной на работу? - Всегда, пожалуйста! Съесть тортик, который не хочешь, чтобы не обидеть подругу? - Дайте два! Отсутствуют личные границы, и ты себе уже не принадлежишь.</p>
                </div>
            </div>
            <div class="base-item">
                <img src="<?php echo get_template_directory_uri(); ?>/images/course-base3.jpg" alt="X">
            </div>
        </div>
        <h2 class="cours-advertisement">Курс – это путевка в жизнь свободную от постоянной тревоги по поводу и без. </h2>
        <div class="wrapper_cours-btn">
            <a href="auth"><button class="course-btn" >Записаться</button></a>
        </div>
    </div>
</div>
<div class="wrapper-cours_forwho">
    <div class="container">
        <h2>Кому подходит курс?</h2>
        <div class="cours-forwho">

            <div id="d1" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s1" class ="cours-forwho_text">не различаешь эмоции, не умеешь с ними справляться.</span></p>
            </div>
            <script>
            
</script>
            <div id="d2" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s2" class ="cours-forwho_text">ешь, когда скучно, одиноко, на стрессе и когда испытываешь сильные эмоции: тревога,грусть, ликование…</span></p>
            </div>

            <div id="d3" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s3" class ="cours-forwho_text">избегаешь “плохую/вредную” еду: от картошки фри до творога с 5% жирностью вместо 0%.</span></p>
            </div>

            <div id="d4" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s4" class ="cours-forwho_text">злишься и винишь себя, когда съешь что-то вредное.</span></p>
            </div>

            <div id="d5" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s5" class ="cours-forwho_text">считаешь, что хорошую форму не сделать без ограничений.</span></p>
            </div>

            <div id="d6" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="ds6" class ="cours-forwho_text">веришь, что, когда похудеешь до идеала, тогда будешь достойна хорошей работы, отношений, и начнешь жить.</span></p>
            </div>

            <div id="d7" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s7" class ="cours-forwho_text">часто срываешься с ПП</span></p>
            </div>  

            <div id="d8" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s8" class ="cours-forwho_text">не различаешь эмоциональный и физический голод.</span></p>
            </div>

            <div id="d9" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s9" class ="cours-forwho_text">критикуешь себя, обесцениваешь свои успехи.</span></p>
            </div>

            <div id="d10" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s10" class  ="cours-forwho_text">не различаешь эмоции, не умеешь с ними справляться.</span></p>
            </div>

            <div id="d11" class="cours-forwho_item">
                <p><span class="you"> Ты </span><span id="s11" class ="cours-forwho_text">не принимаешь себя и свое тело.</span></p>
            </div>
        </div>
    </div>
</div>
<div class="wrapper-program">
    <div class="container">
        <h2>Программа курса:</h2>
        <div class="program">
            <div class="program-item">
                <div class="program-content">
                    <h3>Знакомство, определение <br> цели и построение <br> маршрута</h3>
                    <h4>Ты узнаешь:</h4>
                    <p>О способах и подходах <br> работы с рпп</p> <br>
                    <div class="program-result">
                        <h4>Результат:</h4>
                        <p>Получишь подробное описание <br> твоего случая со стороны <br> психологии, наша рекомендательная <br> система даст первые практические <br> упражнения, и ты начнешь двигаться <br> по своему индивидуальному маршруту</p>
                </div>
            </div>
                <span class='n1'>1</span>
            </div>

            <div class="program-item">
                
                <h3>Выявление <br> патологических <br> стратегий</h3>
                <h4>Ты узнаешь:</h4>
                <p>Что такое патологические <br> стратегии, как мы их формируем и <br> зачем они нам</p>
                <div class="program-result" style="height: 220px">
                    <h4>Результат:</h4>
                    <p>Заметишь свои основные стратегии, <br> определишь желаемые изменения в них, получишь от нашей <br> рекомендательной системы <br> дополнительные материалы для их <br> достижения</p>
                </div>
                <span class='n2'>2</span>
            </div>

            <div class="program-item">
                
                <h3>Семейный и <br> генетический <br> фактор </h3>
                <h4>Ты узнаешь:</h4>
                <p>Как влияют процессы в семье и <br> на работе на рпп, на <br> самовыражение и независимость</p>
                <div class="program-result">
                    <h4>Результат:</h4>
                    <p>Проанализируешь свой опыт <br> взросления и найдешь триггеры, <br> которые до сих пор влияют на тебя. <br> Наша рекомендательная система <br> предложит упражнения на <br> выстраивание границ, возвращение <br> ответственности только за твою <br> жизнь</p>
                </div>
                <span class='n3'>3</span>
            </div>

            <div class="program-item">
                
                <h3>Социальный фактор </h3>
                <h4>Ты узнаешь:</h4>
                <p>Как влияет социум на образ тела и <br> самоценность. Как дорого тебе <br> обходится идеал тела, еды и успешной <br> женщины, нарисованный обществом.</p>
                <div class="program-result">
                    <h4>Результат:</h4>
                    <p>Получишь подробное описание <br> твоего случая со стороны психологии, <br> наша рекомендательная система даст <br> первые практические упражнения, и <br> ты начнешь двигаться по своему <br> индивидуальному маршруту</p>
                </div>
                <span class='n4'>4</span>
            </div>

            <div class="program-item">
                
                <h3>Личный фактор </h3>
                <h4>Ты узнаешь:</h4>
                <p>Где во всей этой истории Я? Моя <br> ответственность, выбор, <br> осознанность</p><br>
                <div class="program-result">
                    <h4>Результат:</h4>
                    <p>Поймешь, где твои «хочу». Наша <br> рекомендательная система научит <br> выбирать себя и слышать сигналы <br> тела, эмоций и внутренних ощущений.</p>
                </div>
                <span class='n5'>5</span>
            </div>

            <div class="program-item">
                
                <h3>Трансформация</h3>
                <h4>Ты узнаешь:</h4>
                <p>Как переработать опыт, который <br> вы «раскопали» на курсе. Как его <br> трансформировать в новый.</p><br>
                <div class="program-result">
                    <h4>Результат:</h4>
                    <p>Введешь новые практики для работы с  <br>мыслями, убеждениями, эмоциями. <br> Наша рекомендательная система <br> познакомит с разными  подходами и<br> техниками для закрепления.</p> 
                </div>
                <span class='n6'>6</span>
            </div>

            <div class="program-item">
                
                <h3>Рефлексия. <br> Осознание результатов. <br> Планирование </h3>
                <h4>Ты узнаешь:</h4>
                <p>Какой путь ты уже прошла. </p>
                <div class="program-result">
                    <h4>Результат:</h4>
                    <p>Осознаешь сильные и слабые <br> стороны. Будешь уметь использовать <br> полученные на курсе инструменты, <br> чтобы жить, наслаждаться и строить <br> планы на будущее.</p>
                </div>
                <span class='n7'>7</span>
            </div>

            <div class="program-item">
                
                <h3> Ресурсы</h3>
                <h4>Ты получишь:</h4>
                <ul>
                    <li>Список рекомендуемых статей и книг;</li>
                    <li>Трансовая практика на возвращение <br> ресурсного состояния;</li>
                    <li>Практические упражнения на работу <br> с внутренним критиком; </li>
                    <li>Список для самоподдержки: 500 идей;</li>
                    <li>Гайд по эмоциональному и <br> физическому голоду; </li>
                    <li>Рисуночная техника «Мой образ тела» <br> на трансформацию отношения к себе.</li>
                    <li>Конспект лекции от детского <br> психолога об этапах становления <br> пищевого поведения ребенка</li>
                </ul>
                <div class="program-result">
                    <h4>Результат:</h4>
                    <p>Ты научишься поддерживать себя в  любой ситуации, когда тебе это  необходимо.</p>
                </div>
                <span class='n8'>8</span>
            </div>

            <div class="program-item">
                
                <h3>Фокус на теле, <br> движении</h3>
                <h4>Ты узнаешь:</h4>
                <p>О концепции интуитивного <br> движения. Как удовлетворять <br> физиологическую потребность в <br> движении, даже когда только <br> лишь мысли о фитнесе и спорте <br> вызывают отторжения.</p>
                <h4>Бонус!</h4>
                <p>-Расстяжка <br>
                -Занятие <br>-Тренировка</p>
                <div class="program-result">
                    <h4>Результат:</h4>
                    <p>Научишься удовлетворять свою потребность в физической <br> активности комфортно и в кайф, без насилия над собой.</p>
                </div>
                <span class='n9'>9</span>
            </div>
    </div>
</div>
</div>
<!-- <div class="wrapper-rates">
    <div class="container">
        <h2 id="rates">Тарифы</h2>
        <div class="rates">
                <div class="rate-item">

                    <?php $the_query = new WP_Query('p=149'); ?>
                    <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                    <h3><?php the_title(); ?></h3>    
                    <?php endwhile; ?>
                    <?php wp_reset_postdata();?>

                    <h4 class="rate-baza_h4">База</h4>
                    <div class="rate-content">
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Индивидуальный маршрут</p>
                        </div>
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Доступ к 7 этапам работы</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Бонус: задать свой вопрос в конце <br> курса по электронной почте и получить <br> от меня развернутый комментарий и <br> обратную связь</p>
                        </div>
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Групповой чат</p>
                        </div>
                        <div class="rate-text">
                            <img class="<?php echo get_template_directory_uri(); ?>/rate-text_img" src="images/cross.svg" alt="">
                            <p>3 групповых сессии в Zoom (ответы на <br> вопросы и проработка ваших <br> конкретных случаев)</p>
                        </div>
                        <div class="rate-text">
                            <img class="<?php echo get_template_directory_uri(); ?>/rate-text_img" src="images/cross.svg" alt="">
                            <p>Бонус: доступ к дополнительным <br> материалам: организация <br> пространства на кухне для <br> поддержания здоровых отношений с <br> едой, доступ к лекции о принятии <br> своего тела и себя</p>
                        </div>
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/cross.svg" alt="">
                            <p>2 личных сессии со мной</p>
                        </div>
                        <div class="rate-text">
                            <img class="<?php echo get_template_directory_uri(); ?>/rate-text_img" src="images/cross.svg" alt="">
                            <p>Бонус: 9 этап об интуитивном <br> движении, мини-тренировки от <br> приглашенных тренеров по танцам, <br> растяжке, функциональному тренингу <br> и осанке.</p>
                        </div>
                        <div class="rate-text">
                            <img class="<?php echo get_template_directory_uri(); ?>/rate-text_img" src="images/cross.svg" alt="">
                            <p>1 групповая сессия-поддержка после <br> курса через 3 недели</p>
                        </div>
                    </div>
                </div>
                
                <a href="#form" class="rate-btn baza-btn">
                        <button class="rates-btn">Купить</button>
                </a>
                
                

                <div class="rate-item">

                    <?php $the_query = new WP_Query('p=147'); ?>
                    <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                    <h3><?php the_title(); ?></h3>    
                    <?php endwhile; ?>
                    <?php wp_reset_postdata();?>
                    
                    <h4 class="rate-standart_h4">Стандарт</h4>
                    <div class="rate-content">
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Индивидуальный маршрут</p>
                        </div>
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Доступ к 8 этапам работы</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Бонус: задать свой вопрос в конце <br> курса по электронной почте и получить <br> от меня развернутый комментарий и <br> обратную связь</p>
                        </div>
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Групповой чат</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>3 групповых сессии в Zoom (ответы на <br> вопросы и проработка ваших <br> конкретных случаев)</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Бонус: доступ к дополнительным <br> материалам: организация <br> пространства на кухне для <br> поддержания здоровых отношений с <br> едой, доступ к лекции о принятии <br> своего тела и себя</p>
                        </div>
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/cross.svg" alt="">
                            <p>2 личных сессии со мной</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/cross.svg" alt="">
                            <p>Бонус: 9 этап об интуитивном <br> движении, мини-тренировки от <br> приглашенных тренеров по танцам, <br> растяжке, функциональному тренингу <br> и осанке.</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/cross.svg" alt="">
                            <p>1 групповая сессия-поддержка после <br> курса через 3 недели</p>
                        </div>
                        
                    </div>
                </div>
                <a href="#form" class="rate-btn stand-btn">
                        <button class="rates-btn">Купить</button>
                </a>

                <div class="rate-item">

                <?php $the_query = new WP_Query('p=144'); ?>
                <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                <h3><?php the_title(); ?></h3>    
                <?php endwhile; ?>
                <?php wp_reset_postdata();?>

                    <h4 class="rate-max_h4">Максимум</h4>
                    <div class="rate-content">
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Индивидуальный маршрут</p>
                        </div>
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Доступ к 7 этапам работы</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Бонус: задать свой вопрос в конце <br> курса по электронной почте и получить <br> от меня развернутый комментарий и <br> обратную связь</p>
                        </div>
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Групповой чат</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>3 групповых сессии в Zoom (ответы на <br> вопросы и проработка ваших <br> конкретных случаев)</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Бонус: доступ к дополнительным <br> материалам: организация <br> пространства на кухне для <br> поддержания здоровых отношений с <br> едой, доступ к лекции о принятии <br> своего тела и себя</p>
                        </div>
                        <div class="rate-text">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>2 личных сессии со мной</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>Бонус: 9 этап об интуитивном <br> движении, мини-тренировки от <br> приглашенных тренеров по танцам, <br> растяжке, функциональному тренингу <br> и осанке.</p>
                        </div>
                        <div class="rate-text">
                            <img class="rate-text_img" src="<?php echo get_template_directory_uri(); ?>/images/check.svg" alt="">
                            <p>1 групповая сессия-поддержка после <br> курса через 3 недели</p>
                        </div>
                        
                    </div>
                </div>
                <a href="#form" class="rate-btn max-btn">
                        <button class="rates-btn">Купить</button>
                </a>
        </div>
        <div class="all-materials">
            <p>* Все материалы курса будут приходить тебе на электронную почту, также в Телеграм канале курса мы будем напоминать о рассылках на <br> каждом этапе, групповой чат также будет в Телеграм. Просим тебя внимательно заполнять твои контактные данные, чтобы ты точно <br> получила все материалы своего маршрута.</p>
        </div>
    </div>
</div> -->
<div class="wrapper-reviews">
    <hr>
    <div class="container">
        <h2>Отзывы</h2>
        

                    <div class="sim-slider">
            <ul class="sim-slider-list">
                <li><img class="sim-slider_bg" src="http://pvbk.spb.ru/inc/slider/imgs/no-image.gif" alt="screen"></li> <!-- это экран -->
                <li id="img1" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review1.svg" alt="1"></li>
                <li id="img2" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review2.svg" alt="2"></li>
                <li id="img3" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review3.svg" alt="3"></li>
                <li id="img4" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review4.svg" alt="4"></li>
                <li id="img5" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review5.svg" alt="5"></li>
                <li id="img6" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review6.svg" alt="6"></li>
                <li id="img7" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review7.svg" alt="7"></li>
                <li id="img8" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review8.svg" alt="8"></li>
                <li id="img9" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review9.svg" alt="9"></li>
                <li id="img10" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review10.svg" alt="10"></li>
                <li id="img11" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review11.svg" alt="11"></li>
                <li id="img12" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review12.svg" alt="12"></li>
                <li id="img13" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review13.svg" alt="13"></li>
                <li id="img14" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review14.svg" alt="14"></li>
                <li id="img15" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review15.svg" alt="15"></li>
                <li id="img16" class="sim-slider-element"><img src="<?php echo get_template_directory_uri(); ?>/images/review16.svg" alt="16"></li>
            </ul>
            <div class="sim-slider-arrow-left"><img class="l-arrow" src="<?php echo get_template_directory_uri(); ?>/images/Arrow.png" alt=""></div>
            <div class="sim-slider-arrow-right"><img class="r-arrow" src="<?php echo get_template_directory_uri(); ?>/images/Arrow.png" alt=""></div>

            
            <div class="sim-slider-dots"></div>
            </div>

        <script>function Sim(sldrId) {

let id = document.getElementById(sldrId);
if(id) {
    this.sldrRoot = id
}
else {
    this.sldrRoot = document.querySelector('.sim-slider')
};

// Carousel objects
this.sldrList = this.sldrRoot.querySelector('.sim-slider-list');
this.sldrElements = this.sldrList.querySelectorAll('.sim-slider-element');
this.sldrElemFirst = this.sldrList.querySelector('.sim-slider-element');
this.leftArrow = this.sldrRoot.querySelector('div.sim-slider-arrow-left');
this.rightArrow = this.sldrRoot.querySelector('div.sim-slider-arrow-right');
this.indicatorDots = this.sldrRoot.querySelector('div.sim-slider-dots');

// Initialization
this.options = Sim.defaults;
Sim.initialize(this)
};

Sim.defaults = {

// Default options for the carousel
loop: true,     // Бесконечное зацикливание слайдера
auto: true,     // Автоматическое пролистывание
interval: 5000, // Интервал между пролистыванием элементов (мс)
arrows: true,   // Пролистывание стрелками
dots: true      // Индикаторные точки
};

Sim.prototype.elemPrev = function(num) {
num = num || 1;

let prevElement = this.currentElement;
this.currentElement -= num;
if(this.currentElement < 0) this.currentElement = this.elemCount-1;

if(!this.options.loop) {
    if(this.currentElement == 0) {
        this.leftArrow.style.display = 'none'
    };
    this.rightArrow.style.display = 'block'
};

this.sldrElements[this.currentElement].style.opacity = '1';
this.sldrElements[prevElement].style.opacity = '0';

if(this.options.dots) {
    this.dotOn(prevElement); this.dotOff(this.currentElement)
}
};

Sim.prototype.elemNext = function(num) {
num = num || 1;

let prevElement = this.currentElement;
this.currentElement += num;
if(this.currentElement >= this.elemCount) this.currentElement = 0;

if(!this.options.loop) {
    if(this.currentElement == this.elemCount-1) {
        this.rightArrow.style.display = 'none'
    };
    this.leftArrow.style.display = 'block'
};

this.sldrElements[this.currentElement].style.opacity = '1';
this.sldrElements[prevElement].style.opacity = '0';

if(this.options.dots) {
    this.dotOn(prevElement); this.dotOff(this.currentElement)
}
};

Sim.prototype.dotOn = function(num) {
this.indicatorDotsAll[num].style.cssText = 'background-color:#202020;; cursor:pointer;width: 7px;height: 7px;bottom: 1px;position: relative;'
};

Sim.prototype.dotOff = function(num) {
this.indicatorDotsAll[num].style.cssText = 'background-color:#fff; cursor:default;'
};

Sim.initialize = function(that) {

// Constants
that.elemCount = that.sldrElements.length; // Количество элементов

// Variables
that.currentElement = 0;
let bgTime = getTime();

// Functions
function getTime() {
    return new Date().getTime();
};
function setAutoScroll() {
    that.autoScroll = setInterval(function() {
        let fnTime = getTime();
        if(fnTime - bgTime + 10 > that.options.interval) {
            bgTime = fnTime; that.elemNext()
        }
    }, that.options.interval)
};

// Start initialization
if(that.elemCount <= 1) {   // Отключить навигацию
    that.options.auto = false; that.options.arrows = false; that.options.dots = false;
    that.leftArrow.style.display = 'none'; that.rightArrow.style.display = 'none'
};
if(that.elemCount >= 1) {   // показать первый элемент
    that.sldrElemFirst.style.opacity = '1';
};

if(!that.options.loop) {
    that.leftArrow.style.display = 'none';  // отключить левую стрелку
    that.options.auto = false; // отключить автопркрутку
}
else if(that.options.auto) {   // инициализация автопрокруки
    setAutoScroll();
    // Остановка прокрутки при наведении мыши на элемент
    that.sldrList.addEventListener('mouseenter', function() {clearInterval(that.autoScroll)}, false);
    that.sldrList.addEventListener('mouseleave', setAutoScroll, false)
};

if(that.options.arrows) {  // инициализация стрелок
    that.leftArrow.addEventListener('click', function() {
        let fnTime = getTime();
        if(fnTime - bgTime > 1000) {
            bgTime = fnTime; that.elemPrev()
        }
    }, false);
    that.rightArrow.addEventListener('click', function() {
        let fnTime = getTime();
        if(fnTime - bgTime > 1000) {
            bgTime = fnTime; that.elemNext()
        }
    }, false)
}
else {
    that.leftArrow.style.display = 'none'; that.rightArrow.style.display = 'none'
};

if(that.options.dots) {  // инициализация индикаторных точек
    let sum = '', diffNum;
    for(let i=0; i<that.elemCount; i++) {
        sum += '<span class="sim-dot"></span>'
    };
    that.indicatorDots.innerHTML = sum;
    that.indicatorDotsAll = that.sldrRoot.querySelectorAll('span.sim-dot');
    // Назначаем точкам обработчик события 'click'
    for(let n=0; n<that.elemCount; n++) {
        that.indicatorDotsAll[n].addEventListener('click', function() {
            diffNum = Math.abs(n - that.currentElement);
            if(n < that.currentElement) {
                bgTime = getTime(); that.elemPrev(diffNum)
            }
            else if(n > that.currentElement) {
                bgTime = getTime(); that.elemNext(diffNum)
            }
            // Если n == that.currentElement ничего не делаем
        }, false)
    };
    that.dotOff(0);  // точка[0] выключена, остальные включены
    for(let i=1; i<that.elemCount; i++) {
        that.dotOn(i)
    }
}
};

new Sim();</script>

    </div>
    <hr>
    <div class="container">
        <div class="go-contacts">
            <p>Если ты не нашла ответ на свой вопрос и хочешь проконсультироваться по поводу <br> курса,напиши свой вопрос в </p>
            <div class="go-contacts_a">
                <a href="contacts">Контакты</a>
            </div>
            
        </div>
    </div>
</div>

