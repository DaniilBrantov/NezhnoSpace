VANTA.NET({
  el: "#topslider",
  mouseControls: true,
  touchControls: true,
  gyroControls: false,
  minHeight: 200.00,
  minWidth: 200.00,
  scale: 1.00,
  scaleMobile: 1.00,
  color: 0x1f6484,
  backgroundColor: 0x0,
  points: 8.00,
  maxDistance: 24.00,
  spacing: 16.00
});



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







var our_mail ='1';
$(document).on('click', '#what_questn_technical', function(){
  $(this).css({
    'background':'#212121',
    'color':'#e2e2e2'
  });
  $('#what_questn_program').css({
    'background':'#e2e2e2',
    'color':'#212121'
  });
  our_mail='1';

});

$(document).on('click', '#what_questn_program', function(){
  $(this).css({
    'background':'#212121',
    'color':'#e2e2e2'
  });
  $('#what_questn_technical').css({
    'background':'#e2e2e2',
    'color':'#212121'
  });
  our_mail='2';
});

$(document).on('click', '.help_btn', function(){
  our_mail='1';
  $.ajax({
    url: 'https://eatintelligent.ru/help_check/',
    type: 'POST',
    data: 'our_mail',
    success: function(data){
      console.log('Loading...');
  },
    error: function(jqxhr, status, errorMsg) {
      console.log(status, errorMsg);
  }
  })
});

$('.stage_number input').on('input change paste', function() {
  $(this).val(this.value.replace(/[^0-9\-]/, '')); // запрещаем ввод любых символов, кроме цифр и знака минуса
});

$('.stage_number').each(function() {
  var numb = $(this),
    controls = numb.find('.number_controls div'),
    input = numb.find('input'), // инпут    
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
      if(val <= 1){
        val= 1;
      }
      else{
        val = val - 1;
      };
    } else if (type == 'plus') {
      if(val >99){
        val = 100;
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











// AUDIO

// $('body').on('mouseup', '.audio_play', function(){
// 	if ($(".audio_play").hasClass("play")){
//     $(this).removeClass('play');
//     $("#audio").trigger('pause');
//     $('.audio_play_icon').attr('name', 'play-outline');
// 	} else {
// 		$(this).addClass('play');
//     $("#audio").trigger('play');
//     $('.audio_play_icon').attr('name', 'pause-outline');
// 	}
//   return false;
// });

// function toggleMuteAudio(){
//   $("#audio").prop("muted",!$("#audio").prop("muted"));
// }



