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