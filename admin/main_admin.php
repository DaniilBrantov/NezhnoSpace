<?php
/**
 * Template Name: admin
 *
 
 */
?>

<div class="add_post">
    <h2>
        Добавить запись
    </h2>
    <form action="admin_check">
        <input name="title" type="text">
        <input name="excerpt" type="text">
        <input name="content" type="text">
        <?php
            $categories = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name', 'hide_empty' => 0 ) );
            if( $categories ){
                foreach ( $categories as $cat ){
                    echo "<input type=\"radio\" name=\"category\" id=\"{$cat->term_id}\" value=\"{$cat->term_id}\">{$cat->name}</input>";
                }
            };
        ?>
        <input name="add_post" type="submit">
    </form>
</div>