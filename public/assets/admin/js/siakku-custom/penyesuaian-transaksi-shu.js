'use strict';

$(document).ready(function () {
      var invPny = $('.invoicePenyesuaian'),
            url = $("#penyesuaian-route").data("route"),
            detailPenyesuaian = $("#detailTransaksi");
      invPny.each(function (index, element) {
            $(element).change(function () {
                  var transaksi_id = $(this).val();
                  if (transaksi_id != '') {
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajaxSetup({
                              headers: {
                                    'X-CSRF-TOKEN': csrf_token
                              }
                        })
                        $.ajax({
                              url: url,
                              method: "GET",
                              data: {
                                    transaksi_id: transaksi_id
                              },
                              success: function (result) {
                                    var html = "";
                                    const tanggal = new Date(result.details.tgl_transaksi);
                                    const dd = tanggal.getDate().toString().padStart(2, '0');
                                    const mm = (tanggal.getMonth() + 1).toString().padStart(2, '0');
                                    const yy = tanggal.getFullYear();
                                    const tgl = dd + '/' + mm + '/' + yy;
                                    const jenis = result.details.tipe === 'penyesuaian' ? ' Penyesuaian' : '';
                                    html += "<div class='row mt-3'>";
                                    html += "<h5 class='text-capitalize text-success'>Detil Transaksi</h5>";
                                    html += "</div>";
                                    html += "<div class='row mb-2 pb-1'>";
                                    html += "<div class='col-lg-9 col-md-6'>";
                                    html += "<table class='table table-borderless'>";
                                    html += "<tr>";
                                    html += "<td>No. Transaksi</td>";
                                    html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + result.details.kode + "</td>";
                                    html += "</tr>";
                                    html += "<tr>";
                                    html += "<td>Tanggal Transaksi</td>";
                                    html += "<td style='text-align: right' class='text-dark'>" + tgl + "</td>";
                                    html += "</tr>";
                                    html += "<tr>";
                                    html += "<td>Tahun Buku</td>";
                                    html += "<td style='text-align: right' class='text-dark'>Tahun " + result.details.tahun_buku + "</td>";
                                    html += "</tr>";
                                    html += "<tr>";
                                    html += "<td>Keterangan</td>";
                                    html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.details.keterangan + "</td>";
                                    html += "</tr>";
                                    html += "</table>";
                                    html += "</div>";
                                    html += "</div>";
                                    html += "<div class='row mb-2 pb-1 bg-theme-dark'>";
                                    html += "<p><strong class='text-success'>Jurnal" + jenis + " Pembagian SHU:</strong></p>";
                                    html += "<div class='table table-responsive text-nowrap pb-4'>";
                                    html += "<table class='table table-striped table-bordered mb-1'>";
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
                                                html += "<td style='text-align:center'>" + jurnal.coa.kode + "</td>";
                                                html += "<td style='text-align:right'>" + currencyIdr(jurnal.nominal, 'Rp ') + "</td>";
                                                html += "<td style='text-align:center'>-</td>";
                                          } else {
                                                html += "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + jurnal.coa.nama + "</td>";
                                                html += "<td style='text-align:center'>" + jurnal.coa.kode + "</td>";
                                                html += "<td style='text-align:center'>-</td>";
                                                html += "<td style='text-align:right'>" + currencyIdr(jurnal.nominal, 'Rp ') + "</td>";
                                          }
                                          html += "</tr>";
                                    });
                                    html += "</tbody>";
                                    html += "</table>";
                                    html += "</div>";
                                    html += "</div>";
                                    detailPenyesuaian.html(html).show();
                              },
                              error: function (xhr, status, error) {
                                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                                    const toastInfo = toastInfoTopRight(errorMessage, "#ed2710");
                                    toastInfo.showToast();
                              }
                        });
                  } else {
                        detailPenyesuaian.hide().empty();
                  }
            });
      });
})