$(document).ready(function () {
  let btn = document.querySelector(".header_btn");
  btn.addEventListener('click', toggleImage);
});

function toggleImage() {
  [...this.children].forEach(el => el.classList.toggle('visually-hidden'));
  document.querySelector('.header_nav').classList.toggle('header_nav-show');
}


