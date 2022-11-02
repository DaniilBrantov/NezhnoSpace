<?php
session_start();
require_once 'wp-content/themes/my-theme/personal_area/connect.php';


$users=mysqli_query($mysqli,"SELECT * FROM `users`");
while($customer=mysqli_fetch_assoc($users)){
    $today=strtotime(date('Y-m-d H:i:s'));
    $next_stage=strtotime($customer["next_stage"]) ;
    $difference= ($today - $next_stage)/ 86400;
    $week=$difference/ 7;
    $customer_id=$customer["id"];

    if($next_stage && $customer["payment"]!=='3' && $customer["payment"]!=='2' && $customer["payment"]!=='0' ){
        if ($customer["pay_week"] == '0') {
            if($week > 1){
                
                // $email = new \PHPMailer\PHPMailer\PHPMailer();

                // $email->CharSet = 'utf-8';
                // $email->isSMTP();
                // $email->Host = 'smtp.yandex.ru';
                // $email->SMTPAuth = true;                              
                // $email->Username = 'support@eatintelligent.ru'; 
                // $email->Password = 'Eat123Intelligent123';
                // $email->SMTPSecure = 'ssl';
                // $email->Port = 465; 
            
                // $email->setFrom('support@eatintelligent.ru');
                // $email->addAddress($customer["mail"]);    
                // $email->isHTML(true);                                 
            
                // $email->Subject = 'Нежно';
    
    
                $email->Body    =  '
                    <div style="
                    background: #1C1C1C;
                    color: whitesmoke;
                    padding: 30px;
                    margin: 30px;
                    border-radius: 20px;
                    margin: 30px auto;
                    max-width: 500px;"
                    >
                        
                        <h2>
                            Чао! 
                        </h2>  
                        <p>
                            Тебе доступен новый материал подписки Нежно. Переходи по ссылке. 
                        </p>
                        <div style="margin: 50px 0px;">
                            <a href="https://nezhno.space/uchebnaya-programma" style="
                                color: whitesmoke;
                                text-decoration: navajowhite;
                                padding: 15px 30px;
                                border: 2px solid whitesmoke;
                                border-radius: 50px;
                            ">Перейти</a>
                        </div>
                        <p>
                            С заботой, <br>
                            Команда Нежно Space
                        </p>
                    </div>
                ';
    
                $email->AltBody = '';
                if(!$email->send()) {
                    echo $email;
                } else {}

                mysqli_query($mysqli,"UPDATE `users` SET `pay_week` = '2' WHERE `users`.`id` = '$customer_id'");
            }
        }else{
            if($week > $customer["pay_week"]){
                
                // $email = new \PHPMailer\PHPMailer\PHPMailer();

                // $email->CharSet = 'utf-8';
                // $email->isSMTP();
                // $email->Host = 'smtp.yandex.ru';
                // $email->SMTPAuth = true;                              
                // $email->Username = 'support@eatintelligent.ru'; 
                // $email->Password = 'Eat123Intelligent123';
                // $email->SMTPSecure = 'ssl';
                // $email->Port = 465; 
            
                // $email->setFrom('support@eatintelligent.ru');
                // $email->addAddress($customer["mail"]);    
                // $email->isHTML(true);                                 
            
                // $email->Subject = 'Нежно';
    
    
                $email->Body    =  '
                    <div style="
                    background: #1C1C1C;
                    color: whitesmoke;
                    padding: 30px;
                    margin: 30px;
                    border-radius: 20px;
                    margin: 30px auto;
                    max-width: 500px;"
                    >
                        
                        <h2>
                            Чао! 
                        </h2>  
                        <p>
                            Тебе доступен новый материал подписки Нежно. Переходи по ссылке. 
                        </p>
                        <div style="margin: 50px 0px;">
                            <a href="https://nezhno.space/uchebnaya-programma" style="
                                color: whitesmoke;
                                text-decoration: navajowhite;
                                padding: 15px 30px;
                                border: 2px solid whitesmoke;
                                border-radius: 50px;
                            ">Перейти</a>
                        </div>
                        <p>
                            С заботой, <br>
                            Команда Нежно Space
                        </p>
                    </div>
                ';
    
                $email->AltBody = '';
                if(!$email->send()) {
                    echo $email;
                } else {echo 'yes';}

                $pay_week=$customer["pay_week"]+1;
                mysqli_query($mysqli,"UPDATE `users` SET `pay_week` = '$pay_week' WHERE `users`.`id` = '$customer_id'");
            }
        }

    }
    
}
    
?>