/* Kafta Custom */
'use-strict';

$(document).ready(function () {
      /* Tooltip*/
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
      })

      tinymce.init({
            selector: '#defaultNews'
      });
      tinymce.init({
            selector: '#dark',
            toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
            plugins: 'code'
      });

      /* real time format ke rupiah */
      !(function formatRupiah() {
            $('.format-rupiah').each(function (index, element) {
                  $(element).on('input', function (e) {
                        const inputVal = e.target.value.replace(/[^0-9]/g, '')

                        const formattedVal =
                              'Rp ' + new Intl.NumberFormat('id-ID').format(inputVal)

                        e.target.value = formattedVal
                  })
            });
      })();
      /* end real time format ke rupiah */
});

$(function () {
      var e = $(".selectpicker")
            , t = $(".select2")
            , n = $(".select2-icons");
      function i(e) {
            return e.id ? "<i class='" + $(e.element).data("icon") + " me-2'></i>" + e.text : e.text
      }
      e.length && e.selectpicker(),
            t.length && t.each(function () {
                  var e = $(this);
                  e.wrap('<div class="position-relative"></div>').select2({
                        placeholder: "Select value",
                        dropdownParent: e.parent()
                  })
            }),
            n.length && n.wrap('<div class="position-relative"></div>').select2({
                  dropdownParent: n.parent(),
                  templateResult: i,
                  templateSelection: i,
                  escapeMarkup: function (e) {
                        return e
                  }
            })
});

function currencyIdr(angka, prefix) {
      if (typeof angka === 'number') {
            angka = angka.toString();
      }
      if (prefix != "") {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                  split = number_string.split(','),
                  sisa = split[0].length % 3,
                  rupiah = split[0].substr(0, sisa),
                  ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                  separator = sisa ? '.' : '';
                  rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
      } else {
            var number_string = angka.toString(),
                  sisa = number_string.length % 3,
                  rupiah = number_string.substr(0, sisa),
                  ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                  separator = sisa ? '.' : '';
                  rupiah += separator + ribuan.join('.');
            }
            return rupiah == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
      }
};

function toastInfoTopRight(info, color) {
      const result = Toastify({
            text: info,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: color,
      });
      return result;
}


