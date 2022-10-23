<?php
    session_start();

    if(!$_SESSION["admin"]){
        header('Location: /auth');
    }

    require_once "connect.php";

    $id= $_GET["id"];
    $var=mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM `main_stages` WHERE `id` = $id"));


    ?>



<div class="wrapper_admin">
    <div class="admin_add update">
            <h1>Обновить переменную</h1>
        <form action="_check" method="post">
            <input type="hidden" name="id" value="<?php echo $var["id"]; ?>">
                    <div class="add_var_item stage_number">
                        <input class="add_var_item_input" type="text" name="less_number" value="<?php echo $var["less_number"]; ?>" required >
                        <label class="add_var_item_label" for="update_title">Номер Этапа</label>
                        <div class="number_controls">
                            <div class="nc_minus">-</div>
                            <div class="nc_plus">+</div>
                        </div>
                    </div>
                    <div class="add_var_item">
                        <input class="add_var_item_input" type="text" id="update_title" name="title" value="<?php echo $var["title"]; ?>" required>
                        <label class="add_var_item_label" for="update_title">Название переменной</label>
                    </div>
                    <div class="add_var_item">
                        <input class="add_var_item_input" type="text" name="description" value="<?php echo $var["description"]; ?>" required>
                        <label class="add_var_item_label">Описание</label>
                    </div>
                    <div class="add_var_item">
                        <input class="add_var_item_input" type="text" name="purpose" value="<?php echo $var["purpose"]; ?>" required>
                        <label class="add_var_item_label">Цель</label>
                    </div>
                    <div class="add_var_item">
                        <input class="add_var_item_input" type="text" name="result" value="<?php echo $var["result"]; ?>" required>
                        <label class="add_var_item_label" >Результат</label>
                    </div>
                    <div class="add_var_item">
                        <input class="add_var_item_input" type="text" name="content" value="<?php echo $var["theory_txt"]; ?>"required>
                        <label class="add_var_item_label">Содержимое</label>
                    </div>
                    <div class="add_var_item">
                        <input class="add_var_item_input" type="text" name="audio_txt" value="<?php echo $var["audio_txt"]; ?>"required>
                        <label class="add_var_item_label">Аудио описание</label>
                    </div>
                    <div class="admin_btn_group">
                        <button type="submit">Добавить</button>
                    </div>
        </form>
    </div>
    
</div>
