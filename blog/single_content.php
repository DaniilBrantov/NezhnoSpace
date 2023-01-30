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