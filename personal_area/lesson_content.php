<?php
    session_start();
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    require_once "connect.php";
    $less_num =$_GET["id"];
    $main_stages=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `main_stages` WHERE `less_number` = '$less_num' "));
?>  
<div class="les">
        <div class="les_banner">
            <div class="les_title">
                <h1><?php  echo $main_stages["title"];  ?></h1>
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
                    <p><?php  echo $main_stages["purpose"];  ?></p>
                </div>
            </div>

            <div class="les_goal_item">
                <h3>Результат урока:</h3>
                <div class="les_goal_item_txt">
                    <p><?php  echo $main_stages["result"];  ?></p>
                </div>
            </div>
        </div>
        <div class="les_theory">
            <h2>Теоритическая часть</h2>
            <hr>
            <div class="les_theory_content">
                <p><?php  echo $main_stages["theory_txt"];  ?></p>
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
                    <p><?php  echo $main_stages["audio_txt"];  ?> </p>
                </div>
            </div>
            <hr>
            <div class="audio_cont">
                <audio id="audio" controls preload="none">
                    <source src="<?php echo get_template_directory_uri(); ?>/audio/coldplay-paradise.mp3" type="audio/mpeg">
                    <source src="<?php echo get_template_directory_uri(); ?>/audio/coldplay-paradise.mp3" type="audio/ogg">
                    Ваш Браузер не поддерживает данный формат audio.
                </audio>
                <div> 
                </div>
                <!-- <div class="audio_play audio_active">
                    <ion-icon class="audio_play_icon" name="play-outline"></ion-icon>
                </div> -->
                


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