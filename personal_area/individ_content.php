<?php
    session_start();
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    require_once 'connect.php';
    $less_num= $_GET["id"];
    $session_id=$_SESSION['user']['id'];
    $indiv_cnt_users=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `users_individ_content` WHERE `less_number` = '$less_num' AND `id_users` = '$session_id' "));
    $id_indiv_cnt=$indiv_cnt_users["id_individ_content"];
    $individual_content=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `individ_content` WHERE `id` = '$id_indiv_cnt' "));
?>  
<div class="les">
        <div class="les_banner">
            <div class="les_title">
                <h1><?php  echo $individual_content["title"];  ?></h1>
            </div>
            <hr>
            <div class="les_banner_img">
                    <img src="" alt="">
            </div>
        </div>
    <div class="container">
        <div class="les_goal">
            <div class="les_goal_item">
                <h3>Цель урока:</h3>
                <div class="les_goal_item_txt">
                    <p><?php  echo $individual_content["purpose"];  ?></p>
                </div>
            </div>

            <div class="les_goal_item">
                <h3>Результат урока:</h3>
                <div class="les_goal_item_txt">
                    <p><?php  echo $individual_content["result"];  ?></p>
                </div>
            </div>
        </div>
        <div class="les_theory">
            <h2>Теоритическая часть</h2>
            <hr>
            <div class="les_theory_content">
                <p><?php  echo $individual_content["theory_content"];  ?> </p>
            </div>
        </div>
    </div>
        <div class="les_audio">
            <h2>Название аудио</h2>
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
                    <p><?php  echo $individual_content["audio_txt"];  ?> </p>
                </div>
            </div>
            <hr>
            <div class="audio_cont">
                <audio src=""></audio>
                <div class="audio_play audio_active">
                    <ion-icon name="play-outline"></ion-icon>
                </div>
            </div>
        </div>
    <div class="container">
        <div class="les_hw">
            <h2>Домашнее задание</h2>
            <hr>
            <div class="les_hw_content">
                <img src="<?php echo get_template_directory_uri(); ?>/images/tg.svg" alt="">
                <div class="les_hw_link" onclick="tgTxt()"></div>
                <a href="https://web.telegram.org/k/" class="les_hw_link_txt">Написать мне <span>для выдачи д/з и прохождения вперёд</span> </a>
            </div>
            <div class="les_hw_tg">
                <a href="https://web.telegram.org/k/">@eatintel</a>
            </div>
            
        </div>
    </div>
</div>