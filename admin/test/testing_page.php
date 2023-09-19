<?php
require_once( get_theme_file_path('processing.php') );
$subscription = new Subscription();
$rec_id=46;
$rec = $subscription->RatedPosts($rec_id);
var_dump($rec);

?>



<div class="try_free_slider" style="width:390px;">
</div>
<audio preload='metadata' class='audio' src='' loop></audio>



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