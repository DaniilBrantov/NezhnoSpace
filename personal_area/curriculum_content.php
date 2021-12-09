<?php
    session_start();
    require_once 'connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
?>  

 <div class="curriculum">
    <div class="container">
        <h1>Этапы</h1>

<?php $variables= mysqli_query($mysqli,"SELECT * FROM `main_stages` ");
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
                        <a href="lesson?id=' . $var["less_number"] .'">
                            <img src="data:image/jpeg;charset=utf-8;base64,'. $image .'" alt="'. $var["title"].'" />
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
                        <a href="individual_content?id=' . $var["less_number"] .'">
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
            <a href="lesson">
                <button>
                        <p> Дополнительные материалы </p>
                        <img src="'. get_template_directory_uri().'/images/account_btn_arrow.svg" alt="">
                </button>
            </a>  
        </div>
        </div> '        ; };  ?>
    </div>
</div>











<?php $variables= mysqli_query($mysqli,"SELECT * FROM `main_stages` ");
        while($var=mysqli_fetch_assoc($variables)){
            $image=base64_encode($var['image']);
            echo '

        <div class="curriculum_item_mobile">
            <div class="curriculum_number_mobile">
                <p>'.$var["less_number"].'.</p>
                <hr>
            </div>
            <div class="slider">
    
    <div class="slide" style="background: url(data:image/jpeg;charset=utf-8;base64,'. $image .'); background-size:100%;">
                            <div class="slide_content">
                                <div class="slider_text">
                                    <h4 class="slider_title">'.$var["title"].'</h4>
                                    <p>'.$var["description"].'</p>
                                </div>
                                <div class="curriculum_btn curriculum_btn_mobile">
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
                                    <a href="individual_content?id=' . $var["less_number"] .'">
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
                                    <a href="lesson">
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