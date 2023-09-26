'use-strict';

$(document).ready(function () {
      var myElement = $(".detail-penyesuaian-simpanan");
      myElement.hide();
      document.querySelectorAll('input[name="cek_simpanan"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                  if (this.value === 'penyesuaian') {
                        myElement.fadeIn(); // Efek fadeIn
                  } else {
                        myElement.fadeOut(); // Efek fadeOut
                  }
            });
      });
})