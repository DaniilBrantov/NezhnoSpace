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
    <script src="https://yookassa.ru/checkout-widget/v1/checkout-widget.js"></script>



    <?php wp_head(); ?>
</head>

<body>
    <header class="header">
        <div class="header_wrap">
            <button class="header_btn">
                <img class="header_open" src="<?php getUrl(); ?>/images/menu.svg" alt="menu open button">
                <img class="header_close visually-hidden" src="<?php getUrl(); ?>/images/menu-close.svg"
                    alt="menu close button">
            </button>
            <div class="header_logo">
                <a href="/">
                    <img src="<?php getUrl(); ?>/images/logo.png" alt="">
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
            <a href="auth" class="header_user">
                <img src="<?php getUrl(); ?>/images/user.svg" alt="user">
            </a>
            <a class="header-btn" href="auth">Старт</a>
            <?php
                    }else{
                        wp_nav_menu(array(
                            'theme_location'=> 'mainmenu',
                            'menu_class'=> 'nav_item'
                        ));
                ?>
            </nav>
            <a href="auth" class="header_user">
                <img src="<?php getUrl(); ?>/images/user.svg" alt="user">
            </a>
            <a class="header-btn" href="">Привет</a>
            <?php
                    };
                ?>
        </div>
    </header>