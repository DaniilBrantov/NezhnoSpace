$(document).ready(function () {
  let btn = document.querySelector(".header_btn");
  let nav = document.querySelector('.header_nav');
  
  btn.addEventListener('click', toggleImage);
  document.addEventListener('click', function(event) {
    if (!nav.contains(event.target) && !btn.contains(event.target)) {
      nav.classList.remove('header_nav-show');
      btn.classList.remove('menu_close');
    }
  });
});

function toggleImage() {
  this.classList.toggle('menu_close');
  document.querySelector('.header_nav').classList.toggle('header_nav-show');
}


