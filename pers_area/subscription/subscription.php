<?php
    require_once( get_theme_file_path('processing.php') );
    CheckAuth();
    $user_data = $db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
    $payment_date =$user_data['payment_date'];
    $payment_days=countDaysBetweenDates(date("Y-m-d H:i:s"), $payment_date);
    $one_month=944;
    $six_month=945;
    $twelve_month=946;



// Вывод конкретной записи
// var_dump($daily_practices[1]);

//$month_theme['3']['next_post_date'];


// Сегодняшняя практика
// Если оплаты нет, тогда выводит NULL
$today_practice=TodayPractice($payment_days);

// Ежедневные практики
$daily_practices=CategoryData(ceil(openPosts($payment_date, '', 45)),45);

// Рекомендательная система
$recommendations=CategoryData(ceil(openPosts($payment_date, '', 46)),46);

// Тема месяца
$month_theme=CategoryData(ceil(openPosts($payment_date, '', 47)),47);



// Выбор услуги
?>
<!-- <form action="payment" method="post">
    <input value="
    <?php 
    // echo $one_month 
    ?>
    " name="payment_btn" type="submit">
    <input value="
    <?php 
    // echo $six_month 
    ?>
    " name="payment_btn" type="submit">
    <input value="
    <?php 
    // echo $twelve_month 
    ?>
    " name="payment_btn" type="submit">
</form> -->
<?php
// echo (get_post_meta(944, 'month_count', true));
// var_dump (get_post_meta(944, 'price', true));
// var_dump (get_post_meta(945, 'month_count', true));
// var_dump (get_post_meta(945, 'price', true));
// var_dump (get_post_meta(946, 'month_count', true));
// var_dump (get_post_meta(946, 'price', true));?>
<?php
// var_dump($open_main_posts);
    //  var_dump($today_practice);
    //   var_dump($daily_practices);
    //  var_dump($recommendations);
    //  var_dump($month_theme);
?>

