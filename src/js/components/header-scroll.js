import Headroom from '../../../node_modules/headroom.js/dist/headroom';

const header = document.querySelector("header");
const headroom = new Headroom(header);

headroom.init();


// const $header = document.querySelector('.site-header');
// let isStart = true;
// let hasStartedScrolling = false;
// let threshold = 50;

// window.addEventListener('scroll', () => scrollFunction());

// function scrollFunction() {

//   if (document.body.scrollTop > threshold || document.documentElement.scrollTop > threshold) {

//     if (!hasStartedScrolling) {
//       $header.classList.remove('-start');
//       $header.classList.add('-scrolled');
//       hasStartedScrolling = true;
//       isStart = false;
//     }
//   } else {
//     if (!isStart) {
//       $header.classList.remove('-scrolled');
//       $header.classList.add('-start');
//       hasStartedScrolling = false;
//       isStart = true;
//     }
//   }
// }