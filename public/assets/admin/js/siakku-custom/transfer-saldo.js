$(document).ready(function () {
    var myElement = $(".detail-penyesuaian-transfer");
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
})

$(document).ready(function () {
    $(function () {
        $('.invoicePenyesuaianTransfer').each(function (index, element) {
            $(element).change(function () {
                var transaksi_id = $(this).val();
                if (transaksi_id != '') {
                    if (unit === 'Pertokoan') {
                        var url = "/transfer-saldo-kas-bank/unit-pertokoan/detail";
                    } else {
                        var url = "/transfer-saldo-kas-bank/unit-sp/detail";
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
                        data: {
                            transaksi_id: transaksi_id
                        },
                        success: function (result) {
                            var html = "";
                            const tanggal = new Date(result.details.transaksi.tgl_transaksi);
                            const dd = tanggal.getDate().toString().padStart(2, '0');
                            const mm = (tanggal.getMonth() + 1).toString().padStart(2, '0');
                            const yy = tanggal.getFullYear();
                            const tgl = dd + '/' + mm + '/' + yy;
                            html += "<div class='row mt-3'>";
                            html += "<h5 class='text-capitalize text-success'>Detil Transaksi</h5>";
                            html += "</div>";
                            html += "<div class='row mb-2 pb-1'>";
                            html += "<div class='col-lg-9 col-md-6'>";
                            html += "<table class='table table-borderless'>";
                            html += "<tr>";
                            html += "<td>No. Transaksi</td>";
                            html += "<td class='text-capitalize text-dark' style='text-align: right'>#" + result.details.transaksi.kode + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Tanggal Transaksi</td>";
                            html += "<td style='text-align: right' class='text-dark'>" + tgl + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Pemindahan dari</td>";
                            html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.details.pengirim.nama + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Pemindahan ke</td>";
                            html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.details.penerima.nama + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Jumlah Pemindahan</td>";
                            html += "<td class='text-capitalize text-dark' style='text-align: right'>" + currencyIdr(result.details.transaksi.total, 'Rp ') + "</td>";
                            html += "</tr>";
                            html += "<tr>";
                            html += "<td>Keterangan</td>";
                            html += "<td class='text-capitalize text-dark' style='text-align: right'>" + result.details.transaksi.keterangan + "</td>";
                            html += "</tr>";
                            html += "</table>";
                            html += "</div>";
                            html += "</div>";
                            html += "<div class='row mb-2 pb-1 bg-theme-dark'>";
                            html += "<p><strong>Jurnal Pemindahan Saldo:</strong></p>";
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
                            $('#detailTransfer').html(html).show();
                        },
                        error: function (xhr, status, error) {
                            var errorMessage = xhr.status + ': ' + xhr.statusText;
                            alert('Error - ' + errorMessage);
                        }
                    });
                } else {
                    $('#detailTransfer').hide().empty();
                }
            });
        });
    });
})

$(document).ready(function () {
    var tampilPengirim = $(".tampilPengirim");
    var saldoPengirim = $("#saldo_pengirim");
    tampilPengirim.hide();
    $("#pengirim").on("change", function () {
        let id_pengirim = this.value;
        let saldo = saldoJson;
        let saldoPengirimx = saldo.find(p => p.id_coa == id_pengirim);
        saldo_debet_pengirim = saldoPengirimx.total_debet;
        saldo_kredit_pengirim = saldoPengirimx.total_kredit;
        saldo_pengirim = saldo_debet_pengirim - saldo_kredit_pengirim;
        saldoPengirim.html(currencyIdr(saldo_pengirim, 'Rp '));
        tampilPengirim.fadeIn(); // Efek tampil
    });
})

$(document).ready(function () {
    var tampilPenerima = $(".tampilPenerima");
    var saldoPenerima = $("#saldo_penerima");
    tampilPenerima.hide();
    $("#penerima").on("change", function () {
        let id_penerima = this.value;
        let saldop = saldoJson;
        let saldoPx = saldop.find(b => b.id_coa == id_penerima);
        saldo_debet_penerima = saldoPx.total_debet;
        saldo_kredit_penerima = saldoPx.total_kredit;
        saldo_penerima = saldo_debet_penerima - saldo_kredit_penerima;
        saldoPenerima.html(currencyIdr(saldo_penerima, 'Rp '));
        tampilPenerima.fadeIn(); // Efek tampil
    });
})