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
    // ...

    public function getFirstName($val)
    {
        return $this->FieldLength($val, "Введите Имя");
    }

    public function getLastName($val)
    {
        return $this->FieldLength($val, "Введите Фамилию");
    }

    public function MatchingPasswords($pass, $pass_conf)
    {
        if ($pass === $pass_conf) {
            return 0;
        } else {
            return "Повторный пароль введен не верно!";
        }
    }

    public function getCoincidenceUser($val)
    {
        if (!$this->getEmail($val)) {
            return $this->CoincidenceUser($val);
        } else {
            return $this->getEmail($val);
        }
    }

    public function getEmail($val)
    {
        $field_length = $this->FieldLength($val, "Введите Email");
        if ($field_length === 0) {
            if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $val)) {
                return $field_length;
            } else {
                return 'Неверно введен e-mail';
            }
        } else {
            return $field_length;
        }
    }

    public function getPassword($val)
    {
        $field_length = $this->FieldLength($val, "Введите Пароль");
        if ($field_length === 0) {
            if (!preg_match('/^\S*(?=\S{8,30})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $val)) {
                return "Слабый пароль";
            } else {
                return $field_length;
            }
        } else {
            return $field_length;
        }
    }

    public function getTelephone($val)
    {
        if (preg_match("/^[0-9]{11,11}+$/", $val)) {
            $first = substr($val, 0, 1);
            if ($first != '7') {
                return "Некорректный номер телефона";
            } else {
                return 0;
            }
        } else {
            return "Телефон задан в неверном формате";
        }
    }

    public function getBirthdate($val)
    {
        if (time() > strtotime($val)) {
            if (time() < strtotime('+18 years', strtotime($val))) {
                return "Вам меньше 18 лет";
            } else {
                return 0;
            }
        } else {
            return "Введите свою дату рождения";
        }
    }

    public function getCheckTokens($mail, $token)
    {
        return $this->checkTokens($mail, $token);
    }

    public function getCheckId($id)
    {
        return $this->checkId($id);
    }

    protected function checkId($id)
    {
        $db = new SafeMySQL();
        $existingUser = $db->query("SELECT id FROM users WHERE id=?i", $id);
        if ($db->numRows($existingUser) > 0) {
            $error['status'] = 0;
            $error['msg'] = "Такой пользователь уже существует";
            return $error;
        } else {
            return $error['status'] = 1;
        }
    }

    protected function checkTokens($mail, $token)
    {
        $db = new SafeMySQL();
        $sql = $db->getAll("SELECT * FROM tokens WHERE mail=?s AND token=?s", $mail, $token)[0];
        $info_sql = $sql['info'];
        $token = $sql['token'];
        $info_sql = json_decode($info_sql);
        $error = [];
        if (isset($sql) && !empty($sql)) {
            $user_sql = $db->query("SELECT mail FROM users WHERE mail=?s", $mail);
            $status = $info_sql->status;
            $pay_choice = $info_sql->pay_choice;
            $date = $info_sql->date;
            if ($db->numRows($user_sql) > 0) {
                $user_up = $db->query("UPDATE users SET status='$status', pay_choice='$pay_choice', payment_date='$date', created_payment='$date' WHERE mail='$mail'");
                $error['status'] = 2;
                $error['info'] = $info_sql;
                $error['token'] = $token;
            } else {
                $error['status'] = 1;
                $error['info'] = $info_sql;
                $error['token'] = $token;
            }
        } else {
            $error['status'] = 0;
            $error['msg'] = "Проверьте вашу почту";
        }
        return $error;
    }

    protected function FieldLength($full_name, $error)
    {
        if ($full_name == "") {
            return $error;
        } elseif (mb_strlen($full_name) < 3 || mb_strlen($full_name) > 50) {
            $error = "Недопустимая длина";
            return $error;
        } else {
            return 0;
        }
    }

    protected function CoincidenceUser($val)
    {
        $db = new SafeMySQL();
        if ($check_user = $db->query("SELECT mail FROM users WHERE mail=?s", $val)) {
            if ($db->numRows($check_user) > 0) {
                return 'Такой пользователь уже существует';
            } else {
                return '';
            }
        } else {
            return "Произошла неизвестная ошибка";
        }
    }

}






class Subscription {
    // Получить данные с каждого поста конкретной категории
    public function getCatData($cat_ID) {
        $res = [];

        if (have_posts()) {
            query_posts(array('orderby' => 'date', 'order' => 'ASC', 'cat' => $cat_ID));

            $res = $this->checkCatData($cat_ID);

            wp_reset_query();
        }

        return $res;
    }

    // Получить вывод постов под конкретным тэгом
    public function getTagPosts() {
        return $this->tagPosts();
    }

    // Получить данные с конкретного поста
    public function getPostData($id) {
        return $this->postData($id);
    }

