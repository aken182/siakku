'use-strict';

$(document).ready(function () {

    /*Variabel Barang Dari Database */
    var idBarang = $("#id_barang");
    var namaBarang = $("#nama_barang");
    var namaSatuan = $("#nama_satuan");
    var stokInventaris = $("#stok");
    var jenisBarang = $("#jenis_barang");
    var namaUnit = $("#nama_unit");
    var umurEkonomis = $("#umur_ekonomis");
    var tglBeli = $("#tgl_beli");

    /*Variabel Barang Baru */
    var namaBarangBaru = $("#nama_barang_baru");
    var idSatuanBaru = $("#id_satuan_baru");
    var namaSatuanBaru = $("#nama_satuan_baru");
    var jenisBarangBaru = $("#jenis_barang_baru");
    var idUnitBaru = $("#id_unit_baru");
    var umurEkonomisBaru = $("#umur_ekonomis_baru");

    /*Variabel Lainnya */
    var myElement = $(".field-barang-baru");
    var myElementTwo = $(".field-dari-database");
    var jnB = $('input[name="cek_barang"]');
    var stokBarang = $("#qty");
    var hargaBeli = $("#harga_beli");
    var tambahKeranjang = $(".addToChartBtn");
    var keranjangTabel = $("#keranjangTabel");
    var jsonToRequest = [];
    var jsonToView = [];

    var toastSuccess = toastInfoTopRight("Data berhasil ditambahkan ke keranjang !", "#4fbe87");
    var toastSuccessDestroy = toastInfoTopRight("Data berhasil dihapus dari keranjang !", "#4fbe87");
    var toastError = toastInfoTopRight("Data tidak dimasukkan dengan benar !", "#ed2710");

    !(function pilihJnsBrg() {
        myElement.hide();
        myElementTwo.hide();
        document.querySelectorAll('input[name="cek_barang"]').forEach(function (radio) {
            radio.addEventListener("change", function () {
                if (this.value === "barang baru") {
                    myElement.fadeIn();
                    myElementTwo.fadeOut();
                    idBarang.val("");
                    namaBarang.val("");
                    namaSatuan.val("");
                    stokInventaris.val("");
                    jenisBarang.val("");
                    namaUnit.val("");
                    umurEkonomis.val("");
                    tglBeli.val("");
                    hargaBeli.val("");
                    tambahKeranjang.prop("disabled", false);
                    hargaBeli.attr("readonly", false);
                } else {
                    myElement.fadeOut();
                    myElementTwo.fadeIn();
                    namaBarangBaru.val("");
                    jenisBarangBaru.val("");
                    idSatuanBaru.val("");
                    namaSatuanBaru.val("");
                    idUnitBaru.val("");
                    hargaBeli.val("");
                    umurEkonomisBaru.val("");
                    hargaBeli.attr("readonly", true);
                }
            });
        });
    })();

    !(function () {
        var btAksi = `<button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button>`;
        var table = keranjangTabel.DataTable({
            columns: [
                { title: "Nama", data: "nama" },
                { title: "Jenis", data: "jenis_barang" },
                { title: "Qty", data: "qty" },
                { title: "Harga", data: "harga" },
                { title: "Subtotal", data: "subtotal" },
                { title: "Aksi", data: "aksi" },
            ]
        });

        idBarang.on("change", function () {
            let id_barang = $(this).val();
            let barang = barangs;
            let barangx = barang.find(p => p.id_barang == id_barang);
            if (barangx) {
                namaBarang.val(barangx.nama_barang);
                const stok = barangx.stok;
                if (!barangx.tgl_beli && !stok) {
                    stokInventaris.val("Inventaris kosong !");
                    stokInventaris.removeClass("text-primary");
                    stokInventaris.addClass("text-danger");
                    tambahKeranjang.prop("disabled", false);
                } else {
                    if (stok > 0) {
                        stokInventaris.val(stok + " " + barangx.satuan.nama_satuan);
                        stokInventaris.removeClass("text-danger");
                        stokInventaris.addClass("text-primary");
                    } else {
                        stokInventaris.val("Inventaris kosong !");
                        stokInventaris.removeClass("text-primary");
                        stokInventaris.addClass("text-danger");
                    }
                    tambahKeranjang.prop("disabled", true);
                }
                namaSatuan.val(barangx.satuan.nama_satuan);
                jenisBarang.val(barangx.jenis_barang);
                namaUnit.val(barangx.unit.nama);
                umurEkonomis.val(barangx.umur_ekonomis);
                tglBeli.val(barangx.tgl_beli);
                hargaBeli.val(currencyIdr(barangx.harga_barang, "Rp "));
            }
        });

        idSatuanBaru.on("change", function () {
            let id_satuan = $(this).val();
            let satuan = satuans;
            let satuanx = satuan.find(p => p.id_satuan == id_satuan);
            if (satuanx) {
                namaSatuanBaru.val(satuanx.nama_satuan);
            }
        });

        function storeKeranjang() {
            if (jnB.is(':checked')) {
                let jnBk = $('input[name="cek_barang"]:checked').val();
                let totalSubtotal = 0;
                const id_barang = jnBk === "barang baru" ? "" : idBarang.val();
                const nama = jnBk === "barang baru" ? namaBarangBaru.val() : namaBarang.val();
                const id_satuan = jnBk === "barang baru" ? idSatuanBaru.val() : "";
                const id_unit = jnBk === "barang baru" ? idUnitBaru.val() : "";
                const satuan = jnBk === "barang baru" ? namaSatuanBaru.val() : namaSatuan.val();
                const umur_ekonomis = jnBk === "barang baru" ? umurEkonomisBaru.val() : umurEkonomis.val();
                const getharga = hargaBeli.val();
                const hargax = getharga.split(".").join("").replace("Rp", "");
                const qty = parseFloat(stokBarang.val());
                const harga = parseFloat(hargax);
                const subtotal = qty * harga;
                const jenis = jnBk;
                const jenis_barang = jnBk === "barang baru" ? jenisBarangBaru.val() : jenisBarang.val();

                let data = {
                    nama: nama,
                    jenis_barang: jenis_barang,
                    qty: qty + ' ' + satuan,
                    harga: currencyIdr(harga, 'Rp '),
                    subtotal: currencyIdr(subtotal, 'Rp '),
                    aksi: btAksi,
                };

                let dataToRequest = {
                    jenis: jenis,
                    id_barang: id_barang,
                    nama: nama,
                    umur_ekonomis: umur_ekonomis,
                    id_satuan: id_satuan,
                    id_unit: id_unit,
                    jenis_barang: jenis_barang,
                    qty: qty,
                    harga: harga,
                    nilai_buku: harga,
                    subtotal: subtotal,
                };

                jsonToView.push(data);
                jsonToRequest.push(dataToRequest);
                table.clear().draw();
                table.rows.add(jsonToView).draw();
                console.log(jsonToRequest);
                const dataBarang = JSON.stringify(jsonToRequest);
                $("#dataBarang").val(dataBarang);

                if (jnBk === "barang baru") {
                    namaBarangBaru.val("");
                    jenisBarangBaru.val("");
                    idSatuanBaru.val("");
                    namaSatuanBaru.val("");
                    idUnitBaru.val("");
                    umurEkonomisBaru.val("");
                } else {
                    idBarang.val("");
                    namaBarang.val("");
                    namaSatuan.val("");
                    jenisBarang.val("");
                    namaUnit.val("");
                    umurEkonomis.val("");
                    stokInventaris.val("");
                    tglBeli.val("");
                }

                stokBarang.val("");
                hargaBeli.val("");

                $.each(jsonToRequest, function (index, item) {
                    totalSubtotal += item.subtotal;
                });

                $("#total_transaksi").val(currencyIdr(totalSubtotal, 'Rp '));
                toastSuccess.showToast();
            } else {
                toastError.showToast();
            }
        }

        // Fungsi untuk melakukan validasi
        function validateInput() {
            if (jnB.is(':checked')) {
                let jnBk = $('input[name="cek_barang"]:checked').val();
                if (jnBk === "barang baru") {
                    // Validasi input untuk "Barang Baru"
                    const isNamaBarangBaruEmpty = namaBarangBaru.val().trim() === "";
                    const isJenisBarangBaruEmpty = jenisBarangBaru.val().trim() === "";
                    const isUmurEkonomisBaruEmpty = umurEkonomisBaru.val().trim() === "";
                    const isIdSatuanBaruEmpty = idSatuanBaru.val() ? idSatuanBaru.val().trim() === "" : true;
                    const isIdUnitBaruEmpty = idUnitBaru.val().trim() === "";
                    const isStokBarangEmpty = stokBarang.val().trim() === "";
                    const isHargaBeliEmpty = hargaBeli.val().trim() === "";

                    const isAnyFieldEmpty =
                        isNamaBarangBaruEmpty ||
                        isJenisBarangBaruEmpty ||
                        isUmurEkonomisBaruEmpty ||
                        isIdSatuanBaruEmpty ||
                        isIdUnitBaruEmpty ||
                        isStokBarangEmpty ||
                        isHargaBeliEmpty;

                    if (isAnyFieldEmpty) {
                        toastError.showToast();
                    } else {
                        storeKeranjang()
                    }
                } else {
                    // Validasi input untuk "Dari Database"
                    const isIdBarangEmpty = idBarang.val() ? idBarang.val().trim() === "" : true;
                    const isHargaBeliEmpty = hargaBeli.val().trim() === "";
                    const isStokBarangEmpty = stokBarang.val().trim() === "";

                    const isAnyFieldEmpty =
                        isIdBarangEmpty ||
                        isStokBarangEmpty ||
                        isHargaBeliEmpty;

                    if (isAnyFieldEmpty) {
                        toastError.showToast();
                    } else {
                        storeKeranjang()
                    }
                }
            }
        }

        tambahKeranjang.click(function () {
            validateInput()
        });


        keranjangTabel.on("click", ".remove-row", function () {
            var rowIndex = $(this).closest("tr").index();
            table.row(rowIndex).remove().draw();
            jsonToView.splice(rowIndex, 1);
            jsonToRequest.splice(rowIndex, 1);
            const dataBarang = JSON.stringify(jsonToRequest);
            $("#dataBarang").val(dataBarang);

            let totalSubtotal = 0;
            $.each(jsonToRequest, function (index, item) {
                totalSubtotal += item.subtotal;
            });
            $("#total_transaksi").val(currencyIdr(totalSubtotal, 'Rp '));

            toastSuccessDestroy.showToast();
        });
    })();
});