<?php 
/**
 * Template Name: survey
 *
 
 */
get_header();
session_start();
CheckAuth();
require_once( get_theme_file_path('processing.php') );

$last_survey = $db->getAll("SELECT * FROM add_survey ORDER BY id DESC LIMIT 1")[0];


//Add Page in WP
?>

<script>
let this_survey = <?php 
      echo($last_survey["survey_questions"]);
  ?>;

let this_id = <?php 
      echo($last_survey["id"]);
  ?>;

let this_name = '<?php 
      echo($last_survey["survey_name"]);
  ?>';

</script>

<!-- опрос -->
<section class='survey'>
    <div class='background-elipse-1'></div>
    <div class='background-elipse-2'></div>
    <div class='background-elipse-3'></div>
    <div class='survey_opening-text'>
        <h2>Дорогой пользователь,</h2>
        <p>Заполнение анкеты является важной частью вашего опыта использования платформы. Это помогает нам делать рекомендации более персонализированными и эффективными для вас.</p>
        <p>В анкете 30 вопросов, и она займет у вас 5-10 минут.</p>
    </div>
    <div id="survey-container">

    </div>
    <div class='buttons-wrp'>
        <button type='button' onclick="generateSurvey(this_survey, document.getElementById('survey-container'), this_id, this_name)"
            class='button-survey blue_btn'>
        </button>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('survey')) {
          if (document.querySelector('.button-survey.blue_btn')) {
            document.querySelector('.button-survey.blue_btn').textContent = 'Продолжить'
          } 
        } else {
          if (document.querySelector('.button-survey.blue_btn')) {
            document.querySelector('.button-survey.blue_btn').textContent = 'Начать'
          }
        }
          })
        </script>
        <a href="/account">Выйти из опроса</a>
    </div>

    <div class='survey_modal-info'>
        <div class='survey_modal-wrap'>
            <div class='survey_modal-content'>
                <div class='survey_modal_btn-close' onclick='closeModal()'>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.0562 5.94383L5.67175 17.3282C5.30075 17.6992 5.30075 18.3008 5.67175 18.6718L5.74246 18.7425C6.11346 19.1135 6.71497 19.1135 7.08597 18.7425L18.4704 7.35804C18.8414 6.98705 18.8414 6.38554 18.4704 6.01454L18.3997 5.94383C18.0287 5.57283 17.4272 5.57283 17.0562 5.94383Z"
                            fill="#111111" />
                        <path
                            d="M18.0562 17.0562L6.67175 5.67175C6.30075 5.30075 5.69925 5.30075 5.32825 5.67175L5.25754 5.74246C4.88654 6.11346 4.88654 6.71497 5.25754 7.08597L16.642 18.4704C17.013 18.8414 17.6145 18.8414 17.9855 18.4704L18.0562 18.3997C18.4272 18.0287 18.4272 17.4272 18.0562 17.0562Z"
                            fill="#111111" />
                    </svg>
                </div>
                <div class='survey_modal-text'></div>
            </div>
        </div>
    </div>
</section>

<script>
function closeModal() {
    document.querySelector('.survey_modal-info').style.display = 'none';
}
</script>

<?php
  get_footer();
?>
