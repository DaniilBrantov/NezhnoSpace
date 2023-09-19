
<div class="container">
    <div class="blog">

    <?php
        $temp = $wp_query; $wp_query= null;
        $wp_query = new WP_Query(); $wp_query->query('showposts=4' . '&paged='.$paged);
        query_posts('cat=18');
            while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                <div class="blog_item"> 
                    <h3>
                        <?php the_title(); ?>
                    </h3>
                    <hr>
                    <?php
                        if (has_post_thumbnail() ) {
                            the_post_thumbnail();
                        }
                    ?>
                    <hr>
                    <p>
                        <?php
                            $maxchar = 100;
                            $text = strip_tags( get_the_content() );
                            echo mb_substr( $text, 0, $maxchar ) ;
                            echo "...";
                        ?>
                    </p>
                    <a href="<?php the_permalink(); ?>">
                        Читать дальше
                    </a>
                </div>
            <?php endwhile; ?>  

    </div>
    <div class="go-over">
        <a href="page-blog">
            Перейти
        </a>
    </div>
</div>