<?php 

/**
 * Template Name: processing
 *
 
 */
require_once 'config/connect.php';
//session_start(); 
$db = new SafeMySQL();

class UserValidationErrors
{
    public function getName($val)
    {	
        return $this->FieldLength($val, "Введите Имя");
    }
    public function getSurname($val)
    {	
        return $this->FieldLength($val, "Введите Фамилию");
    }
    public function MatchingPasswords($pass, $pass_conf){
        if($pass === $pass_conf) {
            return 0;
        }else{
            return "Повторный пароль введен не верно!";
        }
    }
    public function getCoincidenceUser($val){
        if(!$this->getEmail($val)){
            return $this->CoincidenceUser($val);
        }else{
            return $this->getEmail($val);
        }
    }
    public function getEmail($val)
    {	
        $field_lenght=$this->FieldLength($val, "Введите Email");
        if($field_lenght === 0){
            if(preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $val)){
                return $field_lenght;
            }else{
                return 'Неверно введен е-mail';
            }
        }else{
            return $field_lenght;
        }
    }
    public function getPassword($val)
    {
        $field_lenght=$this->FieldLength($val, "Введите Пароль");
        if($field_lenght === 0){
            if(!preg_match('/^\S*(?=\S{8,30})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $val)){
                return "Слабый пароль";
            }else{ 
                return $field_lenght; 
            }
        }else{
            return $field_lenght;
        }
    }
    public function getTelephone($val)
    {
        if(preg_match("/^[0-9]{11,11}+$/", $val)){
			$first = substr($val, "0",1);
			if($first != 7){
				return "Некорректный номер телефона";
			}else{
                return 0;
			}
		}else{
			return"Телефон задан в неверном формате";
		}
    }
    public function getAge($val)
    {
        if( time() > strtotime($val) ){
            if (time() < strtotime('+18 years', strtotime($val))) {
                return "Вам меньше 18 лет";
            } else {
                return 0;
            }
        }else{
            return "Введите свою дату рождения";
        }
    }
    protected function FieldLength($full_name, $error)
    {
        if($full_name == '') {
            return $error;
        }elseif (mb_strlen($full_name) < 3 || mb_strlen($full_name) > 50){
            $error = "Недопустимая длина";
            return $error;
        }else{
            return 0;
        }
    }
    protected function CoincidenceUser($val)
    {
        $db = new SafeMySQL();
        //$check_user=$db->query("SELECT user_email FROM wp_users WHERE user_email=?s", $val
        if($check_user=$db->query("SELECT mail FROM users WHERE mail=?s", $val)){
            if($db->numRows($check_user)>0){
                return 'Такой пользователь уже существует';
            }else{
                return $field_lenght;
            }
        }else{return "Произошла неизвестная ошибка";}
    }
};









class Subscription{
    // Получить данные с каждого поста конкретной категории
    public function getCatData($cat_ID){
        if ( have_posts() ) : query_posts(array( 'orderby'=>'date','order'=>'ASC','cat' => $cat_ID));
            $res=$this->checkCatData($cat_ID);
        endif;
        return $res;
        wp_reset_query();
    }
    // Получить вывод постов под конкретным тэгом
    public function getTagPosts(){
        return $this->tagPosts();
    }
    // Получить данные с конкретного поста
    public function getPostData($id){
        return $this->PostData($id);
    }
    // Получить дату следующего поста
    public function getNextPostDate($close_posts, $cat_ID){
        return $this->nextPostDate($close_posts,$cat_ID);
    }
    // Получить дату оплаты
    // public function getUserPaymentDate(){
    //     return $this->userPaymentDate();
    // }

