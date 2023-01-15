<?php 

/**
 * Template Name: processing
 *
 
 */
require_once 'config/connect.php';
//session_start(); 
$db = new SafeMySQL();


class Sign{
    //Password
    public function ErrPass(){
        $pass = func_get_args()[0];
        $check=$this->ValidPass($pass);
        return $check;
        //return $this->SignResult($check);
    }
    public function getHashPass($pass){
        $hash=$this->HashPass($pass);
        return $hash;
    }
    public function ErrEmail(){
        $mail = func_get_args()[0];
        $check=$this->ValidEmail($mail);
        return $check;
        //return $this->SignResult($check);
    }



    protected function ValidPass($pass){
        if($pass == '') {$res = "Введите пароль";}
        //Недопустимая длина
        elseif (mb_strlen($pass) < 8){$res = "Недопустимая длина пароля";}
        //Проверка пароля
        elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/', $pass)){
            $res = "Слабый пароль";
        }else{
            $res = FALSE;
        }
        return $res;
    }
    protected function HashPass($pass){
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        return $pass;
    }
    protected function ValidEmail($mail){
        if($mail == '') {
            $error = "Введите Email";
        }
        elseif (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail)) {
            $error = 'Неверно введен е-mail';
        }else{
            $error = FALSE;
        }
        return $error;
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