    // Получить дату следующего поста
    public function getNextPostDate($close_posts, $cat_ID) {
        return $this->nextPostDate($close_posts, $cat_ID);
    }

    // Получить кол-во открытых постов конкретной категории
    public function getCountOpenCatPosts($cat_ID) {
        return $this->countOpenCatPosts($cat_ID);
    }

    // Получить массив из открытых постов конкретной категории
    public function getOpenCatPosts($cat_ID) {
        return $this->openCatPosts($cat_ID);
    }

    // Массив из закрытых постов конкретной категории
    public function getCloseCatPosts($cat_ID) {
        return $this->closeCatPosts($cat_ID);
    }

    // Получить сегодняшнюю ежедневную практику
    public function getTodayPractice($cat_ID) {
        return $this->todayPractice($cat_ID);
    }

    // Получить данные записи для вывода на страницу. С проверкой оплаты
    public function getSubscriptionLesson($id) {
        return $this->subscriptionLesson($id);
    }

    // Получить данные проверки админки
    public function getCheckAdmin() {
        return $this->checkAdmin();
    }
    

    // Проверка админки
    protected function checkAdmin() {
        require_once(get_theme_file_path('processing.php'));
        session_start();
        $status = (new SafeMySQL())->getOne("SELECT status FROM users WHERE id = ?i", $_SESSION['id']);

        if ($status === '4') {
            return true;
        }

        header('Location: auth');
        exit();
    }

    // Вывод постов под конкретным тэгом
    protected function tagPosts() {
        $payment_date = $this->userPaymentDate();
        $payment = new Payment();
        $res = [];

        if (have_posts()) {
            $i = 1;
            $close = 1;

            while (have_posts()) {
                the_post();
                $cat_ID = get_the_category()[0]->cat_ID;
                $count_open_posts = $this->getCountOpenCatPosts($cat_ID);

                $res[$i] = $this->getPostData(get_the_ID());

                if ($payment->getCheckPayment()) {
                    if ($i < $count_open_posts) {
                        $res[$i]['status'] = true;
                    } else {
                        $res[$i]['status'] = false;
                    }
                } else {
                    $res[$i]['status'] = false;
                }

                if ($res[$i]['status']) {
                    $close = 0;
                }

                $i++;
            }

            if ($close) {
                $res = [];
            }
        }

        return $res;
    }

    // Получить данные с конкретного поста
    protected function postData($id) {
        $res = [];
        $post = get_post($id);
        $res['id'] = $id;
        $res['title'] = $post->post_title;
        $res['content'] = $post->post_content;
        $res['thumbnail'] = get_the_post_thumbnail_url($id, 'full');
        $res['audio'] = get_post_meta($id, 'audio_url', true);

        return $res;
    }

    // Получить дату следующего поста
    protected function nextPostDate($close_posts, $cat_ID) {
        $next_post_date = '';
        $payment = new Payment();
        $count_close_posts = count($close_posts);
        $count_open_posts = $this->getCountOpenCatPosts($cat_ID);

        if ($payment->getCheckPayment()) {
            if ($count_close_posts == 0 || $count_open_posts == 0) {
                $next_post_date = '';
            } elseif ($count_close_posts >= $count_open_posts) {
                $next_post_date = '';
            } else {
                $today = date('Y-m-d');
                $close_posts_dates = array_column($close_posts, 'post_date');

                foreach ($close_posts_dates as $date) {
                    if ($date > $today) {
                        $next_post_date = $date;
                        break;
                    }
                }
            }
        }

        return $next_post_date;
    }

    // Получить кол-во открытых постов конкретной категории
    protected function countOpenCatPosts($cat_ID) {
        $payment = new Payment();
        $count_open_posts = 0;

        if ($payment->getCheckPayment()) {
            $args = array(
                'post_type' => 'post',
                'cat' => $cat_ID,
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'status',
                        'value' => 'open',
                    ),
                ),
            );

