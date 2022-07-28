<?php
session_start();
require_once "connect.php";
if (!$_SESSION['user']) {
    $href="https://nezhno.space/registration";
    $order="3";
}else{
    $href="https://nezhno.space/payment";
    $order="1";
}

?>




<div class="wrapper_subscription">
    <div class="container">
        <div class="subscription">
            <div class="subcription_cnt">
                <h1>Подписка ei</h1>
                <p>Нежно - онлайн платформа психологической поддержки и заботы о себе. Мы часто не принимаем себя и свое тело. Заедаем проблемы и эмоции. Испытываем стресс, тревожимся. Не понимаем: что делать дальше? </p>
                <p>Наша платформа поможет тебе принимать свое тело и справляться с эмоциями. Мы поддержим и направим тебя на путь к здоровым отношениям с едой, своим телом и окружающими. </p>
                <form action="<?php echo $href; ?>" method='post'>
                    <input id="order" type="hidden" value="<?php echo $order; ?>" name="order">
                    <input type="hidden" value="300" name="sum">
                    <button class="wht_btn_with_arr" type="submit"><p>Попробовать</p><img src="<?php echo get_template_directory_uri(); ?>/images/btn_arrow_black.svg" alt=""></button>
                </form>
            </div>
            <div class="subcription_img">
                <img src="<?php echo get_template_directory_uri(); ?>/images/purple_robot.png" alt="">
            </div>
        </div>


        <div class="vulnerable_places">
            
            <div class="vulnerable_places_cnt">
                <h2>
                Что ты здесь найдешь?
            </h2>
                <p>Ты получишь 4 материала по теме месяца:</p>
                <ol>
                    <li>
                        Психообразование: подкаст
                    </li>
                    <li>
                        Статья от приглашенного специалиста
                    </li>
                    <li>
                        Гайд: подборка книг, фильмов и проектов
                    </li>
                    <li>
                        Терапия: тесты и упражнения
                    </li>
                </ol>
                <p>Мы посмотрим, что влияет на твои отношения с едой и телом, собой и миром.</p>
                <form class="btn_wht_u_find" action="<?php echo $href; ?>" method='post'>
                    <input id="order" type="hidden" value="<?php echo $order; ?>" name="order">
                    <input type="hidden" value="300" name="sum">
                    <button class="wht_btn_with_arr" type="submit"><p>Попробовать</p><img src="<?php echo get_template_directory_uri(); ?>/images/btn_arrow_black.svg" alt=""></button>
                </form>
            </div>
        </div>


        <div class="subscription_elements">
            <div class="subscription_item">
                <h3 class="subscription_item_title">
                    Темы на год:
                </h3>
                <div class="subscription_item_txt">
                    <ol>
                        <li>
                        качество жизни
                        </li>
                        <li>
                        тревожность
                        </li>
                        <li>
                        кризисы
                        </li>
                        <li>
                        деньги
                        </li>
                        <li>
                        отношения
                        </li>
                        <li>
                        карьера
                        </li>
                        <li>
                        сексуальность
                        </li>
                        <li>
                        тело
                        </li>
                        <li>
                        выгорание
                        </li>
                        <li>
                        эмоции
                        </li>
                        <li>
                        уверенность в себе
                        </li>
                        <li>
                        самооценка
                        </li>
                    </ol>
                </div>
                <!-- <p class="subscription_item_num">
                    1
                </p> -->
            </div>
            <div class="subscription_item">
                <h3 class="subscription_item_title">
                    База материалов и онлайн-занятий с психологами, которых нет в открытом доступе:
                </h3>
                <div class="subscription_item_txt">
                    <ul>
                        <li>
                            лекция с практикой, как определиться с запросом
                        </li>
                        <li>
                            7-минутная практика на расслабление (йога)
                        </li>
                        <li>
                            гайд от нутрициолога
                        </li>
                        <li>
                            гормоны счастья от эндокринолога
                        </li>
                        <li>
                            карманная медитация на снятие тревожности
                        </li>
                        <li>
                            и др.
                        </li>
                    </ul>
                </div>
                <!-- <p class="subscription_item_num">
                    2
                </p> -->
            </div>
            <div class="subscription_item">
                <h3 class="subscription_item_title">
                    Наш искусственный интеллект
                </h3>
                <div class="subscription_item_txt">
                <p>
                    подстраивается под тебя и обучается на твоих подсказках. Для того, чтобы рекомендательная система обучалась, достаточно просто использовать платформу Нежно
                </p>
                </div>
                <!-- <p class="subscription_item_num">
                    3
                </p> -->
            </div>
        </div>
        <!-- <div class="your_conductor">
            <div class="your_conductor_title">
                Твой первый шаг к более глубокому пониманию себя начинается здесь и сейчас.</span></h2>
                
            </div>
            <div class="your_conductor_btns">
                <div class="your_conductor_link">
                    <form action="https://nezhno.space/payment" method='post'>
                        <input type="hidden" value="1" name="order">
                        <input type="hidden" value="300" name="sum">
                        <button type="submit">
                                Оформить Подписку
                            <p>
                                300P
                                <span style="color:#F2C0E3; text-decoration: line-through;">
                                    <span style="color:#F2C0E3;
                                    font-size:18px;
                                    position: relative;
                                    top: -10px;">
                                        700P
                                    </span>
                            </span> 
                            </p>

                        </button>
                    </form>
                </div>
                <div>
                <form action="<?php echo $href; ?>" method='post'>
                    <input id="order" type="hidden" value="<?php echo $order; ?>" name="order">
                    <input type="hidden" value="300" name="sum">
                    <button class="wht_btn_with_arr try_1_week" type="submit"><p>Попробовать 1 неделю бесплатно</p></button>
                </form>
                </div>
            </div>
            
        </div> -->
    </div>
        <div class="pay_subscription">
            <div class="pay_subscription_title">
                <h2>
                    Начни заботиться о себе с Нежно
                </h2>
            </div>
            <div class="pay_subscription_cards">
                <form action="<?php echo $href; ?>" method='post'>
                    <input id="order" type="hidden" value="<?php echo $order; ?>" name="order">
                    <input type="hidden" value="7" name="sum">
                    <input type="hidden" value="1" name="rate">
                    <button class="pay_subscription_card" type="submit">
                        <div style="background: rgba(255, 255, 255, 0.4);" class="pay_subscription_card_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/pay_subscription_card_1.png" alt="">
                        </div>
                        <div class="pay_subscription_card_cnt">
                                <h4>
                                    1 месяц
                                </h4>
                                <div class="pay_subscription_card_flex">
                                    <div class="pay_subscription_card_txt">
                                        <p>
                                            первые 7 дней за 7 ₽
                                        </p>
                                    </div>
                                    <div class="pay_subscription_price">
                                        700 ₽ / <span>месяц</span> 
                                    </div>
                                </div>
                        </div>
                    </button>
                </form>
                
                <form action="<?php echo $href; ?>" method='post'>
                    <input id="order" type="hidden" value="<?php echo $order; ?>" name="order">
                    <input type="hidden" value="7" name="sum">
                    <input type="hidden" value="2" name="rate">
                    <button class="pay_subscription_card" type="submit">
                        <div style="background: rgba(27, 27, 27, 0.8);" class="pay_subscription_card_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/pay_subscription_card_2.png" alt="">
                        </div>
                        <div class="pay_subscription_card_cnt">
                                <h4>
                                    6 месяцев
                                </h4>
                                <div class="pay_subscription_card_flex">
                                    <div class="pay_subscription_card_txt">
                                        <p>
                                            первые 7 дней за 7 ₽
                                        </p>
                                    </div>
                                    <div class="pay_subscription_price">
                                        3600 ₽
                                    </div>
                                </div>
                        </div>
                    </button>
                </form>

                <form action="<?php echo $href; ?>" method='post'>
                    <input id="order" type="hidden" value="<?php echo $order; ?>" name="order">
                    <input type="hidden" value="7" name="sum">
                    <input type="hidden" value="3" name="rate">
                    <button style="box-shadow: 0 0 15px 7px rgb(77, 77, 77);" class="pay_subscription_card" type="submit">
                        <div style="background: #101010;" class="pay_subscription_card_img">
                            <div class="pay_subscription_benefit">
                                    Выгода 15%
                            </div>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/pay_subscription_card_3.png" alt="">
                        </div>
                        <div class="pay_subscription_card_cnt">
                                <h4>
                                    1 год
                                </h4>
                                <div class="pay_subscription_card_flex">
                                    <div class="pay_subscription_card_txt">
                                        <p>
                                            первые 7 дней за 7 ₽
                                        </p>
                                        <p>
                                            500₽ / месяц
                                        </p>
                                    </div>
                                    <div class="pay_subscription_price">
                                    <div class="dot">
                                        <div class="dot-pulse"></div>
                                    </div>
                                        6000 ₽ 
                                    </div>
                                </div>
                        </div>
                    </button>
                </form>
            </div>
        </div>
</div>
