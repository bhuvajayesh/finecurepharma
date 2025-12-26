// Header Fix
$(window).scroll(function () {
  if ($(this).scrollTop() > 50) {
    $(".header").addClass("header-fixed");
  } else {
    $(".header").removeClass("header-fixed");
  }
});

// arrow appear and scroll to top
$(window).on("scroll", function () {
  if ($(this).scrollTop() > 500) {
    $(".scroll-top-arrow").fadeIn("slow");
  } else {
    $(".scroll-top-arrow").fadeOut("slow");
  }
});
$(document).on("click", ".scroll-top-arrow", function () {
  $("html, body").animate({ scrollTop: 0 }, 800);

  return false;
});

// Toggle hide/show
$(document).ready(function () {
  $(".toggleButton").click(function () {
    $(".custom-nav").toggleClass("menu-open");
  });
});

// number count for stats, using jQuery animate
$(".counting").each(function () {
  var $this = $(this),
    countTo = $this.attr("data-count");
  $({ countNum: $this.text() }).animate(
    {
      countNum: countTo,
    },
    {
      duration: 3000,
      easing: "linear",
      step: function () {
        $this.text(Math.floor(this.countNum));
      },
      complete: function () {
        $this.text(this.countNum);
        //alert('finished');
      },
    }
  );
});

// Home Therapeutic Slider
var swiper = new Swiper(".home-therapeutic-slider", {
  slidesPerView: 3.6,
  spaceBetween: 24,
  autoplay: {
    delay: 2500, // auto slide every 2.5s
    disableOnInteraction: false, // keeps autoplay after swipe
  },
  loop: false, // infinite loop
  allowTouchMove: true, // swipe enabled
  pagination: false, // remove dots
  navigation: false, // remove arrows
});

// Home Healthcare Brands Slider
var swiper = new Swiper(".home-healthcare-brands-slider", {
  slidesPerView: 3.6,
  spaceBetween: 24,
  autoplay: {
    delay: 2500, // auto slide every 2.5s
    disableOnInteraction: false, // keeps autoplay after swipe
  },
  loop: false, // infinite loop
  allowTouchMove: true, // swipe enabled
  pagination: false, // remove dots
  navigation: false, // remove arrows
});
