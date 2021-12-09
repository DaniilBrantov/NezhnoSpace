
<div class="page-blog">
    <div class="container">

        <h2>
            Блог
        </h2>
        <div class="main-blog">
            <div class="blog_first-line">
                <?php
            $temp = $wp_query; $wp_query= null;
        $wp_query = new WP_Query(); $wp_query->query('showposts=2' . '&paged='.$paged );
            query_posts('cat=18&posts_per_page=2');
            while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                <div class="blog_first-line_item">
                <a href="<?php the_permalink(); ?>">
                    <div class="blog_first-line_img">
                    <?php
                        if (has_post_thumbnail() ) {
                            the_post_thumbnail('blog');
                        }
                    ?>
                    </div>
                    <div class="blog_first-line_content">
                        <p><?php the_title(); ?></p>
                    </div>
                </a>
                </div>
            <?php endwhile; ?>
            </div>

            <div class="blog_second-line">

            <?php
            $temp = $wp_query; $wp_query= null;
        $wp_query = new WP_Query(); $wp_query->query('showposts=2' . '&paged='.$paged );
            query_posts('cat=18&posts_per_page=8&offset=2');
            while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                <div class="blog_second-line_item">
                <a href="<?php the_permalink(); ?>">
                    <div class="blog_second-line_img">
                    <?php
                        if (has_post_thumbnail() ) {
                            the_post_thumbnail('blog');
                        }
                    ?>
                    </div>
                    <div class="blog_second-line_content">
                        <p><?php the_title(); ?></p>
                    </div>
                </a>
                </div>
            
            <?php endwhile; ?>
            </div>
                <!-- <?php echo do_shortcode('[ajax_load_more container_type="div" css_classes="blog_second-line" post_type="post" posts_per_page="8" offset="10" pause="true" destroy_after="15" images_loaded="true" scroll="false" transition_container="false" button_label="Смотреть ещё" button_loading_label="Загрузка..." button_done_label="Статьи закончились" no_results_text=" <div>Sorry, nothing found in this query</div>"]'); ?> -->

            <!-- <script>
            const blog_else=document.querySelector('.blog-else')
            const show14=document.querySelector('.show_14');
            const thirdline=document.querySelector('#blog_third-line');
            show14.onclick=function () {
                show14.id="all_articles"
                show14.classList='all_articles';
                thirdline.style='display:grid';
                show14.style='display:none';
                show14.textContent='Смотреть все статьи (<?php echo  $count_blogs ; ?>)' ;
                const look_all=document.createElement('a');
                look_all.href='all-articles.php';
                look_all.classList='show_14';
                look_all.textContent='Смотреть все(<?php echo  $count_blogs ; ?>)'
                blog_else.prepend(look_all);
                }
                
            </script> -->
    </div>
    
</div>