            $count_open_posts = count(get_posts($args));
        }

        return $count_open_posts;
    }

    // Массив из открытых постов конкретной категории
    protected function openCatPosts($cat_ID) {
        $payment = new Payment();
        $open_posts = [];

        if ($payment->getCheckPayment()) {
            $args = array(
                'post_type' => 'post',
                'cat' => $cat_ID,
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'status',
                        'value' => 'open',
                    ),
                ),
            );

            $posts = get_posts($args);

            foreach ($posts as $post) {
                $open_posts[] = $this->getPostData($post->ID);
            }
        }

        return $open_posts;
    }

    // Массив из закрытых постов конкретной категории
    protected function closeCatPosts($cat_ID) {
        $payment = new Payment();
        $close_posts = [];

        if ($payment->getCheckPayment()) {
            $args = array(
                'post_type' => 'post',
                'cat' => $cat_ID,
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'status',
                        'value' => 'close',
                    ),
                ),
            );

            $posts = get_posts($args);

            foreach ($posts as $post) {
                $close_posts[] = $this->getPostData($post->ID);
            }
        }

        return $close_posts;
    }

    // Получить сегодняшнюю ежедневную практику
    protected function todayPractice($cat_ID) {
        $payment = new Payment();
        $today_practice = [];

        if ($payment->getCheckPayment()) {
            $args = array(
                'post_type' => 'post',
                'cat' => $cat_ID,
                'posts_per_page' => 1,
                'meta_query' => array(
                    array(
                        'key' => 'status',
                        'value' => 'open',
                    ),
                ),
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $today_practice = $this->getPostData(get_the_ID());
                }

                wp_reset_postdata();
            }
        }

        return $today_practice;
    }

    // Получить данные записи для вывода на страницу. С проверкой оплаты
    protected function subscriptionLesson($id) {
        $res = [];
        $payment = new Payment();
        $payment_date = $this->userPaymentDate();

        if ($payment->getCheckPayment()) {
            $res = $this->getPostData($id);
        }

        return $res;
    }

    // Получить дату оплаты пользователя
    protected function userPaymentDate() {
        require_once(get_theme_file_path('processing.php'));
        session_start();
        $user_id = $_SESSION['id'];
        $payment_date = (new SafeMySQL())->getOne("SELECT payment_date FROM users WHERE id = ?i", $user_id);

        return $payment_date;
    }
}








class Payment {
    // Получить проверку промокода
    public function getCheckPromocode($promo) {
        return $this->checkPromocode($promo);
    }

    // Получить проверку оплаты
    public function getCheckPayment() {
        return $this->checkPayment();
    }

    // Получить данные выбранной услуги
    public function getPaymentServiceData() {
        return $this->paymentServiceData();
    }

    // Проверка промокода
    protected function checkPromocode($promo) {
        $db = new SafeMySQL();
        $id = $_SESSION['id'];
        $promoData = $db->getRow("SELECT * FROM promocodes WHERE promo=?s", $promo);
        if ($promoData) {
            $today = date("Y-m-d");
            $firstDate = $promoData['first_date'];
            $lastDate = $promoData['last_date'];
            if (($today >= $firstDate && $today <= $lastDate) || ($lastDate === NULL && $today >= $firstDate)) {
                if ($promoData['sale'] >= 100) {
                    $paymentDate = date("Y-m-d H:i:s");
                    if ($db->query("UPDATE users SET status=?i, payment_date=?s WHERE id=?i", 3, $paymentDate, $id)) {
                        return [
                            'status' => true,
                            'promo' => $promoData['promo'],
                            'sale' => $promoData['sale']
                        ];
                    } else {
                        return [
                            'status' => false,
                            'msg' => "Ошибка при обновлении статуса пользователя!"
                        ];
                    }
                } else {
                    if ($promoData['promo'] === $promo) {
                        return [
                            'status' => true,
                            'promo' => $promoData['promo'],
                            'sale' => $promoData['sale']
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

    // Проверка оплаты
    protected function checkPayment() {
        $db = new SafeMySQL();
        $status = $db->getOne("SELECT status FROM users WHERE id=?i", $_SESSION['id']);
        if ($status && !empty($status) && isset($status) && $status !== NULL) {
            if ($status === '2') {
                return true;
            } elseif ($status === '3') {
                $mail = $db->getOne("SELECT mail FROM users WHERE id=?i", $_SESSION['id']);
                $infoSql = $db->getOne("SELECT info FROM tokens WHERE mail=?s", $mail);
                $infoSql = json_decode($infoSql);
                $weeks = $infoSql->weeks;
                if ($this->checkSubPromoDate($weeks)) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Получение данных выбранной услуги
    protected function paymentServiceData() {
        $db = new SafeMySQL();
        $serviceId = null;
        if (isset($_POST["payment_btn"]) || $_POST["payment_btn"] !== null) {
            $serviceId = $_POST["payment_id"];
        } elseif (isset($_GET["payment_choice"])) {
            $serviceId = $_GET["payment_choice"];
        }
    
        if (!$serviceId || !get_post_meta($serviceId, 'month_count', true) || !get_post_meta($serviceId, 'price', true)) {
            $serviceId = 944;
        }
    
        $mail = $db->getOne("SELECT mail FROM users WHERE id=?i", $_SESSION['id']);
    
        $res = [
            'service_number' => get_post_meta($serviceId, 'month_count', true),
            'price' => get_post_meta($serviceId, 'price', true),
            'description' => $mail . ' Купил услугу на ' . get_post_meta($serviceId, 'month_count', true) . ' месяц(ев)',
            'mail' => $mail
        ];
    
        return $res;
    }
    

    // Проверка срока подписки, заведённый промокодом
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