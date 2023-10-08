"use-strict";
$(document).ready(function () {
      var k = $("#rekening_kas"),
            b = $("#rekening_bank"),
            j = $("#metode_transaksi"),
            d = $(".detail-penyesuaian-pembayaran"),
            jnp = $('input[name="cek_pembayaran"]'),
            i = $('.info-pinjaman'),
            ip = $('#invoicePenyesuaianPembayaran'),
            p = $("#id_pinjaman"),
            kd = $('#kode-pinjaman'),
            n = $('#no-bukti-pinjaman'),
            tgl = $('#tanggal-pinjam'),
            nm = $('#nama-anggota'),
            s = $('#status-peminjaman'),
            sp = $('#saldo-pokok'),
            sb = $('#saldo-bunga'),
            tg = $('#total-tagihan'),
            ap = $("#angsuran-pokok"),
            ab = $("#angsuran-bunga"),
            ta = $("#total-angsuran"),
            submit = $(".simpanBtn");

      k.hide();
      b.hide();
      d.hide();
      i.hide();

      j.on("change", function () {
            let jt = $(this).val();
            if (jt === 'Kas') {
                  k.fadeIn();
                  b.fadeOut();
            } else {
                  b.fadeIn();
                  k.fadeOut();
            }
      });

      jnp.each(function () {
            $(this).on("change", function () {
                  let q = $(this).val();
                  if (q === "penyesuaian") {
                        d.fadeIn();
                  } else {
                        d.fadeOut();
                  }
                  i.fadeOut();
                  p.val("");
                  kd.html("");
                  n.html("");
                  tgl.html("");
                  nm.html("");
                  s.html("");
                  sp.html("");
                  sb.html("");
                  tg.html("");

            });
      });

      p.on("change", function () {
            let id_pinjaman = $(this).val();
            let id_penyesuaian = ip.val();
            if (id_pinjaman != '') {
                  if (jnp.is(':checked')) {
                        let jnpv = $('input[name="cek_pembayaran"]:checked').val();
                        if (jnpv === 'penyesuaian') {
                              var request = {
                                    id_pinjaman: id_pinjaman,
                                    id_penyesuaian: id_penyesuaian,
                              };
                        }
                        else {
                              var request = {
                                    id_pinjaman: id_pinjaman,
                              };

                        }
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajaxSetup({
                              headers: {
                                    'X-CSRF-TOKEN': csrf_token
                              }
                        });
                        $.ajax({
                              url: '/pinjaman/unit-sp/get-pinjaman',
                              method: "GET",
                              data: request,
                              success: function (result) {
                                    i.fadeIn();
                                    kd.html(result.data.kode);
                                    n.html(result.data.no_bukti);
                                    tgl.html(result.data.tgl_transaksi);
                                    nm.html(result.data.nama);
                                    s.html(result.data.status);
                                    sp.html(currencyIdr(result.data.saldo_pokok, 'Rp '));
                                    sb.html(currencyIdr(result.data.saldo_bunga, 'Rp '));
                                    tg.html(currencyIdr(result.data.total_pinjaman, 'Rp '));
                              },
                              error: function (xhr, status, error) {
                                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                                    const toastInfo = toastInfoTopRight(errorMessage, "#ed2710");
                                    toastInfo.showToast();
                                    i.fadeOut();
                              }
                        });
                  } else {
                        const toastInfo = toastInfoTopRight('Anda belum memilih jenis pembayaran!', "#ed2710");
                        toastInfo.showToast();
                        i.fadeOut();
                  }
            } else {
                  const toastInfo = toastInfoTopRight('Data tidak ditemukan!', "#ed2710");
                  toastInfo.showToast();
                  i.fadeOut();
            }
      });

      ap.on("keyup", function () {
            let getAp = $(this).val();
            let getSp = sp.html();
            let getAb = ab.val();
            if (getSp != '') {
                  let spc = getSp.split(".").join("").split("Rp").join("");
                  let apc = getAp.split(".").join("").split("Rp").join("");
                  let spn = parseInt(spc);
                  let apn = parseInt(apc);
                  if (apn > spn) {
                        const toastInfo = toastInfoTopRight('Angsuran pokok melebihi saldo pokok!', "#ed2710");
                        toastInfo.showToast();
                        ta.val("");
                        submit.prop("disabled", true);
                  } else {
                        if (getAb != '') {
                              const abc = getAb.split(".").join("").split("Rp").join("");
                              const abn = parseInt(abc);
                              const total = hitungTotalAngsuran(apn, abn);
                              ta.val(currencyIdr(total, 'Rp '));
                        } else {
                              const abn = 0;
                              const total = hitungTotalAngsuran(apn, abn);
                              ta.val(currencyIdr(total, 'Rp '));
                        }
                        submit.prop("disabled", false);
                  }
            } else {
                  const toastInfo = toastInfoTopRight('Anda harus memasukkan tagihan pinjaman!', "#ed2710");
                  toastInfo.showToast();
            }
      });

      ab.on("keyup", function () {
            let getAb = $(this).val();
            let getSb = sb.html();
            let getAp = ap.val();
            if (getSb != '') {
                  let sbc = getSb.split(".").join("").split("Rp").join("");
                  let abc = getAb.split(".").join("").split("Rp").join("");
                  let sbn = parseInt(sbc);
                  let abn = parseInt(abc);
                  if (abn > sbn) {
                        const toastInfo = toastInfoTopRight('Angsuran bunga melebihi saldo bunga!', "#ed2710");
                        toastInfo.showToast();
                        ta.val("");
                        submit.prop("disabled", true);
                  } else {
                        if (getAp != '') {
                              const apc = getAp.split(".").join("").split("Rp").join("");
                              const apn = parseInt(apc);
                              const total = hitungTotalAngsuran(apn, abn);
                              ta.val(currencyIdr(total, 'Rp '));
                        } else {
                              const apn = 0;
                              const total = hitungTotalAngsuran(apn, abn);
                              ta.val(currencyIdr(total, 'Rp '));
                        }
                        submit.prop("disabled", false);
                  }
            } else {
                  const toastInfo = toastInfoTopRight('Anda harus memasukkan tagihan pinjaman!', "#ed2710");
                  toastInfo.showToast();
            }
      });
});

function hitungTotalAngsuran(a, b) {
      const c = a + b;
      const cp = parseInt(c);
      const x = currencyIdr(cp, 'Rp ');
      return x;
}
