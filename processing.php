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
    public function getCheckTokens($mail, $token)
    {
        return $this->checkTokens($mail, $token);
    }
    public function getCheckId($id){
        return $this->checkId($id);
    }
    protected function checkId($id){
        $db = new SafeMySQL();
        $existingUser = $db->query("SELECT id FROM users WHERE id=?i", $id);
        if($db->numRows($existingUser)>0){
            $error['status']=0;
            $error['msg']="Такой пользователь уже существует";
            return $error;
        }else{
            return $error['status']=1;
        }
    }
    protected function checkTokens($mail, $token)
    {
        $db = new SafeMySQL();
        $sql =$db->getAll("SELECT * FROM tokens WHERE mail=?s AND token=?s", $mail, $token)[0];
        $info_sql =$sql['info'];
        $token=$sql['token'];
        $info_sql= json_decode($info_sql);
        $error=[];
        if(isset($sql) && !empty($sql)){
                $user_sql =$db->query("SELECT mail FROM users WHERE mail=?s", $mail);
                $status=$info_sql->status;
                $pay_choice=$info_sql->pay_choice;
                $date=$info_sql->date;
                if($db->numRows($user_sql)>0){
                    $user_up = $db->query("UPDATE users SET status='$status', pay_choice='$pay_choice', payment_date='$date', created_payment='$date' WHERE mail='$mail'"); 
                    $error['status'] = 2;
                    $error['info'] = $info_sql;
                    $error['token'] = $token;
                }else{
                    $error['status'] = 1;
                    $error['info'] = $info_sql;
                    $error['token'] = $token;
                }
        }else{
            $error['status'] = 0;
            $error['msg'] = "Проверьте вашу почту";
        }
        return $error;
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


class TelegramLogin {
    private $bot_username;

    public function __construct($bot_username) {
        $this->bot_username = $bot_username;
    }

    public function handleLogout() {
        if ($_GET['logout']) {
            setcookie('tg_user', '');
            header('Location: auth?action=out');
            exit;
        }
    }

    public function getTelegramUserData() {
        if (isset($_GET['id'], $_GET['first_name'], $_GET['username'], $_GET['photo_url'])) {
            return [
                'id' => $_GET['id'],
                'first_name' => $_GET['first_name'],
                'username' => $_GET['username'],
                'photo_url' => $_GET['photo_url']
            ];
        }
        return false;
    }

    public function checkTgUser($tg_user) {
        $result = [];

        if ($tg_user !== false) {
            $first_name = htmlspecialchars($tg_user['first_name']);
            $last_name = htmlspecialchars($tg_user['last_name']);
            $username = isset($tg_user['username']) ? htmlspecialchars($tg_user['username']) : '';
            $photo_url = isset($tg_user['photo_url']) ? htmlspecialchars($tg_user['photo_url']) : '';

            $message = [
                'first_name' => $first_name,
                'last_name' => $last_name
            ];

            if (!empty($username)) {
                $message['username'] = $username;
            }

            if (!empty($photo_url)) {
                $message['photo_url'] = $photo_url;
            }

            $result['success'] = true;
            $result['message'] = $message;
        } else {
            $result['success'] = false;
            $result['message'] = "Login with Telegram";
        }

        return $result;
    }

    public function saveTelegramUserData($data) {
        session_start();
        require_once(get_theme_file_path('processing.php'));
        $db = new SafeMySQL();
        $sign_check = new UserValidationErrors();

        $id = $data['id'];
        if ($sign_check->getCheckId($id)['status']) {
            $first_name = urldecode($data['first_name']);
            if (!$sign_check->getName($first_name)) {
                $username = $data['username'];
                $photo_url = urldecode($data['photo_url']);
                $auth_date = strtotime($data['auth_date']);
            } else {
                return $sign_check->getName($first_name);
            }
        } else {
            return $sign_check->getCheckId($id)['msg'];
        }

        if($db->query("INSERT INTO users (name, username, photo_url, last_act) VALUES ('$first_name', '$username', '$photo_url', '$auth_date')")){
            return 'true';
        }
    }

    public function processTelegramLogin() {
        $this->handleLogout();

        $tg_user = $this->getTelegramUserData();
        $result = $this->checkTgUser($tg_user);
        return $result;

        $this->saveTelegramUserData($_GET);
    }
}









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
    // Получить данные проверки админки
    public function getCheckAdmin(){
        return $this->checkAdmin();
    }
    // Проверка админки
    protected function checkAdmin() {
        require_once(get_theme_file_path('processing.php'));
        session_start();
        $status = (new SafeMySQL())->getOne("SELECT status FROM users WHERE id = ?i", $_SESSION['id']);
        if ($status === '4') return true;
        header('Location: auth');
        exit();
    }
    // Вывод постов под конкретным тэгом
    protected function tagPosts(){
        $payment_date=$this->userPaymentDate();
        $payment = new Payment();
        if (have_posts()) :
            $i=1;
            $close=1;
            $res=[];
            while (have_posts()) : the_post();
                $cat_ID=get_the_category()[0]->cat_ID;
                $count_open_posts=$this->getCountOpenCatPosts($cat_ID);
                $res[$i] = $this->getPostData(get_the_ID());

                if($payment->getCheckPayment()){
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
        $payment=new Payment();
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
    public function getSubPromoDate($weeksToAdd){
        return $this->checkSubPromoDate($weeksToAdd);
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
            }elseif($status==='3'){
                $mail = $db->getOne("SELECT mail FROM users WHERE id=?i", $_SESSION['id']);
                $info_sql = $db->getOne("SELECT info FROM tokens WHERE mail=?s", $mail);
                $info_sql= json_decode($info_sql);
                $weeks=$info_sql->weeks;
                if($this->getSubPromoDate($weeks)){
                    return FALSE;
                }else{
                    return TRUE;
                }
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
    protected function checkSubPromoDate($weeksToAdd = 1) {
        $db = new SafeMySQL();
        foreach ($db->getAll("SELECT * FROM users WHERE status = ?i", 3) as $user) {
            if (date('Y-m-d', strtotime($user['payment_date'] . " +{$weeksToAdd} weeks")) <= date("Y-m-d H:i:s")) {
                $db->query("UPDATE users SET status = ?i, payment_date = ?s WHERE mail = ?s", 1, 0, $user['mail']);
                return true;
            }
        }
        return false;
    }
    
    
    //Проверка промокода
    protected function checkPromocode($promo){
        $db = new SafeMySQL();
        $id = $_SESSION['id'];
        $promo_data = $db->getRow("SELECT * FROM promocodes WHERE promo=?s", $promo);
        if($promo_data){
            if(date("Y-m-d") <= $promo_data['last_date'] && date("Y-m-d") >= $promo_data['first_date'] || $promo_data['last_date']==NULL && date("Y-m-d") >= $promo_data['first_date']){
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







class ChangeRole {
    private $db;

    public function __construct() {
        // Подключение к базе данных
        $this->db = new SafeMySQL();
    }

    /**
     * Изменяет статус пользователей на основе CSV файла.
     * @param string $csvFilePath Путь к CSV файлу.
     * @param int $newStatus Новый статус пользователей.
     * @return bool Возвращает true в случае успешного изменения статуса или false в противном случае.
     */
    public function changeStatusForUsersFromCSV(string $csvFilePath, int $newStatus): bool {
        if (!file_exists($csvFilePath)) {
            echo "Файл CSV не найден: $csvFilePath.";
            return false;
        }

        $file = fopen($csvFilePath, 'r');
        if (!$file) {
            echo "Не удалось открыть файл CSV: $csvFilePath.";
            return false;
        }

        $emails = [];
        while (($row = fgetcsv($file)) !== false) {
            $emails[] = $row[0];
        }

        fclose($file);

        // Изменение статуса пользователей
        $result = $this->changeStatusForUsers($emails, $newStatus);

        return $result;
    }

    /**
     * Изменяет статус пользователей.
     * @param array $emails Массив email-ов пользователей.
     * @param int $newStatus Новый статус пользователей.
     * @return bool Возвращает true в случае успешного изменения статуса или false в противном случае.
     */
    public function changeStatusForUsers(array $emails, int $newStatus): bool {
        // Проверяем наличие email-ов
        if (empty($emails)) {
            return false;
        }

        $query = "UPDATE users SET status = ?i WHERE mail IN(?a) AND status = 3";

        // Изменение статуса пользователей в базе данных
        $result = $this->db->query($query, $newStatus, $emails);

        return $result ? true : false;
    }
}








class NewUserRole {
    private array $user_data; 
    /**
     * Конструктор класса
     *
     * @param array $user_data - данные пользователя.
     */
    public function __construct(array $user_data) {
        $this->user_data = $user_data;
    }

    /**
     * Отправляет ссылку для регистрации на указанный адрес электронной почты.
     *
     * @return bool - результат отправки письма.
     */
    public function sendRegistrationLink(): bool {
        require_once(get_theme_file_path('send_mail.php'));

        $mail = $this->user_data['mail'];
        if (!empty($mail)) {
            // Проверяем существование mail в базе данных
            $emailExists = $this->checkEmailExists($mail);

            if ($emailExists) {
                // Обновляем данные пользователя
                $this->updateUserData();
            } else {
                // Генерируем уникальный токен и сохраняем его в базе данных
                $token = $this->generateUniqueToken();
                $this->storeToken($token);
            }

            // Формируем ссылку для регистрации и текст письма
            $registrationLink = 'https://nezhno.space/registration?token=' . urlencode($token);
            $subject = 'Registration Link';
            $message = 'Please click on the following link to register: ' . $registrationLink;

            // Отправляем письмо на указанный адрес электронной почты
            if ($send_mail = SendMail($mail, $subject, $message, $subject)) {
                return $send_mail;
            } else {
                echo 'Failed to send the registration link.';
            }
        } else {
            echo 'Email is missing.';
            return false; // Return false if the mail is missing
        }
    }

    /**
     * Генерирует уникальный токен заданной длины.
     *
     * @param int $length - длина токена (по умолчанию 10 символов).
     * @return string - сгенерированный токен.
     */
    public function generateUniqueToken(int $length = 10): string {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            // Выбираем случайный символ из набора символов.
            $token .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $token;
    }

    /**
     * Сохраняет токен в базе данных.
     *
     * @param string $token - токен для сохранения.
     * @return bool - результат сохранения токена.
     */
    public function storeToken(string $token): bool {
        // Получаем экземпляр объекта базы данных и сохраняем токен.
        $db = new SafeMySQL();
        $json_data = json_encode($this->user_data);
        $mail = $this->user_data['mail'];
        $result = $db->query("INSERT INTO tokens (mail, token, info) VALUES ('$mail', '$token', '$json_data')");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Проверяет существование mail в базе данных.
     *
     * @param string $mail - mail для проверки.
     * @return bool - результат проверки.
     */
    public function checkEmailExists(string $mail): bool {
        // Получаем экземпляр объекта базы данных и проверяем существование mail.
        $db = new SafeMySQL();
        $result = $db->getOne("SELECT COUNT(*) FROM tokens WHERE mail = ?s", $mail);
        return $result > 0;
    }

    /**
     * Обновляет данные пользователя.
     *
     * @return bool - результат обновления данных.
     */
    public function updateUserData(): bool {
        // Получаем экземпляр объекта базы данных и обновляем данные пользователя.
        $db = new SafeMySQL();
        $info = json_encode($this->user_data) ;
        $mail = $this->user_data['mail'];
        

        $result = $db->query("UPDATE tokens SET info = '$info' WHERE mail = '$mail'");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Устанавливает данные пользователя.
     *
     * @param array $user_data - новые данные пользователя.
     */
    public function setUserData($mail, $status, $pay_choice, $weeks): void {
        $this->user_data = [
            'mail' => $mail,
            'status' => $status,
            'pay_choice' => $pay_choice,
            'date' => date("Y-m-d H:i:s"),
            'weeks' => $weeks,
        ];
    }

    /**
     * Возвращает данные пользователя.
     *
     * @return array - данные пользователя.
     */
    public function getUserData(): array {
        return $this->user_data;
    }
}






class addPromo {
    public function add_promo_code($promo, $sale, $first_date, $last_date, $paid_days=null) {
        $db = new SafeMySQL();
        
        if (!$this->is_promo_unique($promo)) {
            return "Промокод уже существует";
        }
    
        if (!$this->is_date_valid($first_date, $last_date)) {
            return "Некорректные даты";
        }
    
        if (!$this->is_sale_valid($sale)) {
            return "Некорректная скидка";
        }
    
        if ($paid_days !== null && !$this->is_paid_days_valid($paid_days)) {
            if(empty($paid_days) || $paid_days == ""){
                $paid_days = null;
            }else{
                return "Некорректное количество оплаченных дней";
            }
        }
    
        $query = "INSERT INTO promocodes (promo, sale, first_date, last_date";
        if ($paid_days !== null) {
            $query .= ", paid_days";
        }
        $query .= ") VALUES (?s, ?i, ?s, ?s";
        $params = [$promo, $sale, $first_date, $last_date];
        if ($paid_days !== null) {
            $query .= ", ?i";
            $params[] = $paid_days;
        }
        $query .= ")";
        $result = $db->query($query, ...$params); // Use the splat operator to unpack the parameters
    
        return $result ? "Промокод успешно добавлен" : "Ошибка при добавлении промокода";
    }
    

    private function is_promo_unique($promo) {
        $db = new SafeMySQL();
        $result = $db->query("SELECT * FROM promocodes WHERE promo = ?s", $promo);
        return $result->num_rows === 0;
    }

    private function is_date_valid($first_date, $last_date) {
        return $first_date < $last_date;
    }

    private function is_sale_valid($sale) {
        return $sale >= 0 && $sale <= 100;
    }

    private function is_paid_days_valid($paid_days) {
        return $paid_days > 0;
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