<footer>
    <div class="container">
        <div class="footer" id="footer">
            <?php
                wp_nav_menu(array(
                    'theme_location'=> 'mainmenu',
                    'menu_class'=> 'footer__menu'
                ))
                ?>
            <div class="center-footer">
                <ul>
                    <li>ИП Ларькина К.Ю.</li>
                    <li>ОГРНИП 318527500097073</li>
                    <li>ИНН 525801278469</li>
                </ul>
                <div class="footer-documents">
                    <a href="privacy-politic">Политика конфиденциальности</a>
                    <a href="contract">Договор публичной оферты</a>
                </div>

            </div>
            <div class="soc_networks">
                <a href="https://instagram.com/eat.intelligent?igshid=tou7pase0mxt">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/instagram.svg" alt="">
                </a>
                <!-- <a href="https://web.telegram.org/k/">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/tg.svg" alt="">
                </a> -->
                <!-- <a href="https://wa.me/79063663550">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/wa.svg" alt="">
                </a> -->
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>

<script src="https://cdn.plyr.io/3.7.2/plyr.js"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js">
AOS.init();
</script>

<script>
$('.js-menu-toggle').on('click', function() {
    $(this).toggleClass('is-active');
    $('.header__menu').toggleClass('is-open');
});
</script>
<script>
if (document.querySelector('.main_less_link')) {
    OpenPayLess(order);
};

const anchors = document.querySelectorAll('a[href*="#"]')
for (let anchor of anchors) {
    anchor.addEventListener("click", function(e) {
        e.preventDefault();
        const blockID = anchor.getAttribute('href');
        document.querySelector('' + blockID).scrollIntoView({
            behavior: "smooth",
            block: "start"
        })
    })
}

$(window).on('scroll', function() {
    if ($(document).scrollTop() > $(window).height()) {
        $('.up').addClass('up-visible');
    } else {
        $('.up').removeClass('up-visible');
    }
}).scroll();
</script>
</body>

</html>
<?php ob_flush(); ?>