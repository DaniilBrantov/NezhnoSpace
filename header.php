<?php 
    @ob_start();
    session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нежно</title>

    <!-- <link type="image/x-icon" rel="shortcut icon" href="…/nezhno_icon.ico"> -->
    <link type="image/png" sizes="16x16" rel="icon" href="<? getUrl(); ?>favicon/nezhno_icon_16x16.png">
    <link type="image/png" sizes="32x32" rel="icon" href="<? getUrl(); ?>favicon/nezhno_icon_32x32.png">
    <link type="image/png" sizes="96x96" rel="icon" href="<? getUrl(); ?>favicon/nezhno_icon_96x96.png">
    <link type="image/png" sizes="120x120" rel="icon" href="<? getUrl(); ?>favicon/nezhno_icon_120x120.png">
    <link type="image/png" sizes="192x192" rel="icon" href="<? getUrl(); ?>favicon/nezhno_icon_192x192.png">

    <!-- IOS -->
    <link sizes="57x57" rel="apple-touch-icon" href="…/apple-touch-icon-57x57.png">
    <link sizes="60x60" rel="apple-touch-icon" href="…/apple-touch-icon-60x60.png">
    <link sizes="72x72" rel="apple-touch-icon" href="…/apple-touch-icon-72x72.png">
    <link sizes="76x76" rel="apple-touch-icon" href="…/apple-touch-icon-76x76.png">
    <link sizes="114x114" rel="apple-touch-icon" href="…/apple-touch-icon-114x114.png">
    <link sizes="120x120" rel="apple-touch-icon" href="…/apple-touch-icon-120x120.png">
    <link sizes="144x144" rel="apple-touch-icon" href="…/apple-touch-icon-144x144.png">
    <link sizes="152x152" rel="apple-touch-icon" href="…/apple-touch-icon-152x152.png">
    <link sizes="180x180" rel="apple-touch-icon" href="…/apple-touch-icon-180x180.png">

    <!-- MacOS -->
    <link color="#e52037" rel="mask-icon" href="…/safari-pinned-tab.svg">

    <!-- Windows -->
    <meta name="msapplication-TileImage" content="…/mstile-144x144.png">
    <meta name="msapplication-square70x70logo" content="…/mstile-70x70.png">
    <meta name="msapplication-square150x150logo" content="…/mstile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="…/mstile-310x310.png">
    <meta name="msapplication-square310x310logo" content="…/mstile-310x150.png">


    <meta name="msapplication-TileColor" content="#D1E4FF">
    <meta name="theme-color" content="#F2F2F2">
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
                    <img src="<?php getUrl(); ?>/images/logo.svg" alt="">
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
                <img src="<?php getUrl(); ?>/images/user.svg" alt="user">
            </a>
            <a class="header-btn" href="registration">Старт</a>
            <?php }else{ ?>
            <a href="auth" class="header_user">
                <img src="<?php getUrl(); ?>/images/user.svg" alt="user">
            </a>
            <a class="header-btn" href="auth-check?action=out">Выйти</a>

        </div>
        <div class="header_auth">
            <ul class="account_navigation-list navigation-list_slider">
                <li class="active account_fullname"><a href="account">Мои данные</a></li>
                <li class="account_subscription"><a href="subscription">Моя подписка</a></li>
                <!-- <li class="account_calendar"><a href="">Календарь</a></li> -->
            </ul>
        </div>
        <?php }; ?>
    </header>