"use-strict";
/*pembayaran tagihan adjustment*/
$(document).ready(function () {
    $(function () {
        var s = $('.select-pengajuan');
        var d = $('.detail-pengajuan');
        var kd = $('#kode-pengajuan');
        var n = $('#nama-anggota');
        var tt = $('#tempat-tugas');
        var j = $('#jumlah-pengajuan');
        var jw = $('#jangka-waktu');
        var b = $('#bunga');
        var a = $('#asuransi');
        var k = $('#kapitalisasi');
        var t = $('#total-penerimaan');
        var ta = $('#total-angsuran');
        var ap = $('#angsuran-pokok');
        var ab = $('#angsuran-bunga');
        var st = $('#status-pencairan');
        var url = $('#route-pengajuan').data('route');
        d.hide();
        s.each(function (index, element) {
            $(element).change(function () {
                var id_pengajuan = $(this).val();
                if (id_pengajuan != '') {
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
                            id_pengajuan: id_pengajuan
                        },
                        success: function (data) {
                            d.fadeIn();
                            kd.html("#" + data.detail.kode);
                            n.html(data.detail.anggota.nama);
                            tt.html(data.detail.anggota.tempat_tugas);
                            j.html(currencyIdr(data.detail.jumlah_pinjaman, 'Rp '));
                            jw.html(data.detail.jangka_waktu + " bulan");
                            b.html(data.detail.bunga + " %");
                            a.html(currencyIdr(data.detail.asuransi, 'Rp '));
                            k.html(currencyIdr(data.detail.kapitalisasi, 'Rp '));
                            t.html(currencyIdr(data.detail.total_pinjaman, 'Rp '));
                            ta.html(currencyIdr(data.detail.total_angsuran, 'Rp '));
                            ap.html(currencyIdr(data.detail.angsuran_pokok, 'Rp '));
                            ab.html(currencyIdr(data.detail.angsuran_bunga, 'Rp '));
                            const status = data.detail.status_pencairan === 'sudah cair' ? 'pinjaman sudah dicairkan' : 'pinjaman belum dicairkan';
                            st.html(status);
                        },
                        error: function (xhr, status, error) {
                            var errorMessage = xhr.status + ': ' + xhr.statusText;
                            const toastError = toastInfoTopRight(errorMessage, "#ed2710");
                            toastError.showToast();
                        }
                    });
                } else {
                    d.fadeOut();
                    const toastError = toastInfoTopRight("Data Tidak Ditemukan !", "#ed2710");
                    toastError.showToast();
                }
            });
        });
    });
})