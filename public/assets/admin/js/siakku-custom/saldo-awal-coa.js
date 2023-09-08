'use-strict';

function hitungTotalSaldo() {
      var totalDebet = 0;
      var totalKredit = 0;
      for (var i = 0; i < coa.length; i++) {
            (function (i) {
                  var obj = {};
                  var debetada = document.getElementById("saldo_debet" + coa[i].id_coa);
                  if (debetada) {
                        obj["getsaldodebet" + coa[i].id_coa] = document.getElementById("saldo_debet" + coa[i].id_coa)
                              .value;
                        obj["konvertdebet" + coa[i].id_coa] = obj["getsaldodebet" + coa[i].id_coa].split(".").join("")
                              .split("Rp").join("");
                        totalDebet += parseInt(obj["konvertdebet" + coa[i].id_coa]);
                  }
                  var kreditada = document.getElementById("saldo_kredit" + coa[i].id_coa);
                  if (kreditada) {
                        obj["getsaldokredit" + coa[i].id_coa] = document.getElementById("saldo_kredit" + coa[i].id_coa)
                              .value;
                        obj["konvertkredit" + coa[i].id_coa] = obj["getsaldokredit" + coa[i].id_coa].split(".").join("")
                              .split("Rp").join("");
                        totalKredit += parseInt(obj["konvertkredit" + coa[i].id_coa]);
                  }
            })(i);
      }

      document.getElementById('input_total_debet').value = totalDebet;
      document.getElementById('input_total_kredit').value = totalKredit;
      var hasildebet = currencyIdr(totalDebet, '');
      var hasilkredit = currencyIdr(totalKredit, '');
      document.getElementById('total_debet').innerHTML = hasildebet;
      document.getElementById('total_kredit').innerHTML = hasilkredit;
}