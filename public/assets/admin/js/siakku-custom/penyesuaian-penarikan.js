/*belanja barang adjustment*/
$(document).ready(function () {
      $(function () {
            $('.invoicePenyesuaian').each(function (index, element) {
                  $(element).change(function () {
                        var transaksi_id = $(this).val();
                        if (transaksi_id != '') {
                              var csrf_token = $('meta[name="csrf-token"]').attr('content');
                              $.ajaxSetup({
                                    headers: {
                                          'X-CSRF-TOKEN': csrf_token
                                    }
                              })
                              var routeUrl = $('#routeUrl').data('route');
                              $.ajax({
                                    url: routeUrl,
                                    method: "GET",
                                    data: {
                                          transaksi_id: transaksi_id
                                    },
                                    success: function (result) {
                                          var html = "";
                                          const tanggal = new Date(result.detail.transaksi.tgl_transaksi);
                                          const dd = tanggal.getDate().toString().padStart(2, '0');
                                          const mm = (tanggal.getMonth() + 1).toString().padStart(2, '0');
                                          const yy = tanggal.getFullYear();
                                          const tgl = dd + '/' + mm + '/' + yy;
                                          html += "<div class='row mt-3'>";
                                          html += "<h5 class='text-capitalize text-success'>Detil Penarikan</h5>";
                                          html += "</div>";
                                          html += "<div class='row mb-2 pb-1'>";
                                          html += "<div class='col-lg-12 col-md-12'>";
                                          html += "<table class='table table-borderless'>";
                                          html += "<tr>";
                                          html += "<td>Nomor Transaksi</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + result.detail.transaksi.kode + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Nomor Bukti</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + result.detail.transaksi.no_bukti + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Tanggal Transaksi</td>";
                                          html += "<td style='text-align: right' class='text-dark'>" + tgl + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Nama Anggota</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.detail.anggota.nama + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Tempat Tugas</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.detail.anggota.tempat_tugas + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Jenis Simpanan</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.detail.nama_penarikan + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Jumlah Penarikan</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + currencyIdr(result.detail.jumlah_penarikan, 'Rp ') + "</td>";
                                          html += "</tr>";
                                          html += "</table>";
                                          html += "</div>";
                                          html += "</div>";
                                          html += "<p><strong>Jurnal Penarikan:</strong></p>";
                                          html +=
                                                "<table class='table table-hover table-bordered mb-1'>";
                                          html += "<thead class='table table-success'>";
                                          html += "<tr>";
                                          html += "<td>Rekening</td>";
                                          html += "<td>Ref</td>";
                                          html += "<td>Debet</td>";
                                          html += "<td>Kredit</td>";
                                          html += "</tr>";
                                          html += "</thead>";
                                          html += "<tbody>";
                                          result.jurnals.forEach(function (jurnal) {
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
                                                      html += "<td style='text-align:right'>" +
                                                            currencyIdr(jurnal
                                                                  .nominal, 'Rp ') + "</td>";
                                                }
                                                html += "</tr>";
                                          });
                                          html += "</tbody>";
                                          html += "</table>";
                                          html += "</div>";
                                          $('.detailPenarikan').html(html).show();
                                    },
                                    error: function (xhr, status, error) {
                                          var errorMessage = xhr.status + ': ' + xhr.statusText;
                                          const toastInfo = toastInfoTopRight(errorMessage, "#ed2710");
                                          toastInfo.showToast();
                                    }
                              });
                        } else {
                              $('.detailPenarikan').hide().empty();
                        }
                  });
            });
      });
})