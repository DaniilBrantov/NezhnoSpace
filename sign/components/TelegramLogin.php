<?php

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
                'last_name' => $_GET['last_name'] ?? '',
                'username' => $_GET['username'],
                'photo_url' => $_GET['photo_url'],
                'hash' => $_GET['hash']
            ];
        }
        return false;
    }

    public function checkTgUser($tg_user) {
        if ($tg_user) {
            $tg_id = $tg_user['id'];
            $first_name = htmlspecialchars($tg_user['first_name']);
            $last_name = htmlspecialchars($tg_user['last_name']);
            $username = isset($tg_user['username']) ? htmlspecialchars($tg_user['username']) : '';
            $photo_url = isset($tg_user['photo_url']) ? htmlspecialchars($tg_user['photo_url']) : '';

            $message = [
                'id' => $tg_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'hash' => $tg_user['hash'],
                'auth_date' => strtotime($tg_user["auth_date"]),
            ];

            if (!empty($username)) {
                $message['username'] = $username;
            }

            if (!empty($photo_url)) {
                $message['photo_url'] = $photo_url;
            }

            return [
                'success' => true,
                'message' => $message
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Login with Telegram'
            ];
        }
    }

    public function saveTelegramUserData($data) {
        session_start();
        require_once(get_theme_file_path('processing.php'));
        $db = new SafeMySQL();
        $sign_check = new UserValidationErrors();

        $id = $data['id'];
        $get_check_id = $sign_check->getCheckId($id);

        if ($get_check_id['status']) {
            $first_name = urldecode($data['first_name']);
            $get_name = $sign_check->getName($first_name);

            if (!$get_name) {
                $username = $data['username'];
                $photo_url = urldecode($data['photo_url']);
                $auth_date = strtotime($data['auth_date']);
                return [$get_name, $username, $photo_url, $auth_date];
            } else {
                return $get_name;
            }
        } else {
            return $get_check_id['msg'];
        }
    }

    public function processTelegramLogin() {
        $this->handleLogout();

        $tg_user = $this->getTelegramUserData();
        $result = $this->checkTgUser($tg_user);
        $this->saveTelegramUserData($_GET);

        return $result;
    }

    public function TgLogin() {
        $tgData = $this->processTelegramLogin()["message"];

        if ($this->processTelegramLogin()["success"]) {
            $db = new SafeMySQL();
            $tg_id = $tgData["id"];
            $name = $tgData["first_name"];
            $last_name = $tgData["last_name"];
            $username = $tgData["username"];
            $hash = $tgData["hash"];
            $photo_url = $tgData["photo_url"];
            $last_act = $tgData["auth_date"];

            $existingUser = $db->getRow("SELECT 1 FROM `users` WHERE `tg_id` = ?s", $tg_id);

            $query = $existingUser
                ? $db->query("UPDATE `users` SET `name`='$name', `surname`='$last_name', `username`='$username', `mail`='$username', `password`='$hash', `photo_url`='$photo_url', `last_act`='$last_act' WHERE `tg_id`='$tg_id'")
                : $db->query("INSERT INTO `users`(`tg_id`, `name`, `surname`, `username`, `mail`, `password`, `photo_url`, `last_act`) VALUES ('$tg_id', '$name', '$last_name', '$username', '$username', '$hash', '$photo_url', '$last_act')");


            if($query){
                $result = [
                    'status' => true,
                    'data' => $tgData,
                ];
            }else{
                $result = [
                    'status' => false,
                    'data' => 'Не удалось сохранить данные',
                ];
            }
        }else{
            $result = [
            'status' => false,
            'data' => 'Произошла ошибка. Попробуйте снова',
        ];
        }
        return $result;
    }
}
