$(document).ready(function () {
  let btn = document.querySelector(".header_btn");
  btn.addEventListener('click', toggleImage);
});

function toggleImage() {
  this.classList.toggle('menu_close');
  document.querySelector('.header_nav').classList.toggle('header_nav-show');
}


