$(function () {
  'use strict';

  var quantityCounter = $('.quantity-counter'),
      CounterMin = 1,
      CounterMax = 10,
      bsStepper = document.querySelectorAll('.bs-stepper'),
      checkoutWizard = document.querySelector('.checkout-tab-steps');

  // bs-stepper işlevselliğini tamamen durduruyoruz.
  if (typeof bsStepper !== 'undefined' && bsStepper !== null) {
      for (var el = 0; el < bsStepper.length; ++el) {
          // Tüm event listener'ları kaldırarak işlevselliği durduruyoruz
          bsStepper[el].removeEventListener('show.bs-stepper', function () {});
      }
  }

  // checkout quantity counter işlevselliği - Bu bölümü muhafaza ediyoruz.
  if (quantityCounter.length > 0) {
      quantityCounter
          .TouchSpin({
              min: CounterMin,
              max: CounterMax
          })
          .on('touchspin.on.startdownspin', function () {
              var $this = $(this);
              $('.bootstrap-touchspin-up').removeClass('disabled-max-min');
              if ($this.val() == 1) {
                  $(this).siblings().find('.bootstrap-touchspin-down').addClass('disabled-max-min');
              }
          })
          .on('touchspin.on.startupspin', function () {
              var $this = $(this);
              $('.bootstrap-touchspin-down').removeClass('disabled-max-min');
              if ($this.val() == 10) {
                  $(this).siblings().find('.bootstrap-touchspin-up').addClass('disabled-max-min');
              }
          });
  }
});
