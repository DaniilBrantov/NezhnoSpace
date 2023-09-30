
<?php
require_once( get_theme_file_path('processing.php') );




class AlarmManager
{
    protected $db;

    public function __construct()
    {
        // Инициализируем соединение с базой данных один раз в конструкторе
        $this->db = new SafeMySQL();
    }

    public function createAlarm($text, $tagId)
    {
        // Проверяем, что текст тревоги не превышает 100 символов
        if (strlen($text) > 100) {
            return "Текст тревоги должен быть не более 100 символов.";
        }
    
        // Проверяем, существует ли тревога с указанным текстом
        $query = "SELECT id FROM TagDescriptions WHERE description = ?s";
        $result = $this->db->query($query, $text);
    
        if ($this->db->numRows($result) === 0) {
            // Проверяем, существует ли тег с указанным id в таблице Tags
            $query = "SELECT id FROM Tags WHERE id = ?i";
            $result = $this->db->query($query, $tagId);

            if ($this->db->numRows($result) === 0) {
                return "Тег с указанным id не существует.";
            }else{
                // Вставляем новую тревогу в таблицу TagDescriptions 
                $query = "INSERT INTO TagDescriptions (description, tag_id) VALUES (?s, ?i)";
                $result = $this->db->query($query, $text, $tagId);
            
                if ($result) {
                    return "Тревога успешно создана.";
                } else {
                    return "Произошла ошибка при создании тревоги.";
                }
            }

            
        }else{
            return "Такая тревога уже существует.";
        }
    }    
    public function createTag($name, $cat)
    {
        // Проверяем, что имя тега не превышает 50 символов
        if (strlen($name) > 50) {
            return "Имя тега должно быть не более 50 символов.";
        }

        // Проверяем, существует ли тревога с указанным текстом
        $query = "SELECT id FROM Tags WHERE name = ?s";
        $result = $this->db->query($query, $name);
    
        if ($this->db->numRows($result) > 0) {
            return "Такая тревога уже существует.";
        }

        // Вставляем новый тег в таблицу Tags
        $query = "INSERT INTO Tags (name, cat) VALUES (?s, ?s)";
        $result = $this->db->query($query, $name, $cat);

        if ($result) {
            return "Тег успешно создан.";
        } else {
            return "Произошла ошибка при создании тега.";
        }
    }

    public function updateTagDescription($tagDescriptionId, $tagId, $newDescription)
    {

        // Проверяем, существует ли тревога с указанным текстом и tag_id
        $query = "SELECT id FROM TagDescriptions WHERE description = ?s";
        $result = $this->db->query($query, $text);

        $tag_query = "SELECT id FROM Tags WHERE id = ?i";
        $tag_result = $this->db->query($query, $text);

        if($this->db->numRows($tag_result) > 0){
            
            if ($this->db->numRows($result) > 0) {
                // Обновляем описание тега в таблице TagDescriptions
                $query = "UPDATE TagDescriptions SET description=?s WHERE id=?i";
                $result = $this->db->query($query, $newDescription, $tagDescriptionId);

                if ($result) {
                    return "Описание тега успешно обновлено.";
                } else {
                    return "Произошла ошибка при обновлении описания тега.";
                }
            }else{
                return "Такая тревога не существует.";
            }
        }
        
    }

    public function deleteTagDescription($tagDescriptionId)
    {
        // Удаляем запись описания тега из таблицы TagDescriptions
        $query = "DELETE FROM TagDescriptions WHERE id=?i";
        $result = $this->db->query($query, $tagDescriptionId);

        if ($result) {
            return "Описание тега успешно удалено.";
        } else {
            return "Произошла ошибка при удалении описания тега.";
        }
    }

    public function updateTagName($tagId, $newName)
    {
        // Проверяем, существует ли тревога с указанным текстом
        $query = "SELECT id FROM Tags WHERE name = ?s";
        $result = $this->db->query($query, $name);
    
            // Обновляем имя тега в таблице Tags
            $query = "UPDATE Tags SET name=?s WHERE id=?i";
            $result = $this->db->query($query, $newName, $tagId);

            if ($result) {
                return "Имя тега успешно обновлено.";
            } else {
                return "Произошла ошибка при обновлении имени тега.";
            }
    }

    public function deleteTag($tagId)
    {
        // Удаляем тег из таблицы Tags
        $query = "DELETE FROM Tags WHERE id=?i";
        $result = $this->db->query($query, $tagId);

        if ($result) {
            return "Тег успешно удален.";
        } else {
            return "Произошла ошибка при удалении тега.";
        }
    }

    public function getTagDescriptions()
    {
        // Получаем данные из таблицы TagDescriptions
        $query = "SELECT * FROM TagDescriptions";
        return $this->db->getAll($query);
    }

    public function getTags()
    {
        // Получаем данные из таблицы Tags
        $query = "SELECT * FROM Tags";
        return $this->db->getAll($query);
    }
}


// Создание объекта AlarmManager
$alarmManager = new AlarmManager();


// // Обновление описания тега
// $updateTagDescriptionResult = $alarmManager->updateTagDescription(1, "Я заедаю эмоции: радость, боль, страх или гнев");
// echo $updateTagDescriptionResult . "<br>";



// // Создания тега
// $createTagResult = $alarmManager->createTag("Emotional regulation", "Emotional regulation and self-awareness");
// echo $createTagResult . "<br>";

// // Обновления тега
// $updateTagNameResult = $alarmManager->updateTagName(1, "Emotional regulation");
// echo $updateTagNameResult . "<br>";




// // Вывод тревог
$tagDescriptions = $alarmManager->getTagDescriptions();
// echo "Список описаний тегов: <pre>" . print_r($tagDescriptions, true) . "</pre>";

