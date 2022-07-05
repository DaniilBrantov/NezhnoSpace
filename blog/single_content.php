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
            
                <div class="single_cnt">
                    <h1>
                        <?php the_title(); ?>
                    </h1>
                    <p>
                        <?php the_content();?>
                    </p>
                </div>
        </div>
    </div>
</div>
