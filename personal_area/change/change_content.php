<?php
    session_start();
    require_once "connect.php";
    if (!$_SESSION['user']) {
        header('Location: auth');
    }

    $id=$_SESSION['user']['id'];
    $sex_query=mysqli_query($mysqli, "SELECT * FROM `users`  WHERE `users`.`id` = $id ");
    $change_assoc=mysqli_fetch_assoc($sex_query);
    if (mysqli_num_rows($sex_query)>0){
        $sex=$change_assoc["sex"];
    };
?>  








<div class="choice_img " id="choice_img">

    <h2>Выберите Свой Аватар</h2>
    <form action="https://nezhno.space/change_check" method='post' id="choice_img_grid">
        <div class="choice_img_flex">
            <div class="choice_img_grid">
                <div class="choice_img_item">
                    <input class="check_img" name="check_img" value="5" type="radio" id="ImgCheckbox-1" />
                    <label for="ImgCheckbox-1">
                    <img id="choiceImg" class="choice_img_avatar" src="<?php echo get_template_directory_uri(); ?>/images/change_img5.png" alt="" />
                    </label>
                </div>
                <div class="choice_img_item">
                    <input class="check_img" name="check_img" value="6" type="radio" id="ImgCheckbox-2" />
                    <label for="ImgCheckbox-2">
                        <img id="choiceImg" class="choice_img_avatar" src="<?php echo get_template_directory_uri(); ?>/images/change_img6.png" alt="" />
                    </label>
                </div>
                <div class="choice_img_item">
                    <input class="check_img" name="check_img" value="7" type="radio" id="ImgCheckbox-3" />
                    <label for="ImgCheckbox-3">
                        <img id="choiceImg" class="choice_img_avatar" src="<?php echo get_template_directory_uri(); ?>/images/change_img7.png" alt="" />
                    </label>
                </div>
                <div class="choice_img_item">
                    <input class="check_img" name="check_img" value="8" type="radio" id="ImgCheckbox-4" />
                    <label for="ImgCheckbox-4">
                        <img id="choiceImg" class="choice_img_avatar" src="<?php echo get_template_directory_uri(); ?>/images/change_img8.png" alt="" />
                    </label>
                </div>
            </div>


            <div class="choice_img_grid">
                <div class="choice_img_item">
                    <input class="check_img" name="check_img" value="2" type="radio" id="ImgCheckbox-5" />
                    <label for="ImgCheckbox-5">
                        <img id="choiceImg" class="choice_img_avatar" src="<?php echo get_template_directory_uri(); ?>/images/change_img2.png" alt="" />
                    </label>
                </div>
                <div class="choice_img_item">
                    <input class="check_img" name="check_img" value="1" type="radio" id="ImgCheckbox-6" />
                    <label for="ImgCheckbox-6">
                        <img id="choiceImg" class="choice_img_avatar" src="<?php echo get_template_directory_uri(); ?>/images/change_img1.png" alt="" />
                    </label>
                </div>
                <div class="choice_img_item">
                    <input class="check_img" name="check_img" value="3" type="radio" id="ImgCheckbox-7" />
                    <label for="ImgCheckbox-7">
                        <img id="choiceImg" class="choice_img_avatar" src="<?php echo get_template_directory_uri(); ?>/images/change_img3.png" alt="" />
                    </label>
                </div>
                <div class="choice_img_item">
                    <input class="check_img" name="check_img" value="4" type="radio" id="ImgCheckbox-8" checked/>
                    <label for="ImgCheckbox-8">
                        <img id="choiceImg" class="choice_img_avatar" src="<?php echo get_template_directory_uri(); ?>/images/change_img4.png" alt="" />
                    </label>
                </div>
            </div>
        </div>

        <div class="your_color_skin">
            <h3>Тон Кожи</h3>
            <div class="color_skin">
                <div class="color_skin_item color_skin_item_white"></div>
                <div class="color_skin_item color_skin_item_black"></div>
            </div>
        </div>
        
        <div class="choice_img_btn">
            <input id="avatar_btn" type="submit" name="avatar_btn" value="Сохранить">
        </div>
        
    </form>
</div>




<div class="change_wrapper">
    <div class="change_container">
        <div class="change">
            <div class="change_info">
                <div class="change_img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/change_img<?php echo $change_assoc["avatar"]; ?>.png')">
                    <div class="change_img_btn">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="">
                    </div>
                    </a>
                </div>
                <div class="personal_data">
                    <div class="change_info_name">
                        <span><?=$_SESSION['user']['surname']?></span>
                        <span><?=$_SESSION['user']['name']?></span>
                    </div>
                    <div class="change_info_item">
                        Возраст: <span><?=$_SESSION['user']['age']?></span>
                    </div>
                    <div class="change_info_item">
                        Email: <span><?=$_SESSION['user']['mail']?></span>
                    </div>
                </div>
            </div>
                    <form action="change_check" method='post' enctype="multipart/form-data">
                        <div class="change_data">
                            <div class="change_data_item" id="change_data_name">
                                <label >Имя</label>
                                <input name="change_name" type="text" value="<?=$_SESSION['user']['name']?>">
                                <p class="change_error"></p>
                            </div>
                            <div class="change_data_item" id="change_data_sex">
                                <label >Пол</label><br>
                                <select id="change_sex" class="change_sex" name="change_sex" value="<?php echo $sex; ?>">
                                    <option value="1">Мужской</option>
                                    <option value="2">Женский</option>
                                    <option value="3">Небинарный</option>
                                    <option value="4">Другое</option>
                                </select>
                            </div>
                            <div class="change_data_item" id="change_data_surname">
                                <label >Фамилия</label>
                                <input name="change_surname" type="text" value="<?=$_SESSION['user']['surname']?>">
                                <p class="change_error"></p>
                            </div>
                            <div class="change_data_item" id="change_data_age">
                                <label >Возраст</label>
                                <input name="change_age" type="number" min="1" max="99" value="<?=$_SESSION['user']['age']?>">
                                <p class="change_error"></p>
                            </div>
                            <!-- <div class="change_data_item">
                                <label >E-mail</label>
                                <input name="change_mail" type="text" value="<?=$_SESSION['user']['mail']?>">
                                <p class="change_error"></p>
                            </div> -->
                        </div>
                        <input type="submit" name="change_save" value="Сохранить" class="change_save">
                    </form>
                    
                    
                
    </div>
    </div>

    
</div>
