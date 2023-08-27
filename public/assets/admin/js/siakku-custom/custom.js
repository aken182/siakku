/* Kafta Custom */
'use-strict';

$(document).ready(function () {
      /* Simple DataTable*/
      $('.dataTable').each(function () {
            new simpleDatatables.DataTable(this);
      });

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


function currencyIdr(angka, prefix) {
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
}