<div class="subcscription_container" data-status-payment='<?php echo (checkPayment() ? 'true' : 'false'); ?>'>
    <!-- <div class="subcscription_calendar">
        <h3 class="subcscription_title">Календарь</h3>
        <svg width="40" height="16" viewBox="0 0 40 16" fill='none' xmlns="http://www.w3.org/2000/svg">
            <path d="M40 4L24.4472 11.7764C24.1657 11.9172 23.8343 11.9172 23.5528 11.7764L8 4" stroke="black"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div> -->
    <h3 class="subcscription_title">Программа</h3>
    <h3 class="subcscription_title">Ежедневные практики</h3>
    <section class="daily-practice">
        <div class="daily-practice_wrapper">
            <a class="daily-practice_img-wrapper" href="subscription_lesson?post=<?php echo $today_practice['id']; ?>">
                <img class="daily-practice_img"
                    src="<?php echo (empty($today_practice['image_url']) ? $daily_practices[1]['image_url'] : $today_practice['image_url']);?>"
                    alt="">
                <span
                    class="daily-practice_img-span"><?php echo (empty($today_practice['title']) ? $daily_practices[1]['title'] : $today_practice['title']);?></span>
            </a>
            <div class="daily-practice_text-wrapper">
                <!-- <div class="daily-practice_progressbar-wrp">
                    <span class="daily-practice_progressbar-txt">Продолжить изучать</span>
                    <div class="daily-practice_progressbar">
                        <span>10/100</span>
                        <div class="daily-practice_progress-bar">
                            <div data-size="10" class="daily-practice_progress"></div>
                        </div>
                    </div>
                </div> -->
                <div class="daily-practice_text">
                    <h4 class="daily-practice_subtitle">
                        <?php echo (empty($today_practice['title']) ? $daily_practices[1]['title'] : $today_practice['title']);?>
                    </h4>
                    <div class="daily-practice_content">
                        <?php echo (empty($today_practice["content"]) ? trimCntWords($daily_practices[1]["content"],30, '...') : trimCntWords($today_practice["content"],30, '...'));?>
                    </div>
                </div>
            </div>
            <a class="daily-practice_btn-more" href="subscription_lesson?post=<?php echo $today_practice['id']; ?>"></a>
        </div>
    </section>


    <section class="daily_practices_slider">
    <?php 
      foreach ($daily_practices as $row) { 
    ?>
        <div id="" class="subcscription_block-slide blockSub-slide daily_practices_slide"
            key="<?php echo array_search($row, $daily_practices); ?>">
            <div class="blockSub-slide_wrapper-img">
                <img id="" class="blockSub-slide_img" src="<?php echo $row["image_url"]; ?>" width="267" />
                <div class="blockSub-slide_after"></div>
                <div class="blockSub-slide_before" status="<?php echo (boolval($row["status"]) ? 'true' : 'false'); ?>">
                </div>
                <div id='blockSub_lesson-time'><?php echo (empty($row["lesson_time"]) ? '' : $row["lesson_time"].' минут');?></div>
                <div id='blockSub_next-post-date'><?php echo (empty($row["next_post_date"]) ? 'скоро' : $row["next_post_date"]);?></div>
            </div>
            <div class="subcscription_title-slide"><?php echo $row["title"]; ?></div>
        </div>
        <?php 
      };
    ?>
        <a id="" class="subcscription_block-slide blockSub-slide-more" href="subscription_posts?id=45">
            <img src="<?php echo get_template_directory_uri(); ?>/images/black_arrow.svg" width="30" />
            <span>Смотреть все</span>
        </a>
    </section>

    <?php 
        foreach ($daily_practices as $row) { 
    ?>
    <section id="" class="daily_practices_addition addition"
        addition-key="<?php echo array_search($row, $daily_practices); ?>"
        status="<?php echo (boolval($row["status"]) ? 'true' : 'false'); ?>">
        <div class="addition_wrapper">
            <div class="addition_text">
                <h2 class="addition_title"><?php echo $row["title"]; ?></h2>
                <ul class="addition_tags">
                    <?php echo $row["tag"]; ?>
                </ul>
                <div class="addition_audio">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17 13C17 12.4696 17.2107 11.9609 17.5858 11.5858C17.9609 11.2107 18.4696 11 19 11C19.5304 11 20.0392 11.2107 20.4142 11.5858C20.7893 11.9609 21 12.4696 21 13V18.9999C21 19.5303 20.7893 20.0391 20.4142 20.4142C20.0392 20.7893 19.5304 20.9999 19 20.9999C18.4696 20.9999 17.9609 20.7893 17.5858 20.4142C17.2107 20.0391 17 19.5303 17 18.9999V13Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M3 13C3 12.4696 3.21074 11.9609 3.58582 11.5858C3.96089 11.2107 4.46957 11 5 11C5.53043 11 6.03917 11.2107 6.41425 11.5858C6.78932 11.9609 7 12.4696 7 13V18.9999C7 19.5303 6.78932 20.0391 6.41425 20.4142C6.03917 20.7893 5.53043 20.9999 5 20.9999C4.46957 20.9999 3.96089 20.7893 3.58582 20.4142C3.21074 20.0391 3 19.5303 3 18.9999V13Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M19 11V10C19 8.14348 18.2625 6.36305 16.9498 5.05029C15.637 3.73754 13.8565 3 12 3C10.1435 3 8.36305 3.73754 7.05029 5.05029C5.73754 6.36305 5 8.14348 5 10V11"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span
                        class="addition_subtitle-audio"><?php echo (empty($row["audio"]) ? 'name audio' : $row["audio"]);?></span>
                </div>
                <div class="addition_materials">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.0039 3.33784C12.8878 2.25505 14.9394 1.49458 17.0739 1.08784C17.5549 0.972565 18.0562 0.970724 18.538 1.08247C19.0199 1.19421 19.4691 1.41641 19.8503 1.73164C20.2315 2.04686 20.5342 2.44645 20.7344 2.89875C20.9346 3.35105 21.0268 3.84374 21.0039 4.33784V13.3378C20.9738 14.4549 20.5705 15.5296 19.8582 16.3906C19.1458 17.2515 18.1656 17.8491 17.0739 18.0878C14.9394 18.4946 12.8878 19.255 11.0039 20.3378"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M11.0034 3.33784C9.11951 2.25505 7.06799 1.49458 4.93348 1.08784C4.45247 0.972565 3.95122 0.970724 3.46937 1.08247C2.98752 1.19421 2.53829 1.41641 2.15711 1.73164C1.77594 2.04686 1.47323 2.44645 1.27302 2.89875C1.07281 3.35105 0.980504 3.84374 1.00343 4.33784V13.3378C1.0335 14.4549 1.43691 15.5296 2.14924 16.3906C2.86158 17.2515 3.84184 17.8491 4.93348 18.0878C7.06799 18.4946 9.11951 19.255 11.0034 20.3378"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.0039 20.3379V3.33789" stroke="black" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <div>
                        <h4 class="addition_subtitle-materials">Материалы</h4>
                        <span class="addition_description"><?php echo trimCntWords($row["content"],30, '...'); ?></span>
                    </div>
                </div>
                <a href="subscription_lesson?post=<?php echo $row['id']; ?>" class="blue_btn addition_btn">Перейти</a>
            </div>
            <div class="addition_image">
                <img src="<?php echo $row["image_url"]; ?>" width="543" class="" />
            </div>
        </div>
    </section>
    <?php 
  };
