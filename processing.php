<?php 

/**
 * Template Name: processing
 *
 
 */



if(require_once 'db/connect.php'){
    $try_free=$result_request_arr;
    $try_free_arr= $try_free;
    echo json_encode($try_free_arr);
}

?>