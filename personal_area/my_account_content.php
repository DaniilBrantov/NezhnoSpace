<?php
    session_start();
    require_once 'connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    if(!$_SESSION["stages"]){
        header('Location: uchebnaya-programma');
    }
    $main_count=str_word_count($_SESSION["stages"]['main'])/5 +1;
    $individual_count=str_word_count($_SESSION["stages"]['individual'])/6 +1;
    $points=$individual_count*6;
?>  

<div class="account">
    <div class="profile_n_statistics">
        <div class="profile">
            <div class="profile_user">
                <p class="profile_user_name"><?=$_SESSION['user']['surname']?> <?=$_SESSION['user']['name']?></p>
                <p class="profile_user_year">Возраст: <?=$_SESSION['user']['age']?></p>
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
                <a href="change">Редактировать</a> 
        </div>
        <?php if($_SESSION['user']['payment']==1){ ?>
            <div class="sub_btns">
                <div class="sub_wall">
                    <div class="sub_elements">
                            <div class="sub_item announcement_item">
                                <div class="announcement_item_left">
                                    <h3>Анонс</h3>
                                    <p>Стоп урок, необходимо ознакомиться с инструкцией, чтобы получить доступ к материалам подписки.</p>
                                </div>
                                <div class="announcement_item_right">
                                    <div class="pie_chart">
                                        <div class="pie animate" style="--p:1;--c:#DBDBDB"> 
                                            0/1 
                                            <span>
                                                Сделано
                                            </span>
                                        </div>
                                    </div>
                                    <div class="general_btn_white">
                                        <a href="announcement">
                                            <button>
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/btn_arrow_black.svg" alt="">
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="sub_item available_materials_item">
                                <h3>
                                    Доступные материалы
                                </h3>
                                <div class="pie_chart">
                                    <div class="pie animate" style="--p:54;--c:#DBDBDB"> 
                                        2/4
                                        <span>
                                            Сделано
                                        </span>
                                    </div>
                                </div>
                                <div class="general_btn_white">
                                    <a href="uchebnaya-programma">
                                        <button>
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/btn_arrow_black.svg" alt="">
                                        </button>
                                    </a>
                                </div>
                            </div>
                        
                            <div class="sub_item additional_products_item">
                                <div class="additional_products_item_cnt">
                                    <h4>
                                        Дополнительные продукты
                                    </h4>
                                    <p>
                                        Открыть доступ в новый мир с новыми возможностями.
                                    </p>
                                </div>
                                <div class="general_btn">
                                    <form action="https://eatintelligent.ru/payment" method='post'>
                                        <input type="hidden" value="2" name="order">
                                        <input type="hidden" value="7000" name="sum">
                                        <button type="submit">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                                        </button>
                                    </form>
                                        
                                    
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
                                    <p> Твоя программа </p>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/account_btn_arrow.svg" alt="">
                            </button>
                        </a>  
                    </div>
                </div>
            </div>
            
        <?php }else{ ?>
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
                            <p><span><?php echo $main_count; ?></span>/8</p>
                        </div>
                    </div>
                    <div class="progress">
                        <progress id="progress1" max="8" value="<?php echo $main_count; ?>">10</progress>
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
                            <p><span><?php echo $individual_count ?></span>/16</p>
                        </div>
                    </div>
                    <div class="statistics_part_schedule">
                        <div class="progress">
                            <progress id="progress2" max="16" value="<?php echo $individual_count ?>">10</progress>
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
                            <p><span><?php echo $points; ?></span>/100</p>
                        </div>
                    </div>
                    <div class="statistics_part_schedule">
                        <div class="progress">
                            <progress id="progress3" max="100" value="<?php echo $points; ?>">80</progress>
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
                        <p> Твоя программа </p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/account_btn_arrow.svg" alt="">
                </button>
            </a>  
        </div>
    </div>
<?php } ?>

    <div class="account_btn_mobile">
            <p>Твоя программа</p>
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

