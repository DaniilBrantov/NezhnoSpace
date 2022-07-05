<?php
    session_start();
    require_once 'connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    if(!$_SESSION["stages"]){
        header('Location: uchebnaya-programma');
    }
    $main_count=count($_SESSION["stages"]['main']);
    if($main_count >= 1){ ?>
        <div class="wrapper_stage_video">
            <div class="stage_video">
                <h1>
                    Онлайн занятие с психологом №1
                </h1>
                <hr>
                <div class="stage_youtube">
                    <iframe width="900" height="600" src="https://www.youtube.com/embed/0deoE1C5-AU" title="Онлайн занятие с психологом №1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    <?php if($main_count > 3){?>
        <div class="wrapper_stage_video">
            <div class="stage_video">
                <h1>
                    Онлайн занятие с психологом №2
                </h1>
                <hr>
                <div class="stage_youtube">
                    <iframe width="900" height="600" src="https://www.youtube.com/embed/Z59ZZtgLmAQ" title="Ciao, bella!" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <?php if($main_count >7){?>
            <div class="wrapper_stage_video">
                <div class="stage_video">
                    <h1>
                        Онлайн занятие с психологом №3
                    </h1>
                    <hr>
                    <div class="stage_youtube">
                        <iframe width="900" height="600" src="https://www.youtube.com/embed/Z59ZZtgLmAQ" title="Ciao, bella!" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <?php }
        }
    }
?>  