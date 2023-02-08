<?php
$post=(int)$_GET['post'];

require_once( get_theme_file_path('processing.php') );
CheckAuth();
$get_id=(int)$_GET['post'];
//$get_id=918;
$user_data = $db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
$payment_date =$user_data['payment_date'];
if( !checkPayment() || !$get_id){
    header('Location: subscription');
};
$post_data = getSubscriptionLesson($get_id, ceil(openPosts($payment_date, $get_id, '')));
$id = get_the_ID($get_id);
$thumb_id = get_post_thumbnail_id();
$src = wp_get_attachment_image_src($thumb_id, 'full')[0];

$month_theme=CategoryData(ceil(openPosts($payment_date, '', 47)), 47);
?>

<div class="sub_less">
    <div style='background-image: url("<?php echo $src; ?>");' class="sub_less_banner">
        <div class="sub_banner_cnt sub_container ">
            <div class="sub_less_title basic">
                <h3 style="text-transform: none;">
                    <?php echo get_the_title(); ?>
                </h3>
            </div>
            <div class="sub_less_tag">
                <ul>
                    <?php echo $post_data['tag']; ?>
                </ul>
            </div>
        </div>
    </div>
    <h1 class='sub_less__mobile-title'>Title</h1>

    <div class="sub_container">
        <div class="sub_less_cnt">
            <div class='sub_less__firstParagraph'>
                <div class='sub_less__firstParagraph-wrpImg'>
                    <img class='sub_less__firstParagraph-img' src='<?php echo firstPostImage($id); ?>'
                        style='display: <?php echo (boolval(firstPostImage($id)) ? 'block' : 'none'); ?>' />
                    <div class='sub_less__firstParagraph-befor'
                        style='display: <?php echo (boolval(firstPostImage($id)) ? 'none' : 'block'); ?>'></div>
                </div>
                <p class='sub_less__firstParagraph-p'>d</p>
            </div>
            <p><?php the_content(); ?></p>


            <div class='sub_less__img-collage img-collage'
                style='display: <?php echo (boolval(LastPostImage($id)) ? 'flex' : 'none'); ?>'>
                <div class='img-collage_wrp'>
                    <img class='img-collage_img' src='<?php echo LastPostImage($id); ?>' />
                </div>
                <div class='img-collage_wrp'>
                    <img class='img-collage_img' src='<?php echo LastPostImage($id); ?>' />
                </div>
                <div class='img-collage_wrp'>
                    <img class='img-collage_img' src='<?php echo LastPostImage($id); ?>' />
                </div>
            </div>
            <div class="trial_audio">
                <div class="player">
                    <div class="player__wrap">
                        <div class="info">
                            <span class="info-icon">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_181_372)">
                                        <path
                                            d="M18 22C17.4477 22 17 21.5523 17 21V15C17 14.4477 16.5523 14 16 14H14C13.4477 14 13 14.4477 13 15C13 15.5523 13.4477 16 14 16C14.5523 16 15 16.4477 15 17V21C15 21.5523 14.5523 22 14 22H13C12.4477 22 12 22.4477 12 23C12 23.5523 12.4477 24 13 24H19C19.5523 24 20 23.5523 20 23C20 22.4477 19.5523 22 19 22H18ZM16 8C15.7033 8 15.4133 8.08797 15.1666 8.2528C14.92 8.41762 14.7277 8.65189 14.6142 8.92597C14.5006 9.20006 14.4709 9.50166 14.5288 9.79264C14.5867 10.0836 14.7296 10.3509 14.9393 10.5607C15.1491 10.7704 15.4164 10.9133 15.7074 10.9712C15.9983 11.0291 16.2999 10.9994 16.574 10.8858C16.8481 10.7723 17.0824 10.58 17.2472 10.3334C17.412 10.0867 17.5 9.79667 17.5 9.5C17.5 9.10218 17.342 8.72064 17.0607 8.43934C16.7794 8.15804 16.3978 8 16 8Z"
                                            fill="white" />
                                        <path
                                            d="M16 30C13.2311 30 10.5243 29.1789 8.22202 27.6406C5.91973 26.1022 4.12532 23.9157 3.06569 21.3576C2.00607 18.7994 1.72882 15.9845 2.26901 13.2687C2.80921 10.553 4.14258 8.05845 6.10051 6.10051C8.05845 4.14258 10.553 2.80921 13.2687 2.26901C15.9845 1.72882 18.7994 2.00607 21.3576 3.06569C23.9157 4.12532 26.1022 5.91973 27.6406 8.22202C29.1789 10.5243 30 13.2311 30 16C30 19.713 28.525 23.274 25.8995 25.8995C23.274 28.525 19.713 30 16 30ZM16 4.00001C13.6266 4.00001 11.3066 4.70379 9.33316 6.02237C7.35977 7.34095 5.8217 9.21509 4.91345 11.4078C4.0052 13.6005 3.76756 16.0133 4.23058 18.3411C4.69361 20.6689 5.83649 22.8071 7.51472 24.4853C9.19296 26.1635 11.3312 27.3064 13.6589 27.7694C15.9867 28.2325 18.3995 27.9948 20.5922 27.0866C22.7849 26.1783 24.6591 24.6402 25.9776 22.6668C27.2962 20.6935 28 18.3734 28 16C28 12.8174 26.7357 9.76516 24.4853 7.51472C22.2348 5.26429 19.1826 4.00001 16 4.00001Z"
                                            fill="#7264AA" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_181_372">
                                            <rect width="32" height="32" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                            <span class="info-tultip">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Deleniti,
                                dolor!</span>
                        </div>
                        <div class="volume-box">
                            <span id="volume" class="volume active">
                                <svg width="22" height="20" viewBox="0 0 22 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15 6.50001C16.333 8.27801 16.333 11.722 15 13.5M18 3.00001C21.988 6.80801 22.012 13.217 18 17M1 12.959V7.04001C1 6.46601 1.448 6.00001 2 6.00001H5.586C5.71833 5.99954 5.8492 5.97228 5.97071 5.91986C6.09222 5.86744 6.20185 5.79095 6.293 5.69501L9.293 2.30701C9.923 1.65101 11 2.11601 11 3.04301V16.957C11 17.891 9.91 18.352 9.284 17.683L6.294 14.314C6.20259 14.2153 6.09185 14.1365 5.96867 14.0825C5.84549 14.0285 5.71251 14.0004 5.578 14H2C1.448 14 1 13.534 1 12.959Z"
                                        stroke="#7264AA" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="volume-none">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M26 19L20 13M26 13L20 19" stroke="#7264AA" stroke-width="2"
                                        stroke-linecap="round" />
                                    <path
                                        d="M6 18.959V13.04C6 12.466 6.448 12 7 12H10.586C10.7183 11.9995 10.8492 11.9723 10.9707 11.9199C11.0922 11.8674 11.2019 11.791 11.293 11.695L14.293 8.30701C14.923 7.65101 16 8.11601 16 9.04301V22.957C16 23.891 14.91 24.352 14.284 23.683L11.294 20.314C11.2026 20.2153 11.0918 20.1365 10.9687 20.0825C10.8455 20.0285 10.7125 20.0004 10.578 20H7C6.448 20 6 19.534 6 18.959Z"
                                        stroke="#7264AA" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <input type="range" class="volume-range visually-hidden" step="1" value="80" min="0"
                                max="100">
                        </div>
                        <div class="speed">1x</div>
                    </div>
                    <div class="title">
                        <p class="player_title_text" id="player_title_text">Подкаст - качество жизни</p>
                    </div>
                    <div class="player__box-wrap">
                        <span class="play">
                            <svg class="play-show" width="25" height="25" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M38.5 20C38.5 30.2173 30.2173 38.5 20 38.5C9.78273 38.5 1.5 30.2173 1.5 20C1.5 9.78273 9.78273 1.5 20 1.5C30.2173 1.5 38.5 9.78273 38.5 20Z"
                                    fill="#7264AA" stroke="#7264AA" stroke-width="3" />
                                <path
                                    d="M30.5 19.134C31.1667 19.5189 31.1667 20.4811 30.5 20.866L15.5 29.5263C14.8333 29.9112 14 29.4301 14 28.6603L14 11.3397C14 10.5699 14.8333 10.0888 15.5 10.4737L30.5 19.134Z"
                                    fill="white" />
                            </svg>
                            <svg class="pause-show" width="25" height="25" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="20" cy="20" r="20" fill="#7264AA" />
                                <rect x="14" y="10" width="4" height="21" rx="2" fill="white" />
                                <rect x="22" y="10" width="4" height="21" rx="2" fill="white" />
                            </svg>
                        </span>
                        <div class="player_box">
                            <!-- input range -->
                            <div class="progress-container" id="progress-container">
                                <input type="range" class="progress" id="progress" max="100" value="0">
                            </div>
                            <div class="duration">
                                <span class="current-time">00:00</span>
                                <span class="duration-time">00:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="trial_text-wrap"></div>
            <button class="trial_btn-show">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M17.0562 5.94383L5.67175 17.3282C5.30075 17.6992 5.30075 18.3008 5.67175 18.6718L5.74246 18.7425C6.11346 19.1135 6.71497 19.1135 7.08597 18.7425L18.4704 7.35804C18.8414 6.98705 18.8414 6.38554 18.4704 6.01454L18.3997 5.94383C18.0287 5.57283 17.4272 5.57283 17.0562 5.94383Z"
                        fill="#421dd8" />
                    <path
                        d="M18.0562 17.0562L6.67175 5.67175C6.30075 5.30075 5.69925 5.30075 5.32825 5.67175L5.25754 5.74246C4.88654 6.11346 4.88654 6.71497 5.25754 7.08597L16.642 18.4704C17.013 18.8414 17.6145 18.8414 17.9855 18.4704L18.0562 18.3997C18.4272 18.0287 18.4272 17.4272 18.0562 17.0562Z"
                        fill="#421dd8" />
                </svg>
            </button> -->



        </div>
    </div>

