<?php
/**
 * Template Name: admin
 *
 
 */
get_header();
require_once( get_theme_file_path('processing.php') );
$subscription = new Subscription();
if($subscription->getCheckAdmin()){



    class ViewSubscription {
        private $subscriptions;
        private $createdPayment;
    
        public function __construct() {
            // Загрузка данных из базы данных и инициализация свойств $subscriptions и $createdPayment
            $this->subscriptions = $this->loadDataFromDatabase();
            $this->createdPayment = $this->loadCreatedPaymentFromDatabase();
        }
    
        // 1. Получение данных из таблицы subscription и проверка статуса
        public function getSubscriptionData() {
            $subscriptionData = array();
    
            foreach ($this->subscriptions as $subscription) {
                // Проверка статуса
                if ($subscription['status'] === 'active') {
                    $subscriptionData[] = $subscription;
                }
            }
    
            return $subscriptionData;
        }
    
        // 2. Получение всех строк из конкретного столбца
        public function getColumnData($columnName) {
            $columnData = array();

            foreach ($this->subscriptions as $subscription) {
                if (isset($subscription[$columnName])) {
                    $columnData[] = $subscription[$columnName];
                }
            }

            return $columnData;
        }
    
        // 3. Вывод одной конкретной строки из таблицы subscription
        public function getSubscriptionById($id) {
            foreach ($this->subscriptions as $subscription) {
                if ($subscription['id'] === $id) {
                    return $subscription;
                }
            }
    
            return null; // Если запись с указанным id не найдена
        }
    
        // 4. Получение даты открытия следующего урока
        public function getNextLessonDate($cat) {
            $lessonCount = count($this->getCatData($cat));
            // $today = date('Y-m-d');
            // $subscriptionDays = date('Y-m-d', strtotime($today) - strtotime($this->createdPayment));
            $now = new DateTime();
            $date = new DateTime($this->createdPayment);
            $subscriptionDays = $date->diff($now)->format("%a");
            $daysInterval = $this->getDaysInterval($cat);
            $nextLessonDays = $daysInterval - $subscriptionDays;

            // $nextLessonDays = $lessonCount * $daysInterval + $daysInterval - $subscriptionDays;
            $nextLessonDate = date('Y-m-d', strtotime("+$nextLessonDays days"));
    
            if ($cat === 'recomendations') {
                $nextLessonDate = null; // Уроки открыты всегда, не нужно определять следующую дату
            }
    
            return $nextLessonDate;
        }
    
        // 5. Получение массива данных из БД по конкретному значению cat
        public function getCatData($cat) {
            $catData = array();
    
            foreach ($this->subscriptions as $subscription) {
                if ($subscription['cat'] === $cat) {
                    $catData[] = $subscription;
                }
            }
            return $catData;
        }
    
        // 6. Получение массива данных из БД с конкретным тегом или тегами
        public function getDataByTag($tags) {
            $tagData = array();
            if (!empty($tags)) {
                $tagsArray = explode(',', $tags);
                foreach ($this->subscriptions as $subscription) {
                    foreach ($tagsArray as $tag) {
                            if (strpos($subscription['tags'], $tag) !== false) {
                                $tagData[] = $subscription;
                                break;
                            }
                        
                    }
                }
            }
            
            return $tagData;
        }
    
        // 7. Получение количества открытых постов конкретной категории
        public function getOpenPostCount($cat) {
            $daysInterval = $this->getDaysInterval($cat);
            $today = date('Y-m-d');
            $subscriptionDays = (strtotime($today) - strtotime($this->createdPayment)) / 86400; // секунды в сутках;
            $openPosts = floor($subscriptionDays / $daysInterval);
            return $openPosts;
        }
    
        // 8. Получение массива открытых постов
        public function getOpenPosts($cat) {
            $openPostCount = $this->getOpenPostCount($cat);
            return array_slice($this->subscriptions, 0, $openPostCount);
        }
    
        // 9. Проверка конкретного поста на статус
        public function checkPostStatus($id) {
            $cat = $this->getCatById($id);
            $daysInterval = $this->getDaysInterval($cat);
            $openPosts = $this->getOpenPostCount($cat);
            if ($id <= $openPosts) {
                return true;
            } else {
                return false;
            }
        }
    
        // 10. Получение сегодняшнего урока
        public function getTodayLesson($cat) {
            // $daysInterval = $this->getDaysInterval($cat);
            // $openPostCount = $this->getOpenPostCount($cat);
            $openPosts = $this->getOpenPosts($cat);
            return end($openPosts);
        }
    
        // 11. Получение интервала дней в зависимости от категории
        public function getDaysInterval($cat) {
            if ($cat === 'themes') {
                return 7;
            } else if ($cat === 'daily') {
                return 1;
            } else {
                return null;
            }
        }
        
        // 12. Получить категорию по id
        public function getCatById($id) {
            foreach ($this->subscriptions as $subscription) {
                if ($subscription['id'] === $id) {
                    return $subscription['cat'];
                }
            }
            return null; // Если запись с указанным id не найдена
        }

        // 13. Добавление нового поста в базу данных и массив $subscriptions
        public function addPost($cat, $status, $title, $description, $tags, $photo, $video, $audio, $link) {
            // Добавление данных в базу данных
            $db = new SafeMySQL();
            $db->query("INSERT INTO subscription (cat, status, title, description, tags, photo, video, audio, link) VALUES (?s, ?s, ?s, ?s, ?s, ?s, ?s, ?s, ?s)",
            $cat,
            $status,
            $title,
            $description,
            $tags,
            $photo,
            $video,
            $audio,
            $link);
        }

    // 14. Проверка наличия поста и пользователя в БД + updatePostAccess()
    public function togglePostAccess($postId, $userId, $access) {
        $post = $this->getSubscriptionById($postId);
        $user = $_SESSION['id'];
        
        if ($post && $user) {
            if($this->updatePostAccess($postId, $userId, $access)){
                return true; // Успешное выполнение операции
            }else{
                return false; 
            
            }
        }
        return false; // Невозможно открыть или закрыть доступ
        
    }
    
    // 15. Обновление состояния доступа к посту для пользователя
    private function updatePostAccess($postId, $userId, $access) {
        $db = new SafeMySQL();
        
        // Проверка наличия записи в таблице post_access
        $existingAccess = $db->getOne("SELECT access FROM post_access WHERE post_id = ?i AND user_id = ?i", $postId, $userId);
        
        if ($existingAccess !== null) {
            // Обновление состояния доступа в таблице post_access
            $res = $db->query("UPDATE post_access SET access = ?s WHERE post_id = ?i AND user_id = ?i", $access, $postId, $userId);
        } else {
            // Создание новой записи в таблице post_access
            $res = $db->query("INSERT INTO post_access (post_id, user_id, access) VALUES (?i, ?i, ?i)", $postId, $userId, $access);
        }
        return $res;
        // // Обновление состояния доступа в объекте subscriptions, если данные хранятся в памяти
        // $post = $this->getSubscriptionById($postId);
        // if ($post) {
        //     $post->access = $access;
        // }
    }

        // Загрузка данных из базы данных
        private function loadDataFromDatabase() {
            $db = new SafeMySQL();
            $data = $db->getAll("SELECT * FROM subscription");
    
            return $data;
        }
    
        // Загрузка даты создания платежа пользователя из базы данных
        private function loadCreatedPaymentFromDatabase() {
            $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
            if ($userId) {
                $db = new SafeMySQL();
                $createdPayment = $db->getOne("SELECT created_payment FROM users WHERE id = ?i", $userId);
                return $createdPayment;
            }
    
            return null;
        }
    }
    
    $subscription= new ViewSubscription();
    var_dump($subscription->togglePostAccess('1', '190', 1));
    // var_dump($subscription->getCatData($cat))
    // var_dump($subscription->addPost('daily', 'active', "title", 'description', '', '', '', '', ''));
?>



<form action="admin_check" method="post">
    <div id="token-fields">
        <div class="token-field">
            <label for="email">Email:</label>
            <input type="email" name="email[]" required>

            <label for="token">Token:</label>
            <input type="text" name="token[]" required>

            <label for="info">Info:</label>
            <input type="text" name="info[]" required>

            <button type="button" class="delete-field">Delete</button>
        </div>
    </div>

    <button type="button" id="add-field">Add Field</button>
    <input type="submit" value="Submit">
</form>




<script>
document.addEventListener("DOMContentLoaded", function() {
    const addFieldButton = document.getElementById("add-field");
    const tokenFields = document.getElementById("token-fields");

    addFieldButton.addEventListener("click", function() {
        const fieldContainer = document.createElement("div");
        fieldContainer.className = "token-field";

        const emailInput = document.createElement("input");
        emailInput.type = "email";
        emailInput.name = "email[]";
        emailInput.required = true;

        const tokenInput = document.createElement("input");
        tokenInput.type = "text";
        tokenInput.name = "token[]";
        tokenInput.required = true;

        const infoInput = document.createElement("input");
        infoInput.type = "text";
        infoInput.name = "info[]";
        infoInput.required = true;

        const deleteButton = document.createElement("button");
        deleteButton.type = "button";
        deleteButton.className = "delete-field";
        deleteButton.textContent = "Delete";

        deleteButton.addEventListener("click", function() {
            fieldContainer.remove();
        });

        fieldContainer.appendChild(emailInput);
        fieldContainer.appendChild(tokenInput);
        fieldContainer.appendChild(infoInput);
        fieldContainer.appendChild(deleteButton);

        tokenFields.appendChild(fieldContainer);
    });

    const deleteButtons = document.getElementsByClassName("delete-field");
    for (const deleteButton of deleteButtons) {
        deleteButton.addEventListener("click", function() {
            deleteButton.parentNode.remove();
        });
    }
});
</script>














<h2>Добавление/Обновление ролей</h2>

<form action="admin_check" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="">--Выберите статус--</option>
        <?php
            $status_options = $db->getAll("SELECT * FROM status");
            foreach ($status_options as $key => $value) {
                echo "<option value='" . ($key + 1) . "'>" . $value['name'] . "</option>";
            }
        ?>
    </select>

    <label for="pay_choice">Цена:</label>
    <?php
        $pay_options = $db->getAll("SELECT * FROM services");
        foreach ($pay_options as $key => $value) {
            echo "<input type='radio' id='pay_choice" . ($key + 1) . "' name='pay_choice' value='" . ($key + 1) . "' required>";
            echo "<label for='pay_choice" . ($key + 1) . "'>" . $value['price'] . "</label>";
        }
    ?>
    <input type="number" id="weeks" name="weeks" style="display: none;">

    <input type="submit" value="Отправить">
</form>

<script>
document.getElementById('status').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex].value;
    var weeksInput = document.getElementById('weeks');

    if (selectedOption === '3') {
        weeksInput.style.display = 'block';
    } else {
        weeksInput.style.display = 'none';
    }
});
</script>






