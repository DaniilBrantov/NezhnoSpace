<?php
/**
 * Template Name: promocode_check
 *
 
 */

// session_start();
// CheckAuth();
// require_once( get_theme_file_path('processing.php') );

// if($_POST['promo_btn']){
//     if( $_POST['promo'] ){
//         echo json_encode(checkPromocode($_POST['promo']));
//     }else{
//         $err["status"]=false;
//         $err["msg"]="Введите промокод!";
//         echo json_encode($err);
//     }
// }

// function checkPromocode($promo){
//   $db = new SafeMySQL();
//   $promo_data = $db->getRow("SELECT * FROM promocodes WHERE promo=?s", $promo);
//   if($promo_data){
//       if(date("Y-m-d") <= $promo_data['last_date'] && date("Y-m-d") >= $promo_data['first_date'] || $promo_data['last_date']==NULL && date("Y-m-d") >= $promo_data['first_date']){
//           if($promo_data['sale'] >= 100){
//               $payment_date = date("Y-m-d H:i:s");
//               if($db->query("UPDATE users SET status=?s, payment_date=?s WHERE id=?i", 'Activate', $payment_date, $_SESSION['id'])){
//                   return [
//                       'status' => true,
//                       'promo' => $promo_data['promo'],
//                       'sale' => $promo_data['sale']
//                   ];
//               } else {
//                   return [
//                       'status' => false,
//                       'msg' => "Ошибка при обновлении статуса пользователя!"
//                   ];
//               }
//           } else {
//               if($promo_data['promo'] === $promo){
//                   return [
//                       'status' => true,
//                       'promo' => $promo_data['promo'],
//                       'sale' => $promo_data['sale']
//                   ];
//               }
//           }
//       } else {
//           return [
//               'status' => false,
//               'msg' => "Данный промокод не доступен!"
//           ];
//       }
//   } else {
//       return [
//           'status' => false,
//           'msg' => "Неверный промокод!"
//       ];
//   }
// }




session_start();
CheckAuth();
require_once( get_theme_file_path('processing.php') );

if (isset($_POST['promo'])) {
    $promoCode = $_POST['promo'];
    $db = new SafeMySQL();
    $promoId = $db->getRow("SELECT id FROM promocodes WHERE promo = ?s", $promoCode)['id'];
    if ($promoId) {
        $userId = $_SESSION['id'];
        $success = $db->query("UPDATE users SET promo_id = ?s WHERE id = ?i", $promoId, $userId);
        if ($success) {

            echo json_encode([
                'status' => true,
                'message' => 'Промокод успешно использован.'
            ]);
        } else {

            echo json_encode([
                'status' => false,
                'message' => 'Ошибка при использовании промокода.'
            ]);
        }
    } else {

        echo json_encode([
            'status' => false,
            'message' => 'Промокод не действителен.'
        ]);
    }
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Промокод не указан.'
    ]);

}
?>