?>


    <h3 class="subcscription_title">Упражнения для вас</h3>
    <section class="recommendations_slider">
        <?php 
      foreach ($recommendations as $rec) { 
    ?>
        <div id="" class="subcscription_block-slide blockSub-slide recommendations_slide"
            key="<?php echo array_search($rec, $recommendations); ?>">
            <div class="blockSub-slide_wrapper-img">
                <img id="" class="blockSub-slide_img" src="<?php echo $rec["image_url"]; ?>" width="267" />
                <div class="blockSub-slide_after"></div>
                <div class="blockSub-slide_before" status="<?php echo (boolval($rec["status"]) ? 'true' : 'false'); ?>">
                </div>
                <div id='blockSub_lesson-time'><?php echo (empty($rec["lesson_time"]) ? '' : $rec["lesson_time"].' минут');?></div>
                <div id='blockSub_next-post-date'><?php echo (empty($rec["next_post_date"]) ? 'скоро' : $rec["next_post_date"]);?></div>
            </div>
            <div class="subcscription_title-slide"><?php echo $rec["title"]; ?></div>
        </div>
        <?php 
      };
    ?>
        <a id="" class="subcscription_block-slide blockSub-slide-more" href="subscription_posts?id=46">
            <img src="<?php echo get_template_directory_uri(); ?>/images/black_arrow.svg" width="30" />
            <span>Смотреть все</span>
        </a>
    </section>

    <?php 
    foreach ($recommendations as $rec) { 
?>
    <section id="" class="recommendations_addition addition"
        addition-key="<?php echo array_search($rec, $recommendations); ?>"
        status="<?php echo (boolval($rec["status"]) ? 'true' : 'false'); ?>">
        <div class="addition_wrapper">
            <div class="addition_text">
                <h2 class="addition_title"><?php echo $rec["title"]; ?></h2>
                <ul class="addition_tags">
                    <?php echo $rec["tag"]; ?>
                </ul>
                <div class="addition_audio">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17 13C17 12.4696 17.2107 11.9609 17.5858 11.5858C17.9609 11.2107 18.4696 11 19 11C19.5304 11 20.0392 11.2107 20.4142 11.5858C20.7893 11.9609 21 12.4696 21 13V18.9999C21 19.5303 20.7893 20.0391 20.4142 20.4142C20.0392 20.7893 19.5304 20.9999 19 20.9999C18.4696 20.9999 17.9609 20.7893 17.5858 20.4142C17.2107 20.0391 17 19.5303 17 18.9999V13Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M3 13C3 12.4696 3.21074 11.9609 3.58582 11.5858C3.96089 11.2107 4.46957 11 5 11C5.53043 11 6.03917 11.2107 6.41425 11.5858C6.78932 11.9609 7 12.4696 7 13V18.9999C7 19.5303 6.78932 20.0391 6.41425 20.4142C6.03917 20.7893 5.53043 20.9999 5 20.9999C4.46957 20.9999 3.96089 20.7893 3.58582 20.4142C3.21074 20.0391 3 19.5303 3 18.9999V13Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M19 11V10C19 8.14348 18.2625 6.36305 16.9498 5.05029C15.637 3.73754 13.8565 3 12 3C10.1435 3 8.36305 3.73754 7.05029 5.05029C5.73754 6.36305 5 8.14348 5 10V11"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span
                        class="addition_subtitle-audio"><?php echo (empty($rec["audio"]) ? 'name audio' : $rec["audio"]);?></span>
                </div>
                <div class="addition_materials">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.0039 3.33784C12.8878 2.25505 14.9394 1.49458 17.0739 1.08784C17.5549 0.972565 18.0562 0.970724 18.538 1.08247C19.0199 1.19421 19.4691 1.41641 19.8503 1.73164C20.2315 2.04686 20.5342 2.44645 20.7344 2.89875C20.9346 3.35105 21.0268 3.84374 21.0039 4.33784V13.3378C20.9738 14.4549 20.5705 15.5296 19.8582 16.3906C19.1458 17.2515 18.1656 17.8491 17.0739 18.0878C14.9394 18.4946 12.8878 19.255 11.0039 20.3378"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M11.0034 3.33784C9.11951 2.25505 7.06799 1.49458 4.93348 1.08784C4.45247 0.972565 3.95122 0.970724 3.46937 1.08247C2.98752 1.19421 2.53829 1.41641 2.15711 1.73164C1.77594 2.04686 1.47323 2.44645 1.27302 2.89875C1.07281 3.35105 0.980504 3.84374 1.00343 4.33784V13.3378C1.0335 14.4549 1.43691 15.5296 2.14924 16.3906C2.86158 17.2515 3.84184 17.8491 4.93348 18.0878C7.06799 18.4946 9.11951 19.255 11.0034 20.3378"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.0039 20.3379V3.33789" stroke="black" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <div>
                        <h4 class="addition_subtitle-materials">Материалы</h4>
                        <span class="addition_description"><?php echo trimCntWords($rec["content"],30, '...'); ?></span>
                    </div>
                </div>
                <a href="subscription_lesson?post=<?php echo $rec['id']; ?>" class="blue_btn addition_btn">Перейти</a>
            </div>
            <div class="addition_image">
                <img src="<?php echo $rec["image_url"]; ?>" width="543" class="" />
            </div>
        </div>
    </section>
    <?php 
  };
