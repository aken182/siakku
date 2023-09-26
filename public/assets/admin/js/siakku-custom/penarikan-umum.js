'use-strict';

$(document).ready(function () {
      var s = $('#nama-simpanan');
      var a = $('#id-anggota');
      var sat = $('#sisa-title');
      var sas = $('#sisa-saldo');
      var sf = $('#saldo-field');
      var st = $('#saldo-title');
      var ss = $('#saldo-simpanan');
      var t = $('#total-transaksi');
      var i = $('#invoicePenyesuaian');
      var jnP = $('input[name="cek_penarikan"]');
      var rs = $('#route-saldo').data('route');
      var submit = $('#btn-submit');

      var myElement = $(".detail-penyesuaian-penarikan");
      myElement.hide();
      document.querySelectorAll('input[name="cek_penarikan"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                  if (this.value === 'penyesuaian') {
                        myElement.fadeIn(); // Efek fadeIn
                  } else {
                        myElement.fadeOut(); // Efek fadeOut
                  }
                  ss.val("");
                  sas.val("");
                  s.val("");
                  t.val("");
            });
      });

      a.on('change', function () {
            ss.val("");
            sas.val("");
            s.val("");
            t.val("");
      })

      sf.hide();
      s.on('change', function () {
            sas.val("");
            let id_anggota = a.val();
            let nama_simpanan = $(this).val();
            if (id_anggota != '' && nama_simpanan != '') {

                  if (jnP.is(':checked')) {
                        let jnPk = $('input[name="cek_penarikan"]:checked').val();
                        if (jnPk === 'penyesuaian') {
                              if (i.val() === '') {
                                    const toastError = toastInfoTopRight("Anda belum memasukan nomor transaksi penyesuaian !", "#ed2710");
                                    toastError.showToast();
                                    sf.fadeOut();
                              }
                              var request = {
                                    id_anggota: id_anggota,
                                    nama: nama_simpanan,
                                    id_penyesuaian: i.val(),
                              }
                        } else {
                              var request = {
                                    id_anggota: id_anggota,
                                    nama: nama_simpanan,
                              }
                        }

                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajaxSetup({
                              headers: {
                                    'X-CSRF-TOKEN': csrf_token
                              }
                        })

                        $.ajax({
                              url: rs,
                              method: "GET",
                              data: request,
                              success: function (result) {
                                    sf.fadeIn();
                                    st.html('Saldo ' + nama_simpanan);
                                    sat.html('Sisa Saldo ' + nama_simpanan);
                                    ss.val(currencyIdr(result.saldo, 'Rp '));
                              },
                              error: function (xhr, status, error) {
                                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                                    const toastInfo = toastInfoTopRight(errorMessage, "#ed2710");
                                    toastInfo.showToast();
                                    sf.fadeOut();

                              }
                        });

                  } else {
                        const toastError = toastInfoTopRight("Anda harus memilih jenis penarikan untuk melihat saldo simpanan !", "#ed2710");
                        toastError.showToast();
                        sf.fadeOut();
                  }

            } else {
                  const toastError = toastInfoTopRight("Anda harus memasukkan data anggota dan jenis simpanan dengan benar untuk melihat saldo simpanan !", "#ed2710");
                  toastError.showToast();
                  sf.fadeOut();
            }
      });
      t.on('keyup', function () {
            let getJumlah = $(this).val();
            let getSaldo = ss.val();
            if (getSaldo != "") {
                  let j = getJumlah.split(".").join("").split("Rp").join("");
                  let sl = getSaldo.split(".").join("").split("Rp").join("");
                  let jumlah = parseFloat(j);
                  let saldo = parseFloat(sl);
                  if (jumlah <= saldo && saldo > 0) {
                        const saldoAkhir = saldo - jumlah;
                        const ssval = currencyIdr(saldoAkhir, 'Rp ');
                        sas.val(ssval);
                        submit.prop("disabled", false);
                  } else {
                        const toastError = toastInfoTopRight("Saldo simpanan tidak cukup !", "#ed2710");
                        toastError.showToast();
                        submit.prop("disabled", true);
                  }
            } else {
                  const toastError = toastInfoTopRight("Saldo simpanan tidak boleh kosong !", "#ed2710");
                  toastError.showToast();
                  submit.prop("disabled", true);
            }
      })
})