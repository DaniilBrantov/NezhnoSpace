
$(function () {

    $('.slider').slick({
        infinite: false,
        slidesToShow: 2,
        slidesToScroll: 2,
        arrows: false,
        dots: true,
        centerMode: true,
        centerPadding: '60px',
        waitForAnimate: false,
        variableWidth: true,
        variableHeight: true,
        speed: 700,
        touchThreshold: 25,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    centerPadding: '180px',
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '20px',
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.slider').slick('setPosition');
});


$(function () {

    $('.project_slider').slick({
        dots: true,
        speed: 300,
        adaptiveHeight: true,
        variableWidth: true,
        speed: 700,
        touchThreshold: 25,
        centerMode: true,
        centerPadding: '60px',
        autoplaySpeed: 2500,
        autoplay: true,
        pauseOnHover: true,
        slidesToShow: 1,
        responsive: [
            {
                breakpoint: 720,
                settings: {
                    arrows: false,
                }
            },
            {
                breakpoint: 520,
                settings: {
                    arrows: false,
                }
            }
        ]
    });
})


$(function () {

    $('.about_slider').slick({
        adaptiveHeight: true,
        variableWidth: true,
        touchThreshold: 25,
        centerMode: true,
        autoplaySpeed: 2500,
        autoplay: true,
        pauseOnHover: true,
        slidesToShow: 1,
        responsive: [
            {
                breakpoint: 500,
                settings: {
                    arrows: false,
                    slidesToShow: 1,
                    centerMode: false,
                }
            }
        ]
    });
    $('.about_slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        let colors = ['#EFE1F0', '#BFA4CE', '#D9D9D9', '#7264AA', '#8D9ACE',
            '#917286', '#EFE1F0', '#BFA4CE', '#D9D9D9', '#7264AA', '#8D9ACE', '#917286'];
        document.querySelector('.about_slider-before').style.background = colors[nextSlide];
    })
});


$(function () {

    $('.our_platform_cnt').slick({
        adaptiveHeight: true,
        variableWidth: true,
        slidesToShow: 4,
        infinite: false,
        centerPadding: '10px',
        responsive: [
            {
                breakpoint: 930,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });
    if ($(window).width() > 720) {
        $('.our_platform_item').mouseover(function (event) {
            let img = $(this).find('img');
            let txt = $(this).find('.our_platform_item_txt');
            $(img).fadeOut(100, function () {
                $(txt).fadeIn(200);
            });
        });
        $('.our_platform_item').mouseleave(function (event) {
            let img = $(this).find('img');
            let txt = $(this).find('.our_platform_item_txt');
            $(txt).fadeOut(100, function () {
                $(img).fadeIn(400);
            });
        });
    } else {
        $('.our_platform_item').click(function (event) {
            let img = $(this).find('img');
            let txt = $(this).find('.our_platform_item_txt');
            $(img).fadeToggle(200, function () {
                setTimeout(function () { $(txt).fadeToggle(); }, 200);
            });
        });
    };
    $('.our_platform_cnt').slick('setPosition');
});


$(function () {
    $('.reviews_list').slick({
        arrows: false,
        centerMode: true,
        variableWidth: true,
        speed: 700,
        touchThreshold: 25,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    centerPadding: '180px',
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '20px',
                    slidesToShow: 1
                }
            }
        ]
    });
    $('.reviews_list').slick('setPosition');
});


$(function () {

    $('.slider_sliders').slick({
        infinite: false,
        dots: true,
        arrows: true,
        centerMode: true,
        waitForAnimate: false,
        touchThreshold: 25,
        centerPadding: '0px',
        fade: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    arrows: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '20px',
                }
            }
        ]
    });

    let slidesLength = document.querySelectorAll('.it_bothers_me_item.slick-slide').length;
    let btnNext = document.querySelector('.slider_sliders .slick-next');
    let btnPrev = document.querySelector('.slider_sliders .slick-prev');

    if ($('.slider_sliders').slick('slickCurrentSlide') === 0) {
        console.log(btnPrev)
        btnPrev.style.display = 'none'
    }

    $('.slider_sliders').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        if (nextSlide === slidesLength - 1) {
            btnNext.style.display = 'none';
            btnPrev.style.display = '';
        } else if (nextSlide === 0) {
            btnPrev.style.display = 'none';
            btnNext.style.display = '';
        } else {
            btnPrev.style.display = '';
            btnNext.style.display = '';
        }
    })

    $('.slider_sliders').slick('setPosition');
});


$(function () {

    $('.subscriptions_list').slick({
        infinite: false,
        slidesToShow: 3,
        centerMode: true,
        waitForAnimate: false,
        variableWidth: true,
        variableHeight: true,
        speed: 700,
        touchThreshold: 25,
        initialSlide: 1,
        centerPadding: '100px',
        responsive: [
            {
                breakpoint: 960,
                settings: {
                    slidesToShow: 1,
                    centerPadding: '10px',
                }
            },
        ]
    });

    $('.subscriptions_list').slick('setPosition');
});
