
  function delete_characters(str, length) {
  
    if ((str.constructor === String) && (length>0)) {
        document.writeln (str.slice(0, length));
    }
};

function forYouTxt_1()
{
  btn = document.querySelector('#our_trainings_btn_1');
  txt = document.querySelector('#our_trainings_text_1');
      if(btn.style.transform == "rotate(-90deg)"){
        btn.style = "transform:rotate(90deg)";
        txt.classList.add("our_trainings_list");
        txt.classList.remove("our_trainings_list_onclick");
      }
      else{
        txt.classList.remove("our_trainings_list");
        txt.classList.add("our_trainings_list_onclick");
          btn.style = "transform:rotate(-90deg)";
      }
}
function forYouTxt_2()
{
  btn = document.querySelector('#our_trainings_btn_2');
  txt = document.querySelector('#our_trainings_text_2');
      if(btn.style.transform == "rotate(-90deg)"){
        btn.style = "transform:rotate(90deg)";
        txt.classList.add("our_trainings_list");
        txt.classList.remove("our_trainings_list_onclick");
      }
      else{
        txt.classList.remove("our_trainings_list");
        txt.classList.add("our_trainings_list_onclick");
          btn.style = "transform:rotate(-90deg)";
      }
}
function forYouTxt_3()
{
  btn = document.querySelector('#our_trainings_btn_3');
  txt = document.querySelector('#our_trainings_text_3');
      if(btn.style.transform == "rotate(-90deg)"){
        btn.style = "transform:rotate(90deg)";
        txt.classList.add("our_trainings_list");
        txt.classList.remove("our_trainings_list_onclick");
      }
      else{
        txt.classList.remove("our_trainings_list");
        txt.classList.add("our_trainings_list_onclick");
          btn.style = "transform:rotate(-90deg)";
      }
}







$('.stage_number input').on('input change paste', function() {
  $(this).val(this.value.replace(/[^0-9\-]/, '')); // запрещаем ввод любых символов, кроме цифр и знака минуса
});

$('.stage_number').each(function() {
  var numb = $(this),
    controls = numb.find('.number_controls div'),
    input = numb.find('input'),     
    interval,
    timeout;
  controls.each(function() {
    var control = $(this);
    var pressed = false;
    control.on('mousedown', function() {
      timeout = setTimeout(function() {
        pressed = true;
      }, 51);
      var value = parseInt(input.val()) || 0;
      interval = setInterval(function() {
        if (pressed) {
          if (control.hasClass('nc_minus')) {
            value = changeValue(value, 'minus');
          } else if (control.hasClass('nc_plus')) {
            value = changeValue(value, 'plus');
          }
          input.val(value).change();
        }
      }, 150);
    });

    control.on('mouseup', function() {
      var value = parseInt(input.val()) || 0;
      if (control.hasClass('nc_minus')) {
        value = changeValue(value, 'minus');
      } else if (control.hasClass('nc_plus')) {
        value = changeValue(value, 'plus');
      }
      input.val(value).change();

      pressed = false;
      clearInterval(interval);
    });

    control.on('mouseout', function() {
      clearInterval(interval);
    });
  });

  function changeValue(val, type) {
    if (type == 'minus') {
      if(val <= 2){
        val= 2;
      }
      else{
        val = val - 1;
      };
    } else if (type == 'plus') {
      if(val==0){
        val = val + 2;
      }
      else{
        val = val + 1;
      };
    }
    return val;
  }

});








// Look Password
$('body').on('mousedown', '.password_control', function(){
	if ($('#pass').attr('type') == 'password'){
		$(this).addClass('view');
		$('#pass').attr('type', 'text');
	} else {
		$(this).removeClass('view');
		$('#pass').attr('type', 'password');
	}
	return false;
});

$('body').on('mouseup', '.password_control', function(){
	if ($('#pass').attr('type') == 'password'){
		$(this).addClass('view');
		$('#pass').attr('type', 'text');
	} else {
		$(this).removeClass('view');
		$('#pass').attr('type', 'password');
	}
	return false;
});





