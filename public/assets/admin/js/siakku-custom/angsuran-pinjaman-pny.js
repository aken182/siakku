"use-strict";
/*pembayaran tagihan adjustment*/
$(document).ready(function () {
    $(function () {
        $('.invoicePenyesuaianPembayaran').each(function (index, element) {
            $(element).change(function () {
                var pembayaran_id = $(this).val();
                var routeUrl = $('#routeUrl').data('route');
                if (pembayaran_id != '') {
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
                            pembayaran_id: pembayaran_id
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
                            html += "<td>Nomor Pembayaran</td>";
                            html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + data.detail.invoice + "</td>";
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
                            html += "<td>Tanggal Bayar</td>";
                            html += "<td style='text-align: right' class='text-dark'>" + data.detail.tanggal_bayar + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Jumlah Angsuran Pokok</td>";
                            html += "<td style='text-align: right' class='text-dark'>" + data.detail.angsuran_pokok + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Jumlah Angsuran Bunga</td>";
                            html += "<td style='text-align: right' class='text-dark'>" + data.detail.angsuran_bunga + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Total Angsuran</td>";
                            html += "<td style='text-align: right' class='text-dark'>" + data.detail.total_angsuran + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Saldo Pokok</td>";
                            html += "<td style='text-align: right' class='text-dark'>" + data.detail.saldo_pokok + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Saldo Bunga</td>";
                            html += "<td style='text-align: right' class='text-dark'>" + data.detail.saldo_bunga + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Status</td>";
                            html += "<td class='text-capitalize text-primary' style='text-align: right'>" + data.detail.status + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Keterangan</td>";
                            html += "<td class='text-capitalize text-dark' style='text-align: right'>" + data.detail.keterangan + "</td>";
                            html += "</tr>";
                            html += "</table>";
                            html += "</div>";
                            html += "</div>";
                            html += "<p class='text-success'><strong>Jurnal Pembayaran:</strong></p>";
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
                            $('.detailPembayaran').html(html).show();
                        },
                        error: function (xhr, status, error) {
                            const errorMessage = xhr.status + ': ' + xhr.statusText;
                            const toastInfo = toastInfoTopRight(errorMessage, "#ed2710");
                            toastInfo.showToast();
                        }
                    });
                } else {
                    $('.detailPembayaran').hide().empty();
                    const toastInfo = toastInfoTopRight('Detail penyesuaian pembayaran tidak ditemukan!', "#ed2710");
                    toastInfo.showToast();
                }
            });
        });
    });
})