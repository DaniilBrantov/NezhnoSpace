<?php
session_start();
require_once 'connect.php';


    $nname=$_POST['nname'];
    //$surname=$_POST['surname'];
    $mail=strtolower($_POST['mail']);;
    $pass=$_POST['pass'];
    $pass_conf=$_POST['pass_conf'];
    $checkbox=$_POST['reg_checkbox'];
    $order=$_POST['order'];

    $check_user=mysqli_query($mysqli, "SELECT * FROM `users` WHERE `mail` = '$mail'");
    
    if (mysqli_num_rows($check_user)>0){
      $response=[
        "status"=> false,
        "type"=> 1,
        "message"=> "Такой пользователь уже существует.",
        "fields"=>['mail']
    ];
    echo json_encode($response);

    die();
    }

    $error_fields=[];

    if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,25}$/', $pass)) {
        $error_fields[]= "pass";
        $msg= "Пароль должен содержать не менее восьми знаков, включать буквы и цифры";
      }

    if(!$pass){
      $error_fields[]= "pass";
      $msg= "Введите пароль";
    }
    

    // if ($mail === "" && !filter_var((string) $mail, FILTER_VALIDATE_EMAIL)){
    //     $error_fields[]= "mail";
    //     $msg= "E-mail указан не корректно!";
    // }

    if (isset($mail)) {
      $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
      if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error_fields[]= "mail";
        $msg= "E-mail указан не корректно!";
      }
    }

    if (strlen($nname) < 2){
      $error_fields[]= "nname";
      $msg= "Укажите своё имя!";
  }



  if(!empty($error_fields)){

    $response=[
        "status"=> false,
        "type"=> 1,
        "message"=> $msg,
        "fields"=>$error_fields
    ];
    

    echo json_encode($response);

    die();
};




    if (strlen($pass) > 7 && !preg_match("[aA-zZ0-9]",$pass)) {

      $pass= md5($pass."lksd4fvm879");


      if($order){
        $mysqli->query("INSERT INTO `users`( `name`, `surname`, `mail`, `password`, `payment`) VALUES('$nname','$surname','$mail','$pass','$order') ");
      }else{
        $mysqli->query("INSERT INTO `users`( `name`, `surname`, `mail`, `password`) VALUES('$nname','$surname','$mail','$pass') ");
      };



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
      $email->addAddress($mail);    
      $email->isHTML(true);                                 

      $email->Subject = 'Eat Intelligent';
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
                Чао, Белла. 
              </h2>  
              <p>Ты успешно зарегистрировалась на платформе «Нежно». <br>
              Тебе уже доступна бесплатная неделя подписки и материалы по психологии питания и пищевого поведения.</p>
              <div style="margin: 50px 20px;">
                  <a href="https://nezhno.space/uchebnaya-programma" style="
                      color: whitesmoke;
                      text-decoration: none;
                      padding: 15px 30px;
                      border: 2px solid whitesmoke;
                      border-radius: 50px;
                  ">Бесплатная неделя</a>
              </div>
                  
          </div>
      ';
      $email->AltBody = '';
      if(!$email->send()) {
        echo 'Error';
    } else {
                $response=[
            "status"=> true,
            "message"=> "Регистрация прошла успешно!",
          ];

          echo json_encode($response);

          //$mysqli->close();

    }












    } else {
      $response=[
        "status"=> false,
        "message"=> "Пароль должен содержать не менее восьми знаков, включать буквы, цифры и специальные символы",
      ];

      echo json_encode($response);
    }
?>