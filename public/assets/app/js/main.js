$(document).ready(function () {
  //Gallery
  $(".tracking_app_item").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });
});

//OutSide Scroll Hidden
function scrollOutsideHidden() {
  let htmlTag = document.querySelector("html");
  htmlTag.style.cssText = "overflow:hidden;";
}
//OutSide Scroll Scroll
function scrollOutsideScroll() {
  let htmlTag = document.querySelector("html");
  htmlTag.style.cssText = "overflow:auto;";
}

//Sticky Navbar
//Sticky Navbar
function stickyHeader(stickyTag, stickyClass, scrollHeight = 0) {
  let stickyWrapper = document.querySelector(`#${stickyTag}`);
  stickyWrapper.classList.toggle(stickyClass, scrollY > scrollHeight);
}
let headerWrapper = document.querySelector("#headerWrapper");
if (headerWrapper) {
  window.addEventListener("scroll", () => {
    stickyHeader("headerWrapper", "navbar_fixed");
  });
}

// Mobile Menu
let navbarIcon = document.querySelector("#menuToggleBtn");
let navbarCloseIcon = document.querySelector(".close_icon");
let navbarOverlay = document.querySelector(".mobile_menu_overlay");
let mobileMenuArea = document.querySelector(".mobile_menu_area");
if (navbarIcon) {
  navbarIcon.addEventListener("click", () => {
    mobileMenuArea.classList.add("navbar_active");
    scrollOutsideHidden();
  });
}
if (navbarIcon) {
  navbarCloseIcon.addEventListener("click", () => {
    hideNavbar();
  });
}

if (navbarIcon) {
  navbarOverlay.addEventListener("click", () => {
    hideNavbar();
  });
}

function hideNavbar() {
  mobileMenuArea.classList.remove("navbar_active");
  scrollOutsideScroll();
}

// Form Validation Methods Using Bootstrap 5
(function () {
  "use strict";

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll(".needs-validation");

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();

//Tracking app slider
const swiperTracking = new Swiper(".tracking_slider_area .swiper", {
  slidesPerView: "auto",
  // slidesPerGroup: "auto",
  centeredSlides: true,
  speed: 1100,
  spaceBetween: 10,
  freeMode: true,
  initialSlide: 2,
  // Responsive breakpoints
  breakpoints: {
    320: {
      spaceBetween: 20,
    },

    768: {
      spaceBetween: 20,
    },

    1200: {
      spaceBetween: 40,
    },
  },
  pagination: {
    el: ".tracking_slider_area .swiper-pagination",
    dynamicBullets: true,
    clickable: true,
  },
});

// ScrollToUp
let scroll = document.querySelector("#scrollTop");
function scrollUp() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}
if (scroll) {
  window.addEventListener("scroll", function () {
    scroll.classList.toggle("scroll_active", window.scrollY > 500);
  });
  scroll.addEventListener("click", () => {
    scrollUp();
  });
}

// AOS On Page Scroll JS
$(function () {
  AOS.init({
    duration: 1100,
    offest: 50,
    once: true,
  });
});
