//Авторизация


//'$'-выбор эл-та по классу. И при клике выполняем функцию.
// e или event это как this,указывает на то,с чем работаем.
$('#auth_btn').click(function(e){
//отключает стандартное поведение e(кнопки)
    e.preventDefault();
    $('input').removeClass('error');
    //val()- взять инф-цию с данного эл-нта
    let mail= $('input[name="mail"]').val();
    let pass= $('input[name="pass"]').val();

    let formData = new FormData;
    formData.append('mail', mail);
    formData.append('pass', pass);


    //обьект ajax со св-ми ,как было у формы. 
    $.ajax({
        url: 'https://eatintelligent.ru/auth-check/',
        type: 'POST',
        //возращаем текст
        dataType: 'json',
        processData:false,
        contentType:false,
        cache:false,
        //обьект с нашими данными
        data: formData, 
        //метод ,который передаёт ф-цию
        success: function(data){
            
            if(data.status){
                document.location.href= '/my_account';
            }else{
                if (data.type===1) {
                    data.fields.forEach(function(field){
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.auth_msg').removeClass('none').text(data.message);
            }
        },
        error: function(jqxhr, status, errorMsg) {
            console.log(status, errorMsg);
        }
    });

});



//Регистрация



//'$'-выбор эл-та по классу. И при клике выполняем функцию.
// e или event это как this,указывает на то,с чем работаем.
$('.reg_btn').click(function(e){
    //отключает стандартное поведение e(кнопки)
        e.preventDefault();
    
        $(`input`).removeClass('error');
        //val()- взять инф-цию с данного эл-нта
        var mail= $('input[name="mail"]').val();
        var pass= $('input[name="pass"]').val();
        var nname= $('input[name="nname"]').val();

        var formData= new FormData();
        formData.append('mail',mail);
        formData.append('pass',pass);
        formData.append('nname',nname);
    
        // обьект ajax со св-ми ,как было у формы. 
        $.ajax({
            url: 'https://eatintelligent.ru/check/',
            type: 'POST',
            dataType: 'json',
            processData:false,
            contentType:false,
            cache:false,
            data:formData,
            success: function(data){
                if(data.status){
                    document.location.href= '/auth';
                }else{
                    if (data.type===1) {
                        data.fields.forEach(function(field){
                            $(`input[name="${field}"]`).addClass('error');
                        });
                        
                        $('.auth_msg').removeClass('none').text(data.message);

                        
                    }
                    
                    
                }
            }
        });
    });



function audioTxt(){
    btn = document.querySelector('#les_button');
    txt = document.querySelector('#les_audio_txt_cont');
        if(txt.style.display == "block"){
            txt.style = "display: none";
            btn.style = "transform:rotate(90deg)";
        }
        else{
            txt.style = "display: block;"; timeVar = 1;
            btn.style = "transform:rotate(-90deg)";
        }
}

function tgTxt(){
    btn = document.querySelector('.les_hw_link');
    txt = document.querySelector('.les_hw_link_txt');
    widthBtn=document.querySelector('.les_hw_content');
        if(txt.style.display == "block"){
            txt.style = "display: none";timeVar = 1;
            widthBtn.style= "width:125px;";timeVar = 1;
        }
        else{
            txt.style = "display: block;"; timeVar = 1;
            widthBtn.style= "width:70%;";timeVar = 1;
        }
}





// Плавное появление блока при скролле

$(window).scroll(function() {
    var sTop = $(this).scrollTop();
  
    $('.what_get').each(function(i, el) { 
      var pTop = $(el).offset().top;
      var height = $(el).height(); 
  
      var top = pTop - sTop + height; 
      if (top > 0) { 
        $(el).css({
          opacity: function() {
            var elementHeight = $(el).height();
            return 1 - top / 300 + height / 250;
          }
        });
      }
    });
});





window.onscroll = function() {
    let free_access_cnt = document.querySelector(".free_access_cnt");

    if(free_access_cnt){
        
        let free_access = window.document.querySelector(".free_access").offsetTop;
        let begining_your_sebor = window.document.querySelector(".begining_your_sebor").offsetTop;
        let show_your_sebor = window.document.querySelector(".show_your_sebor").offsetTop;
        let your_sebor_title = document.querySelector(".your_sebor_title");
        let your_sebor_cnt = document.querySelector(".your_sebor_cnt");
        let your_sebor = document.querySelector(".your_sebor");
        let scrolled = window.pageYOffset;
        let free_scrolled= scrolled+400;

        if(free_scrolled >= free_access && free_scrolled < begining_your_sebor) {
            free_access_cnt.classList.add('is_visible');
        } else {
            free_access_cnt.classList.remove('is_visible');
        };
        if(scrolled-500 > free_access){
            function ShowYourSebor(){
                your_sebor.classList.add('is_visible');
                // function ShowSeborCnt() {
                //     your_sebor_cnt.classList.add('is_visible');
                // }
                // setTimeout(ShowSeborCnt,200);
            }
            setTimeout(ShowYourSebor, 100);
        } else {
            your_sebor.classList.remove('is_visible');
            //your_sebor_cnt.classList.remove('is_visible');
        }
    }
};



//MOBILE FirstStage
if( window.innerWidth <= 1500 ){
    $(".audio_meditation_img").prependTo(".section_audio_meditation");
    $(".recognized_yourself_img").css('padding', '0').prependTo(".recognized_yourself");
    $(".recognized_yourself").css('display', 'block');
} else {
    $(".audio_meditation_img").appendTo(".wrapper_audio_meditation");
    $(".recognized_yourself_img").css('padding-top', '200px').appendTo(".recognized_yourself");
} 
if( window.innerWidth <= 1050 ){
    $(".practice_img").prependTo(".practice_cnt");
    $(".we_are_ready_img").prependTo(".we_are_ready");
} else {

}










// Отправка сообщения на электронную почту

/* $('.reg_btn').click(function(e){
    $.ajax({
        type: 'POST',
        url: 'https://mandrillapp.com/api/1.0/messages/send.json',
        data: {
        'key': 'YOUR API KEY HERE',
        'message': {
            'from_email': 'eatintelligent@mail.com',
            'to': [
                {
                'email': 'daniil.brantov04@mail.ru',
                'name': 'Daniil',
                'type': 'to'
                }
            ],
            'autotext': 'true',
            'subject': 'no subject',
            'html': '-----HELLO-----'
        }
      }
     }).done(function(response) {
       console.log(response); // if you're into that sorta thing
     });
}) */