<?php 
    session_start();

    if($_SESSION["admin"]){
        require_once "connect.php";
        date_default_timezone_set('Europe/Moscow');


    
?>



<div class="wrapper_admin">
    <div class="main_admin">
        <div class="admin_title">
            <h1>Общий Контент:</h1>
            <a href="#individ_cont_title">В Индивидуальный Контент</a>
        </div>
        <div class="admin_main_content">
            <div class="admin_add">
                <h2>Добавить переменную:</h2>
                    <form action="https://nezhno.space/add_var" method='post' enctype="multipart/form-data">
                        <div class="add_var_item stage_number">
                            <input class="add_var_item_input" type="text"  name="less_number" required oninvalid="this.setCustomValidity('Уточни, какой номер этапа')" oninput="setCustomValidity('')">
                            <label class="add_var_item_label">Номер Этапа</label>
                            <div class="number_controls">
                                <div class="nc_minus">-</div>
                                <div class="nc_plus">+</div>
                            </div>
                        </div>
                        <div class="add_var_item">
                            <input class="add_var_item_input" type="text" name="title" required>
                            <label class="add_var_item_label">Название Переменной</label>
                        </div>
                        <div class="add_var_item">
                            <input class="add_var_item_input" type="text" name="description" required>
                            <label class="add_var_item_label">Описание</label>
                        </div>
                        <div class="add_var_item">
                            <input class="add_var_item_input" type="text" name="purpose" required>
                            <label class="add_var_item_label">Цель</label>
                        </div>
                        <div class="add_var_item">
                            <input class="add_var_item_input" type="text" name="result" required>
                            <label class="add_var_item_label">Результат</label>
                        </div>
                        <div class="add_var_item">
                            <input class="add_var_item_input" type="text" name="content" required>
                            <label class="add_var_item_label">Содержимое</label>
                        </div>
                        <div class="add_var_item">
                            <input class="add_var_item_input" type="text" name="audio_txt" required>
                            <label class="add_var_item_label">Аудио описание</label>
                        </div>
                        <div class="add_var_item">
                            <input class="add_var_item_input" type="text" name="second_audio_txt" required>
                            <label class="add_var_item_label">Второе аудио описание</label>
                        </div>
                        <div class="add_var_item">
                            <input class="add_var_item_input" type="text" name="video" required>
                            <label class="add_var_item_label">Ссылка на видео</label>
                        </div>
                        <div class="add_image">
                            <p>Изображение</p>
                            <input class="add_var_item_input" id="image" type="file" name="image">
                            <label id="add_image_label" for="image">
                                <span class="image_btn">Добавить</span>
                            </label>
                        </div>
                        <div class="add_image">
                            <p>Аудио</p>
                            <input class="add_var_item_input" id="audio" type="file" name="audio">
                            <label id="add_audio_label" for="audio">
                                <span id="audio_btn" class="audio_btn">Добавить</span>
                            </label>
                        </div>
                        <div class="add_image">
                            <p>Ещё Аудио</p>
                            <input class="add_var_item_input" id="second_audio" type="file" name="second_audio">
                            <label id="second_audio_label" for="second_audio">
                                <span id="second_audio_btn" class="audio_btn">Добавить</span>
                            </label>
                        </div>
                        <p class="check_mp"></p>
                        <div class="admin_btn_group">
                            <button type="submit">Добавить</button>
                        </div>
                    </form>
            </div>
                <div class="admin_main_stages">
                    <?php $variables= mysqli_query($mysqli,"SELECT * FROM `main_stages`");
                    while($var=mysqli_fetch_assoc($variables)){
                    echo ' 
                    <div class="main_stages_item"> 
                        <a class="delete_les" href="delete_variable?id=' . $var["id"] .'">Удалить</a>
                            <div class="main_stage_cnt">
                                <h2 scope="row">0' . $var["less_number"] . '</h2>
                                <h3>' . $var["title"] . '</h3>
                                <p>' . $var["description"] . '</p>
                            </div>
                        <div class="admin_btn_group" >
                            <a href="update?id=' . $var["id"] .'">Редактировать</a>
                        </div>
                    </div>
                        
                    
                    ';  };  ?>
                </div>
        </div>
    </div>
    <div class="individ_admin">
        <div class="admin_title">
            <h1 id="individ_cont_title">Индивидуальный<br>контент:</h1>
        </div>
    
        <?php 
        $users=mysqli_query($mysqli,"SELECT * FROM `users` WHERE `payment` = '2'");
        while($person=mysqli_fetch_assoc($users)){
        $person_id=$person["id"];
        $today=new DateTime(date('Y-m-d H:i:s'));
        $interval = $today->diff(new DateTime($person["next_stage"]));
        $difference = $interval->format("%D");
        $difference = floor($difference /6+2);

        $users_individ_content=mysqli_query($mysqli,"SELECT * FROM `users_individ_content` WHERE `id_users` = '$person_id'");
            echo '<div class="individ_cnt_item">
                    <p style="--1:var(--turquoise);
                    --2:#454545;
                    --3:var(--pink);
                    --4:var(--purple);
                    background: var(--'.$person["route_value"].');">' . $person["name"] . '</p>
                    <p>' . $person["mail"] . '</p>
                    <div class="admin_btn_group indiv_btn" >
                        <a href="individ_update?id=' . $person["id"] .'">Добавить контент</a>
                    </div>
                    </div>';
                    while($individ_content=mysqli_fetch_assoc($users_individ_content)){
                        $individ_content_id=$individ_content["id_individ_content"];
                        $individual_cnt=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `individ_content` WHERE `id` = '$individ_content_id'"));
                        echo '<div class="individ_admin_list">
                            <p>'.$individ_content["less_number"].'.</p>
                            <span>'.$individual_cnt["title"].'</span>
                            <a class="change_indiv_les" href="individ_change?id=' . $person["id"] .'">Редактировать</a>
                            <a class="delete_indiv_les" href="delete_variable?stage=' . $person["id"] .'&les_num=' .$individ_content["less_number"]. '">Удалить</a>
                            ';
                            if($individ_content["publication"]==0){
                                echo '<button class="publication_btn change_indiv_les" value="' . $person["id"] .' , ' .$individ_content["less_number"]. '">Опубликовать</button>';
                            }

                        echo'</div>';
                    };
                    echo '<div class="statistics_part_content individ_statistics">
                        <div class="statistics_part_text">
                            <div class="statistics_part_title">
                                <p>Пройдено:</p>
                            </div>
                            <div class="statistics_part_procent">
                                <p><span>'.$difference.'</span>/8</p>
                            </div>
                        </div>
                        <div class="progress indiv_progress">
                            <progress id="indiv_progress" max="8" value="'.$difference.'">'.$difference.'</progress>
                        </div>
                    </div>';

            }; 
        ?>
    </div>
</div>



        











    <?php }
        else{   
    ?>

<div class="pers auth">
    <div class="container">
        <h2 class="pers_title">Авторизация</h2>
            <form class="pers_form" action="admin_check" method="post">
                <div class="pers_item">
                    <input class="pers_input" type="text"  id="mail" name="gmail" required><br>
                    <label class="pers_label">E-mail</label>
                </div>
                <div class="pers_item">
                    <input class="pers_input" type="password" id="pass" name="password" required><br>
                    <label class="pers_label">Пароль</label>
                </div>
                <button class="auth_btn" type="submit">Войти</button>
            </form>
    </div>
</div>
    
<?php }; ?>