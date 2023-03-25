<?php 
global $post;
require_once( get_theme_file_path('processing.php') );
$cat_data = get_the_category( $post->ID )[0];
$cat_slug=$cat_data->slug;
if( $cat_slug === "blogs"){

?>
<div class="wrapper_single">
    <div class="container">
        <div class="single">
            <div class="btn_back">
                <a href="javascript:history.go(-1)" class="arrow-2">
                    <div class="arrow-2-top"></div>
                    <div class="arrow-2-bottom"></div>
                </a>
            </div>
            <div class="single_main_img">
                <?php the_post_thumbnail();?>
            </div>

            <div class="single_cnt basic">
                <h1 class="single_title">
                    <?php the_title(); ?>
                </h1>
                <div class="single_cnt">
                    <?php the_content();?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}elseif( $cat_slug==="daily-practices" || $cat_slug==="recommendations" || $cat_slug==="themes"){
    CheckAuth();

    if(!$post->ID){
        header('Location: subscription');
    }else{
        $subscription= new Subscription();
        //$post_data =$subscription->getSubscriptionLesson($post->ID);
        // if($post_data['status'] !== true){
        //     header('Location: subscription');
        // }else{
        //     the_post();
        // }
    }

    $thumb_id = get_post_thumbnail_id( $id );
    $src = wp_get_attachment_image_src($thumb_id, 'full')[0];
?>

<div class="sub_less">
    <div style='background-image: url("<?php echo $src; ?>");' class="sub_less_banner">
        <div class="sub_banner_cnt sub_container ">
            <div class="sub_less_title basic">
                <h3 style="text-transform: none;">
                    <?php the_title(); ?>
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
                            <span class="info-tultip">Подкаст о жизни</span>
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

<?php 

if(FilterCat($post->ID, "recommendations")){ ?>
<div class='single_button-reaction'>
    <button id="like" class="like" onclick="addLike(<?php echo $post->ID; ?>,<?php echo $_SESSION['id']; ?>)">
        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M2.0638 12.4897C2.03793 12.0175 2.10861 11.545 2.27151 11.1011C2.43441 10.6571 2.6861 10.251 3.01123 9.90756C3.33636 9.56414 3.72809 9.29055 4.16249 9.10362C4.59689 8.91668 5.06485 8.82031 5.53777 8.82031C6.01068 8.82031 6.47863 8.91668 6.91303 9.10362C7.34743 9.29055 7.73916 9.56414 8.06429 9.90756C8.38942 10.251 8.64113 10.6571 8.80402 11.1011C8.96692 11.545 9.03758 12.0175 9.01172 12.4897V18.3543C9.03758 18.8265 8.96692 19.2991 8.80402 19.7431C8.64113 20.187 8.38942 20.5931 8.06429 20.9366C7.73916 21.28 7.34743 21.5535 6.91303 21.7404C6.47863 21.9274 6.01068 22.0238 5.53777 22.0238C5.06485 22.0238 4.59689 21.9274 4.16249 21.7404C3.72809 21.5535 3.33636 21.28 3.01123 20.9366C2.6861 20.5931 2.43441 20.187 2.27151 19.7431C2.10861 19.2991 2.03793 18.8265 2.0638 18.3543V12.4897Z"
                stroke="#EBE6FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M9.03131 18.3543C9.02857 18.8126 9.11611 19.2669 9.28895 19.6913C9.46179 20.1157 9.71653 20.502 10.0386 20.8279C10.3607 21.1539 10.7439 21.4132 11.1662 21.5911C11.5886 21.769 12.0418 21.862 12.5001 21.8647H16.7917C17.7924 21.864 18.7659 21.5387 19.566 20.9377C20.3661 20.3366 20.9497 19.4923 21.2292 18.5314L22.7917 13.2397C22.9161 12.888 22.9547 12.5116 22.9043 12.1419C22.854 11.7723 22.7161 11.42 22.5021 11.1143C22.2882 10.8087 22.0043 10.5585 21.6742 10.3846C21.3441 10.2108 20.9773 10.1183 20.6042 10.1147H14.8542V4.61472C14.8556 4.415 14.8176 4.217 14.7425 4.03196C14.6673 3.84692 14.5564 3.67849 14.4162 3.5363C14.2759 3.39411 14.109 3.28091 13.925 3.20321C13.741 3.12552 13.5435 3.08486 13.3438 3.0835V3.0835C13.0152 3.08499 12.6961 3.19361 12.4348 3.39287C12.1735 3.59213 11.9843 3.87116 11.8959 4.18766L9.03131 13.7293"
                stroke="#EBE6FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <button id="dislike" class="dislike" onclick="addLike(<?php echo $post->ID; ?>,<?php echo $_SESSION['id']; ?>)">
        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M9.03125 11.229L11.8958 20.7706C11.9842 21.0871 12.1734 21.3662 12.4347 21.5654C12.696 21.7647 13.0151 21.8733 13.3437 21.8748V21.8748C13.5435 21.8734 13.7409 21.8328 13.9249 21.7551C14.1089 21.6774 14.2758 21.5642 14.4161 21.422C14.5563 21.2798 14.6672 21.1114 14.7424 20.9263C14.8176 20.7413 14.8555 20.5433 14.8542 20.3436V14.8436"
                stroke="#202020" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M2.08333 12.4999C2.05747 12.9721 2.12815 13.4447 2.29104 13.8886C2.45394 14.3326 2.70565 14.7387 3.03078 15.0821C3.35591 15.4256 3.74762 15.6991 4.18202 15.886C4.61642 16.0729 5.08437 16.1694 5.55728 16.1694C6.0302 16.1694 6.49814 16.0729 6.93255 15.886C7.36695 15.6991 7.75869 15.4256 8.08382 15.0821C8.40895 14.7387 8.66066 14.3326 8.82355 13.8886C8.98645 13.4447 9.05713 12.9721 9.03126 12.4999V6.63531C9.05713 6.1631 8.98645 5.6906 8.82355 5.24663C8.66066 4.80265 8.40895 4.3965 8.08382 4.05307C7.75869 3.70965 7.36695 3.43613 6.93255 3.24919C6.49814 3.06225 6.0302 2.96582 5.55728 2.96582C5.08437 2.96582 4.61642 3.06225 4.18202 3.24919C3.74762 3.43613 3.35591 3.70965 3.03078 4.05307C2.70565 4.3965 2.45394 4.80265 2.29104 5.24663C2.12815 5.6906 2.05747 6.1631 2.08333 6.63531V12.4999Z"
                stroke="#202020" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M9.03131 6.63541C9.02857 6.17715 9.11609 5.72285 9.28893 5.29842C9.46177 4.874 9.71651 4.48775 10.0386 4.16177C10.3607 3.8358 10.7439 3.57647 11.1662 3.39858C11.5885 3.22068 12.0418 3.12773 12.5 3.125H16.7917C17.7924 3.12575 18.7659 3.45107 19.566 4.0521C20.3661 4.65313 20.9497 5.49745 21.2292 6.45835L22.7917 11.75C22.9161 12.1018 22.9547 12.4781 22.9043 12.8478C22.854 13.2174 22.7161 13.5697 22.5021 13.8754C22.2882 14.181 22.0043 14.4312 21.6742 14.6051C21.3441 14.7789 20.9773 14.8715 20.6042 14.875H14.875"
                stroke="#202020" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
</div>
<?php }; ?>





<?php
    $month_theme=$subscription->getCatData(47);
?>

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
                <div class='blockSub_lesson-time'>
                    <?php echo (empty($row["lesson_time"]) ? '' : $row["lesson_time"].' минут');?></div>
                <div class='blockSub_next-post-date'>
                    <?php echo (empty($row["next_post_date"]) ? '' : $row["next_post_date"]);?></div>
                <div class='blockSub_audio hidden'>
                    <?php echo (empty($row["audio"]) ? '' : 'true');?></div>
            </div>
            <div class="subcscription_title-slide"><?php echo trimCntChars($row["title"], 30, '...') ; ?></div>
        </div>
        <?php 
        };
        ?>
        <a id="" class="subcscription_block-slide blockSub-slide-more" href="subscription_posts?id=45">
            <img src="<?php img('black_arrow.svg') ?>" width="30" />
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
                    <?php if (!empty($row["audio"])) { ?>
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
                    <span class="addition_subtitle-audio"></span>
                    <?php };?>
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
                        <h4 class="addition_subtitle-materials">Описание</h4>
                        <span
                            class="addition_description"><?php echo (empty($row["excerpt"]) ? trimCntWords($row["content"],30, '...') : $row["excerpt"]); ?></span>
                    </div>
                </div>
                <a href="<?php echo get_permalink($row['id']); ?>" class="blue_btn addition_btn">Перейти</a>
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

<?php 
    };
?>


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

    <span class='price_944' data-price='<?php echo (get_post_meta(944, 'price', true))?>' style='display: none'></span>
    <span class='price_945' data-price='<?php echo (get_post_meta(945, 'price', true))?>' style='display: none'></span>
    <span class='price_946' data-price='<?php echo (get_post_meta(946, 'price', true))?>' style='display: none'></span>

    <!-- <form action="payment.php" method="POST" class='promocode-post'>
        <input type="text" name="promocode" class='promocode_duble'/>
        <button type='submit' class='post-promocode-payment'></button>
    </form> -->
    <audio preload='metadata' class='audio' src='' loop></audio>
</section>