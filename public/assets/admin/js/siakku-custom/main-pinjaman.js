"use-strict";
$(document).ready(function () {
      var myElement = $(".detail-penyesuaian");
      myElement.hide();
      document.querySelectorAll('input[name="cek_penyesuaian"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                  if (this.value === 'penyesuaian') {
                        myElement.fadeIn(); // Efek fadeIn
                  } else {
                        myElement.fadeOut(); // Efek fadeOut
                  }
            });
      });

      !(function jenisTrans() {
            var kas = $("#rekening_kas");
            var bank = $("#rekening_bank");
            var jenis = $("#metode_transaksi");
            kas.hide();
            bank.hide();
            jenis.on("change", function () {
                  let jt = $(this).val();
                  if (jt === 'Kas') {
                        kas.fadeIn();
                        bank.fadeOut();
                  } else {
                        bank.fadeIn();
                        kas.fadeOut();
                  }
            });
      })();

      !(function penyesuaian() {
            $('.invoicePenyesuaian').each(function (index, element) {
                  $(element).change(function () {
                        var id_penyesuaian = $(this).val();
                        var routeUrl = $('#route-detail').data('route');
                        var jenis = $('#jenis-penyesuaian').data('jenis');
                        console.log(jenis);
                        if (id_penyesuaian != '') {
                              var csrf_token = $('meta[name="csrf-token"]').attr('content');
                              $.ajaxSetup({
                                    headers: {
                                          'X-CSRF-TOKEN': csrf_token
                                    }
                              })
                              $.ajax({
                                    url: routeUrl,
                                    method: "GET",
                                    data: {
                                          id_penyesuaian: id_penyesuaian,
                                          jenis: jenis
                                    },
                                    success: function (data) {
                                          var html = "";
                                          html += "<div class='row mt-3'>";
                                          html += "<h5 class='text-capitalize text-success'>Detil Transaksi</h5>";
                                          html += "</div>";
                                          html += "<div class='row mb-2 pb-1'>";
                                          html += "<div class='col-lg-12 col-md-12'>";
                                          html += "<table class='table table-borderless'>";
                                          html += "<tr>";
                                          html += "<td>Nomor Transaksi</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + data.detail.kode + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Nomor Bukti</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + data.detail.no_bukti + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Nama Anggota</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + data.detail.nama + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Tempat Tugas</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + data.detail.tempat_tugas + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Tanggal Transaksi</td>";
                                          html += "<td style='text-align: right' class='text-dark'>" + data.detail.tgl_transaksi + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Jumlah Pinjaman</td>";
                                          html += "<td style='text-align: right' class='text-dark'>" + currencyIdr(data.detail.jumlah_pinjaman, 'Rp ') + "</td>";
                                          html += "</tr>";
                                          if (jenis === 'pinjam tindis') {
                                                html += "<tr>";
                                                html += "<td>Penambahan Pinjaman</td>";
                                                html += "<td style='text-align: right' class='text-dark'>" + currencyIdr(data.detail.pinjam_tindis, 'Rp ') + "</td>";
                                                html += "</tr>";
                                          }
                                          html += "<tr>";
                                          html += "<td>Saldo Pokok Pinjaman</td>";
                                          html += "<td style='text-align: right' class='text-dark'>" + currencyIdr(data.detail.saldo_pokok, 'Rp ') + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Saldo Bunga Pinjaman</td>";
                                          html += "<td style='text-align: right' class='text-dark'>" + currencyIdr(data.detail.saldo_bunga, 'Rp ') + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Status</td>";
                                          html += "<td style='text-align: right' class='text-dark text-capitalize'>" + data.detail.status + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Keterangan</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + data.detail.keterangan + "</td>";
                                          html += "</tr>";
                                          html += "</table>";
                                          html += "</div>";
                                          html += "</div>";
                                          const titleJurnal = jenis === 'pinjam tindis' ? 'Jurnal Penambahan Pinjaman' : 'Jurnal Pinjaman';
                                          html += "<p class='text-success'><strong>" + titleJurnal + "</strong></p>";
                                          html +=
                                                "<table class='table table-striped table-bordered mb-1'>";
                                          html += "<thead class='table table-success'>";
                                          html += "<tr>";
                                          html += "<td>Rekening</td>";
                                          html += "<td>Ref</td>";
                                          html += "<td>Debet</td>";
                                          html += "<td>Kredit</td>";
                                          html += "</tr>";
                                          html += "</thead>";
                                          html += "<tbody>";
                                          data.jurnals.forEach(function (jurnal) {
                                                html += "<tr>";
                                                if (jurnal.posisi_dr_cr === 'debet') {
                                                      html += "<td>" + jurnal.coa.nama + "</td>";
                                                      html += "<td style='text-align:center'>" + jurnal
                                                            .coa.kode + "</td>";
                                                      html += "<td style='text-align:right'>" +
                                                            currencyIdr(jurnal
                                                                  .nominal, 'Rp ') + "</td>";
                                                      html += "<td style='text-align:center'>-</td>";
                                                } else {
                                                      html +=
                                                            "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" +
                                                            jurnal.coa.nama + "</td>";
                                                      html += "<td style='text-align:center'>" + jurnal
                                                            .coa.kode + "</td>";
                                                      html += "<td style='text-align:center'>-</td>";
                                                      html += "<td style='text-align:right'>" + currencyIdr(jurnal.nominal, 'Rp ') + "</td>";
                                                }
                                                html += "</tr>";
                                          });
                                          html += "</tbody>";
                                          html += "</table>";
                                          html += "</div>";
                                          $('#detailTransaksi').html(html).show();
                                    },
                                    error: function (xhr, status, error) {
                                          var errorMessage = xhr.status + ': ' + xhr.statusText;
                                          const toastError = toastInfoTopRight(errorMessage, "#ed2710");
                                          toastError.showToast();
                                    }
                              });
                        } else {
                              $('#detailTransaksi').hide().empty();
                        }
                  });
            });
      })();
});
