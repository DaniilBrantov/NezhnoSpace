$(function(){

    $('.slider').slick({
        infinite: false,
        slidesToShow: 2,
        slidesToScroll: 2,
        arrows:false,
        dots: true,
        centerMode: true,
        centerPadding: '60px',
        waitForAnimate: false,
        variableWidth: true,
        variableHeight: true,
        speed:700,
        touchThreshold:25,
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


$(function(){

    $('.project_slider').slick({
        dots: true,
        speed: 300,
        adaptiveHeight: true,
        variableWidth: true,
        speed:700,
        touchThreshold:25,
        centerMode: true,
        centerPadding: '60px',
        autoplaySpeed: 2500,
        autoplay:true,
        pauseOnHover:true,
        slidesToShow:1,
        responsive:[
            {
                breakpoint: 720,
                settings:{
                    arrows:false,
                }
            },
            {
                breakpoint: 520,
                settings:{
                    arrows:false,
                }
            }
        ]
    });
})


