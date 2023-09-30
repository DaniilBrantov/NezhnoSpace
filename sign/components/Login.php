<?php
// require_once( get_theme_file_path('/components/CloudPayments/CloudPayments.php') );
// $payment = new CloudPayment;
// $_SESSION['status'] = '2';

class Login
{
    private $db;

    public function __construct()
    {   
        require_once( get_theme_file_path('processing.php') );
        $this->db = new SafeMySQL();
    }

    public function enter()
    {
        $error = [];

        if (!empty($_POST['mail']) && !empty($_POST['pass'])) {
            $mail = $_POST['mail'];
            $pass = $_POST['pass'];
            $enter_rez = $this->db->query("SELECT * FROM users WHERE mail = ?s", $_POST['mail']);

            if ($this->db->numRows($enter_rez) == 1) {
                $tgLogin = new TelegramLogin('NezhnoSpacebot');
                $tg_log = $tgLogin->TgLogin();
                $row = $this->db->getAll("SELECT * FROM users WHERE mail = ?s", $_POST['mail'])[0];

                if ($tg_log['status'] || password_verify($pass, $row['password'])) {
                    setcookie("mail", $row['mail'], time() + 50000);
                    setcookie("pass", md5($row['mail'] . $row['password']), time() + 50000);
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['status'] = $row['status'];
                    
                    $id = $_SESSION['id'];
                    $this->lastAct($id);
                    return $error;
                } else {
                    $error['pass'] = "Неверный пароль";
                    return $error;
                }
            } else {
                $error['mail'] = "Такого пользователя не существует";
                return $error;
            }
        } else {
            if (empty($_POST['mail'])) {
                $error['mail'] = "Вы не ввели email";
            }
            if (empty($_POST['pass'])) {
                $error['pass'] = "Вы не ввели пароль";
            }
            return $error;
        }
    }

    private function lastAct($id)
    {
        $tm = time();
        $this->db->query("UPDATE users SET online = '$tm', last_act = '$tm' WHERE id = '$id'");
    }

    public function login()
    {
        if (!session_id()) {
            session_start();
        }

        if (isset($_SESSION['id'])) {
            if (isset($_COOKIE['mail']) && isset($_COOKIE['pass'])) {
                setcookie("mail", "", time() - 1, '/');
                setcookie("pass", "", time() - 1, '/');
                setcookie("mail", $_COOKIE['mail'], time() + 50000, '/');
                setcookie("pass", $_COOKIE['pass'], time() + 50000, '/');
                $id = $_SESSION['id'];
                $this->lastAct($id);
                return true;
            } else {
                $rez = $this->db->query("SELECT * FROM users WHERE id = '{$_SESSION['id']}'");

                if ($this->db->numRows($rez) == 1) {
                    $row = $this->db->getAll("SELECT * FROM users WHERE mail = ?s", $_POST['mail'])[0];
                    setcookie("mail", $row['mail'], time() + 50000, '/');
                    setcookie("pass", md5($row['mail'] . $row['password']), time() + 50000, '/');
                    $id = $_SESSION['id'];
                    $this->lastAct($id);
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            if (isset($_COOKIE['mail']) && isset($_COOKIE['pass'])) {
                $rez = $this->db->query("SELECT * FROM users WHERE mail = '{$_COOKIE['mail']}'");
                $row = $this->db->getAll("SELECT * FROM users WHERE mail = ?s", $_POST['mail'])[0];

                if ($this->db->numRows($rez) == 1 && md5($row['mail'] . $row['password']) == $_COOKIE['pass']) {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['status'] = $row['status'];
                    // require_once( get_theme_file_path('/components/CloudPayments/CloudPayments.php') );
                    // $payment = new CloudPayment;
                    // $_SESSION['status'] = '$payment->checkPayStatusDB()';
                    $id = $_SESSION['id'];
                    $this->lastAct($id);
                    return true;
                } else {
                    setcookie("mail", "", time() - 360000, '/');
                    setcookie("pass", "", time() - 360000, '/');
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function callLog($tg_log)
    {
        if ($tg_log['status']) {
            $_POST['mail'] = $tg_log['data']['username'];
            $_POST['pass'] = $tg_log['data']['hash'];
            $_POST['auth_btn'] = true;
        }

        if ($this->login()) {
            $UID = $_SESSION['id'];
            $error = [];
            $error['status'] = true;
            if ($tg_log['status']) {
                header('Location: account');
                exit();
            } else {
                echo json_encode($error);
            }
        } else {
            if (isset($_POST['auth_btn'])) {
                $error = $this->enter();
                if (count($error) == 0) {
                    $UID = $_SESSION['id'];
                    $error['status'] = true;
                    $error['id'] = $UID;
                    if ($tg_log['status']) {
                        echo json_encode($error);
                        header('Location: account');
                    } else {
                        echo json_encode($error);
                    }
                } else {
                    $error['status'] = false;
                    echo json_encode($error);
                }
            }
        }
    }

    public function out()
    {
        ini_set("session.use_trans_sid", true);
        session_start();
        $id = $_SESSION['id'];

        $this->db->query("UPDATE users SET online = 0 WHERE id = '$id'");
        unset($_SESSION['id']);
        unset($_SESSION['status']);
        setcookie("mail", "", time() - 1, '/');
        setcookie("pass", "", time() - 1, '/');

        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
    }
}

    