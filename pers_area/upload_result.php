<?php

// Подключение к БД.

$dbh = new PDO('mysql:dbname=db_name;host=localhost', 'логин', 'пароль');

 

$sth = $dbh->prepare("SELECT * FROM `reviews` ORDER BY `date_add` DESC");

$sth->execute();

$items = $sth->fetchAll(PDO::FETCH_ASSOC);

if (!empty($items)) { ?>
<h2>Отзывы</h2>
<div class="reviews">
    <?php
		foreach ($items as $row) {
			$sth = $dbh->prepare("SELECT * FROM `reviews_images` WHERE `reviews_id` = ?");
			$sth->execute(array($row['id']));
			$images = $sth->fetchAll(PDO::FETCH_ASSOC);?>
    <div class="reviews_item">
        <div class="reviews_item-name"><?php echo $row['name']; ?></div>
        <div class="reviews_item-text"><?php echo $row['text']; ?></div>
        <?php if (!empty($images)): ?>
        <div class="reviews_item-images">
            <?php foreach($images as $img): ?>
            <div class="reviews_item-img">
                <?php 
						$name = pathinfo($img['filename'], PATHINFO_FILENAME);
						$ext = pathinfo($img['filename'], PATHINFO_EXTENSION);
						?>
                <a href="/uploads/<?php echo $img['filename']; ?>" target="_blank">
                    <img src="/uploads/<?php echo $name . '-thumb.' . $ext; ?>">
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php
		}
		?>
</div>
<?php
}
?>