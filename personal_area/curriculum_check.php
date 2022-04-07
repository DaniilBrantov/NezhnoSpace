
<?php
    session_start();
    require_once 'connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    }
    $user_id=$_SESSION['user']['id'];
    $user_query=mysqli_query($mysqli,"SELECT * FROM `users` WHERE `users`.`id`='$user_id' ");
    date_default_timezone_set("Europe/Moscow");
    $today=time(); 
    $user_start=mysqli_fetch_assoc($user_query)['next_stage'];
    $open_stage_num=0;

    
?>
<script type="text/javascript">
    const order=<?php echo($_SESSION["user"]["payment"]) ?>;
    function OpenPayLess(order) {
        const main_less_link=document.querySelectorAll(".main_less_link");
        const individ_less_link=document.querySelectorAll(".individ_less_link");
        const mobile_main_link=document.querySelectorAll(".main_stage_link a");
        const mobile_individ_link=document.querySelectorAll(".mobile_individ_link");
        if(order==1){
            <?php
                if ($user_start == 0) {
                    $next_less = time()+60*60*24*7;
                    mysqli_query($mysqli, "UPDATE `users` SET `next_stage`='$next_less' WHERE `users`.`id` = '$user_id' ");
                }else if($user_start <= $today){
                    while ($user_start<=$today){
                        $user_start=$user_start+(60*60*24*7);
                        $open_stage_num++;
                    }
                }
            ?>
            const open_stage_num=<?php echo json_encode($open_stage_num); ?>;
            const individ_arr=[];
            OpenStage(open_stage_num,individ_arr);
        }else if(order==2){
            <?php 
                if ($user_start == 0) {
                    $next_less = time()+60*60*24*6;
                    mysqli_query($mysqli, "UPDATE `users` SET `next_stage`='$next_less' WHERE `users`.`id` = '$user_id' ");
                    $user_name=@trim(stripslashes($_SESSION['user']['mail']));
                    $name       =$user_name ;
                    $from       = "EatIntelligent";
                    $subject    ="Доступ ко 2ому Этапу Открыт!";
                    $message    ="Открыт Новый Урок!!!";
                    $to         = $user_name;
                    
                    $headers = "MIME-Version: 1.0";
                    $headers .= "Content-type: text/plain; charset=UTF-8";
                    $headers .= "From: {$name} <{$from}>";
                    $headers .= "Reply-To: <{$from}>";
                    $headers .= "Subject: {$subject}";
                    $headers .= "X-Mailer: PHP/".phpversion();
                    $success=mail($to, $subject, $message,$headers);
                }else if($user_start <= $today){
                    while ($user_start<=$today){
                        $user_start=$user_start+(60*60*24*6);
                        $open_stage_num++;

                        $user_name=@trim(stripslashes($_SESSION['user']['mail']));

                        $name       =$user_name ;
                        $from       = "EatIntelligent";
                        $subject    ="Открыт Следующий Урок!";
                        $message    ="Открыт Новый Урок!!!";
                        $to         = $user_name;
                        
                        $headers = "MIME-Version: 1.0";
                        $headers .= "Content-type: text/plain; charset=UTF-8";
                        $headers .= "From: {$name} <{$from}>";
                        $headers .= "Reply-To: <{$from}>";
                        $headers .= "Subject: {$subject}";
                        $headers .= "X-Mailer: PHP/".phpversion();
                        $success=mail($to, $subject, $message,$headers);
                    }
                }


                $indiv_arr = array(); 
                $result= mysqli_query($mysqli,"SELECT * FROM `users_individ_content` WHERE `id_users`='$user_id' ");
                while($var=mysqli_fetch_assoc($result)){
                    $indiv_arr[] = $var['less_number']; 
                };
            ?>
                    const open_stage_num=<?php echo json_encode($open_stage_num); ?>;
                    const individ_arr=<?php echo json_encode($indiv_arr); ?>;
                    OpenStage(open_stage_num,individ_arr);
        }else{
            NoAccessLess(main_less_link);
            NoAccessLess(individ_less_link);
            NoAccessLess(mobile_main_link);
            NoAccessLess(mobile_individ_link);
        }
    }
</script>