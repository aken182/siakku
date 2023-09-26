'use-strict';

$(document).ready(function () {
      var pb = $('#persen-bunga');
      var a = $('#id-anggota');
      var i = $('#invoicePenyesuaian');
      var jp = $('input[name="cek_penarikan_simpanan"]');
      var jnP = $('input[name="cek_penarikan"]');
      var bf = $('.bungas-field');
      var sf = $('.saldos-field');
      var b = $('#bunga-sebelum');
      var s = $('#saldo-sebelum');
      var bs = $('#bunga');
      var ss = $('#saldo-simpanan');
      var t = $('#total-transaksi');
      var detil = $(".detail-penyesuaian-penarikan");
      var submit = $('#btn-submit');

      bf.hide();
      sf.hide();
      detil.hide();
      document.querySelectorAll('input[name="cek_penarikan"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                  if (this.value === 'penyesuaian') {
                        detil.fadeIn(); // Efek fadeIn
                  } else {
                        detil.fadeOut(); // Efek fadeOut
                  }
                  bf.fadeOut();
                  sf.fadeOut();
                  b.val('');
                  s.val('');
                  t.val('');
                  bs.val('');
                  ss.val('');
            });
      });

      document.querySelectorAll('input[name="cek_penarikan_simpanan"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                  t.val('');
                  bs.val('');
                  ss.val('');
            });
      });

      pb.on('change', function () {
            bf.fadeOut();
            sf.fadeOut();
            a.val('');
            b.val('');
            s.val('');
            t.val('');
            bs.val('');
            ss.val('');
      })

      a.on('change', function () {
            let persen_bunga = pb.val();
            let id_anggota = $(this).val();
            if (id_anggota != '' && persen_bunga != '') {
                  if (jnP.is(':checked')) {
                        let jnPv = $('input[name="cek_penarikan"]:checked').val();
                        if (jnPv === 'penyesuaian') {
                              if (i.val() === '') {
                                    const toastError = toastInfoTopRight("Anda belum memasukan nomor transaksi penyesuaian !", "#ed2710");
                                    toastError.showToast();
                                    bf.fadeOut();
                                    sf.fadeOut();
                              }
                              var request = {
                                    id_anggota: id_anggota,
                                    persen_bunga: persen_bunga,
                                    id_penyesuaian: i.val(),
                              }
                        } else {
                              var request = {
                                    id_anggota: id_anggota,
                                    persen_bunga: persen_bunga,
                              }
                        }

                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajaxSetup({
                              headers: {
                                    'X-CSRF-TOKEN': csrf_token
                              }
                        })

                        $.ajax({
                              url: '/simpanan/unit-sp/get-saldo-sukarela-berbunga',
                              method: "GET",
                              data: request,
                              success: function (result) {
                                    bf.fadeIn();
                                    sf.fadeIn();
                                    b.val(currencyIdr(result.bunga, 'Rp '));
                                    s.val(currencyIdr(result.saldo, 'Rp '));
                              },
                              error: function (xhr, status, error) {
                                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                                    const toastInfo = toastInfoTopRight(errorMessage, "#ed2710");
                                    toastInfo.showToast();

                              }
                        });

                  } else {
                        const toastError = toastInfoTopRight("Anda harus memilih jenis transaksi untuk melihat saldo simpanan !", "#ed2710");
                        toastError.showToast();
                  }

            } else {
                  const toastError = toastInfoTopRight("Anda harus memasukkan data anggota dan persentase bunga dengan benar untuk melihat saldo simpanan !", "#ed2710");
                  toastError.showToast();
            }
      });

      t.on('keyup', function () {
            let getJumlah = $(this).val();
            if (jp.is(':checked')) {
                  let jpv = $('input[name="cek_penarikan_simpanan"]:checked').val();
                  let getSaldo = s.val();
                  let getPersenBunga = pb.val();
                  if (getSaldo != "" && getPersenBunga != '') {
                        let j = getJumlah.split(".").join("").split("Rp").join("");
                        let sl = getSaldo.split(".").join("").split("Rp").join("");
                        let jumlah = parseFloat(j);
                        let saldo = parseFloat(sl);
                        let persenBunga = parseFloat(getPersenBunga);
                        if (jumlah <= saldo && saldo > 0) {
                              if (jpv === 'penarikan pokok') {
                                    const saldoAkhir = saldo - jumlah;
                                    const bungaAkhir = saldoAkhir * (persenBunga / 100);
                                    const bsval = currencyIdr(bungaAkhir, 'Rp ');
                                    const ssval = currencyIdr(saldoAkhir, 'Rp ');
                                    ss.val(ssval);
                                    bs.val(bsval);
                              } else {
                                    const ssval = s.val();
                                    const bsval = b.val();
                                    ss.val(ssval);
                                    bs.val(bsval);
                              }
                              submit.prop("disabled", false);
                        } else {
                              const toastError = toastInfoTopRight("Saldo simpanan tidak cukup !", "#ed2710");
                              toastError.showToast();
                              submit.prop("disabled", true);
                        }
                  } else {
                        const toastError = toastInfoTopRight("Saldo simpanan dan persentase bunga tidak boleh kosong !", "#ed2710");
                        toastError.showToast();
                        submit.prop("disabled", true);
                  }
            } else {
                  const toastError = toastInfoTopRight("Jenis penarikan wajib dipilih !", "#ed2710");
                  toastError.showToast();
                  submit.prop("disabled", true);
            }
      })
})