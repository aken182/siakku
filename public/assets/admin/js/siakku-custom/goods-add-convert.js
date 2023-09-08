'use-strict';

$(document).ready(function () {
    document.querySelector("#id_barang").addEventListener("change", function () {
        let id_barang = this.value;
        let barang = barangJson;
        let barangx = barang.find(p => p.id_barang == id_barang);
        document.querySelector("#namabarang").value = barangx.nama_barang;
        document.querySelector("#kodebarang").value = barangx.kode_barang;
        document.querySelector("#satuan").value = barangx.satuan.nama_satuan;
        var stokformat = formatAngka(barangx.stok);
        document.querySelector("#stok").value = stokformat;
        document.querySelector("#standar").value = barangx.satuan.nama_satuan;
        document.querySelector("#standar2").value = barangx.satuan.nama_satuan;
        document.querySelector("#standar3").value = barangx.satuan.nama_satuan;
        var currencyhargax = currencyIdr(barangx.harga_barang, '');
        var currencyhargajx = currencyIdr(barangx.harga_jual, '');
        document.querySelector("#harga_barang").value = currencyhargax;
        document.querySelector("#harga_jual").value = currencyhargajx;
    });
    document.querySelector("#id_satuan").addEventListener("change", function () {
        let id_satuan = this.value;
        let satuan = satuanJson;
        let satuanx = satuan.find(p => p.id_satuan == id_satuan);
        document.querySelector("#standar_konversi").value = satuanx.nama_satuan;
        document.querySelector("#standar_konversi2").value = satuanx.nama_satuan;
    });
    //---end input otomatis dengan menggunakan select option---//

    // --konversi angka ke rupiah-- //
    var hargatext = document.getElementById('harga_barang');
    hargatext.addEventListener('keyup', function (e) {
        hargatext.value = currencyIdr(this.value, 'Rp ');
    });
    var hargajualtext = document.getElementById('harga_jual');
    hargajualtext.addEventListener('keyup', function (e) {
        hargajualtext.value = currencyIdr(this.value, 'Rp ');
    });

    var hargajualkontext = document.getElementById('harga_jual_konversi');
    hargajualkontext.addEventListener('keyup', function (e) {
        hargajualkontext.value = currencyIdr(this.value, 'Rp ');
    });

    function formatAngka(angka) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            accounting = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            accounting += separator + ribuan.join('.');
        }
        return accounting;
    };
    //---end konversi angka ke number format---//
});

//---input otomatis dengan perhitungan---//
function hitung() {
    //ambil data id
    var getstokx = document.getElementById('stok').value;
    var getstandarnilai = document.getElementById('standar_nilai').value;
    var getjumlahkonversi = document.getElementById('jumlah_konversi').value;
    var gethargabarang = document.getElementById('harga_barang').value;
    var gethargajual = document.getElementById('harga_jual').value;
    //konvert rp ke angka
    var hargabarang = gethargabarang.split(".").join("").split("Rp").join("");
    var hargajual = gethargajual.split(".").join("").split("Rp").join("");
    //hitung konvert satuan
    var stokkonvert = parseFloat(getstandarnilai) * parseFloat(getjumlahkonversi);
    var stoksisa = parseFloat(getstokx) - parseFloat(getjumlahkonversi);
    var hargakonvert = parseInt(hargabarang) / parseFloat(getstandarnilai);
    var hargajkonvert = parseInt(hargajual) / parseFloat(getstandarnilai);
    var total4 = parseFloat(stoksisa);
    var total1 = parseInt(hargakonvert);
    var total2 = parseInt(hargajkonvert);
    var total3 = parseFloat(stokkonvert);
    //konvert hasil ke rupiah
    var currencyhargak = currencyIdr(total1, '');
    var currencyhargajk = currencyIdr(total2, '');
    //panggil id yang sudah dihitung
    document.getElementById('sisa_stok').value = total4;
    document.getElementById('stok_konversi').value = total3;
    document.getElementById('harga_barang_konversi').value = currencyhargak;
    document.getElementById('harga_jual_konversi').value = currencyhargajk;
};
//---end input otomatis dengan perhitungan---//