    // Получить кол-во открытых постов конкретной категории
    public function getCountOpenCatPosts($cat_ID){
        return $this->countOpenCatPosts($cat_ID);
    }
    // Получить массив из открытых постов конкретной категории
    public function getOpenCatPosts($cat_ID){
        return $this->openCatPosts($cat_ID);
    }
    // Массив из закрытых постов конкретной категории
    public function getCloseCatPosts($cat_ID){
        return $this->closeCatPosts($cat_ID);
    }
    //Получить сегодняшнюю ежедневную практику
    public function getTodayPractice($cat_ID){
        return $this->TodayPractice($cat_ID);
    }
    // Получить данные записи для вывода на страницу. С проверкой оплаты
    public function getSubscriptionLesson($id){
        return $this->subscriptionLesson($id);
    }
    // Вывод постов под конкретным тэгом
    protected function tagPosts(){
        $payment_date=$this->userPaymentDate();
        if (have_posts()) :
            $i=1;
            $close=1;
            $res=[];
            while (have_posts()) : the_post();
                $cat_ID=get_the_category()[0]->cat_ID;
                $count_open_posts=$this->getCountOpenCatPosts($cat_ID);
                $res[$i] = $this->getPostData(get_the_ID());

                if($this->getCheckPayment()){
                    if($i < $count_open_posts){
                        $res[$i]['status']=true;
                    }else{
                        $res[$i]['status']=false;
                        $res[$i]['next_post_date']=$this->getNextPostDate($close,$cat_ID);
                        $close++;
                    }
                };
                if($res[$i]['exception']==='1'){
                    $res[$i]['status']=TRUE;
                    // array_unshift($res, $res[$i]);
                    unset($res[$i]['next_post_date']);
                }
            $i+=1;
            endwhile;
            return $res;
        endif;
    }
    //Данные с конкретного поста
    protected function PostData($id){
        $post = get_post($id);
        $res=[
            'id' => $post->ID,
            'date' => $post->post_date,
            'excerpt' => $post->post_excerpt,
            'title' => $post->post_title,
            'content' => $post->post_content,
            'image_url' => get_the_post_thumbnail_url( $post->ID, 'full' ),
            'audio' => array_shift(get_attached_media( 'audio', $post->ID ))->guid,
            'lesson_time' => get_post_meta($post->ID, 'reading_time', true),
            'exception' => get_post_meta($post->ID, 'open_posts_exception', true),
            'tag' => get_the_tag_list('<li>','</li><li>','</li>', $post->ID )
        ];
        ($res['exception']==='1')? $res['status']=TRUE : $res['status']=FALSE;

        return $res;
    }
    // Распределение открытых и закрытых постов
    protected function checkCatData($cat_ID){
        $count_open_posts=$this->getCountOpenCatPosts($cat_ID);
        $i=0;
        $close=1;
        $res=[];
        while (have_posts()) : the_post();
            $res[$i] = $this->getPostData(get_the_ID());
            $payment=new Payment();
            if($payment->getCheckPayment()){
                if($i < $count_open_posts){
                    $res[$i]['status']=true;
                }else{
                    $res[$i]['status']=false;
                    $res[$i]['next_post_date']=$this->getNextPostDate($close, $cat_ID);
                    $close++;
                }
            };

            if($res[$i]['exception']==='1'){
                $res[$i]['status']=TRUE;
                array_unshift($res, $res[$i]);
                unset($res[$i]['next_post_date']);
                unset($res[$i]);
            }
            
            $i+=1;
        endwhile;
        return $res;
    }
    // Дата следующего поста
    protected function nextPostDate($close_posts, $cat_ID){
        if($cat_ID===45 || $cat_ID===46){
            $days=1*$close_posts;
        }if($cat_ID===47){
            $open_posts=$this->getCountOpenCatPosts($cat_ID);
            $payment_date = $this->userPaymentDate();
            $today = date("Y-m-d H:i:s");
            $frequency_discoveries=countDaysBetweenDates($today, $payment_date);
            $open_days=$open_posts*7;
            $days_before_open=$open_days-$frequency_discoveries;
            if($close_posts===1){
                $days=$days_before_open;
            }else{
                $close_posts=$close_posts-1;
                $days=$days_before_open+7*$close_posts;
            }
        }
        $next_post_date="+". $days ." day";
        $next_post_date = strtotime($next_post_date, time());
        $date = date("d.m.Y",$next_post_date);
        $months = [
            '01' => 'января',
            '02' => 'февраля',
            '03' => 'марта',
            '04' => 'апреля',
            '05' => 'мая',
            '06' => 'июня',
            '07' => 'июля',
            '08' => 'августа',
            '09' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря',
        ];
        $dateParts = explode('.', $date);
        return $dateParts[0] . ' ' . $months[$dateParts[1]];
        }
    //Дата оплаты
    protected function userPaymentDate(){
        $db = new SafeMySQL();
        session_start();
        $payment_date = $db->getOne("SELECT payment_date FROM users WHERE id=?i", $_SESSION['id']);
        return $payment_date;
    }
    // Кол-во открытых постов конкретной категории
    protected function countOpenCatPosts($cat_ID){
        $payment_date = $this->userPaymentDate();
        $today = date("Y-m-d H:i:s");
        $frequency_discoveries=countDaysBetweenDates($today, $payment_date);
        if($cat_ID === 45){
            $open_posts=$frequency_discoveries;
        }elseif($cat_ID === 46){
            $open_posts=999;
        }elseif($cat_ID === 47){
            $open_posts=$frequency_discoveries/7;
        }
        $open_posts=ceil($open_posts);
        return $open_posts;
    }
    // Массив из открытых постов конкретной категории
    protected function openCatPosts($cat_ID){
        if ( have_posts() ) : query_posts(array( 'orderby'=>'date','order'=>'ASC','cat' => $cat_ID));
            $res = [];
            $i = 0;
            $count = $this->getCountOpenCatPosts($cat_ID);
            while ($i < $count) : the_post();
                $res[$i] = $this->getPostData(get_the_ID());
                $res[$i]['status']=true;
                $i++;
            endwhile;
        endif;
        return $res;
    }
    // Массив из закрытых постов конкретной категории
    protected function closeCatPosts($cat_ID){
        if ( have_posts() ) : query_posts(array( 'orderby'=>'date','order'=>'ASC','cat' => $cat_ID));
            $res = [];
            $i=0;
            $count = $this->getCountOpenCatPosts($cat_ID);
            while (have_posts()) : the_post();
                $res[$i] = $this->getPostData(get_the_ID());
                $res[$i]['status']=false;
                $i++;
            endwhile;
            $res = array_slice($res, $count);
        endif;
        return $res;
    }
    //Сегодняшняя ежедневная практика
    protected function TodayPractice($cat_ID){
        $arr = $this->getCatData($cat_ID);
        $open_arr=[];
        $i=0;
        foreach ($arr as &$element) {
            if($element['status'] === true){
                $res = $element;
            }
        }
        return $res;
    }
    // Данные записи для вывода на страницу. С проверкой оплаты
    protected function subscriptionLesson($id){
        $cat = (array)(get_the_category($id)[0]);
        $cat_ID=$cat["cat_ID"];
        $count_open_posts=$this->getCountOpenCatPosts($cat_ID);
        $i=0;
        $res=[];
        while (have_posts()) : the_post();
            $res[$i] = $this->getPostData(get_the_ID());
            if($id === $res[$i]['id']){
                if($this->getCheckPayment()){
                    if($i < $count_open_posts){
                        $res[$i]['status']=true;
                    }else{
                        $res[$i]['status']=false;
                    }
                }else{
                    $res[$i]['status']=false;
                };
                if($res[$i]['exception']==='1'){
                    $res[$i]['status']=TRUE;
                    array_unshift($res, $res[$i]);
                    unset($res[$i]);
                }
                break;
            }
            
            $i+=1;
        endwhile;
        return $res[1];
    }
    // Посты, которые лайкнул пользователь
    protected function RatedPosts($cat_ID){
        $db = new SafeMySQL();
        session_start();
        $user_likes = $db->getAll("SELECT * FROM likes WHERE user_id=?i", $_SESSION['id']);
        $cat_data = $this->getCatData($cat_ID);
        $result_key = 0;
        $result_list=[];
        foreach($cat_data as $cat_post){
            foreach($user_likes as $like_data){
                if($like_data['post_id'] == $cat_post['id']){
                    $result_list[$result_key] = $cat_post;
                    $result_key++;
                }
            }
        }
        return $result_list;
    }
    // Получить отфильтрованные по лайкам посты 
    public function getFilterPostsByLike($cat_ID){
        return $this->FilterPostsByLike($cat_ID);
    }
    // Получить результат проверки категории
    public function getFilterCat($post_id, $filter_cat){
        return $this->FilterCat($post_id, $filter_cat);
    }
    //Отфильтрованные по лайкам посты 
    protected function FilterPostsByLike($cat_ID){
        $liked_posts = $this->RatedPosts($cat_ID);
        $cat_data = $this->getCatData($cat_ID);
        foreach($cat_data as $key => $cat_post){
            $post_id=$cat_post['id'];
            foreach($liked_posts as $like_data){
                if($post_id == $like_data['id']){
                    unset($cat_data[$key]);
                }
            }
            
        }
        return $cat_data;
    }
    // Проверка категории
    protected function FilterCat($post_id, $filter_cat){
        $cat = get_the_category( $post_id );
        foreach($cat as $el){
            if($el->slug === $filter_cat){
            return TRUE;
            }
        }
    }
}









