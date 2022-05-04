<?php
    session_start();
    require_once 'connect.php';

if($_POST["answer"]){
    $route_value = $_POST["answer"];
    if($_SESSION["user"]){
        $user_id=$_SESSION["user"]["id"];
        mysqli_query($mysqli,"UPDATE `users` SET `route_value`='$route_value' WHERE `users`.`id` = '$user_id'");
        header('Location: first-stage-individual');
    }else{
        $user_mail = $_POST["user_mail"];
        $check_user=mysqli_query($mysqli, "SELECT * FROM `users` WHERE `mail` = '$mail'");
        if (mysqli_num_rows($check_user)>0){
            header('Location: auth');
        }else{
            $user_name = $_POST["user_name"];
            $password = "";
            $arr = array(
                    'a', 'b', 'c', 'd', 'e', 'f',
                    'g', 'h', 'i', 'j', 'k', 'l',
                    'm', 'n', 'o', 'p', 'q', 'r',
                    's', 't', 'u', 'v', 'w', 'x',
                    'y', 'z', 'A', 'B', 'C', 'D',
                    'E', 'F', 'G', 'H', 'I', 'J',
                    'K', 'L', 'M', 'N', 'O', 'P',
                    'Q', 'R', 'S', 'T', 'U', 'V',
                    'W', 'X', 'Y', 'Z', '1', '2',
                    '3', '4', '5', '6', '7', '8',
                    '9', '0', '#', '!', "?", "&"
            );
            for ($i = 0; $i < 9; $i++){
                $password .= $arr[mt_rand(0, count($arr) - 1)]; // Берём случайный элемент из массива
            }
        

            if (strlen($password) > 7 && !preg_match("[aA-zZ0-9]",$password)) {
                $pass= md5($password."lksd4fvm879");
                mysqli_query($mysqli,"INSERT INTO `users` (`name`, `mail`, `password`,`route_value`) VALUES ('$user_name','$user_mail','$pass','$route_value') ");

                $email = new \PHPMailer\PHPMailer\PHPMailer();
                $email->CharSet = 'utf-8';
                $email->isSMTP();
                $email->Host = 'smtp.yandex.ru';
                $email->SMTPAuth = true;                              
                $email->Username = 'support@eatintelligent.ru'; 
                $email->Password = 'Eat123Intelligent123';
                $email->SMTPSecure = 'ssl';
                $email->Port = 465; 

                $email->setFrom('support@eatintelligent.ru');
                $email->addAddress($user_mail);    
                $email->isHTML(true);                                 

                $email->Subject = 'Курс по Психологии питания и пищевому поведению';
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
                            Ты уже прошла голландский опросник пищевого поведения и готова двигаться дальше.
                        </h2>  
                        <p>Вот всё,что тебе нужно, чтобы попасть в твой личный кабинет, ждем тебя там :</p>
                        <span style="font-weight:bold;">логин:</span><span style="margin: 50px; font-size: 20px;"><a href="/compose?To='.$user_mail.'" style=" color: whitesmoke; text-decoration:none;">'.$user_mail.'</a></span><br><br>
                        <span style="font-weight:bold;">пароль:</span><span style="margin: 50px; font-size: 20px;">'.$password.'</span>
                        <p>Вот ссылка на твой индивидуальный маршрут : </p>
                        <div style="margin: 50px 0px;">
                            <a href="https://eatintelligent.ru/first-stage-individual" style="
                                color: whitesmoke;
                                text-decoration: navajowhite;
                                padding: 15px 30px;
                                border: 2px solid whitesmoke;
                                border-radius: 50px;
                            ">Индивидуальный Маршрут</a>
                        </div>
                        <p?>Мы ждем тебя на онлайн занятие с психологом, основательницей проекта, где ты сможешь четко сформулировать свой запрос по работе с пищевым поведением и принятием своего тела.</p>

                        <p>Подключайся по ссылке </p>
                            <h3>25 апреля <span style="font-size:15px" >в 19:00</span></h3>
                        </p>
                        <div style="margin: 50px 0px;">
                            <a href="https://online.bizon365.ru/room/127192/Eatintelligent-online-meeting" style="
                                color: whitesmoke;
                                text-decoration: navajowhite;
                                padding: 15px 30px;
                                border: 2px solid whitesmoke;
                                border-radius: 50px;
                            ">Перейти</a>
                        </div>
                    </div>
                ';
                $email->AltBody = '';

                if(!$email->send()) {
                    echo 'Error';
                } else {
                        $sql="SELECT * FROM `users` WHERE `mail` = '$user_mail' AND `password` = '$pass'";
                        $result=mysqli_query($mysqli,$sql);
                        if (mysqli_num_rows($result)>0){
                            $user=mysqli_fetch_assoc($result);

                            $_SESSION["user"]=[
                                "id"=>$user["id"],
                                "name"=>$user["name"],
                                "surname"=>$user["surname"],
                                "sex"=>$user["sex"],
                                "age"=>$user["age"],
                                "mail"=>$user["mail"],
                                "payment"=>$user["payment"],
                            ];}
                        echo '
                        <div class="wrapper_your_type">
                            <div class="your_type">
                                <h1>Ваш аккаунт успешно создан! Проверьте почту,чтобы узнать логин и пароль!</h1>
                                    <div class="general_btn">
                                        <a href="first-stage-individual">
                                            <button>
                                                <img src="'. get_template_directory_uri() .'/images/account_arrow.svg" alt="">
                                            </button>
                                        </a>
                                    </div>
                            </div>
                        </div>
                        ';
                    
            }
                
            }
        }
    }
    
}
else{
    header('Location: first-stage-individual');
}


?>


