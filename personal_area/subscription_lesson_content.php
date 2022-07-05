<?php
require_once 'curriculum_check.php';

$get_id=(int)$_GET['id'];
$subcsription_less=$open_stage_num;


if($get_id>$subcsription_less){
    header('Location: uchebnaya-programma');
};

    if ($get_id==1) {
        $sub_less_audio="Первый материал месяца. Подкаст";
    }elseif ($get_id==2) {
        $sub_less_audio="Статья от приглашённого спикера";
    }elseif ($get_id==3) {
        $sub_less_audio="Рекомендации";
    }else{
        $sub_less_audio="Терапия";
    };

?>
<div class="wrapper_subscription_lesson">
    
    <div class="subscription_lesson">
        <h1><?php echo $sub_less_audio; ?></h1>
        <?php if($get_id==1 || $get_id==4 ){ ?>
            <div class="audio_cont">
                <audio id="audio" controls preload="none">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $sub_less_audio; ?>.mp3" type="audio/mpeg">
                    <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $sub_less_audio; ?>.mp3" type="audio/ogg">
                    Ваш Браузер не поддерживает данный формат audio.
                </audio>
            </div>
        <?php }else if ($get_id==2 || $get_id==3) {  ?>
                <?php if($get_id==2){
                    echo '<a class="read_btn" href="/kachestvo-zhizni">Читать</a>';
                }else{
                    echo '<a class="read_btn" href="'. get_template_directory_uri() .'/personal_area/pdf_files/practice_1_stage.pdf" download>';
                }; ?>
            </a>

            <?php };  ?>
    </div>
</div>
