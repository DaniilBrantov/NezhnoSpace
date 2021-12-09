<?php
    session_start();
    if (!$_SESSION['user']) {
        header('Location: auth');
    }

?>  
<div class="account">
    <div class="profile_n_statistics">
        <div class="profile">
            <div class="profile_user">
                <p class="profile_user_name"><?=$_SESSION['user']['name']?></p>
                <p class="profile_user_year">Возраст: ...</p>
            </div>
            <div class="profile_mobile">
                <div class="profile_img">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/account_icon.jpg" alt="">
                </div>
                <div class="profile_user_mobile">
                    <p class="profile_user_name"><?=$_SESSION['user']['name']?></p>
                    <p class="profile_user_year">Возраст: ...</p>
                </div>
            </div>
                <button>
                    Редактировать
                </button> <br>
                <a class="account_exit" href="exit">Выйти</a>
        </div>
        <div class="statistics">
            <h2>Статистика</h2>
            <div class="statistics_part">
                <div class="statistics_part_img">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/account_book.svg" alt="">
                </div>
                <div class="statistics_part_content">
                    <div class="statistics_part_text">
                        <div class="statistics_part_title">
                            <p>Пройдено уроков</p>
                        </div>
                        <div class="statistics_part_procent">
                            <p><span>10</span>/12</p>
                        </div>
                    </div>
                    <div class="progress">
                        <progress id="progress1" max="12" value="10">10</progress>
                    </div>
                </div>
            </div>

            <div class="statistics_part">
                <div class="statistics_part_img">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/account_pencil.svg" alt="">
                </div>
                <div class="statistics_part_content">
                    <div class="statistics_part_text">
                        <div class="statistics_part_title">
                            <p>Сделано домашних заданий</p>
                        </div>
                        <div class="statistics_part_procent">
                            <p><span>10</span>/24</p>
                        </div>
                    </div>
                    <div class="statistics_part_schedule">
                        <div class="progress">
                            <progress id="progress2" max="24" value="10"<?=$_SESSION['user']['mail']?>>10</progress>
                        </div>
                    </div>
                </div>
            </div>

            <div class="statistics_part">
                <div class="statistics_part_img">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/account_ei.svg" alt="">
                </div>
                <div class="statistics_part_content">
                    <div class="statistics_part_text">
                        <div class="statistics_part_title">
                            <p>Количество набранных баллов</p>
                        </div>
                        <div class="statistics_part_procent">
                            <p><span>80</span>/100</p>
                        </div>
                    </div>
                    <div class="statistics_part_schedule">
                        <div class="progress">
                            <progress id="progress3" max="100" value="80">80</progress>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="account_link">
        <div class="account_line">
            <hr>
        </div>
        <div class="account_btn">
            <a href="uchebnaya-programma">
                <button>
                        <p> Ваша программа </p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/account_btn_arrow.svg" alt="">
                </button>
            </a>  
        </div>
    </div>
    <div class="account_btn_mobile">
            <p>Ваша программа</p>
            <hr>
            <div class="general_btn">
                <a href="uchebnaya-programma">
                    <button>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                    </button>
                </a>
            </div>
        </div>
</div>

