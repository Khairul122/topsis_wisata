window.addEventListener('load', function () {
  document.body.classList.add('loaded');
});

document.addEventListener('DOMContentLoaded', function () {
  document.body.classList.add('loaded');
});

document.addEventListener('DOMContentLoaded', function () {
  function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && rect.right <= (window.innerWidth || document.documentElement.clientWidth);
  }

  function checkVisibility() {
    const fadeSlideElements = document.querySelectorAll('.fade-in');
    const fadeScrollElements = document.querySelectorAll('.fade-scroll');
    const fadeImageElements = document.querySelectorAll('.fade-in-image');

    fadeSlideElements.forEach((el, index) => {
      if (isElementInViewport(el)) {
        setTimeout(() => {
          el.classList.add('visible');
        }, index * 150);
      }
    });

    fadeScrollElements.forEach((el) => {
      if (isElementInViewport(el)) {
        el.classList.add('visible');
      }
    });

    fadeImageElements.forEach((el) => {
      if (isElementInViewport(el)) {
        el.classList.add('visible');
      }
    });
  }

  checkVisibility();
  window.addEventListener('scroll', checkVisibility);
});

function scrollToSection(id, offset = 0) {
  const element = document.querySelector(id);
  const position = element.getBoundingClientRect().top + window.pageYOffset - offset;
  window.scrollTo({
    top: position,
    behavior: 'smooth',
  });
}

document.querySelector('a[href="#section-2"]').addEventListener('click', function (event) {
  event.preventDefault();
  scrollToSection('#section-2', -160);
});

function scrollToSection(id, offset = 0) {
  const element = document.querySelector(id);
  const position = element.getBoundingClientRect().top + window.pageYOffset - offset;
  window.scrollTo({
    top: position,
    behavior: 'smooth',
  });
}

document.querySelector('a[href="#section-3"]').addEventListener('click', function (event) {
  event.preventDefault();
  scrollToSection('#section-3', -120);
});

function scrollToSection(id, offset = 0) {
  const element = document.querySelector(id);
  const position = element.getBoundingClientRect().top + window.pageYOffset - offset;
  window.scrollTo({
    top: position,
    behavior: 'smooth',
  });
}

document.querySelector('a[href="#section-4"]').addEventListener('click', function (event) {
  event.preventDefault();
  scrollToSection('#section-4', 560);
});
