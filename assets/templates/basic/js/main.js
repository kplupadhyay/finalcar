
(function ($) {
  'use strict';


  /*============= dropdown js start start =============*/
  $('.dropdown-btn').on('click', function (event) {
    event.stopPropagation();
    $('.dropdown-menu-list').toggleClass("show-dropdown-list")
  })
  $('body').on('click', function () {
    $('.dropdown-menu-list').removeClass('show-dropdown-list');
  })
  //============= dropdown js end start =============*/

  // Activate scrollspy to add active class to navbar links on scroll




  // ========================= Client Slider Js Start ===============
  $('.client-slider').slick({
    arrows: false,
    infinite: true,
    slidesToShow: 7,
    slidesToScroll: 1,
    speed: 2000,
    cssEase: "linear",
    autoplay: true,
    autoplaySpeed: 0,
    adaptiveHeight: false,
    autoplay: true,
    pauseOnDotsHover: false,
    pauseOnHover: true,
    pauseOnFocus: true,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 6,
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 5
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 4
        }
      },
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 2
        }
      }
    ]
  });
  // ========================= Client Slider Js End ===================

  //============================ Scroll To Top Icon Js Start =========
  var btn = $('.scroll-top');

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, '300');
  });
  //========================= Scroll To Top Icon Js End ======================


  // ============== Header Hide Click On Body Js Start ========
  $('.header-button').on('click', function () {
    $('.body-overlay').toggleClass('show-overlay')
  });
  $('.body-overlay').on('click', function () {
    $('.header-button').trigger('click')
    $(this).removeClass('show-overlay');
  });
  // =============== Header Hide Click On Body Js End =========


  // ========================= Slick Slider Js Start ==============
  $(".testimonial-slider").slick({
    dots: false,
    arrows: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    speed: 5000,
    cssEase: "linear",
    autoplaySpeed: 0,
    autoplay: true,
    pauseOnHover: true,
    pauseOnFocus: true,
    infinite: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 650,
        settings: {
          slidesToShow: 1,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });
  /* ========================= Slick Slider Js End ===================*/

  // ========================= Client Slider Js Start ===============
  $('.testimonial-slider-rtl').slick({
    arrows: false,
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    speed: 5000,
    cssEase: "linear",
    autoplaySpeed: 0,
    adaptiveHeight: false,
    autoplay: true,
    rtl: true, // Set right-to-left mode
    pauseOnDotsHover: false,
    pauseOnHover: true,
    pauseOnFocus: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });
  // ========================= Client Slider Js Start ===============

  // ========================= Header Sticky Js End===================

  // ========================= banner section Sticky Js Start ==============
  window.addEventListener('scroll', function () {
    if (window.scrollY > 1400) {
      $('.banner-section').addClass('banner-show')
    } else {
      $('.banner-section').removeClass('banner-show')
    }
  });

  // ========================= banner section Sticky Js End===================

  $(window).on('load', function () {
    $('.preloader').fadeOut(1000);
  });

})(jQuery);

