<?php
require_once 'curriculum_check.php';

$get_id=(int)$_GET['id'];
$subcsription_less=$open_stage_num+1;


if($get_id>$subcsription_less){
    header('Location: uchebnaya-programma');
};
if($get_id==1 || $get_id==4 ){
    if ($get_id==1) {
        $sub_less_audio="Первый материал месяца.Подкаст";
    }else{
        $sub_less_audio="Терапия";
    };

?>
<div class="wrapper_subscription_lesson">
    
    <div class="subscription_lesson">
        <h1><?php echo $sub_less_audio; ?></h1>
        <div class="audio_cont">
            <audio id="audio" controls preload="none">
                <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $sub_less_audio; ?>.mp3" type="audio/mpeg">
                <source src="<?php echo get_template_directory_uri(); ?>/personal_area/audio/<?php echo $sub_less_audio; ?>.mp3" type="audio/ogg">
                Ваш Браузер не поддерживает данный формат audio.
            </audio>
        </div>
    </div>
</div>


<?php 
}elseif ($get_id==2 || $get_id==3) {
    if($get_id==2){

        $filename   =  get_template_directory_uri().'/personal_area/pdf_files/practice_1_stage.pdf';
        $fileinfo = pathinfo($filename);
        $sendname = $fileinfo['filename'] . '.' . strtoupper($fileinfo['extension']);
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=\"$sendname\"");
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filename));
        header('Accept-Ranges: bytes');
        readfile($filename);


    }else{
        $filename   =  get_template_directory_uri().'/personal_area/pdf_files/practice_1_stage.pdf';
        $fileinfo = pathinfo($filename);
        $sendname = $fileinfo['filename'] . '.' . strtoupper($fileinfo['extension']);
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=\"$sendname\"");
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filename));
        header('Accept-Ranges: bytes');
        readfile($filename);
    }
}else{
    header('Content-type: application/pdf');
}

?>