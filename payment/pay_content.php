<?php
session_start();
date_default_timezone_set("Europe/Moscow");
require_once( get_theme_file_path('processing.php') );
require __DIR__ . '/../libs/yookassa/autoload.php';
use YooKassa\Client;
$status=2;
$user_id=$db->getAll("SELECT id FROM users WHERE status=?i", $status);
$payment=new Payment();
for($i = 0; $i < count($user_id); $i++){
    $id=$user_id[$i]['id'];
    $user_data=$db->getRow("SELECT * FROM users WHERE id=?i AND status=2", $id);
    $price=get_post_meta($user_data['pay_choice'], 'price', true);
    $service_month=get_post_meta($user_data['pay_choice'], 'month_count', true);
    $description=$mail . ' Продлил услугу на ' . $service_month .'месяц(ев)';
    $count_month='+'.$service_month.' month';
    $next_payment_date=strtotime($count_month, strtotime($user_data['payment_date']));
    if($_GET['autopay']==="turn_off"){
        if($db->query("UPDATE users SET payment_method=?s WHERE id=?i AND status=2", '', $_SESSION["id"])){
            // echo "Вы отписались от nezhno space! Вам ещё доступны материалы оплаченного месяца";
            // echo '--Закроется: '.date('d M Y H:i:s',$next_payment_date) ;
            get_header(); 
            echo "<section class='account_payment-off_banner_background' style='display: block;'>
            <div id='payment-off_banner' class='account_payment-off_banner payment-off_banner'>
                <button class='pay-banner_btnClose' type='button' onclick='window.location.href=`https://nezhno.space/account`'></button>
                <div class='pay-banner_content'>
                    <h4 class='pay-banner_title'>Вы отписались от подписки Нежно Space!</h4>
                    <div class='pay-banner_text' style='display: block;'>Вам ещё доступны материалы оплаченного месяца до <span class='pay-banner_text-date'>".date('d M Y H:i:s',$next_payment_date)."</span></div>
                    <div class='account_payment-off_buttons' style='max-width: 272px;'>
                        <button class='blue_btn' onclick='window.location.href=`https://nezhno.space/account`'>ок</button>
                    </div>
                </div>
            </div>
        </section>";
        get_footer();
        }else{
            echo "Что то пошло не так. Попробовать снова?";
        }
    }else{
            if( $next_payment_date >= time() && $user_data["payment_method"] && !empty($user_data["payment_method"]) && isset($user_data["payment_method"]) && $user_data["payment_method"]!==NULL){
                if(time() >= strtotime('-1 days', $next_payment_date)){
                    echo ('Письмо оповещение об оплате через 24ч');
                }else{
                    echo 'Оплата для '. $user_data["mail"] .': '.date('d M Y H:i:s',$next_payment_date) ;
                }
            }else{
                if($user_data["payment_method"] && !empty($user_data["payment_method"]) && isset($user_data["payment_method"]) && $user_data["payment_method"]!==NULL){
                    if($payment->getconnectToPayment($payment->getAutopay($user_data["payment_method"],$price,$description))){
                        $today = date("Y-m-d H:i:s");
                        if($db->query("UPDATE users SET payment_date=?s WHERE id=?i AND status=2",$today, $id)){
                            echo $id;
                        }else{
                            echo "Что то пошло не так. Попробовать снова?";
                        }
                    }else{
                        echo "Что то пошло не так. Попробовать снова?";
                    }
                }else{
                    if( time() >= $next_payment_date ){
                        if($db->query("UPDATE users SET status=?i, pay_choice=?i, payment_method=?s, payment_date=?s, created_payment=?s WHERE id=?i", 1, 0, '', 0, 0, $id)){
                            echo 'Оплатите подписку, чтобы открыть все материалы';
                        }
                    }else{
                        echo 'Закроется: '.date('d M Y H:i:s',$next_payment_date) ;
                    }
                }
            }
    }
}

?>