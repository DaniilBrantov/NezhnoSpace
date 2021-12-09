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
        var surname= $('input[name="surname"]').val();

        var formData= new FormData();
        formData.append('mail',mail);
        formData.append('pass',pass);
        formData.append('nname',nname);
        formData.append('surname',surname);
    
        // //обьект ajax со св-ми ,как было у формы. 
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