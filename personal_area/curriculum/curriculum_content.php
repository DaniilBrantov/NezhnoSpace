<?php
    session_start();
    require_once 'connect.php';
    require_once 'curriculum_check.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    $user_id=$_SESSION['user']['id'];
    
    
    
    
    if($_SESSION['user']["payment"]==0 || $_SESSION['user']["payment"]==NULL){
?>
<!-- <div class="container">
    <div class="promocode">
        <div class="promocode_title">
            <h2>
                Введите промокод, чтобы открыть материалы
            </h2>
        </div>
        <form class="promocode_form">
            <div class="promocode_cnt">
                <input class="pers_input promocode_input" id="promocode_input" name="promocode" type="text" placeholder="ПРОМОКОД" >
                <div class="none promocode_msg auth_msg"></div>
            </div>
            <div class="promocode_cnt">
                <input id="phone" class="pers_input promocode_input" type="tel" placeholder="+7 (999) 999 99 99" name="user_tel" maxlength="20" required>
                <div id="error_phone" class="none auth_msg">Некорректный номер телефона</div>
            </div>
            <button id="promocode_btn" class="classic_btn_white promocode_btn" type="submit">Отправить</button>
        </form>
    </div>
    <div class="promocode_svg">
        <svg class=" none" width="133px" height="133px" viewBox="0 0 133 133" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g id="check-group" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <circle id="filled-circle" fill="whitesmoke" cx="66.5" cy="66.5" r="36.5"></circle>
                <circle id="white-circle" fill="var(--purple)" stroke-linecap="round" cx="66.5" cy="66.5" r="40.5"></circle>
                <circle id="outline" stroke-width="4" cx="66.5" cy="66.5" r="36.5"></circle>
                <polyline id="check" stroke="var(--purple)" stroke-linecap="round" stroke-width="4" points="52 70 62 80 82 55"></polyline>
            </g>
        </svg>
    </div>
    
</div> -->



<?php 
    };

    if($_SESSION['user']['payment'] == 1 || $_SESSION['user']['payment'] == 3 || $_SESSION['user']['payment'] == 0 || $_SESSION['user']['payment'] == 6){ ?>
<div class="container">
    <div class="subscription_less">
        <?php  
            $variables= mysqli_query($mysqli,"SELECT * FROM `main_subscription`");
            while($var=mysqli_fetch_assoc($variables)){
                $image=base64_encode($var['image']);
                echo '
                    <div class="curriculum_item sub_stage_item">
                            <div class="main_less">
                                <div style="" class="main_less_img">
                                    <a class="main_less_link" href="subscription_lesson?id=' . $var["id"] .'">
                                        <img src="" alt="" />
                                    </a>
                                </div>
                                <div class="curriculum_content">
                                    <div class="curriculum_text">
                                        <h3>'. $var["title"].'</h3>
                                    <p></p>
                                    </div>
                                    <div class="curriculum_btn">
                                        <a href="subscription_lesson?id=' . $var["id"] .'">
                                            <button>
                                                <img src="'. get_template_directory_uri() .'/images/account_arrow.svg" alt="">
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </div> '        ; }; 


                    // $temp = $wp_query; $wp_query= null;
                    // $wp_query = new WP_Query(); $wp_query->query( '&paged='.$paged );
                    // query_posts('cat=44&posts_per_page=5&order=ASC');
                    // while ($wp_query->have_posts()) : $wp_query->the_post();?>

        <!-- <div class="curriculum_item sub_stage_item">
                            <div class="main_less">
                                <div style="" class="main_less_img">
                                    <a class="main_less_link" href="<?php the_permalink(); ?>">
                                        <img src="" alt="" />
                                    </a>
                                </div>
                                <div class="curriculum_content">
                                    <div class="curriculum_text">
                                        <h3><?php the_title(); ?></h3>
                                    <p></p>
                                    </div>
                                    <div class="curriculum_btn">
                                        <a href="<?php the_permalink(); ?>">
                                            <button>
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </div> -->
        <?php //endwhile; ?>

    </div>
</div><?php 

            $variables= mysqli_query($mysqli,"SELECT * FROM `main_subscription` ");
            while($var=mysqli_fetch_assoc($variables)){
            $image=base64_encode($var['image']);
            echo '

                <div class="curriculum_item_mobile">
                    <div class="curriculum_number_mobile">
                        <p>Доступ открывается каждую неделю</p>
                        <hr>
                    </div>
                    <div class="slider">
                <div class="slide" style="background-size:100%;">
                                    <div class="slide_content">
                                        <div class="slider_text">
                                            <h4 class="slider_title">'.$var["title"].'</h4>
                                            <p></p>
                                        </div>
                                        <div  class="curriculum_btn main_stage_link curriculum_btn_mobile">
                                            <a href="subscription_lesson?id=' . $var["id"] .'">
                                                <button>
                                                    <img src="'. get_template_directory_uri().'/images/account_arrow.svg" alt="">
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide">
                                    <div class="slide_content">
                                        <div class="slider_text">
                                            <h4 class="slider_title">Дополнительные материалы</h4>
                                        </div>
                                        <div class="curriculum_btn curriculum_btn_mobile">
                                            <a href="additional_materials">
                                                <button>
                                                    <img src="'. get_template_directory_uri().'/images/account_arrow.svg" alt="">
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            
                        
                    </div>
                </div> '        ; }; 


            //     $temp = $wp_query; $wp_query= null;
            //     $wp_query = new WP_Query(); $wp_query->query('showposts=5' . '&paged='.$paged );
            //     query_posts('cat=44&posts_per_page=5');
            //     while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
<!-- 
                <div class="curriculum_item_mobile">
                    <div class="curriculum_number_mobile">
                        <hr>
                    </div>
                    <div class="slider">
                <div class="slide" style="background-size:100%;">
                                    <div class="slide_content">
                                        <div class="slider_text">
                                            <h4 class="slider_title"><?php the_title(); ?></h4>
                                            <p></p>
                                        </div>
                                        <div  class="curriculum_btn main_stage_link curriculum_btn_mobile">
                                            <a href="<?php the_permalink(); ?>">
                                                <button>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide">
                                    <div class="slide_content">
                                        <div class="slider_text">
                                            <h4 class="slider_title">Дополнительные материалы</h4>
                                        </div>
                                        <div class="curriculum_btn curriculum_btn_mobile">
                                            <a href="additional_materials">
                                                <button>
                                                    <img src="<?php echo get_template_directory_uri();?>/images/account_arrow.svg" alt="">
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div> -->

<?php //endwhile;
                    }else{
?>
<div class="curriculum">
    <div class="container">
        <h1>Этапы</h1>

        <div class="curriculum_item">
            <div class="curriculum_number">
                <h2>1.</h2>
                <hr>
            </div>
            <div class="curriculum_less">
                <div class="main_less">
                    <div class="main_less_img">
                        <a href="first_stage">
                            <img src="" />
                        </a>
                    </div>
                    <div class="curriculum_content">
                        <div class="curriculum_text">
                            <h3>Добро пожаловать на Курс по Психологии Питания и Пищевого Поведения! </h3>
                            <p></p>
                        </div>
                        <div class="curriculum_btn">
                            <a href="first_stage">
                                <button>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg"
                                        alt="">
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="individ_less">
                    <div class="individ_less_img">
                        <a class="first_individ_less_link" href="first-stage-individual">
                            <img src="" alt="">
                        </a>
                    </div>
                    <div class="curriculum_content">
                        <div class="curriculum_text">
                            <h3>Твой первый шаг Индивидуального маршрута. </h3>
                        </div>
                        <div class="curriculum_btn">
                            <a href="first-stage-individual">
                                <button>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg"
                                        alt="">
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="account_btn curriculum_link">
                <a href="additional_materials">
                    <button>
                        <p> Дополнительные материалы </p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/account_btn_arrow.svg" alt="">
                    </button>
                </a>
            </div>
        </div>






        <?php  $variables= mysqli_query($mysqli,"SELECT * FROM `main_stages`");
        while($var=mysqli_fetch_assoc($variables)){
            $image=base64_encode($var['image']);
            echo '
        <div class="curriculum_item">
            <div class="curriculum_number">
                <h2> '. $var["less_number"].' .</h2>
                <hr>
            </div>
            <div class="curriculum_less">
                <div class="main_less">
                    <div class="main_less_img">
                        <a class="main_less_link" href="lesson?id=' . $var["less_number"] .'">
                            <img src="data:image/jpeg;charset=utf-8;base64,'. $image .'" alt="" />
                        </a>
                    </div>
                    <div class="curriculum_content">
                        <div class="curriculum_text">
                            <h3>'. $var["title"].'</h3>
                        <p>'. $var["description"].'</p>
                        </div>
                        <div class="curriculum_btn">
                            <a href="lesson?id=' . $var["less_number"] .'">
                                <button>
                                    <img src="'. get_template_directory_uri() .'/images/account_arrow.svg" alt="">
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="individ_less">
                    <div class="individ_less_img">
                        <a class="individ_less_link" href="individual_content?id=' . $var["less_number"] .'">
                            <img src="" alt="">
                        </a>
                    </div>
                    <div class="curriculum_content">
                        <div class="curriculum_text">
                            <h3>'; IndividualContentTitle($var["less_number"],$mysqli);  echo ' </h3>
                        </div>
                        <div class="curriculum_btn">
                            <a href="individual_content?id=' . $var["less_number"] .'">
                                <button>
                                    <img src="'. get_template_directory_uri() .'/images/account_arrow.svg" alt="">
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="account_btn curriculum_link">
            <a href="additional_materials">
                <button>
                        <p> Дополнительные материалы </p>
                        <img src="'. get_template_directory_uri().'/images/account_btn_arrow.svg" alt="">
                </button>
            </a>  
        </div>
        </div> '        ; };  ?>
    </div>
</div>














<div class="curriculum_item_mobile">
    <div class="curriculum_number_mobile">
        <p>1.</p>
        <hr>
    </div>
    <div class="slider">

        <div class="slide"
            style="background: url(data:image/jpeg;charset=utf-8;base64,'. $image .'); background-size:100%;">
            <div class="slide_content">
                <div class="slider_text">
                    <h4 class="slider_title">Добро пожаловать на Курс по
                        Психологии Питания и Пищевого Поведения! </h4>
                    <p></p>
                </div>
                <div class="curriculum_btn first_stage_btn_mobile">
                    <a href="first_stage">
                        <button>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="slide">
            <div class="slide_content">
                <div class="slider_text">
                    <h4 class="slider_title">Твой первый шаг Индивидуального маршрута.</h4>
                </div>
                <div class="curriculum_btn first_stage_btn_mobile">
                    <a href="first-stage-individual">
                        <button>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="slide">
            <div class="slide_content">
                <div class="slider_text">
                    <h4 class="slider_title">Дополнительные материалы</h4>
                </div>
                <div class="curriculum_btn first_stage_btn_mobile">
                    <a href="additional_materials">
                        <button>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/account_arrow.svg" alt="">
                        </button>
                    </a>
                </div>
            </div>
        </div>


    </div>
</div>


<?php  $variables= mysqli_query($mysqli,"SELECT * FROM `main_stages` ");
        while($var=mysqli_fetch_assoc($variables)){
            $image=base64_encode($var['image']);
            echo '

        <div class="curriculum_item_mobile">
            <div class="curriculum_number_mobile">
                <p>'.$var["less_number"].'.</p>
                <hr>
            </div>
            <div class="slider">
<!-- background: url(data:image/jpeg;charset=utf-8;base64,'. $image .'); -->
    
    <div class="slide" style="background-size:100%;">
                            <div class="slide_content">
                                <div class="slider_text">
                                    <h4 class="slider_title">'.$var["title"].'</h4>
                                    <p>'.$var["description"].'</p>
                                </div>
                                <div  class="curriculum_btn main_stage_link curriculum_btn_mobile">
                                    <a href="lesson?id=' . $var["less_number"] .'">
                                        <button>
                                            <img src="'. get_template_directory_uri().'/images/account_arrow.svg" alt="">
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="slide">
                            <div class="slide_content">
                                <div class="slider_text">
                                    <h4 class="slider_title">'; IndividualContentTitle($var["less_number"],$mysqli);  echo '</h4>
                                </div>
                                <div class="curriculum_btn curriculum_btn_mobile">
                                    <a class="mobile_individ_link" href="individual_content?id=' . $var["less_number"] .'">
                                        <button>
                                            <img src="'. get_template_directory_uri().'/images/account_arrow.svg" alt="">
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="slide">
                            <div class="slide_content">
                                <div class="slider_text">
                                    <h4 class="slider_title">Дополнительные материалы</h4>
                                </div>
                                <div class="curriculum_btn curriculum_btn_mobile">
                                    <a href="additional_materials">
                                        <button>
                                            <img src="'. get_template_directory_uri().'/images/account_arrow.svg" alt="">
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    
                
            </div>
        </div> '        ; };  ?>
</div>
</div>
<?php }  ?>