<?php 

/**
 * Template Name: processing
 *
 
 */
require_once 'config/connect.php';
$db = new SafeMySQL();




function CheckAuth(){
    if (!$_SESSION['id']) {
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