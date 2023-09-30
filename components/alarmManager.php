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
            return [
                'status' => false,
                'message' => "Текст тревоги должен быть не более 100 символов."
            ];
        }
    
        // Проверяем, существует ли тревога с указанным текстом
        $query = "SELECT id FROM TagDescriptions WHERE description = ?s";
        $result = $this->db->query($query, $text);
    
        if ($this->db->numRows($result) === 0) {
            // Проверяем, существует ли тег с указанным id в таблице Tags
            $query = "SELECT id FROM Tags WHERE id = ?i";
            $result = $this->db->query($query, $tagId);

            if ($this->db->numRows($result) === 0) {
                return [
                    'status' => false,
                    'message' => "Тег с указанным id не существует."
                ];
            } else {
                // Вставляем новую тревогу в таблицу TagDescriptions 
                $query = "INSERT INTO TagDescriptions (description, tag_id) VALUES (?s, ?i)";
                $insertResult = $this->db->query($query, $text, $tagId);
            
                if ($insertResult) {
                    return [
                        'status' => true,
                        'message' => "Тревога успешно создана."
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => "Произошла ошибка при создании тревоги."
                    ];
                }
            }
        } else {
            return [
                'status' => false,
                'message' => "Такая тревога уже существует."
            ];
        }
    }    

    public function createTag($name, $cat)
    {
        // Проверяем, что имя тега не превышает 50 символов
        if (strlen($name) > 50) {
            return [
                'status' => false,
                'message' => "Имя тега должно быть не более 50 символов."
            ];
        }

        // Проверяем, существует ли тревога с указанным текстом
        $query = "SELECT id FROM Tags WHERE name = ?s";
        $result = $this->db->query($query, $name);
    
        if ($this->db->numRows($result) > 0) {
            return [
                'status' => false,
                'message' => "Такая тревога уже существует."
            ];
        }

        // Вставляем новый тег в таблицу Tags
        $query = "INSERT INTO Tags (name, cat) VALUES (?s, ?s)";
        $insertResult = $this->db->query($query, $name, $cat);

        if ($insertResult) {
            return [
                'status' => true,
                'message' => "Тег успешно создан."
            ];
        } else {
            return [
                'status' => false,
                'message' => "Произошла ошибка при создании тега."
            ];
        }
    }

    public function updateTagDescription($tagDescriptionId, $tagId, $newDescription)
    {

        // Проверяем, существует ли тревога с указанным текстом и tag_id
        $query = "SELECT id FROM TagDescriptions WHERE id = ?i";
        $result = $this->db->query($query, $tagDescriptionId);

        $tag_query = "SELECT id FROM Tags WHERE id = ?i";
        $tag_result = $this->db->query($tag_query, $tagId);

        if ($this->db->numRows($tag_result) > 0){
            
            if ($this->db->numRows($result) > 0) {
                // Обновляем описание тега в таблице TagDescriptions
                $query = "UPDATE TagDescriptions SET description=?s WHERE id=?i";
                $updateResult = $this->db->query($query, $newDescription, $tagDescriptionId);

                if ($updateResult) {
                    return [
                        'status' => true,
                        'message' => "Описание тега успешно обновлено."
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => "Произошла ошибка при обновлении описания тега."
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'message' => "Такая тревога не существует."
                ];
            }
        }
        
    }

    public function deleteTagDescription($tagDescriptionId)
    {
        // Удаляем запись описания тега из таблицы TagDescriptions
        $query = "DELETE FROM TagDescriptions WHERE id=?i";
        $deleteResult = $this->db->query($query, $tagDescriptionId);

        if ($deleteResult) {
            return [
                'status' => true,
                'message' => "Описание тега успешно удалено."
            ];
        } else {
            return [
                'status' => false,
                'message' => "Произошла ошибка при удалении описания тега."
            ];
        }
    }

    public function updateTagName($tagId, $newName)
    {
        // Проверяем, существует ли тревога с указанным текстом
        $query = "SELECT id FROM Tags WHERE id = ?i";
        $result = $this->db->query($query, $tagId);
    
        if ($this->db->numRows($result) > 0) {
            // Обновляем имя тега в таблице Tags
            $query = "UPDATE Tags SET name=?s WHERE id=?i";
            $updateResult = $this->db->query($query, $newName, $tagId);

            if ($updateResult) {
                return [
                    'status' => true,
                    'message' => "Имя тега успешно обновлено."
                ];
            } else {
                return [
                    'status' => false,
                    'message' => "Произошла ошибка при обновлении имени тега."
                ];
            }
        } else {
            return [
                'status' => false,
                'message' => "Тег с указанным id не существует."
            ];
        }
    }

    public function deleteTag($tagId)
    {
        // Удаляем тег из таблицы Tags
        $query = "DELETE FROM Tags WHERE id=?i";
        $deleteResult = $this->db->query($query, $tagId);

        if ($deleteResult) {
            return [
                'status' => true,
                'message' => "Тег успешно удален."
            ];
        } else {
            return [
                'status' => false,
                'message' => "Произошла ошибка при удалении тега."
            ];
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

?>