<?php 
    @ob_start();
    session_start();
    $_SESSION['id'] = 1;
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нежно</title>

    <link rel="nezhno_icon_180" sizes="180x180" href="<?php getUrl(); ?>/favicon/nezhno_icon_180x180.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php getUrl(); ?>/favicon/nezhno_icon_32x32.png">
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="<?php getUrl(); ?>/favicon/nezhno_icon_16x16.png"> -->
    <link rel="manifest" href="<?php getUrl(); ?>/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php getUrl(); ?>/favicon/nezhno_icon_1280x1280.svg" color="#5bbad5">

    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />

    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="yandex-verification" content="d821d01bf0467793" />
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
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
                <ul id="menu-mainmenu" class="nav_list"><li id="menu-item-54" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-40 current_page_item menu-item-54"><a href="index" aria-current="page" class="nav_active">Главная</a></li>
                    <li id="menu-item-792" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-792"><a href="about">О нас</a></li>
                    <li id="menu-item-790" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-790"><a href="blog">Блог</a></li>
                </ul>
            </nav>
            <?php
                   
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
                <li class="account_calendar"><a href="">Календарь</a></li>
            </ul>
        </div>
        <?php }; ?>
    </header>