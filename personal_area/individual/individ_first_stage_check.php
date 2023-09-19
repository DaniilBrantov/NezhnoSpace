<?php

    $user_id=$_SESSION['user']['id'];
    $route_value=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT `route_value` FROM `users` WHERE `id`='$user_id'"));
    $route_val=$route_value['route_value'];
    
    if ($route_val==0){
        if(!$_SESSION["user"]){
            header('Location: auth');
        }else{
            header('Location: first_stage');
        }
    }elseif ($route_val==5){
        header('Location: first_stage');
    }else{
        if($route_val==1 || $route_val==4){
            $image='type_picture_1.png';
            $txt=[
                "1. <span>Вспомни</span> 2-3 последних эпизода, когда ты заела свой эмоциональный дискомфорт",
                "2. <span>Опиши</span> каждый по схеме ниже:
                <ul>
                    <li>
                        Какая ситуация его вызвала?
                    </li>
                    <li>
                        Какие эмоции и чувства ты испытала в этой ситуации? С помощью диаграммы эмоций попробуй найти и назвать эмоцию.
                    </li>
                    <li>
                        Есть ли закономерность в твоих действиях? Например, произошел стресс - я почувствовал гнев - я заел эмоцию сладким.
                    </li>
                </ul>"
            ];
            if($route_val==1){
                $audio='emotiog_type.mp3';
                $video='https://www.youtube.com/embed/chLq5gmvgX4';
            }else{
                $audio='smesh_type.mp3';
                $video='https://www.youtube.com/embed/9OfHQlmO4J8';
            }
        }else if($route_val==2){
            $image='purple_robot.png';
            $audio='ekstern_type.mp3';
            $video='https://www.youtube.com/embed/wToJbAcdBoQ';
            $txt=[
                "1. <span>Прохлопай</span> свое тело снизу вверх, начиная с ног, доходя до головы и лица, делай это ощутимо, но бережно к себе. Этот простой способ возвращает нас в осознанность.",
                "2. <span>Попробуй</span> закрыть глаза на пару минут. Пройдись мысленным сканером по каждому участку тела – и оно подскажет, что тебе на самом деле необходимо.",
                "3. <span>Вернись</span> в свое привычное положение, прислушайся к ощущениям. Может, у тебя затекла спина? ",
                "4. <span>Ответь</span> прямо сейчас на свою телесную потребность. Попробуй пройтись и размяться. Поменяй положение тела. Сделай глубокий вдох."
            ];
        }else if($route_val==3){
            $image='type_picture_2.png';
            $audio='ogranich_type.mp3';
            $video='https://www.youtube.com/embed/0frR8ckE02E';
            $txt=[
                "1. <span>Выпиши</span> 5-6 областей твоей жизни, где тебе важен успех (вместе с формой и весом, контролем за питанием)",
                "2. <span>Ранжируй</span> элементы самооценки с точки зрения их важности. Спроси себя: 'Если что-то пойдет не так в этой области, насколько это мне повредит?'",
                "3. <span>Нарисуй</span> круговую диаграмму самооценки, сделав каждый элемент «кусочком» пирога.",
                "4. <span>Выпиши</span> 3 дела из областей помимо формы тела, которые ты сможешь осуществить уже в ближайшие 72 часа.",
                "5. <span>Выполни</span> эти 3 дела"
            ];
        }else{
            
        }
    } 
?>
