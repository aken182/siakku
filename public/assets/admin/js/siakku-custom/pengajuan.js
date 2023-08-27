"use-strict";
function hitung() {
      function convertToNumber(input) {
            return parseFloat(input.split(".").join("").split("Rp").join(""));
      }

      function calculateCurrencyIdr(value) {
            return currencyIdr(value, '');
      }

      var inputs = [
            'gaji_perbulan', 'potongan_perbulan', 'cicilan_perbulan', 'biaya_perbulan',
            'jumlah_pinjaman', 'asuransi', 'perkiraan', 'jangka_waktu', 'bunga'
      ];

      var values = inputs.map(function (inputId) {
            return convertToNumber(document.getElementById(inputId).value);
      });

      var [gaji, potongan, cicilan, biaya, pinjaman, administrasi, perkiraan, bulan, bunga] = values;

      var total = potongan + cicilan + biaya;
      var total1 = gaji - total;
      var total2 = (perkiraan / 100) * total1;
      var total3 = (bunga / 100) * pinjaman;
      var total8 = 0.05 * pinjaman;
      var total4 = Math.floor(pinjaman / bulan);
      var total6 = total4;
      var total5 = total3 + total6;
      var total7 = pinjaman - (administrasi + total8);

      var results = [
            total1, total2, total3, total6, total5, total7, total8
      ].map(calculateCurrencyIdr);

      var outputFields = [
            'sisa_penghasilan', 'kemampuan_bayar', 'angsuran_bunga',
            'angsuran_pokok', 'total_angsuran', 'total_pinjaman', 'kapitalisasi'
      ];

      results.forEach(function (result, index) {
            document.getElementById(outputFields[index]).value = result;
      });
}