// IMAGE STYLES
$(document).ready(function() {

  $("#image").change(function() {

    var f_name = [];

    for(var i = 0; i < $(this).get(0).files.length; ++i) {

      f_name.push($(this).get(0).files[i].name);

    }

    $(".image_btn").html(f_name.join(", "));
    $("#add_image_label").css('background','rgba(0, 255, 40, 0.19)');
  });
});


$(document).ready(function() {
  $("#audio").change(function() {
    var f_name = [];
    for(var i = 0; i < $(this).get(0).files.length; ++i) {
      f_name.push($(this).get(0).files[i].name);
    }
    if(f_name[0].split('').splice(-3).join('')==="mp3"){
      $("#audio_btn").html(f_name.join(", "));
      $("#add_audio_label").css('background','rgba(0, 255, 40, 0.19)');
      $(".check_mp").html("");
    }
    else{
      $(".check_mp").html("Сообщение должно быть в формате 'mp3'").css('color','rgb(216, 41, 57)');
    }
  });
  
});


$(document).ready(function() {
  $("#second_audio").change(function() {
    var s_name = [];
    for(var i = 0; i < $(this).get(0).files.length; ++i) {
      s_name.push($(this).get(0).files[i].name);
    }
    if(s_name[0].split('').splice(-3).join('')==="mp3"){
      $(".second_audio_btn").html('s_name');
      $("#second_audio_label").css('background','rgba(0, 255, 40, 0.19)');
      $(".check_mp").html("");
    }
    else{
      $(".check_mp").html("Сообщение должно быть в формате 'mp3'").css('color','rgb(216, 41, 57)');
    }
  });
});















// RESET PASSWORD

$(document).ready(function(){
  "use strict";
  //регулярное выражение для проверки email
  var pattern = /^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i;
  var mail = $('input[name=reset_email]');
   
  mail.blur(function(){
      if(mail.val() != ''){
          if(mail.val().search(pattern) == 0){
              $('#valid_email_message').text('');
              $('input[type=submit]').attr('disabled', false);
          }else{
              $('#valid_email_message').text('Не правильный Email');
              $('input[type=submit]').attr('disabled', true);
          }
      }else{
          $('#valid_email_message').text('Введите Ваш email');
      }
  });
});










// Выбор определённого option через select value
$(document).ready(function() {
  $('.change_sex').each(function(index, id) {
    var theValue = $(this).attr('value');
    var theID = $(this).attr('id');
    $('.change_sex#' + theID + ' option[value=' + theValue + ']').attr('selected', true);
  });
});








// Choice Image
$(function () {
  $('.change_img_btn').click(function () {
    $('.choice_img').addClass('choice_img_active');
    $('.change_container').addClass('change_blur');
  });
  // $('.change_container').click(function () {
  //   $('.choice_img').removeClass('choice_img_active');
  //   $('.change_container').removeClass('change_blur');
  // });
});


$('.choice_img_item > :checkbox').on('change', function() {
  var checkbox = $(this);
  var name = checkbox.prop('name');
  if (checkbox.is(':checked')) {
    $(':checkbox[name="' + name + '"]').not($(this)).prop({
      'checked': false,
      'required': false
    });
    
  }
});


//CHANGE SRC
$(function () {
  $('.color_skin_item_black').click(function () {
    $('.choice_img_item > input').each(function(){
      let val_check_img =$(this).prop('value');
      val_check_img=val_check_img.concat('_2');
      $(this).val(val_check_img)
    });
    
    $('.choice_img_item > label > img').each(function(){
      const imgSrc =$(this).attr('src');
      const last_imgSrc= imgSrc.slice(-6);
      if(last_imgSrc !== "_2.png"){
        $(this).attr('src', $(this).attr('src').replace(/\.png/, '_2.png'));
      }
    })
  });
  $('.color_skin_item_white').click(function () {
    $('.choice_img_item > input').each(function(){
      let val_check_img =$(this).prop('value');
      val_check_img=val_check_img.replace(/\_2/, '');
      $(this).val(val_check_img)
    });

    $('.choice_img_item > label > img').each(function(){
      const imgSrc =$(this).attr('src');
      const last_imgSrc= imgSrc.slice(-6);
      if(last_imgSrc == "_2.png"){
        $(this).attr('src', $(this).attr('src').replace(/\_2.png/, '.png'));
        $(this).val($(this).val().replace(/\_2/, ''));
      }
    })
  });
});






















