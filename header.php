<?php 
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Нежно Space — платформа для психотерапии</title>
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title("", true); ?></title>
    <!-- <script src="https://yookassa.ru/checkout-widget/v1/checkout-widget.js"></script> -->
    <script src="https://widget.cloudpayments.ru/bundles/cloudpayments.js"></script>
    <?php wp_head(); ?>
    <!-- <meta name="yandex-verification" content="d821d01bf0467793" /> -->

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
    m[i].l=1*new Date();
    for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
    k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(90670398, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
    });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/90670398" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
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
            <div class="header_right">
                <a href="auth" class="header_user">
                    <img src="<?php img('user.svg') ?>" alt="user">
                </a>
                <a class="header-btn" href="confirm-anxiety">
                    Старт
                </a>
            </div>
            <?php }else{ ?>
                <div class='header_btn-mobile'>
                <a href="https://nezhno.space/auth" class="header_user">
                    <img src="<?php img('user.svg') ?>" alt="user">
                </a>
                <a href="https://nezhno.space/auth-check?action=out" class="header_logout-mobile">
                    <img src="<?php img('signout.svg') ?>" alt="signout">
                </a>
                </div>
            <a class="header-btn" href="https://nezhno.space/auth-check?action=out">Выйти</a>
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