<h2>Добавить промокод</h2>
<form action="admin_check" method="post">
    <label for="promo">Промокод (заглавными буквами):</label>
    <input type="text" id="promo" name="promo" required><br>

    <label for="sale">Скидка (от 1 до 100):</label>
    <input type="number" id="sale" name="sale" min="1" max="100" required onchange="togglePaidDays()"><br>

    <label for="first_date">Дата начала действия промокода:</label>
    <input type="date" id="first_date" name="first_date" required><br>

    <label for="last_date">Дата окончания действия промокода:</label>
    <input type="date" id="last_date" name="last_date"><br>

    <div id="paid_days_container" style="display: none;">
        <label for="paid_days">Количество дней оплаченной подписки:</label>
        <input type="number" id="paid_days" name="paid_days" min="1" max="365"><br>
    </div>

    <input type="submit" value="Отправить">
</form>

<script>
function togglePaidDays() {
    var saleInput = document.getElementById("sale");
    var paidDaysContainer = document.getElementById("paid_days_container");
    if (saleInput.value == 100) {
        paidDaysContainer.style.display = "block";
    } else {
        paidDaysContainer.style.display = "none";
    }
}
</script>




<?php 
    }; 
    get_footer(); 
?>






<!-- 
<br><br><br>

<br><br><br><br>


<div class="add_post">
    <h2>
        Добавить запись
    </h2>
    <form action="admin_check">
        <input name="title" type="text">
        <input name="excerpt" type="text">
        <input name="content" type="text">
        <?php
            // $categories = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name', 'hide_empty' => 0 ) );
            // if( $categories ){
            //     foreach ( $categories as $cat ){
            //         echo "<input type=\"radio\" name=\"category\" id=\"{$cat->term_id}\" value=\"{$cat->term_id}\">{$cat->name}</input>";
            //     }
            // };
        ?>
        <input name="add_post" type="submit">
    </form>
</div>
<div class="add_payment_user">
    <h2>Добавить пользователя, который оплатил</h2>
    <form action="admin_check">
        <input name="add_payment_mail" type="text">
        <input name="add_payment_choice" type="number">
        <input name="add_payment_mail" type="text">
    </form>
</div>



<br><br><br><br> -->