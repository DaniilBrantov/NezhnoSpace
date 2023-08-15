<?php
/**
 * Template Name: promocode_check
 *
 
 */

session_start();
CheckAuth();
require_once( get_theme_file_path('processing.php') );

if($_POST['promo_btn']){
    if( $_POST['promo'] ){
        echo json_encode(checkPromocode($_POST['promo']));
    }else{
        $err["status"]=false;
        $err["msg"]="Введите промокод!";
        echo json_encode($err);
    }
}

function checkPromocode($promo){
  $db = new SafeMySQL();
  $promo_data = $db->getRow("SELECT * FROM promocodes WHERE promo=?s", $promo);
  if($promo_data){
      if(date("Y-m-d") <= $promo_data['last_date'] && date("Y-m-d") >= $promo_data['first_date'] || $promo_data['last_date']==NULL && date("Y-m-d") >= $promo_data['first_date']){
          if($promo_data['sale'] >= 100){
              $payment_date = date("Y-m-d H:i:s");
              if($db->query("UPDATE users SET status=?s, payment_date=?s WHERE id=?i", 'Activate', $payment_date, $_SESSION['id'])){
                  return [
                      'status' => true,
                      'promo' => $promo_data['promo'],
                      'sale' => $promo_data['sale']
                  ];
              } else {
                  return [
                      'status' => false,
                      'msg' => "Ошибка при обновлении статуса пользователя!"
                  ];
              }
          } else {
              if($promo_data['promo'] === $promo){
                  return [
                      'status' => true,
                      'promo' => $promo_data['promo'],
                      'sale' => $promo_data['sale']
                  ];
              }
          }
      } else {
          return [
              'status' => false,
              'msg' => "Данный промокод не доступен!"
          ];
      }
  } else {
      return [
          'status' => false,
          'msg' => "Неверный промокод!"
      ];
  }
}











// if($email = $db->getOne("SELECT mail FROM users WHERE id=?i", $_SESSION['id'])){
//     if($promocode=$_POST["promocode"] && !empty($_POST["promocode"]) && isset($_POST["promocode"]) && $_POST["promocode"] !== NULL && $_POST["promocode"]!==""){
        
        
//     }else{
//         $response=[
//             "status" => false,
//             "message" => "Введите промокод",
//         ];
//     }
// }else{
//     $response=[
//         "status" => false,
//         "message" => "Произошла неизвестная ошибка",
//     ];
// }


// if($promocode && $user_tel){
//     if($promocode==""){
//         $response= [
//             "status" => false,
//             "message" => "Введите промокод",
//         ];
//         echo json_encode($response);
//     };
//     if($user_tel==""){
//         $response= [
//             "status" => false,
//             "type"=> 2,
//         ];

//         echo json_encode($response);
//     };
//     $code="НЕТОЛОГИЯ";
//     if($promocode==$code){
//         mysqli_query($mysqli,"UPDATE `users` SET `payment`='3',`telephone`='$user_tel' WHERE `mail`='$email'");
//         $_SESSION["user"]["payment"]='3';
//         $response= [
//             "status" => true,
//         ];

//         echo json_encode($response);
//     }else{
//         $response= [
//             "status" => false,
//             "type"=> 1,
//             "message" => "Такого промокода не существует",
//             "fields"=> "promocode"
//         ];

//         echo json_encode($response);
//     }
// }else{
// }

?>