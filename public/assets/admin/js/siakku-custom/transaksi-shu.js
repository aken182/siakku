'use strict';

$(document).ready(function () {
      var c = document.querySelectorAll('input[name="cek_penyesuaian"]'),
            ca = $('input[name="cek_penyesuaian"]'),
            id_pny = $('#id-penyesuaian'),
            e = $('.detail-penyesuaian'),
            dj = $('#detailJurnal'),
            j = $('.show-jurnal'),
            // tg = $('#tgl_transaksi'),
            ts = $('#tahun_shu'),
            t = $('#total-transaksi'),
            urlJurnal = $('#jurnal-route').data('route'),
            lihatJurnal = $('.lihat-jurnal');

      e.hide();
      j.hide();
      c.forEach(function (radio) {
            radio.addEventListener('change', function () {
                  if (this.value === 'penyesuaian') {
                        e.fadeIn();
                        j.fadeOut();
                        t.val("");
                        dj.hide().empty();

                  } else {
                        e.fadeOut();
                        j.fadeOut();
                        t.val("");
                        dj.hide().empty();
                  }
            })
      });

      lihatJurnal.click(function () {
            if (!ca.is(':checked')) {
                  const toastError = toastInfoTopRight("Anda belum memilih jenis transaksi !", "#ed2710");
                  toastError.showToast();
                  t.val("");
                  j.fadeOut();
                  return;
            }

            if (ts.val() === '') {
                  const toastError = toastInfoTopRight("Anda wajib memasukkan tahun SHU !", "#ed2710");
                  toastError.showToast();
                  t.val("");
                  j.fadeOut();
                  return;
            }

            let cak = $('input[name="cek_penyesuaian"]:checked').val();
            let request = {
                  tahun: ts.val()
            };

            if (cak === 'penyesuaian') {
                  if (id_pny.val() === '') {
                        const toastError = toastInfoTopRight("Anda belum memasukkan nomor transaksi penyesuaian !", "#ed2710");
                        toastError.showToast();
                        return;
                  }
                  request.id_penyesuaian = id_pny.val();
            }
            console.log(request);
            const token = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                  headers: {
                        'X-CSRF-TOKEN': token
                  }
            });

            $.ajax({
                  url: urlJurnal,
                  method: "GET",
                  data: request,
                  success: function (result) {
                        t.val(currencyIdr(result.total));
                        const jenis = result.jenis === 'penyesuaian' ? ' Penyesuaian' : '';
                        var jH = "<p class='text-success'><strong>Jurnal" + jenis + " Pembagian SHU :</strong></p>";
                        jH += "<table class='table table-striped table-bordered mb-1'>";
                        jH += "<thead class='table table-success'>";
                        jH += "<tr><td>Rekening</td><td>Ref</td><td>Debet</td><td>Kredit</td></tr>";
                        jH += "</thead><tbody>";
                        var hhh = 0;
                        result.jurnals.forEach(function (jurnal) {
                              jH += "<tr>";
                              if (jurnal.posisi_dr_cr === 'debet') {
                                    jH += "<td>" + jurnal.nama + "</td><td style='text-align:center'>" + jurnal.kode + "</td>";
                                    jH += "<td style='text-align:right'>" + currencyIdrDecimal(jurnal.nominal) + "</td><td style='text-align:center'>-</td>";
                              } else {
                                    hhh += jurnal.nominal;
                                    jH += "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + jurnal.nama + "</td>";
                                    jH += "<td style='text-align:center'>" + jurnal.kode + "</td><td style='text-align:center'>-</td>";
                                    jH += "<td style='text-align:right'>" + currencyIdrDecimal(jurnal.nominal) + "</td>";
                              }
                              jH += "</tr>";
                        });
                        jH += "</tbody></table>";
                        console.log(hhh);
                        dj.html(jH).show();
                        j.fadeIn();
                  },
                  error: function (xhr, status, error) {
                        const errorMessage = xhr.status + ': ' + xhr.statusText;
                        const toastInfo = toastInfoTopRight(errorMessage, "#ed2710");
                        toastInfo.showToast();
                        dj.hide().empty();
                        t.val("");
                        j.fadeOut();
                  }
            });

            const toastSuccess = toastInfoTopRight("Jurnal pembagian SHU berhasil ditambahkan !", "#4fbe87");
            toastSuccess.showToast();
      });


})