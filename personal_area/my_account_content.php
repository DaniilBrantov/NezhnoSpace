<?php
    session_start();
    require_once 'connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    if(!$_SESSION["stages"]){
        header('Location: uchebnaya-programma');
    };
    
    $all_main=$_SESSION["stages"]['all_main'];
    $main_count=count($_SESSION["stages"]['main']);
    $individual_count=floor(str_word_count($_SESSION["stages"]['individual'])/6 +1);
    $points=$individual_count*6;
    $main_procent=ceil(($main_count/$all_main)*100);


    $id=$_SESSION['user']["id"];
    $user_assoc=mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM `users`  WHERE `users`.`id` = $id "));
    $announcement='0';
    if($_SESSION['user']['payment']==1 || $_SESSION['user']['payment']==3 || $_SESSION['user']['payment']==6){
        if($_SESSION['user']['route_value']==6){
            $announcement='1';
        }
    }else{
    }
?>  









<div class="unsubscribe_confirmation">
    <div class="unsubscribe_form" id="unsubscribe_form">
        <h2>Подтверждение отмены подписки</h2>
        <form action="https://nezhno.space/auth-check" method='post' id="choice_img_grid">
            <p>
                Вы можете отменить подписку сейчас и продолжить ее использование до указанной даты(11.11.11).
            </p>
            <div class="unsubscribe_form_btns">
                <div class="unsubscribe_form_btn">
                    <button style="background: #424242; font-weight: normal;" class="btn__ok" id="unsubscribe_cancel">Отмена</button>
                </div>
                <div class="unsubscribe_form_btn">
                    <input class="btn__ok" type="submit" name="unsubscribe_form_btn" value="Подтвердить">
                </div>
            </div>
        </form>
    </div>
</div>



<div class="account">
    <div class="profile_n_statistics">
        <div class="profile_unsubscribe">
            <div class="profile">
                <div class="profile_user">
                    <p class="profile_user_name"><?=$_SESSION['user']['surname']?> <?=$_SESSION['user']['name']?></p>
                    <p class="profile_user_year">Возраст: <?=$_SESSION['user']['age']?></p>
                </div>
                <div class="profile_mobile">
                    <div class="profile_img">
                        <?php if($user_assoc["avatar"]){ 
                            echo '<img src="'.get_template_directory_uri().'/images/change_img'.$user_assoc["avatar"].'.png" alt="">';
                        } else{ 
                            echo '<img src="'.get_template_directory_uri().'/images/account_icon.jpg" alt="">';
                        }; ?>
                    </div>
                    <div class="profile_user_mobile">
                        <p class="profile_user_name"><?=$_SESSION['user']['name']?></p>
                        <p class="profile_user_year">Возраст: ...</p>
                    </div>
                </div>
                    <a href="change">Редактировать</a> 
                        <form action="auth-check" method="post">
                            <input type="hidden" name="change_material" value="1">
                            <button class="change_material" type="submit">
                                <?php if($_SESSION['user']["payment"]=='3' || $_SESSION['user']["payment"]=='1' || $_SESSION['user']["payment"]=='0' || $_SESSION['user']['payment']=='6'){
                                        echo "Курс";
                                    }else{
                                        echo "Подписка";
                                    } 
                                ?>
                            </button>
                        </form>
            </div>
            <?php if($_SESSION['user']['payment']==1){ ?>
                <div class="unsubscribe_btn">
                    <button>Отписаться</button>
                </div>
            <?php }else{ ?>
                <div class="subscribe_btn your_conductor_link">
                    <form action="https://nezhno.space/payment" method='post'>
                        <input type="hidden" value="1" name="order">
                        <input type="hidden" value="7" name="sum">
                        <button type="submit">
                                Оформить Подписку
                            <p>
                                700P
                                <!-- <span style="color:#F2C0E3; text-decoration: line-through;">
                                    <span style="color:#F2C0E3;
                                    font-size:18px;
                                    position: relative;
                                    top: -10px;">
                                        700P
                                    </span>
                                </span>  -->
                            </p>

                        </button>
                    </form>
                </div>
            <?php }; ?>
        </div>
        
        <?php if($_SESSION['user']['payment']==1 || $_SESSION['user']['payment']==3 || $_SESSION['user']['payment']==0 || $_SESSION['user']['payment']==6){ ?>
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
                                        <div class="pie animate" style="--p:<?php echo $announcement; ?>00;--c:#DBDBDB"> 
                                            <?php echo $announcement; ?>/1 
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
                                    <div class="pie animate" style="--p:<?php echo $main_procent; ?>;--c:#DBDBDB"> 
                                        <?php echo $main_count.'/'.$all_main; ?>
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
                                    <a href="additional_materials">
                                        <button type="submit">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                                        </button>
                                    </a>
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
                            <p><span><?php echo ($main_count+1); ?></span>/8</p>
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
                            <p><span><?php echo $main_procent; ?></span>/100</p>
                        </div>
                    </div>
                    <div class="statistics_part_schedule">
                        <div class="progress">
                            <progress id="progress3" max="100" value="<?php echo $main_procent; ?>">80</progress>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cours_account_link">
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