// // Вывод тегов
$tags = $alarmManager->getTags();
// echo "Список тегов: <pre>" . print_r($tags, true) . "</pre>";
// ?>
<div class="admin_anxiety">
    <span>Список тревог</span>
    <div class="anxiety_desc" id="anxiety-list">
        <?php
        foreach ($tagDescriptions as $anxiety) {
            echo '<p>' . $anxiety['description'] . ' - ';
            foreach ($tags as $tag) {
                if ($anxiety['tag_id'] == $tag['id']) {
                    echo '<span>' . $tag['name'] . '</span>';
                }
            }
            // Добавляем кнопку удаления тревоги
            echo '<button onclick="deleteAnxiety(' . $anxiety['id'] . ')">Удалить</button>';
            echo '</p>';
        }
        ?>
    </div>
</div>

<div class="add_anxiety">
    <span>Добавить Тревогу</span>
    <form id="addAnxietyForm">
        <input name="anxiety" type="text">
        <select name="tag" id="anxietyTagSelect">
            <?php
            foreach ($tags as $tag) {
                echo '<option value="' . $tag['id'] . '">' . $tag['name'] . '</option>';
            }
            ?>
        </select>
        <button class="add_anxiety_btn">Создать Тревогу</button>
    </form>
</div>

<div class="update_anxiety">
    <span>Обновить Тревогу</span>
    <form id="updateAnxietyForm">
        <select name="anxiety" id="updateAnxietySelect">
            <?php
            foreach ($tagDescriptions as $anxiety) {
                echo '<option value="' . $anxiety['id'] . '">' . $anxiety['description'] . '</option>';
            }
            ?>
        </select>
        <input name="update_anxiety" type="text">
        <select name="tag" id="updateAnxietyTagSelect">
            <?php
            foreach ($tags as $tag) {
                echo '<option value="' . $tag['id'] . '">' . $tag['name'] . '</option>';
            }
            ?>
        </select>
        <button class="update_anxiety_btn">Обновить Тревогу</button>
    </form>
</div>

<div class="admin_tags">
    <span>Теги</span>
    <div class="tags_desc" id="tag-list">
        <?php
        foreach ($tags as $tag) {
            echo '<p>' . $tag['name'] . ' - ' . $tag['cat'] . ' ';
            // Добавляем кнопку удаления тега
            echo '<button onclick="deleteTag(' . $tag['id'] . ')">Удалить</button>';
            echo '</p>';
        }
        ?>
    </div>
</div>

<script>
    
</script>














<!-- Try Free --> 

 <div class="try_free_slider" style="width:390px;">
</div>


        <section class="subs">
            <div class="container">
                <h1 class="subs-header">Что ВЫ получите в подписке?</h1>
                <p class="subs-paragraph">
                    Приобретая подписку, ты получаешь доступ к личному кабинету.<br><br>
                    Затем, на основе опроса, разработанные нами алгоритмы сформируют для тебя индивидуальную подборку упражнений, практик и рекомендаций. Ты можешь корректировать ее, отмечая понравившиеся материалы.
                </p>
                <div class="subs-items">
                        <div class="subs-items__item">
                            <img src="./svg/Group160.svg" alt="" class="item_img">
                            <p class="subs-item__item_s">Опрос</p>
                        </div>
                        <div class="subs-items__item">
                            <img src="./svg/Rectangle9.svg" alt="" class="item_img">
                            <p class="subs-item__item_s">Темы</p>
                        </div>
                        <div class="subs-items__item">
                            <img src="./svg/Rectangle10.svg" alt="" class="item_img">
                            <p class="subs-item__item_s">Ежедневные практики </p>
                        </div>
                        <div class="subs-items__item">
                            <img src="./svg/Rectangle11.svg" alt="" class="item_img">
                            <p class="subs-item__item_s">Упражнения</p>
                        </div>
                </div>
            </div>
        </section>
        <section class="theme">
                <ul class="theme-card">
                    <li class="theme-card__item">
                        <h2 class="theme-card__header">
                        Темы
                        </h2>
                        <p class="theme-card__paragraph">У нас есть более 30 тем, из которых ты сможешь выбрать те, над которыми хотелось бы поработать, например:</p>
                         <ul class="theme-card__list">
                            <li class="theme-card__items">
                                качество жизни,
                            </li>
                            <li class="theme-card__items">
                                карьера,
                            </li>
                            <li class="theme-card__items">
                                деньги,
                            </li>
                            <li class="theme-card__items">
                                отношения,
                            </li>
                            <li class="theme-card__items">
                                семья,
                            </li>
                            <li class="theme-card__items">
                                секс,
                            </li>
                            <li class="theme-card__items">
                                тело,
                            </li>
                            <li class="theme-card__items">
                                самооценка,
                            </li>
                        </ul>
                    <p class="theme-card__paragraph">Мы не будем торопить тебя с прохождением тем, ты можешь оставаться в выбранной теме столько, сколько считаешь нужным.</p>
                </li>
                <li class="theme-card__item">
                    <h2 class="theme-card__header">
                        Ежедневные практики
                        </h2>
                        <p class="theme-card__paragraph">Сформируют у тебя привычку замечать свои желания, эмоции, потребности, сигналы голода и насыщения.</p>
                </li>
                <li class="theme-card__item">
                    <h2 class="theme-card__header">
                        Упражнения
                        </h2>
                        <p class="theme-card__paragraph">Методики гештальта, когнитивно-поведенческой,  семейной и телесно-ориентированной терапии подбираются для тебя искусственным интеллектом.</p>
                </li>
                </ul>
         </section>      



         
         




