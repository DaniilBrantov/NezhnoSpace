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
                document.location.href= '/uchebnaya-programma';
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
        var checkbox= $('input[name="reg_checkbox"]').val();

        var formData= new FormData();
        formData.append('mail',mail);
        formData.append('pass',pass);
        formData.append('nname',nname);
        formData.append('checkbox',checkbox);
    
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






//сохранение src аватара пользователя
var src_img="";
$('.choice_img_avatar').click(function(){
	if ($('.check_img').is(':checked')){
        src_img=$(this).attr("src");
		$('.check_img').prop('checked', true);
	} else {
		$('.check_img').prop('checked', false);
	}
});
function AvatarUrl() {
    $.ajax({
        type:'POST',
        url: 'https://eatintelligent.ru/change_check/',
        dataType:'json',
        data:"param="+JSON.stringify(src_img),
        success:function(html) {
$("<p class='for_content'>" + html['title'] + "</p>").
                    prependTo(".content").
                    hide().
                    fadeIn(500);
        }
    });
};







    



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
function SecondAudioTxt(){
    btn = document.querySelector('#second_les_button');
    txt = document.querySelector('#second_les_audio_txt_cont');
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
            }
            setTimeout(ShowYourSebor, 100);
        } else {
            your_sebor.classList.remove('is_visible');
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
};










//Опросник

var questionTree = function (selector) {
    var nowQuestion,
        arrayQuestions = [],
        self = this,
        select = document.querySelector(selector),

        quest = function (questions) {
            this.question = questions;
            this.arrAnswer = [1,2,3,4,5];
            this.arrToQuestion = [1,2,3,4,5];
        };
        
    this.addQuestion = function (questions) {
        arrayQuestions.push(new quest(questions));
    };

    var all_quest=1;
    var name_val;
    var mail_val;
    var choice_array=[];

    this.startQuestions = function() {
            var NameStart = document.createElement('input');
            NameStart.type = "text";
            NameStart.classList.add("question_name");
            select.querySelector(".question").appendChild(NameStart);
            var NameLabel = document.createElement('label');
            NameLabel.innerHTML = "Имя";
            NameLabel.classList.add("question_name_label");
            select.querySelector(".question").appendChild(NameLabel);

            var buttonStart = document.createElement('input');
            buttonStart.type = "button";
            buttonStart.classList.add("question_btn_start");
            select.querySelector(".questionnaire_buttons").appendChild(buttonStart);
            nowQuestion = 0;
            buttonStart.disabled = true;

            NameStart.addEventListener('input', function(event) {
                buttonStart.disabled = (NameStart.value == '');
            });
            buttonStart.addEventListener('click', function(event) {
                if (NameStart.value != ''){
                    this.disabled = false;
                    WriteEmail();
                    name_val=NameStart.value;
                    
                }else{
                    NameStart.value = '';
                    this.disabled = true;
                }
                    
                
            });
        };
    function WriteEmail(){
        delButton(select.querySelector(".question"));
        var EmailError = document.createElement('p');
        var EmailStart = document.createElement('input');
        EmailStart.type = "email";
        EmailStart.classList.add("question_mail");
        select.querySelector(".question").appendChild(EmailStart);
        var EmailLabel = document.createElement('label');
        EmailLabel.innerHTML = "Email";
        EmailLabel.classList.add("question_name_label");
        select.querySelector(".question").appendChild(EmailLabel);
        var buttonStart=select.querySelector(".question_btn_start")
        buttonStart.disabled = true;
        EmailStart.addEventListener('input', function(event) {
            buttonStart.disabled = (EmailStart.value == '');
        });
        buttonStart.addEventListener('click', function(event) {
            if (EmailStart.value != ''){
                this.disabled = false;
                mail_val=EmailStart.value;
                if(validateEmail(mail_val)==true){
                    printQuestion();
                }else if(EmailError.innerHTML==""){
                        select.querySelector(".question").appendChild(EmailError);
                        EmailError.innerHTML="Указанный адрес не является действительным адресом электронной почты.";
                }
            }else{
                EmailStart.value = '';
                this.disabled = true;
            }
        });
    }
    function validateEmail(email){
        var re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        return re.test(email);
    }
    function nextQuestion(choice) {
        nowQuestion++;
        printQuestion(choice);

    }

    
    function printQuestion(choice) {
        select.querySelector(".questionnaire_rules").classList.remove("none");
        var Questionnaire_done= document.querySelector(".questionnaire_done");
        if (all_quest <= 33) {
            Questionnaire_done.innerHTML=`Сделано: ${all_quest} / 33`;
            all_quest++;
        }
        select.querySelector(".question").innerHTML = arrayQuestions[nowQuestion].question;
        if (choice && choice != 0) {
            choice_array.push(choice);
        }
        if(arrayQuestions[nowQuestion].question != "Молодец"){
            printButton();
        }else{
            delButton(select.querySelector(".questionnaire_buttons"));
            QuestEnd();
        }
    }
    
    function printButton(){
        var q = 5,
            selectButton = select.querySelector(".questionnaire_buttons");
            delButton(selectButton);
            selectButton.classList.add("questionnaire_numbers");
            var QuestButton = document.createElement('input');
            QuestButton.type = "button";
            QuestButton.classList.add("question_btn");
            
        for(var i = 0; i < q; i++){
            var val = arrayQuestions[nowQuestion].arrAnswer[i],
                nxt = arrayQuestions[nowQuestion].arrToQuestion[i],

                newButton = document.createElement('input');
                newButton.type = "radio";
                newButton.name = "choice";
                newButton.classList.add("number_btn");
                newButton.data = nxt;
                newButton.id = `choice_${nxt}`;
                


                newLabel=document.createElement('label');
                newLabel.htmlFor = `choice_${nxt}`;
                newLabel.innerHTML = newButton.data;
                
                QuestItem=document.createElement('div');
                QuestItem.classList.add("question_item");

                selectButton.appendChild(QuestItem);
                QuestItem.appendChild(newButton);
                QuestItem.appendChild(newLabel);
                
                QuestButton.disabled=true;
                newButton.addEventListener("click",OpenNextBtn);
        }
        selectButton.after(QuestButton);
    }
    function OpenNextBtn() {
        QuestButton=select.querySelector(".question_btn");
        if(this.checked==true){
                QuestButton.disabled=false;
                var choice=this.data;
                QuestButton.onclick = function(){
                    nextQuestion(choice);
                }
        }else{
            QuestButton.disabled=true;
        }
    }
    function delButton(selector){
        while (selector.firstChild) {
            selector.removeChild(selector.firstChild);
        }
        if(select.querySelector(".question_btn")){
            QuestButton=select.querySelector(".question_btn");
            QuestButton.remove();
        }
    }
    function QuestEnd() {
        var sum1 = 0;
        var sum2 = 0;
        var sum3 = 0;
        var q1=10;
        var q2=23;
        var q3=32;
        for(var i = 0; i < q1; i++){
            sum1 += choice_array[i]/10;
        }
        for(var i = q1; i < q2; i++){
            sum2 += choice_array[i]/13;
        }
        for(var i = q2; i <= q3; i++){
            sum3 += choice_array[i]/10;
        }
        let result;
        if (sum1 > 2.4 && sum2 > 1.8 && sum3 > 2.7 || sum1 > 2.4 && sum3 > 2.7) {
            result=4;
        }else if(sum2 > 1.8 && sum3 > 2.7 || sum3 > 2.7 ){
            result=3;
        }else if(sum1 > 2.4 && sum2 > 1.8 || sum1 > 2.4){
            result=1;
        }else{
            result=2;
        }
        document.querySelector("#answer_input").value=result;
        document.querySelector('.answer_input_btn').click();
    }
};

