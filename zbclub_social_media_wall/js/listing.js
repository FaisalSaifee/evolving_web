/**
 * @file
 * ZB Club Social Media Wall utilities.
 *
 */
(function ($, Drupal) {

  "use strict";

  App.page.fbslider = function () {
    let modulePath = drupalSettings.modulePath;
    console.log("Inside function");
    // load slick js first
    $('.js-reader-club-slider').slick({
      dots: false,
      infinite: false,
      slidesToShow: 1,
      arrows: true,
      prevArrow: "<button type='button' class='slick-prev'><img src=" + modulePath + "/images/icon/arrow-prev.svg></button>",
      nextArrow: "<button type='button' class='slick-next'><img src=" + modulePath + "/images/icon/arrow-next.svg></button>",
      rows: 0
    });
    var sliderGallery = $('.overlay.js-overlay.overlay-fb-gallery');
    var slidesArry = $('.overlay-content-container.mobile');
    var cloneArry = slidesArry.clone(true, true);
    var index;
    $('.js-fb-gallery').on('click', function (e) {
      e.preventDefault();
      index = $(e.currentTarget).data('id');
      sliderGallery = $('.overlay.js-overlay.overlay-fb-gallery');
      sliderGallery.css('visibility', 'visible');
      sliderGallery.css('z-index', '4');
      sliderGallery.css('opacity', '1');

      // slick slider initial when click on the image slider appear and direct to the particular images base on index
      $('.js-reader-club-slider').slick('slickSetOption', 'speed', 0);
      $('.js-reader-club-slider').slick('slickGoTo', index);
      $('.js-reader-club-slider').slick('slickSetOption', 'speed', 500);
      $('body').css('overflow', 'hidden');
    });
    $(window).on('load resize', function () {
      $('body').removeAttr('style');
      var windowSize = $(window).width();
      sliderGallery.css('visibility', 'hidden');
      if (windowSize < 768) {
        // filter left the list to left desktop class
        $('.js-reader-club-slider').slick('slickFilter', '.desktop');
      } else {
        var slideLength = $('.overlay-content-container.slick-slide').length;
        if (slideLength < 8) {
          // add the clonelisting back to container
          console.log('do something');
          $('.js-reader-club-slider').slick('slickAdd', cloneArry);
          $('.js-reader-club-slider').slick('slickGoTo', index);
        }
      }

      // detect first and last slide
      $('.js-reader-club-slider').on('beforeChange', function (e, slick, currentSlide, nextSlide) {
        if (nextSlide === 0) {
          $('.slick-prev').addClass('slick-disabled');
        } else {
          $('.slick-prev').removeClass('slick-disabled');
        }
      });
    });
    // slider end

    // thumbnail function start
    if ($('.thumbnail').length > 0) {
      $('.thumbnail').on('click', function (e) {
        e.preventDefault();
        $('.thumbnail').removeClass('is-active');
        $(e.currentTarget).addClass('is-active');
        var imgUrl = $(e.currentTarget).css('background-image').slice(5, -2);
        var displayImage = $(e.currentTarget).closest('.overlay-image-container').find('img').eq(0);
        displayImage.attr('src', imgUrl);
      });
    }
    // cancel cta
    var canelCta = $('.overlay-fb-gallery .overlay-wrap').find('.cancel');
    canelCta.on('click', function () {
      sliderGallery.css('visibility', 'hidden');
      $('body').removeAttr('style');
    });
  };
  App.page.fbslider();
})(jQuery, Drupal);