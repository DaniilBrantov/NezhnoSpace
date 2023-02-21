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

    //Данные с каждого поста конкретной категории
    public function getCatData($cat_ID){
        if ( have_posts() ) : query_posts(array( 'orderby'=>'date','order'=>'ASC','cat' => $cat_ID));
            $res=$this->checkCatData($cat_ID);
        endif;
        return $res;
        wp_reset_query();
    }
    //Вывод постов под конкретным тэгом
    public function tagPosts(){
        $payment_date=$this->userPaymentDate();
        if (have_posts()) :
            $i=1;
            $close=1;
            $res=[];
            while (have_posts()) : the_post();
                $cat_ID=get_the_category()[0]->cat_ID;
                $count_open_posts=$this->countOpenCatPosts($cat_ID);
                $res[$i] = $this->PostData(get_the_ID());

                if(checkPayment()){
                    if($i < $count_open_posts){
                        $res[$i]['status']=true;
                    }else{
                        $res[$i]['status']=false;
                        $res[$i]['next_post_date']=$this->getNextPostDate($count_open_posts,$close,$cat_ID);
                        $close++;
                    }
                };

                // $open_posts=ceil(openPosts( $payment_date, '', $cat_id ));
                // $res[$i] = subscriptionData(get_the_ID()) ;
                // if(checkPayment()){
                //     if($open_posts >= $i || $res[$i]['id']===current($res[1]) || $res[$i]===0){
                //         $res[$i]['status']=TRUE;
                //     }else{
                //         $res[$i]['status']=FALSE;
                //         $res[$i]['next_post_date']=getNextPostDate($open_posts,$close_posts,$category);
                //         $close_posts++;
                //     }
                // };

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
        $count_open_posts=$this->countOpenCatPosts($cat_ID);
        $i=1;
        $close=1;
        $res=[];
        while (have_posts()) : the_post();
            $res[$i] = $this->PostData(get_the_ID());

            if(checkPayment()){
                if($i < $count_open_posts){
                    $res[$i]['status']=true;
                }else{
                    $res[$i]['status']=false;
                    $res[$i]['next_post_date']=$this->getNextPostDate($count_open_posts,$close,$cat_ID);
                    $close++;
                }
            };

            if($res[$i]['exception']==='1'){
                $res[$i]['status']=TRUE;
                array_unshift($res, $res[$i]);
                unset($res[$i]);
            }
            
            $i+=1;
        endwhile;
        return $res;
    }
    // Получить дату следующего поста
    protected function getNextPostDate($open_posts, $close_posts,$category){
        if($category===45 || $category===46){
            $days = 6 - $open_posts-7;
            if($close_posts){
                $days=1*$close_posts;
            }
        }
        if($category===47){
            $days = 6 - $open_posts-7;
            if($close_posts){
                $days=$days+7*$close_posts;
            }
        }
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
        ceil($open_posts);
        return $open_posts;
    }
    // Массив из открытых постов конкретной категории
    protected function openCatPosts($cat_ID){
        if ( have_posts() ) : query_posts(array( 'orderby'=>'date','order'=>'ASC','cat' => $cat_ID));
            $res = [];
            $i = 0;
            $count = $this->countOpenCatPosts($cat_ID);
            while ($i < $count) : the_post();
                $res[$i] = $this->PostData(get_the_ID());
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
            $count = $this->countOpenCatPosts($cat_ID);
            while (have_posts()) : the_post();
                $res[$i] = $this->PostData(get_the_ID());
                $res[$i]['status']=false;
                $i++;
            endwhile;
            $res = array_slice($res, $count);
        endif;
        return $res;
    }
    
}
// if($_SESSION['id']==='190'){
//     $subscription= new Subscription();
//     $x=$subscription->tagPosts();
//     var_dump($x);
// }







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