<?php
    session_start();
    if (!$_SESSION['user'] || $_SESSION['user']['payment']!== '2' ) {
        header('Location: uchebnaya-programma');
    }
    require_once "connect.php";
    $less_num =$_GET["id"];
    $users_id=$_SESSION['user']['id'];
    if($_SESSION['user']['payment']==1){
        $main_stages=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `main_subscription` WHERE `id` = '$less_num' ORDER BY id LIMIT 1 "));
    }else{
        $main_stages=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `main_stages` WHERE `less_number` = '$less_num' ORDER BY id LIMIT 1 "));
    }
    
    $pos = strpos($_SESSION["stages"]['main'],$_SERVER['REQUEST_URI']);
    if($main_stages["title"]=="" || !$pos){
        header('Location: uchebnaya-programma');
    }

?>  

            <?php
            if(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `survey` WHERE `less_num` = '$less_num' AND `users_id` = '$users_id' "))){
                echo '<div class="help_success">
                    <div class="help_success_cnt">
                        <img src="'. get_template_directory_uri() .'/images/check.svg" alt="">
                        <p>Этап пройден! Скоро тебе откроется Индивидуальный маршрут.</p>
                    </div>
                    </div>';
            }
            ?>  
    <div class="les">
        <div class="les_banner">
            <div class="les_title">
                <h1><?php echo $main_stages["title"];  ?></h1>
            </div>
            <hr>
                <iframe class="les_banner_img" width="700" height="400" src="<?php echo $main_stages['video']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <h2>Аудио: Теория</h2>
            <hr>
            <div class="les_audio_txt">
                <div class="les_audio_txt_title">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/headphone.png" alt="tTt">
                    <p>В аудиозаписи рассматриваются:</p>
                    <div class="curriculum_btn les_btn">
                            <button onclick="audioTxt()" id="les_button">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                            </button>
                    </div>
                </div>
                <div id="les_audio_txt_cont" class="les_audio_txt_cont">
                    <hr>
                    <p><?php  echo $main_stages["audio_txt"];  ?> </p>
                </div>
            </div>
            <hr>
            <div class="audio_cont">
                <audio id="audio" controls preload="none">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $main_stages['audio']; ?>" type="audio/mpeg">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $main_stages['audio']; ?>" type="audio/ogg">
                    Ваш Браузер не поддерживает данный формат audio.
                </audio>
            </div>
        </div>
            
    <div class="container">
        <div class="les_goal">
            <div class="les_goal_item">
                <h3>Цель этапа:</h3>
                <div class="les_goal_item_txt">
                    <p><?php  echo $main_stages["purpose"];  ?></p>
                </div>
            </div>
            <div class="les_goal_item">
                <h3>Результат этапа:</h3>
                <div class="les_goal_item_txt">
                    <p><?php  echo $main_stages["result"];  ?></p>
                </div>
            </div>
        </div>
        <div class="les_theory">
            <h2>Расписание</h2>
            <hr>
        </div>
    </div>
        <div class="les_audio">
            <h2>Аудио: Практика</h2>
            <hr>
            <div class="les_audio_txt">
                <div class="les_audio_txt_title">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/headphone.png" alt="tTt">
                    <p>В аудиозаписи рассматриваются:</p>
                    <div class="curriculum_btn les_btn">
                            <button onclick="SecondAudioTxt()" id="second_les_button">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                            </button>
                    </div>
                </div>
                <div id="second_les_audio_txt_cont" class="les_audio_txt_cont">
                    <hr>
                    <p><?php  echo $main_stages["second_audio_txt"]; ?></p>
                </div>
            </div>
            <hr>
            <div class="audio_cont">
                <audio id="audio" controls preload="none">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $main_stages['second_audio']; ?>" type="audio/mpeg">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $main_stages['second_audio']; ?>" type="audio/ogg">
                    Ваш Браузер не поддерживает данный формат audio.
                </audio>
            </div>
        </div>
    <div class="container">
            <div class="les_theory_content">
                <p><?php  echo $main_stages["theory_txt"];  ?></p>
            </div>
    </div>
        
    <div class="container les">
        <div class="les_hw">
            <h2>Домашнее задание</h2>
            <hr>
        </div>
    </div>
    
    <form action="https://eatintelligent.ru/lesson_check"  method='post'>
        <div id="survey" class = 'survey'></div>
        <input id="survey_value" type="hidden" name="survey_value">
        <input id="less_num" type="hidden" name="less_num" value="<?php echo $less_num; ?>">
        <input id="survey_btn" type="submit">
    </form>

    <div class="container">
        <div class="less_pdf audio_meditation_cnt">
            <a href="<?php echo get_template_directory_uri(); ?>/personal_area/pdf_files/stage_<?php echo $less_num;?>.pdf" download >
                <img src="<?php echo get_template_directory_uri(); ?>/images/download_icon.png" alt="">
            </a>
            <p>Скачать pdf-материал этапа</p>

        </div>
    </div>
    </div>
</div>