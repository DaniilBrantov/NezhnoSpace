<?php
/**
 * Template Name: admin
 *
 
 */

require_once( get_theme_file_path('processing.php') );

?>

<form action="admin_check" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="">--Выберите статус--</option>
        <?php

      $status_options = $db->getAll("SELECT * FROM status");
      foreach ($status_options as $key => $value) {
        echo "<option value='" . ($key + 1) . "'>" . $value['name'] . "</option>";
      }
    ?>
    </select>

    <label for="pay_choice">Цена:</label>
    <?php
    $pay_options = $db->getAll("SELECT * FROM services");
    foreach ($pay_options as $key => $value) {
      echo "<input type='radio' id='pay_choice" . ($key + 1) . "' name='pay_choice' value='" . ($key + 1) . "' required>";
      echo "<label for='pay_choice" . ($key + 1) . "'>" . $value['price'] . "</label>";
    }
  ?>

    <input type="submit" value="Отправить">
</form>




<br><br><br><br><br><br><br>


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
<div class="add_payment_user">
    <h2>Добавить пользователя, который оплатил</h2>
    <form action="admin_check">
        <input name="add_payment_mail" type="text">
        <input name="add_payment_choice" type="number">
        <input name="add_payment_mail" type="text">
    </form>
</div>