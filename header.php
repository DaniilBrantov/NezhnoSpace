<?php 
    @ob_start();
    session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title("", true); ?></title>
    <meta name="yandex-verification" content="d821d01bf0467793" />
    <script src="https://yookassa.ru/checkout-widget/v1/checkout-widget.js"></script>
    <?php wp_head(); ?>
</head>

<body>
    <header class="header">
        <div class="header_wrap">
            <button class="header_btn"></button>
            <div class="header_logo">
                <a href="/">
                    <img src="<?php img('logo.svg') ?>" alt="">
                </a>
            </div>
            <nav class="nav header_nav">
                <?php if (!$_SESSION['user'] && !$_SESSION['admin']) { 
                        wp_nav_menu(array(
                            'theme_location'=> 'mainmenu',
                            'menu_class'=> 'nav_list'
                        ));
                ?>
            </nav>
            <?php
                    }else{
                        wp_nav_menu(array(
                            'theme_location'=> 'mainmenu',
                            'menu_class'=> 'nav_item'
                        ));
                ?>
            </nav>
            <?php
                    };
            if(!$_SESSION['id']){ ?>
            <a href="auth" class="header_user">
                <img src="<?php img('user.svg') ?>" alt="user">
            </a>
            <a class="header-btn" href="registration">Старт</a>
            <?php }else{ ?>
            <a href="auth" class="header_user">
                <img src="<?php img('user.svg') ?>" alt="user">
            </a>
            <a class="header-btn" href="auth-check?action=out">Выйти</a>

        </div>
        <div class="header_auth">
            <ul class="account_navigation-list navigation-list_slider">
                <li class="active account_fullname"><a href="https://nezhno.space/account">Мои данные</a></li>
                <li class="account_subscription"><a href="https://nezhno.space/subscription">Моя подписка</a></li>
                <!-- <li class="account_calendar"><a href="">Календарь</a></li> -->
            </ul>
        </div>
        <?php }; ?>
    </header>