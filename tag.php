<?php /*
Template Name: Tag Archive
*/ 
get_header();
require_once( get_theme_file_path('processing.php') );

$user_data = $db->getRow("SELECT * FROM users WHERE id=?i", $_SESSION['id']);
$payment_date =$user_data['payment_date'];
//wp_tag_cloud('smallest=12&largest=36&number=1500&format=flat&separator=|&orderby=name');
$tag_posts=tagPosts($payment_date );

?>
<div class="subcscription_container" data-status-payment='<?php echo (checkPayment() ? 'true' : 'false'); ?>'>
    <h3 class="subcscription_title"><?php single_tag_title(); ?></h3>

    <section class="subscriptions-posts">
        <?php 
    foreach ($tag_posts as $row) { 
    ?>
        <div id="" class="subcscription_block-slide blockSub-slide subscriptions-post"
            key="<?php echo array_search($row, $tag_posts); ?>">
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
    </section>

    <?php 
        foreach ($tag_posts as $row) { 
    ?>
    <section id="" class="subscriptions-posts_addition addition"
        addition-key="<?php echo array_search($row, $tag_posts); ?>"
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
<h3 class="subcscription_title">Смотреть также</h3>
<div class="tags">
    <div class="tags_cnt">
        <?php
            wp_tag_cloud('smallest=12&largest=36&number=1500&format=flat&separator= &orderby=name');
        ?>
    </div>
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

    <!-- <form action="payment.php" method="POST" class='promocode-post'>
        <input type="text" name="promocode" class='promocode_duble'/>
        <button type='submit' class='post-promocode-payment'></button>
    </form> -->
</section>

<?php get_footer(); ?>