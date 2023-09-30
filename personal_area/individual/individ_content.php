<?php
    session_start();
    if (!$_SESSION['user'] && $_SESSION['user']['payment']!==2) {
        header('Location: auth');
    }
    require_once 'connect.php';
    $less_num= $_GET["id"];
    $session_id=$_SESSION['user']['id'];
    $indiv_cnt_users=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `users_individ_content` WHERE `less_number` = '$less_num' AND `id_users` = '$session_id' "));
    $id_indiv_cnt=$indiv_cnt_users["id_individ_content"];
    $individual_content=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `individ_content` WHERE `id` = '$id_indiv_cnt' "));
    if($individual_content["title"] =="" || $indiv_cnt_users["publication"]==0){
        header('Location: uchebnaya-programma');
    }
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
                <h3>Об упражнении:</h3>
                <div class="les_goal_item_txt">
                    <p><?php  echo $individual_content["purpose"];  ?></p>
                </div>
            </div>

            <div class="les_goal_item">
                <h3>Короткое описание:</h3>
                <div class="les_goal_item_txt">
                    <p><?php  echo $individual_content["result"];  ?></p>
                </div>
            </div>
        </div>
        <?php if($individual_content["theory_content"]){ ?>
        <div class="les_theory">
            <h2>Инструкции по выполнению:</h2>
            <hr>
            <div class="les_theory_content">
                <p><?php  echo $individual_content["theory_content"];  ?> </p>
            </div>
        </div>
        <?php }; ?>
    </div>
    <?php if($individual_content["audio"]){ ?>
    <div class="les_audio">
        <h2>Название аудио</h2>
        <hr>
        <div class="les_audio_txt">
            <div class="les_audio_txt_title">
                <img src="<?php img('headphone.png') ?>" alt="tTt">
                <p>В аудиозаписи рассматриваются:</p>
                <div class="curriculum_btn les_btn">
                    <button onclick="audioTxt()" id="les_button">
                        <img src="<?php img('account_arrow.svg') ?>" alt="">
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
            <audio id="audio" controls preload="none">
                <source
                    src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $individual_content['audio']; ?>"
                    type="audio/mpeg">
                <source
                    src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $individual_content['audio']; ?>"
                    type="audio/ogg">
                Ваш Браузер не поддерживает данный формат audio.
            </audio>
        </div>
    </div> <?php }; ?>
</div>





<div class="page">
    <div class="page__demo">
        <div class="page__group">
            <form class="rating">
                <input type="radio" name="rating-star2" value="1" class="rating__control screen-reader" id="rc6">
                <input type="radio" name="rating-star2" value="2" class="rating__control screen-reader" id="rc7">
                <input type="radio" name="rating-star2" value="3" class="rating__control screen-reader" id="rc8">
                <input type="radio" name="rating-star2" value="4" class="rating__control screen-reader" id="rc9">
                <input type="radio" name="rating-star2" value="5" class="rating__control screen-reader" id="rc10">
                <label for="rc6" class="rating__item">
                    <svg class="rating__star">
                        <use xlink:href="#star"></use>
                    </svg>
                    <span class="screen-reader">1</span>
                </label>
                <label for="rc7" class="rating__item">
                    <svg class="rating__star">
                        <use xlink:href="#star"></use>
                    </svg>
                    <span class="screen-reader">2</span>
                </label>
                <label for="rc8" class="rating__item">
                    <svg class="rating__star">
                        <use xlink:href="#star"></use>
                    </svg>
                    <span class="screen-reader">3</span>
                </label>
                <label for="rc9" class="rating__item">
                    <svg class="rating__star">
                        <use xlink:href="#star"></use>
                    </svg>
                    <span class="screen-reader">4</span>
                </label>
                <label for="rc10" class="rating__item">
                    <svg class="rating__star">
                        <use xlink:href="#star"></use>
                    </svg>
                    <span class="screen-reader">5</span>
                </label>
            </form>
            <div class="general_btn">
                <button id="individ_rating_btn">
                    <img src="<?php img('account_arrow.svg') ?>" alt="">
                </button>
            </div>
        </div>
        <div class="rating_success"></div>
    </div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none">
    <symbol id="star" viewBox="0 0 26 28">
        <path
            d="M26 10.109c0 .281-.203.547-.406.75l-5.672 5.531 1.344 7.812c.016.109.016.203.016.313 0 .406-.187.781-.641.781a1.27 1.27 0 0 1-.625-.187L13 21.422l-7.016 3.687c-.203.109-.406.187-.625.187-.453 0-.656-.375-.656-.781 0-.109.016-.203.031-.313l1.344-7.812L.39 10.859c-.187-.203-.391-.469-.391-.75 0-.469.484-.656.875-.719l7.844-1.141 3.516-7.109c.141-.297.406-.641.766-.641s.625.344.766.641l3.516 7.109 7.844 1.141c.375.063.875.25.875.719z" />
    </symbol>
</svg>