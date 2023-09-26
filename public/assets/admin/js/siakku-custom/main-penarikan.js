'use-strict';

$(document).ready(function () {
      var m = $('.metode-transaksi');
      var k = $('.akun-kas');
      var b = $('.akun-bank');

      k.hide();
      b.hide();
      m.on('change', function () {
            mv = $(this).val();
            if (mv === 'Kas') {
                  k.fadeIn();
                  b.fadeOut();
            } else {
                  b.fadeIn();
                  k.fadeOut();

            }
      })
})