</div>

<div class="subcscription_container" data-status-payment='<?php echo (checkPayment() ? 'true' : 'false'); ?>'>
    <h3 class="subcscription_title">Общий материал</h3>
    <section class="daily_practices_slider">
        <?php 
        foreach ($month_theme as $row) { 
        ?>
        <div id="" class="subcscription_block-slide blockSub-slide daily_practices_slide"
            key="<?php echo array_search($row, $month_theme); ?>">
            <div class="blockSub-slide_wrapper-img">
                <img id="" class="blockSub-slide_img" src="<?php echo $row["image_url"]; ?>" width="267" />
                <div class="blockSub-slide_after"></div>
                <div class="blockSub-slide_before" status="<?php echo (boolval($row["status"]) ? 'true' : 'false'); ?>">
                </div>
                <div id='blockSub_lesson-time'>
                    <?php echo (empty($row["lesson_time"]) ? '' : $row["lesson_time"].' минут');?></div>
                <div id='blockSub_next-post-date'>
                    <?php echo (empty($row["next_post_date"]) ? 'скоро' : $row["next_post_date"]);?></div>
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
            foreach ($month_theme as $row) { 
        ?>
    <section id="" class="daily_practices_addition addition"
        addition-key="<?php echo array_search($row, $month_theme); ?>"
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
                        <span
                            class="addition_description"><?php echo (empty($row["excerpt"]) ? trimCntWords($row["content"],30, '...') : $row["excerpt"]); ?></span>
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
</div>