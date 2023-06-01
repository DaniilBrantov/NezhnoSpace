<?php
/**
 * Template Name: admin
 *
 
 */
get_header();
require_once( get_theme_file_path('processing.php') );
$subscription = new Subscription();
if($subscription->getCheckAdmin()){
?>



<form action="admin_check" method="post">
    <div id="token-fields">
        <div class="token-field">
            <label for="email">Email:</label>
            <input type="email" name="email[]" required>

            <label for="token">Token:</label>
            <input type="text" name="token[]" required>

            <label for="info">Info:</label>
            <input type="text" name="info[]" required>

            <button type="button" class="delete-field">Delete</button>
        </div>
    </div>

    <button type="button" id="add-field">Add Field</button>
    <input type="submit" value="Submit">
</form>




<script>
document.addEventListener("DOMContentLoaded", function() {
    const addFieldButton = document.getElementById("add-field");
    const tokenFields = document.getElementById("token-fields");

    addFieldButton.addEventListener("click", function() {
        const fieldContainer = document.createElement("div");
        fieldContainer.className = "token-field";

        const emailInput = document.createElement("input");
        emailInput.type = "email";
        emailInput.name = "email[]";
        emailInput.required = true;

        const tokenInput = document.createElement("input");
        tokenInput.type = "text";
        tokenInput.name = "token[]";
        tokenInput.required = true;

        const infoInput = document.createElement("input");
        infoInput.type = "text";
        infoInput.name = "info[]";
        infoInput.required = true;

        const deleteButton = document.createElement("button");
        deleteButton.type = "button";
        deleteButton.className = "delete-field";
        deleteButton.textContent = "Delete";

        deleteButton.addEventListener("click", function() {
            fieldContainer.remove();
        });

        fieldContainer.appendChild(emailInput);
        fieldContainer.appendChild(tokenInput);
        fieldContainer.appendChild(infoInput);
        fieldContainer.appendChild(deleteButton);

        tokenFields.appendChild(fieldContainer);
    });

    const deleteButtons = document.getElementsByClassName("delete-field");
    for (const deleteButton of deleteButtons) {
        deleteButton.addEventListener("click", function() {
            deleteButton.parentNode.remove();
        });
    }
});
</script>














<h2>Добавление/Обновление ролей</h2>

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
    <input type="number" id="weeks" name="weeks" style="display: none;">

    <input type="submit" value="Отправить">
</form>

<script>
document.getElementById('status').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex].value;
    var weeksInput = document.getElementById('weeks');

    if (selectedOption === '3') {
        weeksInput.style.display = 'block';
    } else {
        weeksInput.style.display = 'none';
    }
});
</script>






<h2>Добавить промокод</h2>
<form action="admin_check" method="post">
    <label for="promo">Промокод (заглавными буквами):</label>
    <input type="text" id="promo" name="promo" required><br>

    <label for="sale">Скидка (от 1 до 100):</label>
    <input type="number" id="sale" name="sale" min="1" max="100" required onchange="togglePaidDays()"><br>

    <label for="first_date">Дата начала действия промокода:</label>
    <input type="date" id="first_date" name="first_date" required><br>

    <label for="last_date">Дата окончания действия промокода:</label>
    <input type="date" id="last_date" name="last_date"><br>

    <div id="paid_days_container" style="display: none;">
        <label for="paid_days">Количество дней оплаченной подписки:</label>
        <input type="number" id="paid_days" name="paid_days" min="1" max="365"><br>
    </div>

    <input type="submit" value="Отправить">
</form>

<script>
function togglePaidDays() {
    var saleInput = document.getElementById("sale");
    var paidDaysContainer = document.getElementById("paid_days_container");
    if (saleInput.value == 100) {
        paidDaysContainer.style.display = "block";
    } else {
        paidDaysContainer.style.display = "none";
    }
}
</script>




<?php 
    }; 
    get_footer(); 
?>






<!-- 
<br><br><br>

<br><br><br><br>


<div class="add_post">
    <h2>
        Добавить запись
    </h2>
    <form action="admin_check">
        <input name="title" type="text">
        <input name="excerpt" type="text">
        <input name="content" type="text">
        <?php
            // $categories = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name', 'hide_empty' => 0 ) );
            // if( $categories ){
            //     foreach ( $categories as $cat ){
            //         echo "<input type=\"radio\" name=\"category\" id=\"{$cat->term_id}\" value=\"{$cat->term_id}\">{$cat->name}</input>";
            //     }
            // };
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



<br><br><br><br> -->