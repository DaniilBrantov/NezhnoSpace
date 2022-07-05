<?php 

    @ob_start();
    session_start();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eat Intelligent</title>

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="yandex-verification" content="d821d01bf0467793" />

    <link href="<?php echo get_template_directory_uri(); ?>/css/hamburgers.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css">
    <link href="<?php echo get_template_directory_uri(); ?>/css/header.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/main_content.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/blog.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/companies.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/footer.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/about_us.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/services_content.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/page-blog.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/contacts_content.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/form.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/404.css" rel="stylesheet" type="text/css">
    <link href="<?php echo get_template_directory_uri(); ?>/css/cours-ei.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/documents.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/single.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/libs/phone/css/intlTelInput.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/libs/modal/modal.css">
    <link href="<?php echo get_template_directory_uri(); ?>/css/personal_area.css" rel="stylesheet">
    

    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/libs/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/libs/slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <script src="https://yookassa.ru/checkout-widget/v1/checkout-widget.js"></script>



    <?php wp_head(); ?>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-row">
                <button class="hamburger hamburger--squeeze header__menu-toggle js-menu-toggle" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
                <div class="header__logo">
                    <a href="/">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="Logo" width="60">
                    </a>
                </div>
                <?php if (!$_SESSION['user'] && !$_SESSION['admin']) { 
                    wp_nav_menu(array(
                        'theme_location'=> 'mainmenu',
                        'menu_class'=> 'header__menu'
                    ))
                ?>
                <div class="header__right">
                    <a href="tel:+9063663550" class="header__right_item">
                        <ion-icon name="call-outline"></ion-icon>
                    </a>
                    <a href="auth" class="header__right_item">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </a>
                </div>
                <?php } 
                else { ?>
                    <ul class="header__menu">
                        <li>
                            <a href="my_account">Аккаунт</a>
                        </li>
                        <li>
                            <a href="uchebnaya-programma">Этапы</a>
                        </li>
                        <li>
                            <a href="help">Помощь</a>
                        </li>
                        <li>
                            <a href="for-business">Для бизнеса</a>
                        </li>
                    </ul>

                    <div class="header__right">
                    <a href="exit" class="header__right_item">
                        <ion-icon name="log-out-outline"></ion-icon>
                    </a>
                    <a href="my_account" class="header__right_item">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </a>
                </div>
                <?php ;} ?>
            </div>
        </div>
</header>
<div class="header_none" id="top"></div>
<div class="up">
    <a href="#top">
        <img src="<?php echo get_template_directory_uri(); ?>/images/up-arrow.svg" alt="up">
    </a>
</div>