if(document.querySelector(".questionTree")){
    var question = new questionTree(".questionTree");

    question.addQuestion("1. Если ваш вес начинает нарастать, вы едите меньше обычного? ");
    question.addQuestion("2. Стараетесь ли вы есть меньше, чем вам хотелось бы во время обычного приёма пищи? ");
    question.addQuestion("3. Часто ли вы отказываетесь от еды и питья из-за того, что беспокоитесь о своём весе?");
    question.addQuestion("4. Аккуратно ли вы контролируете количество съеденного?");
    question.addQuestion("5. Выбираете ли вы пищу преднамеренно , чтобы похудеть?");
    question.addQuestion("6. Если вы переели, будете ли вы на следующий день есть меньше?");
    question.addQuestion("7. Стараетесь ли вы есть меньше, чтобы не поправиться? ");
    question.addQuestion("8. Часто ли вы стараетесь не есть между обычными приёмами пищи из-за того, что следите за своим весом?");
    question.addQuestion("9. Часто ли вы стараетесь не есть вечером из-за того, что следите за своим весом? ");
    question.addQuestion("10. Имеет ли значение ваш вес, когда вы едите?");
    question.addQuestion("11. Возникает ли у вас желание есть, когда вы раздражены?");
    question.addQuestion("12. Возникает ли у вас желание есть, когда вам нечего делать?");
    question.addQuestion("13. Возникает ли у вас желание есть, когда вы подавлены или обескуражены?");
    question.addQuestion("14. Возникает ли у вас желание есть, когда вам одиноко?");
    question.addQuestion("15. Возникает ли у вас желание есть, когда вас кто-либо подвёл? ");
    question.addQuestion("16. Возникает ли у вас желание есть, когда вам что либо препятствует, встаёт на вашем пути, или нарушаются ваши планы, либо что то не удаётся?");
    question.addQuestion("17. Возникает ли у вас желание есть, когда вы предчувствуете какую-либо неприятность?");
    question.addQuestion("18. Возникает ли у вас желание есть, когда вы встревожены, озабочены или напряжены? ");
    question.addQuestion("19. Возникает ли у вас желание есть, когда «всё не так», «всё валится из рук»? ");
    question.addQuestion("20. Возникает ли у вас желание есть, когда вы испуганы?");
    question.addQuestion("21. Возникает ли у вас желание есть, когда вы разочарованы, когда разрушены ваши надежды? ");
    question.addQuestion("22. Возникает ли у вас желание есть, когда вы взволнованы, расстроены?");
    question.addQuestion("23. Возникает ли у вас желание есть, когда вы скучаете, утомлены, неспокойны? ");
    question.addQuestion("24. Едите ли вы больше чем обычно, когда еда вкусная? ");
    question.addQuestion("25. Если еда хорошо выглядит и хорошо пахнет, едите ли вы больше обычного? ");
    question.addQuestion("26. Если вы видите вкусную пищу и чувствуете её запах, едите ли вы больше обычного?");
    question.addQuestion("27. Если у вас есть что-либо вкусное, съедите ли вы это немедленно? ");
    question.addQuestion("28. Если бы проходите мимо булочной (кондитерской), хочется ли вам купить что-либо вкусное?");
    question.addQuestion("29. Если вы проходите мимо закусочной или кафе, хочется ли вам купить что либо вкусное? ");
    question.addQuestion("30. Если вы видите, как едят другие, появляется ли у вас желание есть? ");
    question.addQuestion("31. Можете ли вы остановиться, если едите что либо вкусное?");
    question.addQuestion("32. Едите ли вы больше чем обычно в компании (когда едят другие)? ");
    question.addQuestion("33. Когда вы готовите пищу, часто ли вы её пробуете?");
    question.addQuestion("Молодец");

    question.startQuestions();
}



