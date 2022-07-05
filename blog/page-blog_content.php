<div class="wrapper_blog">
    <div class="container">
        <div class="blog_title">
            <h1>Блог</h1>
        </div>
            <div class="blog">
                <div class="blog_fst_line">
                    <?php
                $temp = $wp_query; $wp_query= null;
                $wp_query = new WP_Query(); $wp_query->query('showposts=5' . '&paged='.$paged );
                query_posts('cat=18&posts_per_page=5');
                while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <a style="
                        background: linear-gradient( rgba(0, 0, 0, 0), rgb(0, 0, 1) ), url(
                                <?php 
                                    if (has_post_thumbnail() ) {
                                        the_post_thumbnail_url('blog');
                                    } 
                                ?>) center no-repeat;
                        background-size: cover;
                        " class="blog_item" href="<?php the_permalink(); ?>"> 
                            <div class="blog_item_top">
                                <div class="blog_favourites">
                                
                                </div>
                                <div class="blog_date">
                                    <?php echo get_the_date();?>
                                </div>
                            </div>
                            <div class="blog_item_txt">
                                <div class="blog_item_title">
                                    <h3>
                                        <?php the_title(); ?>
                                    </h3>
                                </div>
                                <div class="blog_item_description">
                                <?php
                                    $limit = 50;
                                    $string = strip_tags( get_the_content() );
                                    

                                    if (strlen($string) > $limit) {
                                        $substring_limited = substr($string, 0, $limit);
                                        $return = substr($substring_limited, 0, strrpos($substring_limited, ' ')) . $after;
                                        } else
                                        $return = $string;
                                        echo $return.'...';
                                ?>
                                </div>
                            </div>
                        </a>
                <?php endwhile; ?>
                    
                </div>
                <div class="blog_snd_line">
                    <?php
                    $temp = $wp_query; $wp_query= null;
                    $wp_query = new WP_Query(); $wp_query->query('showposts=4' . '&paged='.$paged );
                    query_posts('cat=18&posts_per_page=4&offset=5');
                    while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                    <a style="
                        background: linear-gradient( rgba(0, 0, 0, 0), rgb(0, 0, 1) ), url(
                                <?php 
                                    if (has_post_thumbnail() ) {
                                        the_post_thumbnail_url('blog');
                                    } 
                                ?>) center no-repeat;
                        background-size: cover;
                        " class="blog_item" href="<?php the_permalink(); ?>">
                        <div class="blog_item_top">
                            <div class="blog_favourites">
                            </div>
                            <div class="blog_date">
                                <?php echo get_the_date();?>
                            </div>
                        </div>
                            <div class="blog_item_txt">
                                <div class="blog_item_title">
                                    <h3>
                                        <?php the_title(); ?>
                                    </h3>
                                </div>
                                <div class="blog_item_description">
                                    <?php
                                        $limit = 110;
                                        $string = strip_tags( get_the_content() );
                                        

                                        if (strlen($string) > $limit) {
                                            $substring_limited = substr($string, 0, $limit);
                                            $return = substr($substring_limited, 0, strrpos($substring_limited, ' ')) . $after;
                                            } else
                                            $return = $string;
                                            echo $return.'...';
                                    ?>
                                </div>
                            </div>
                    </a>
                    <?php endwhile; ?>
                </div>
            </div>
    </div>
</div>