?>


    <h3 class="subcscription_title">Темы</h3>
    <section class="month-theme_slider">
        <?php 
      foreach ($month_theme as $month) { 
    ?>
        <div id="" class="subcscription_block-slide blockSub-slide month-theme_slide"
            key="<?php echo array_search($month, $month_theme); ?>">
            <div class="blockSub-slide_wrapper-img">
                <img id="" class="blockSub-slide_img" src="<?php echo $month["image_url"]; ?>" width="267" />
                <div class="blockSub-slide_after"></div>
                <div class="blockSub-slide_before"
                    status="<?php echo (boolval($month["status"]) ? 'true' : 'false'); ?>">
                </div>
                <div id='blockSub_lesson-time'><?php echo (empty($month["lesson_time"]) ? '' : $month["lesson_time"].' минут');?></div>
                <div id='blockSub_next-post-date'><?php echo (empty($month["next_post_date"]) ? 'скоро' : $month["next_post_date"]);?></div>
            </div>
            
            <div class="subcscription_title-slide"><?php echo $month["title"]; ?></div>
        </div>
        <?php 
      };
    ?>
        <a id="" class="subcscription_block-slide blockSub-slide-more" href="subscription_posts?id=47">
            <img src="<?php echo get_template_directory_uri(); ?>/images/black_arrow.svg" width="30" />
            <span>Смотреть все</span>
        </a>
    </section>

    <?php 
  foreach ($month_theme as $month) { 
?>
    <section id="" class="month-theme_addition addition"
        addition-key="<?php echo array_search($month, $month_theme); ?>"
        status="<?php echo (boolval($month["status"]) ? 'true' : 'false'); ?>">
        <div class="addition_wrapper">
            <div class="addition_text">
                <h2 class="addition_title"><?php echo $month["title"]; ?></h2>
                <ul class="addition_tags">
                    <?php echo $month["tag"]; ?>
                </ul>
                <div class="addition_audio">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17 13C17 12.4696 17.2107 11.9609 17.5858 11.5858C17.9609 11.2107 18.4696 11 19 11C19.5304 11 20.0392 11.2107 20.4142 11.5858C20.7893 11.9609 21 12.4696 21 13V18.9999C21 19.5303 20.7893 20.0391 20.4142 20.4142C20.0392 20.7893 19.5304 20.9999 19 20.9999C18.4696 20.9999 17.9609 20.7893 17.5858 20.4142C17.2107 20.0391 17 19.5303 17 18.9999V13Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M3 13C3 12.4696 3.21074 11.9609 3.58582 11.5858C3.96089 11.2107 4.46957 11 5 11C5.53043 11 6.03917 11.2107 6.41425 11.5858C6.78932 11.9609 7 12.4696 7 13V18.9999C7 19.5303 6.78932 20.0391 6.41425 20.4142C6.03917 20.7893 5.53043 20.9999 5 20.9999C4.46957 20.9999 3.96089 20.7893 3.58582 20.4142C3.21074 20.0391 3 19.5303 3 18.9999V13Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M19 11V10C19 8.14348 18.2625 6.36305 16.9498 5.05029C15.637 3.73754 13.8565 3 12 3C10.1435 3 8.36305 3.73754 7.05029 5.05029C5.73754 6.36305 5 8.14348 5 10V11"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span
                        class="addition_subtitle-audio"><?php echo (empty($month["audio"]) ? 'name audio' : $month["audio"]);?></span>
                </div>
                <div class="addition_materials">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.0039 3.33784C12.8878 2.25505 14.9394 1.49458 17.0739 1.08784C17.5549 0.972565 18.0562 0.970724 18.538 1.08247C19.0199 1.19421 19.4691 1.41641 19.8503 1.73164C20.2315 2.04686 20.5342 2.44645 20.7344 2.89875C20.9346 3.35105 21.0268 3.84374 21.0039 4.33784V13.3378C20.9738 14.4549 20.5705 15.5296 19.8582 16.3906C19.1458 17.2515 18.1656 17.8491 17.0739 18.0878C14.9394 18.4946 12.8878 19.255 11.0039 20.3378"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M11.0034 3.33784C9.11951 2.25505 7.06799 1.49458 4.93348 1.08784C4.45247 0.972565 3.95122 0.970724 3.46937 1.08247C2.98752 1.19421 2.53829 1.41641 2.15711 1.73164C1.77594 2.04686 1.47323 2.44645 1.27302 2.89875C1.07281 3.35105 0.980504 3.84374 1.00343 4.33784V13.3378C1.0335 14.4549 1.43691 15.5296 2.14924 16.3906C2.86158 17.2515 3.84184 17.8491 4.93348 18.0878C7.06799 18.4946 9.11951 19.255 11.0034 20.3378"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.0039 20.3379V3.33789" stroke="black" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <div>
                        <h4 class="addition_subtitle-materials">Материалы</h4>
                        <span
                            class="addition_description"><?php echo trimCntWords($month["content"],30, '...'); ?></span>
                    </div>
                </div>
                <a href="subscription_lesson?post=<?php echo $month['id']; ?>" class="blue_btn addition_btn">Перейти</a>
            </div>
            <div class="addition_image">
                <img src="<?php echo $month["image_url"]; ?>" width="543" class="" />
            </div>
        </div>
    </section>
    <?php 
  };
?>
</div>



<section class='subscription_payment-banner_background'>
    <div id='payment-banner' class='subscription_payment-banner pay-banner'>
        <button class='pay-banner_btnClose' type='button'></button>
        <div class='pay-banner_content'>
            <form class='pay-banner_promocode-wrap'>
                <h4 class='pay-banner_promocode-title'>Промокод</h4>
                <div class='pay-banner_promocode-input-wrap'>
                    <input name="promo" class='pay-banner_promocode-input' type="text" placeholder='Промокод'>
                    <span class="text-error text-error_promo">text error</span>
                </div>
                <div class='pay-banner_promocode-btn-wrap'>
                    <button name="promo_btn" class='blue_btn pay-banner_promocode-btn'
                        type='button'>Использовать</button>
                </div>
            </form>
            <h4 class='pay-banner_title'>Оформить подписку:</h4>
            <ul class='pay-banner_options-wrap pay-banner_options-slider'>
            </ul>
        </div>
    </div>

    <form action="payment.php" method="POST" class='promocode-post'>
        <input type="text" name="promocode" class='promocode_duble'/>
        <button type='submit' class='post-promocode-payment'></button>
    </form>
</section>