<?php
    session_start();

    if(!$_SESSION["admin"]){
        header('Location: /auth');
    }

    require_once "connect.php";

    $id= $_GET["id"];
    $ind_cnt=mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM `individ_content` WHERE `id` = $id"));


    ?>

<div class="wrapper_admin">
    <div class="admin_add update">
        <h1>Введите данные</h1>
        <form action="individ_update_check" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="add_var_item stage_number">
                <input class="add_var_item_input" type="number" name="less_number" required>
                <label class="add_var_item_label">Номер урока</label>
                <div class="number_controls">
                    <div class="nc_minus">-</div>
                    <div class="nc_plus">+</div>
                </div>
            </div>
            <div class="add_var_item">
                <input class="add_var_item_input" type="text" id="update_title" name="title" required>
                <label class="add_var_item_label" for="update_title">Заголовок</label>
            </div>
            <div class="add_var_item">
                <input class="add_var_item_input" type="text" name="purpose" required>
                <label class="add_var_item_label">Цель урока</label>
            </div>
            <div class="add_var_item">
                <input class="add_var_item_input" type="text" name="result" required>
                <label class="add_var_item_label">Результат урока</label>
            </div>
            <div class="add_var_item">
                <input class="add_var_item_input" type="text" name="content" required>
                <label class="add_var_item_label">Теоритическая часть</label>
            </div>
            <div class="add_var_item">
                <input class="add_var_item_input" type="text" name="audio_txt" required>
                <label class="add_var_item_label">Описание аудио</label>
            </div>
        <!--        <div class="add_var_item">
                        <label for="image">Изображение</label>
                        <input name="image" type="file">
                    </div> -->
            <div class="admin_btn_group">
                <button type="submit">Добавить</button>
            </div>
        </form>
    </div>
</div>
