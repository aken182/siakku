/*penyesuaian penyusutan inventaris*/
$(document).ready(function () {
    var myElement = $(".detail-penyesuaian-penyusutan");
    myElement.hide();
    document.querySelectorAll('input[name="cek_penyusutan"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value === 'penyesuaian') {
                myElement.fadeIn(); // Efek fadeIn
            } else {
                myElement.fadeOut(); // Efek fadeOut
            }
        });
    });
})

$(document).ready(function () {
    $(function () {
        $('.invoicePenyesuaianPenyusutan').each(function (index, element) {
            $(element).change(function () {
                var transaksi_id = $(this).val();
                var url = $('#route-penyesuaian').data('route');
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
                            const tanggal = new Date(result.transaksi.tgl_transaksi);
                            const dd = tanggal.getDate().toString().padStart(2, '0');
                            const mm = (tanggal.getMonth() + 1).toString().padStart(2, '0');
                            const yy = tanggal.getFullYear();
                            const tgl = dd + '/' + mm + '/' + yy;
                            html += "<div class='row mt-3'>";
                            html += "<h5 class='text-capitalize text-success'>Detil Transaksi</h5>";
                            html += "</div>";
                            html += "<div class='row mb-2 pb-1'>";
                            html += "<div class='col-lg-7 col-md-6'>";
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
                            html += "<p><strong>Detail Penyusutan :</strong></p>";
                            html += "<div class='table table-responsive pb-3'>";
                            html +=
                                "<table class='table table-hover table-bordered mb-2'>";
                            html += "<thead class='table table-info'>";
                            html += "<tr>";
                            html += "<td>Nama</td>";
                            html += "<td>Tanggal Beli</td>";
                            html += "<td>Harga Beli</td>";
                            html += "<td>Nilai Buku</td>";
                            html += "<td>Nilai Penyusutan</td>";
                            html += "<td>Kuantitas</td>";
                            html += "<td>Total Penyusutan</td>";
                            html += "</tr>";
                            html += "</thead>";
                            html += "<tbody>";
                            result.details.forEach(function (detail) {
                                html += "<tr>";
                                const nama_barang = detail.id_eceran ? detail.barang.nama_barang + " (eceran)" : detail.barang.nama_barang;
                                html += "<td>" + nama_barang + "</td>";
                                const tglBeli = new Date(detail.barang.tgl_beli);
                                const ddBeli = tglBeli.getDate().toString().padStart(2, '0');
                                const mmBeli = (tglBeli.getMonth() + 1).toString().padStart(2, '0');
                                const yyBeli = tglBeli.getFullYear();
                                const tgl_beli = ddBeli + '/' + mmBeli + '/' + yyBeli;
                                html += "<td>" + tgl_beli + "</td>";
                                const harga_beli = detail.id_eceran ? detail.barang_eceran.harga_barang : detail.barang.harga_barang;
                                html += "<td style='text-align:right'>" + currencyIdr(harga_beli, 'Rp ') + "</td>";
                                html += "<td style='text-align:right'>" + currencyIdr(detail.harga_brg_sekarang, 'Rp ') + "</td>";
                                html += "<td style='text-align:right'>" + currencyIdr(detail.harga_penyusutan, 'Rp ') + "</td>";
                                html += "<td style='text-align:right'>" + detail.qty + " " + detail.satuan.nama_satuan + "</td>";
                                html += "<td style='text-align:right'>" + currencyIdr(detail.subtotal, 'Rp ') + "</td>";
                                html += "</tr>";
                            });
                            html += "</tbody>";
                            html += "<tfoot>";
                            html += "<tr>";
                            html += "<td colspan='6' style='text-align:right'><b>Total</b></td>";
                            html += "<td style='text-align:right'><b>" + currencyIdr(result.transaksi.total, 'Rp ') + "</b></td>";
                            html += "</tr>";
                            html += "</tfoot>";
                            html += "</table>";
                            html += "<p><strong>Jurnal Penyusutan:</strong></p>";
                            html +=
                                "<table class='table table-hover table-bordered mb-1'>";
                            html += "<thead class='table table-info'>";
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
                            $('.detailPenyusutan').each(function (index, element) {
                                $(element).html(html).show();
                            })
                        },
                        error: function (xhr, status, error) {
                            var errorMessage = xhr.status + ': ' + xhr.statusText;
                            alert('Error - ' + errorMessage);
                        }
                    });
                } else {
                    $('.detailPenyusutan').each(function (index, element) {
                        $(element).hide().empty();
                    })
                }
            });
        });
    });
})