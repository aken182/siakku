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
                                          const tanggal = new Date(result.transaksi.transaksi.tgl_transaksi);
                                          const dd = tanggal.getDate().toString().padStart(2, '0');
                                          const mm = (tanggal.getMonth() + 1).toString().padStart(2, '0');
                                          const yy = tanggal.getFullYear();
                                          const tgl = dd + '/' + mm + '/' + yy;
                                          let jenis = result.transaksi.jenis_simpanan;
                                          html += "<div class='row mt-3'>";
                                          html += "<h5 class='text-capitalize text-success'>Detil Transaksi</h5>";
                                          html += "</div>";
                                          html += "<div class='row mb-2 pb-1'>";
                                          html += "<div class='col-lg-12 col-md-12'>";
                                          html += "<table class='table table-borderless'>";
                                          html += "<tr>";
                                          html += "<td>Nomor Transaksi</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + result.transaksi.transaksi.kode + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Nomor Bukti</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + result.transaksi.transaksi.no_bukti + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Tanggal Transaksi</td>";
                                          html += "<td style='text-align: right' class='text-dark'>" + tgl + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Nama Anggota</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.transaksi.anggota.nama + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Tempat Tugas</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.transaksi.anggota.tempat_tugas + "</td>";
                                          html += "</tr>";
                                          html += "<tr>";
                                          html += "<td>Keterangan</td>";
                                          html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.transaksi.transaksi.keterangan + "</td>";
                                          html += "</tr>";
                                          html += "</table>";
                                          html += "</div>";
                                          html += "</div>";
                                          html += "<p><strong>Detail Setoran:</strong></p>";
                                          html += "<div class='table-responsive'>";
                                          html +=
                                                "<table class='table table-hover table-bordered mb-2'>";
                                          html += "<thead class='table table-success'>";
                                          html += "<tr>";
                                          html += "<td>No.</td>";
                                          html += "<td>Nama Simpanan</td>";
                                          if (jenis === 'sukarela berbunga') {
                                                html += "<td>Bunga Simpanan</td>";
                                          }
                                          html += "<td>Jumlah Setoran</td>";
                                          html += "</tr>";
                                          html += "</thead>";
                                          html += "<tbody>";
                                          let no = 1;
                                          let nama = jenis === 'umum' ? 'Simpanan Khusus Pertokoan' : 'Simpanan Sukarela Berbunga';
                                          result.details.forEach(function (detail) {
                                                const nomor = no++;
                                                html += "<tr>";
                                                html += "<td>" + nomor + ".</td>";
                                                if (!detail.id_simpanan) {
                                                      html += "<td>" + nama + "</td>";
                                                } else {
                                                      html += "<td>" + detail.simpanan.nama + "</td>";
                                                }
                                                if (jenis === 'sukarela berbunga') {
                                                      html += "<td style='text-align:right'>" + currencyIdr(detail.bunga, 'Rp ') + "</td>";
                                                }
                                                html += "<td style='text-align:right'>" + currencyIdr(detail.jumlah, 'Rp ') + "</td>";
                                                html += "</tr>";
                                          });
                                          html += "<tr>";
                                          const col = jenis === "sukarela berbunga" ? "3" : "2";
                                          html += "<td colspan='" + col + "' style='text-align:right'><b>Total</b></td>";
                                          html += "<td style='text-align:right'><b>" + currencyIdr(result.transaksi.transaksi.total, 'Rp ') + "</b></td>";
                                          html += "</tr>";
                                          html += "</tbody>";
                                          html += "</table>";
                                          html += "<p><strong>Jurnal Simpanan:</strong></p>";
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
                                          $('.detailSimpanan').html(html).show();
                                    },
                                    error: function (xhr, status, error) {
                                          var errorMessage = xhr.status + ': ' + xhr.statusText;
                                          alert('Error - ' + errorMessage);
                                    }
                              });
                        } else {
                              $('.detailSimpanan').hide().empty();
                        }
                  });
            });
      });
})