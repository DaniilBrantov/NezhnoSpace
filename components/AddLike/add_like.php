<?php

    function addLikeOrDislike($postId, $userId, $type) {
        try {
            // подключение к базе данных
            $db = new SafeMySQL();
            // проверяем, существует ли уже лайк или дизлайк от этого пользователя для этого поста
            $stmt = $db->query("SELECT * FROM likes WHERE post_id = ?i AND user_id = ?i", $postId, $userId);
            // если запись уже есть, то обновляем значение
            if ($db->numRows($stmt) > 0) {
                if($stmt = $db->query("UPDATE likes SET type = ?s WHERE post_id = ?i AND user_id = ?i", $type, $postId, $userId )){
                    $status ="update";
                }
            }
            // если записи нет, то создаем новую
            else {
                if($stmt = $db->query("INSERT INTO likes (post_id, user_id, type) VALUES (?i, ?i, ?s)", $postId, $userId, $type)){
                    $status ="insert";
                }
            }
            $res=[
                'type' => $type,
                'status' => $status
            ];
            return $res;
        } catch (Exception $e) {
            // обработка ошибок
            error_log($e->getMessage());
            return false;
        }
    }
    

    echo json_encode(addLikeOrDislike($_POST['post_id'], $_POST['user_id'], $_POST['type']));






    // function addLikeOrDislike($postId, $userId, $type) {
    //     // подключение к базе данных
    //     $db = new SafeMySQL();
    //     // проверяем, существует ли уже лайк или дизлайк от этого пользователя для этого поста
    //     $stmt = $db->query("SELECT * FROM likes WHERE post_id = ?i AND user_id = ?i", $postId, $userId);
    //     // если запись уже есть, то обновляем значение
    //     if ($db->numRows($stmt) > 0) {
    //             if($stmt = $db->query("UPDATE likes SET type = ?s WHERE post_id = ?i AND user_id = ?i", $type, $postId, $userId )){
    //                 $status ="update";
    //             }
    //     }
    //     // если записи нет, то создаем новую
    //     else {
    //         if($stmt = $db->query("INSERT INTO likes (post_id, user_id, type) VALUES (?i, ?i, ?s)", $postId, $userId, $type)){
    //             $status ="insert";
    //         }
    //     }
    //     $res=[
    //         'type' => $type,
    //         'status' => $status
    //     ];
    //     return $res;
    // }



?>