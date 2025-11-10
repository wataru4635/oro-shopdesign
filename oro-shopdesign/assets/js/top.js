"use strict";

window.addEventListener('load', () => {
  setTimeout(() => {
    const mv_swiper = new Swiper(".js-mv-swiper", {
      loop: true,
      speed: 2000,
      effect: "fade",
      fadeEffect: {
        crossFade: true
      },
      autoplay: {
        delay: 3000,
        disableOnInteraction: false
      },
      allowTouchMove: false
    });
  }, 100);
});