//Payment
class Payment{
    // Получить проверку промокода
    public function getcheckPromocode($promo){
        return $this->checkPromocode($promo);
    }
    //Подключение к кассе
    public function getConnectToPayment($data){
        return $this->connectionPayment($data);
    }
    // Получить автоплатёж
    public function getAutopay($pay_id,$price,$description){
        return $this->Autopay($pay_id,$price,$description);
    }
    // Создание платежных данных
    public function createPagePayment($price,$description){
        $data = array(
            'amount' => array(
                'value' => $price,
                'currency' => 'RUB',
            ),
            'payment_method_data' => array(
                'type' => 'bank_card',
            ),
            'capture' => true,
            'confirmation' => array(
                'type' => 'redirect',
                'return_url' => 'https://nezhno.space/pay_success',
            ),
            'description' => $description,
            'save_payment_method' => true,
            'metadata' => array(
                'order_id' => 1,
            )
        );
        return $data;
    }
    //Получить проверку оплаты
    public function getCheckPayment(){
        return $this->checkPayment($data);
    }
    //Получить данные выбранной услуги
    public function getPaymentServiceData(){
        return $this->PaymentServiceData();
    }
    //Проверка срока подписки, заведённый промокодом
    public function getSubPromoDate(){
        return $this->checkSubPromoDate();
    }
    // Данные выбранной услуги
    protected function PaymentServiceData(){
        $db = new SafeMySQL();
        if($_POST["payment_btn"] || $_POST["payment_btn"] !== NULL){
            $service_id=$_POST["payment_id"];
        }elseif($_GET["payment_choice"]){
            $service_id=$_GET["payment_choice"];
        }else{
            $service_id=944;
        };
        if(!get_post_meta($service_id, 'month_count', true) || !get_post_meta($service_id, 'price', true)){
            $service_id=944;
        };
        $res['service_number']=get_post_meta($service_id, 'month_count', true);
        $res['price']=get_post_meta($service_id, 'price', true);
        $res['description']=$mail . ' Купил услугу на ' . $res['service_number'] .' месяц(ев)';
        $res['mail'] = $db->getOne("SELECT mail FROM users WHERE id=?i",$_SESSION['id']);
        return $res;
    }
    //Проверка оплаты
    protected function checkPayment(){
        $db = new SafeMySQL();
        $status = $db->getOne("SELECT status FROM users WHERE id=?i", $_SESSION['id']);
        if($status && !empty($status) && isset($status) && $status !== NULL){
            if($status==='2'){
                return TRUE;
            }else{ return FALSE; }
        }else{ return FALSE; }
    }
    //Автоплатёж
    protected function Autopay($pay_id,$price,$description){
        $data=array(
            'amount' => array(
            'value' => $price,
            'currency' => 'RUB',
            ),
            'capture' => true,
            'payment_method_id' => $pay_id,
            'description' => $description,
        );
        return $data;
    }
    //Подключение к кассе
    protected function connectionPayment($data){
        $client = new \YooKassa\Client();
        $set_auth=$client->setAuth(YOOKASSA_SHOPID, YOOKASSA_SECRET_KEY);
        // $set_auth=$client->setAuth('975491', 'test_ubpi1LK1auMcV-0o77C9Nn4ikb1h9RbzjaD0_2oFT7I');
        $payment = $client->createPayment($data,uniqid('', true));
        return $payment;
    }
    // Получение данных оплаты
    protected function getPaymentInformation($paymentId){
        $client = new \YooKassa\Client();
        $client->setAuth(YOOKASSA_SHOPID, YOOKASSA_SECRET_KEY);
        // $client->setAuth('975491', 'test_ubpi1LK1auMcV-0o77C9Nn4ikb1h9RbzjaD0_2oFT7I');
        $payment = $client->getPaymentInfo($paymentId);
        return $payment;
    }
    // Сохранить платёж
    protected function SavePayment($paymentId){
        if($paymentId){
            $payment_info= $this->getPaymentInformation($paymentId);
            $id=$_SESSION['id'];
            if($payment_info){
                if($payment_info["status"]==='succeeded'){
                    $payment_date=(array)($payment_info["created_at"]);
                    $db = new SafeMySQL();
                    if($db->query("UPDATE users SET status=?i, pay_choice=?i, payment_method=?s, payment_date=?s, created_payment=?s WHERE
                        id=?i", 2,
                        $_SESSION["payment"]["service_id"], $payment_info['payment_method']['id'], $payment_date["date"], $payment_date["date"],
                        $id)){
                            $answer = true;
                    }
                }
            }
        }
        return (isset($answer) );
    }
    //Проверка срока подписки, заведённый промокодом
    protected function checkSubPromoDate(){
        $db = new SafeMySQL();
        $users = $db->getAll("SELECT * FROM users WHERE status=?i", 3);
        foreach($users as $user){
            $date = date('Y-m-d', strtotime($user['payment_date'] . " +2 weeks"));
            if($user['payment_date'] >= date("Y-m-d H:i:s")){
                echo $user['mail'];
            }
        }
    }
    //Проверка промокода
    protected function checkPromocode($promo){
        $db = new SafeMySQL();
        $id = $_SESSION['id'];
        $promo_data = $db->getRow("SELECT * FROM promocodes WHERE promo=?s", $promo);
        if($promo_data){
            if(date("Y-m-d") <= $promo_data['last_date'] && date("Y-m-d") >= $promo_data['first_date']){
                if($promo_data['sale'] >= 100){
                    $payment_date = date("Y-m-d H:i:s");
                    if($db->query("UPDATE users SET status=?i, payment_date=?s WHERE id=?i", 3, $payment_date, $id)){
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
}






function GetResponseFromDB($condition, $db_func){
    if($condition){
        echo json_encode($db_func);
    };
};
    GetResponseFromDB(
        $_POST['try_free'],
        $db->getAll("SELECT * FROM main_try_free")
    );

?>