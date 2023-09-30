var currentURL = window.location.href;
if (currentURL.indexOf("testing_page") !== -1) {
    // JavaScript функция для удаления тревоги
    function deleteAnxiety(anxietyId) {
        // Отправить запрос на удаление тревоги с помощью AJAX
        let anxietyData = {
            anxietyId: anxietyId,
        };

        $.ajax({
            url: "delete_anxiety",
            type: "POST",
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            data: anxietyData,
            success: function(data) {

                if (data.status) {
                    // Обновить список тревог на странице
                    refreshAnxietyList();
                } else {
                    if (data.message) {
                        console.log('Ошибка при удалении тревоги: ' + data.message);
                    } else {
                        console.log('Ошибка при удалении тревоги.');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Ошибка при выполнении AJAX-запроса:', error);
            }
        });
    }


    // JavaScript функция для удаления тега
    function deleteTag(tagId) {
        // Отправить запрос на удаление тега с помощью AJAX
        fetch('/delete_tag.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ tagId: tagId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Обновить список тегов на странице
                refreshTagList();
            } else {
                alert('Ошибка при удалении тега: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Ошибка при выполнении AJAX-запроса:', error);
        });
    }

    // JavaScript функция для добавления тревоги
    document.getElementById("addAnxietyForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const anxietyText = document.querySelector("#addAnxietyForm input[name='anxiety']").value;
        const anxietyTagId = document.querySelector("#addAnxietyForm select[name='tag']").value;

        // Отправить запрос на добавление тревоги с помощью AJAX
        fetch('/add_anxiety.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ anxietyText: anxietyText, anxietyTagId: anxietyTagId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Обновить список тревог на странице
                refreshAnxietyList();
                // Очистить форму
                document.querySelector("#addAnxietyForm input[name='anxiety']").value = '';
            } else {
                alert('Ошибка при добавлении тревоги: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Ошибка при выполнении AJAX-запроса:', error);
        });
    });

    // JavaScript функция для обновления тревоги
    document.getElementById("updateAnxietyForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const anxietyId = document.querySelector("#updateAnxietyForm select[name='anxiety']").value;
        const newAnxietyText = document.querySelector("#updateAnxietyForm input[name='update_anxiety']").value;
        const newAnxietyTagId = document.querySelector("#updateAnxietyForm select[name='tag']").value;

        // Отправить запрос на обновление тревоги с помощью AJAX
        fetch('/update_anxiety.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ anxietyId: anxietyId, newAnxietyText: newAnxietyText, newAnxietyTagId: newAnxietyTagId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Обновить список тревог на странице
                refreshAnxietyList();
                // Очистить форму
                document.querySelector("#updateAnxietyForm input[name='update_anxiety']").value = '';
            } else {
                alert('Ошибка при обновлении тревоги: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Ошибка при выполнении AJAX-запроса:', error);
        });
    });

    // Функция для обновления списка тревог на странице
    function refreshAnxietyList() {
        // Отправить запрос на получение списка тревог с помощью AJAX
        fetch('/get_anxiety_list')
            then(data => {
                if (data.status) {
                    // Обновить отображение списка тревог на странице
                    const anxietyList = document.getElementById('anxiety-list');
                    anxietyList.innerHTML = data.msg.map(anxiety => `<p>${anxiety.description} - ${anxiety.tag}</p>`).join('');
                } else {
                    alert('Ошибка при обновлении списка тревог: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Ошибка при выполнении AJAX-запроса:', error);
                alert('Произошла ошибка при выполнении AJAX-запроса.');
            });
    }


    // Функция для обновления списка тегов на странице
    function refreshTagList() {
        // Отправить запрос на получение списка тегов с помощью AJAX
        fetch('/get_tag_list')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                // Обновить отображение списка тегов на странице
                const tagList = document.getElementById('tag-list');
                tagList.innerHTML = '';
                data.tagList.forEach(tag => {
                    tagList.innerHTML += `<p>${tag.name} - ${tag.cat}</p>`;
                });
            } else {
                alert('Ошибка при обновлении списка тегов: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Ошибка при выполнении AJAX-запроса:', error);
        });
    }

    // Вызов функций для обновления списков тревог и тегов при загрузке страницы
    // refreshAnxietyList();
    // refreshTagList();

}