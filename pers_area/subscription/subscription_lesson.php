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
$src = wp_get_attachment_image_src($thumb_id, 'full');

?>

<div class="sub_less">
    <div class="sub_less_banner">
        <div class="sub_container">
            <div class="sub_less_title">
                <h1>
                    <?php echo get_the_title(); ?>
                </h1>
            </div>
            <div class="sub_less_tag">
                <?php echo $post_data['tag']; ?>
            </div>
        </div>
    </div>
    <div class="sub_container">
        <div class="sub_less_cnt">
            <p><?php the_content(); ?></p>
        </div>
    </div>

</div>