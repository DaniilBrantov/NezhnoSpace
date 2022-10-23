
<?php
    session_start();
    require_once 'connect.php';
    if (!$_SESSION['user']) {
        header('Location: auth');
    };
    $user_id=$_SESSION['user']['id'];
    $user_mail=$_SESSION['user']['mail'];
    $user_query=mysqli_query($mysqli,"SELECT * FROM `users` WHERE `users`.`id`='$user_id' ");
    date_default_timezone_set("Europe/Moscow");
    $today=date('Y-m-d H:i:s'); 
    $user_start=mysqli_fetch_assoc($user_query)['next_stage'];
    
    $open_stage_num=0;

    if($_SESSION['user']['payment']== '4'){
        $payment= 1;
    }else{
        $payment=$_SESSION['user']['payment'];
    }

?>


<script type="text/javascript">
    const order="<?php echo($payment) ?>";
    function OpenPayLess(order) {
        const main_less_link=document.querySelectorAll(".main_less_link");
        const individ_less_link=document.querySelectorAll(".individ_less_link");
        const mobile_main_link=document.querySelectorAll(".main_stage_link a");
        const mobile_individ_link=document.querySelectorAll(".mobile_individ_link");
        let today=new Date();
        let open_date = new Date(2022, 3, 28, 0, 0, 0, 0);
        
        
        
        if(order=="1" && today > open_date){
            <?php 
            if($payment==1){
                if ($user_start == NULL) {
                    $next_less = date('Y-m-d H:i:s', strtotime($today));
                    $user_start=$next_less;
                    mysqli_query($mysqli, "UPDATE `users` SET `next_stage`='$next_less' WHERE `users`.`id` = '$user_id' ");
                }else if($user_start <= $today){
                    while ($user_start<=$today){
                        $user_start=date("Y-m-d H:i:s", strtotime($user_start.'+ 7 days'));
                        $open_stage_num++;
                    };
                };
            };
                
            ?>
            const open_stage_num=<?php echo json_encode($open_stage_num); ?>;
            const individ_arr=[];
            OpenStage(open_stage_num,individ_arr);
        }else if(order=="2" && today > open_date){
            <?php 
            if($payment==2){
                if ($user_start == NULL) {
                    $next_less = date('Y-m-d H:i:s', strtotime($today.'+ 6 days'));
                    $user_start=$next_less;
                    mysqli_query($mysqli, "UPDATE `users` SET `next_stage`='$next_less' WHERE `users`.`id` = '$user_id' ");
                }else if($user_start <= $today){
                    while ($user_start<=$today){
                        $user_start=date("Y-m-d H:i:s", strtotime($user_start.'+ 6 days'));
                        $open_stage_num++;
                    };
                };
                $indiv_arr = array(); 
                $result= mysqli_query($mysqli,"SELECT * FROM `users_individ_content` WHERE `id_users`='$user_id' AND `publication`='1'");
                while($var=mysqli_fetch_assoc($result)){
                    $indiv_arr[] = $var['less_number']; 
                };
            };
            ?>
                    const open_stage_num=<?php echo json_encode($open_stage_num); ?>;
                    const individ_arr=<?php echo json_encode($indiv_arr); ?>;
                    OpenStage(open_stage_num,individ_arr);
        }else if(order=="3"){
            <?php
                if($payment==3){
                    if ($user_start == NULL) {
                        $next_less = date('Y-m-d H:i:s', strtotime($today));
                        $user_start=$next_less;
                        mysqli_query($mysqli, "UPDATE `users` SET `next_stage`='$next_less' WHERE `users`.`id` = '$user_id' ");
                    }else if($user_start <= $today){
                        while ($user_start<=$today){
                            $user_start=date("Y-m-d H:i:s", strtotime($user_start.'+ 7 days'));
                            $open_stage_num++;
                        };
                        
                    };
                    if($open_stage_num >= 5){
                        mysqli_query($mysqli, "UPDATE `users` SET `payment`='0' WHERE `users`.`id` = '$user_id' ");
                        $_SESSION["user"]["payment"]=mysqli_fetch_assoc($user_query)['payment'];
                    };
                };
            ?>
            const open_stage_num=<?php echo json_encode($open_stage_num); ?>;
            const individ_arr=[];
            OpenStage(open_stage_num,individ_arr);
        }else if(order=="6"){
            <?php 
                if($payment==6){
                    $open_month=date("Y-m-d H:i:s", strtotime($user_start.'+ 27 days'));
                    if($open_month <= $today){
                        $query_update_payment = $mysqli->query("UPDATE `users` SET `payment`='3' WHERE `mail`='$user_mail'");
                    }else{
                        if($user_start <= $today){
                            while ($user_start<=$today){
                                $user_start=date("Y-m-d H:i:s", strtotime($user_start.'+ 7 days'));
                                $open_stage_num++;
                            };
                        };
                    }
                };
            ?>
            const user_start=<?php echo json_encode($user_start); ?>;
            console.log(user_start);
            const open_stage_num=<?php echo json_encode($open_stage_num); ?>;
            const individ_arr=[];
            OpenStage(open_stage_num,individ_arr);
        }else{
            NoAccessLess(main_less_link);
            NoAccessLess(individ_less_link);
            NoAccessLess(mobile_main_link);
            NoAccessLess(mobile_individ_link);
        }

}
</script>
