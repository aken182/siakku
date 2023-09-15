/*belanja barang adjustment*/
$(document).ready(function () {
    $(function () {
        $('.invoicePenyesuaianPenjualan').each(function (index, element) {
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
                        url: '/penjualan/unit-pertokoan/create-lainnya/detail',
                        method: "GET",
                        data: {
                            transaksi_id: transaksi_id
                        },
                        success: function (result) {
                            var html = "";
                            const tanggal = new Date(result.transaksi.tgl_transaksi);
                            const dd = tanggal.getDate().toString().padStart(2, '0');
                            const mm = (tanggal.getMonth() + 1).toString().padStart(2, '0');
                            const yy = tanggal.getFullYear();
                            const tgl = dd + '/' + mm + '/' + yy;
                            html += "<div class='row mt-3'>";
                            html += "<h5 class='text-capitalize text-success'>Detail Transaksi</h5>";
                            html += "</div>";
                            html += "<div class='row mb-2 pb-1'>";
                            html += "<div class='col-lg-12 col-md-8'>";
                            html += "<table class='table table-borderless'>";
                            html += "<tr>";
                            html += "<td>Nomor</td>";
                            html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + result.transaksi.kode + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Tanggal Transaksi</td>";
                            html += "<td style='text-align: right' class='text-dark'>" + tgl + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Keterangan</td>";
                            html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.transaksi.keterangan + "</td>";
                            html += "</tr>";
                            html += "</table>";
                            html += "</div>";
                            html += "</div>";
                            html += "<p><strong class='text-success' >Detail Pendapatan:</strong></p>";
                            html += "<div class='table-responsive'>";
                            html +=
                                "<table class='table table-striped table-bordered mb-2'>";
                            html += "<thead class='table table-success'>";
                            html += "<tr>";
                            html += "<td>Nama</td>";
                            html += "<td>Jenis</td>";
                            html += "<td>Jumlah</td>";
                            html += "<td>Harga</td>";
                            html += "<td>Total</td>";
                            html += "</tr>";
                            html += "</thead>";
                            html += "<tbody>";
                            result.details.forEach(function (detail) {
                                html += "<tr>";
                                html += "<td>" + detail.nama + "</td>";
                                html += "<td>" + detail.jenis + "</td>";
                                html += "<td style='text-align:right'>" + detail.qty + " " + detail.satuan + "</td>";
                                html += "<td style='text-align:right'>" + currencyIdr(detail.harga, 'Rp ') + "</td>";
                                html += "<td style='text-align:right'>" + currencyIdr(detail.subtotal, 'Rp ') + "</td>";
                                html += "</tr>";
                            });
                            html += "<tr>";
                            html += "<td colspan='4' style='text-align:right'><b>Total</b></td>";
                            html += "<td style='text-align:right'><b>" + currencyIdr(result.transaksi.total, 'Rp ') + "</b></td>";
                            html += "</tr>";
                            html += "</tbody>";
                            html += "</table>";
                            html += "<p><strong class='text-success'>Jurnal Pendapatan:</strong></p>";
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
                            $('.detailPenjualan').each(function (index, element) {
                                $(element).html(html).show();
                            })
                        },
                        error: function (xhr, status, error) {
                            var errorMessage = xhr.status + ': ' + xhr.statusText;
                            alert('Error - ' + errorMessage);
                        }
                    });
                } else {
                    $('.detailPenjualan').each(function (index, element) {
                        $(element).hide().empty();
                        //   $('#detailPenjualan').hide().empty();
                    })
                }
            });
        });
    });
})