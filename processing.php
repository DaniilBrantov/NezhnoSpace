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
    public function getValidPass(){
        $pass = func_get_args()[0];
        $check=$this->ValidPass($pass);
        return $this->SignResult($check);
    }
    protected function SignResult($check){
        if($check==''){
            return TRUE;
        }else{
            return $check;
        }
    }
    protected function ValidPass($pass){
        if($pass == '') {$res = "Введите пароль";}
        //Недопустимая длина
        elseif (mb_strlen($pass) < 8){$res = "Недопустимая длина пароля";}
        //Проверка пароля
        elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/', $pass)){
            $res = "Слабый пароль";
        }else{
            $res = '';
        }
        return $res;
    }
    //Email
    public function getValidEmail(){
        $mail = func_get_args()[0];
        $check=$this->ValidEmail($mail);
        return $this->SignResult($check);
    }
    protected function ValidEmail($mail){
        if($mail == '') {
            $error = "Введите Email";
        }
        elseif (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail)) {
            $error = 'Неверно введен е-mail';
        }else{
            $error = '';
        }
        return $error;
    }
}

function CheckAuth(){
    if (!$_SESSION['id'] || $_SESSION['id']==NULL) {
        header('Location: auth');
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