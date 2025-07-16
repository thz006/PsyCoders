new Swiper('#swiper-inicial', {
  slidesPerView: 'auto',     // deixa o CSS decidir a largura
  centeredSlides: true,
  spaceBetween: 50,
  grabCursor: true,
  // loop: true,                // garante um vizinho à esquerda desde o 1º frame
  initialSlide: 1,           // começa já com um cartão de cada lado
  pagination: { el: '.swiper-pagination', clickable: true },

  // No desktop você volta para três inteiros
  breakpoints: {
    768: { slidesPerView: 3, spaceBetween: 24 }
  }
});
