'use-strict';

$(document).ready(function () {

      var s = $(".select-pinjaman"),
            id = $("#id-pinjaman"),
            d = $(".detail-pinjaman"),
            url = $("#route-pinjaman").data("route"),
            kp = $("#kode-pinjaman"),
            n = $("#nama-anggota"),
            tgl = $("#tanggal-pinjam"),
            sp = $("#saldo-pokok"),
            cp = $('input[name="cek_penyesuaian"]'),
            ip = $("#id-penyesuaian"),
            sb = $("#saldo-bunga"),
            t = $("#total-transaksi"),
            fsp = $(".field-saldo-pokok"),
            fsb = $(".field-saldo-bunga"),
            sps = $("#saldo-pokok-sekarang"),
            sbs = $("#saldo-bunga-sekarang");

      d.hide();
      fsp.hide();
      fsb.hide();
      s.each(function (index, element) {
            $(element).change(function () {
                  var id_pinjaman = $(this).val();
                  let id_penyesuaian = ip.val();
                  sps.val("");
                  sbs.val("");
                  t.val("");
                  fsp.fadeOut();
                  fsb.fadeOut();
                  if (id_pinjaman != '') {
                        if (cp.is(':checked')) {
                              let cpv = $('input[name="cek_penyesuaian"]:checked').val();
                              if (cpv === 'penyesuaian') {
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
                              })
                              $.ajax({
                                    url: url,
                                    method: "GET",
                                    data: request,
                                    success: function (data) {
                                          d.fadeIn();
                                          kp.html("#" + data.detail.transaksi.kode);
                                          n.html(data.detail.anggota.nama);
                                          const tanggal = new Date(data.detail.transaksi.tgl_transaksi);
                                          const dd = tanggal.getDate().toString().padStart(2, '0');
                                          const mm = (tanggal.getMonth() + 1).toString().padStart(2, '0');
                                          const yy = tanggal.getFullYear();
                                          const tglv = dd + '/' + mm + '/' + yy;
                                          tgl.html(tglv);
                                          sp.html(currencyIdr(data.detail.saldo_pokok, 'Rp '));
                                          sb.html(currencyIdr(data.detail.saldo_bunga, 'Rp '));
                                    },
                                    error: function (xhr, status, error) {
                                          var errorMessage = xhr.status + ': ' + xhr.statusText;
                                          const toastError = toastInfoTopRight(errorMessage, "#ed2710");
                                          toastError.showToast();
                                    }
                              });
                        } else {
                              const toastInfo = toastInfoTopRight('Anda belum memilih jenis transaksi!', "#ed2710");
                              toastInfo.showToast();
                              d.fadeOut();
                        }
                  } else {
                        d.fadeOut();
                        const toastError = toastInfoTopRight("Data Tidak Ditemukan !", "#ed2710");
                        toastError.showToast();
                  }
            });
      });

      t.on("keyup", function () {
            let total = $(this).val();
            fsp.fadeIn();
            fsb.fadeIn();
            let id_pinjaman = id.val();
            if (id_pinjaman != '') {
                  const totalc = total.split(".").join("").split("Rp").join("");
                  const getSp = sp.html();
                  const getSb = sb.html();
                  const spc = getSp.split(".").join("").split("Rp").join("");
                  const totalx = parseInt(totalc);
                  const spx = parseInt(spc);
                  const fix = totalx + spx;
                  sps.val(currencyIdr(fix, 'Rp '));
                  sbs.val(getSb);
            } else {
                  const toastError = toastInfoTopRight("Data Tidak Ditemukan !", "#ed2710");
                  toastError.showToast();
            }
      })
})