function NoAccessLess(main_less_link){
    main_less_link.forEach(function(entry) {
        const no_access=entry.parentElement;
        const curriculum_btn=no_access.parentElement.querySelector(".curriculum_btn");
        curriculum_btn.classList.add("none");
        no_access.classList.add("no_access");
        entry.remove()
        if(window.innerWidth <= 720){
            const mobile_no_access=no_access.parentElement.parentElement;
            mobile_no_access.style.background = "url(wp-content/themes/my-theme/images/padlock.svg) no-repeat center #212121a6";
            mobile_no_access.style.backgroundSize = "80px";
            mobile_no_access.classList.add("no_access");
        }
    });
}
var open_indiv_arr=[];
let open_main_arr;
function CloseIndivLess(individ_id){
    if (individ_id) {
        const open_individ_arr=[];
        let individ_links;
        if(window.innerWidth <= 720){
            individ_links=document.querySelectorAll(".mobile_individ_link");
        }else{
            individ_links=document.querySelectorAll(".individ_less_link");
        }
        
        const all_individ_link=Array.prototype.slice.call(individ_links);
        const individ_arr=Array.prototype.slice.call(individ_links);

        for (let i = 0; i < individ_id.length; i++) {
            const individ_link=Array.from(individ_links).find(
            e=>e.href.includes(`individual_content?id=${individ_id[i]}`) );
            open_individ_arr.push(individ_link);
        }
        for (var i = 0; i < all_individ_link.length; i++) { 
            for (var j = 0; j< open_individ_arr.length; j++) { 
                if(all_individ_link[i] === open_individ_arr[j]){
                    const check_open_link = all_individ_link.indexOf(all_individ_link[i]);
                    if (check_open_link !== -1) {
                        all_individ_link.splice(check_open_link, 1);
                    }
                }
            }
        }
        NoAccessLess(all_individ_link);
        open_indiv_arr=individ_arr.filter(x => !all_individ_link.includes(x));
    }else{
        console.log("Нет индивид контента");
    }
}
function OpenStage(open_stage_num,individ_arr){
    let individ_links;
    if(window.innerWidth <= 720){
        main_list=document.querySelectorAll(".main_stage_link a");
    }else{
        main_list=document.querySelectorAll(".main_less_link");
    }
    const all_main_arr=Array.prototype.slice.call(main_list);
    const main_arr=Array.prototype.slice.call(main_list);
    main_arr.shift();
    main_arr.splice(0,open_stage_num);
    NoAccessLess(main_arr);
    open_main_arr=all_main_arr.filter(x => !main_arr.includes(x));

    const individ_id=individ_arr.filter(function(item, pos) {
        return individ_arr.indexOf(item) == pos;
    });
    CloseIndivLess(individ_id);

    $(window).on('resize', function() {
        OpenStage(open_stage_num,individ_arr);
    });
    MainIndivStage();
}
function MainIndivStage() {

    let main=open_main_arr.toString().replace(/,/g," ");
    let individual=open_indiv_arr.toString().replace(/,/g," ");
    var json= {
        main: main, 
        individual: individual
    };
    $.ajax({
        type: "POST",
        url: 'https://eatintelligent.ru/auth-check/',
        data: json,
        success: function(data){
        }
    });
}






    $('.reg_btn').prop('disabled', true);
$(".reg_checkbox_item").bind('change', function() {
    if ( $(this).is(':checked') ) {
        $('.reg_btn').prop('disabled', false);
    }
    else{
        $('.reg_btn').prop('disabled', true);
    }
});
    


