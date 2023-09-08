'use-strict';
$(document).ready(function () {

    /*Variabel Barang Dari Database */
    var idBarang = $("#id_barang");
    var namaBarang = $("#nama_barang");
    var namaSatuan = $("#nama_satuan");
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
    var tglBeliBaru = $("#tgl_beli_baru");

    /*Variabel Lainnya */
    var myElement = $(".field-barang-baru");
    var myElementTwo = $(".field-dari-database");
    var jnB = $('input[name="cek_barang"]');
    var stokBarang = $("#qty");
    var hargaBeli = $("#harga_beli");
    var nilaiBuku = $("#nilai_buku");
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
                    jenisBarang.val("");
                    namaUnit.val("");
                    umurEkonomis.val("");
                    tglBeli.val("");
                } else {
                    myElement.fadeOut();
                    myElementTwo.fadeIn();
                    namaBarangBaru.val("");
                    jenisBarangBaru.val("");
                    idSatuanBaru.val("");
                    namaSatuanBaru.val("");
                    idUnitBaru.val("");
                    umurEkonomisBaru.val("");
                    tglBeliBaru.val("");
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
                { title: "Tgl. Beli", data: "tgl_beli" },
                { title: "Stok", data: "qty" },
                { title: "Nilai Buku", data: "nilai_buku" },
                { title: "Subtotal", data: "subtotal" },
                { title: "Aksi", data: "aksi" },
            ]
        });

        detailTransaksi.forEach(function (detail) {
            const data = {
                nama: detail.barang.nama_barang,
                jenis_barang: detail.barang.jenis_barang,
                tgl_beli: detail.barang.tgl_beli,
                qty: detail.qty + ' ' + detail.barang.satuan.nama_satuan,
                nilai_buku: currencyIdr(detail.nilai_buku, 'Rp '),
                subtotal: currencyIdr(detail.subtotal, 'Rp '),
                aksi: btAksi,
            };
            const dataToRequest = {
                jenis: 'dari database',
                id_barang: detail.id_barang,
                nama: detail.barang.nama_barang,
                tgl_beli: detail.barang.tgl_beli,
                umur_ekonomis: detail.barang.umur_ekonomis,
                id_satuan: detail.barang.id_satuan,
                id_unit: detail.barang.id_unit,
                jenis_barang: detail.barang.jenis_barang,
                qty: detail.qty,
                harga: detail.harga,
                nilai_buku: detail.nilai_buku,
                subtotal: detail.subtotal,
            };
            jsonToView.push(data);
            jsonToRequest.push(dataToRequest);
            table.clear().draw();
            table.rows.add(jsonToView).draw();
            const dataBarang = JSON.stringify(jsonToRequest);
            $("#dataBarang").val(dataBarang);
        });
        let dataSubtotal = 0;
        $.each(jsonToRequest, function (index, item) {
            dataSubtotal += item.subtotal;
        });
        $("#total_transaksi").val(currencyIdr(dataSubtotal, 'Rp '));

        idBarang.on("change", function () {
            let id_barang = $(this).val();
            let barang = barangs;
            let barangx = barang.find(p => p.id_barang == id_barang);
            if (barangx) {
                namaBarang.val(barangx.nama_barang);
                namaSatuan.val(barangx.satuan.nama_satuan);
                jenisBarang.val(barangx.jenis_barang);
                namaUnit.val(barangx.unit.nama);
                umurEkonomis.val(barangx.umur_ekonomis);
                tglBeli.val(barangx.tgl_beli);
                hargaBeli.val(currencyIdr(barangx.harga_barang, "Rp "));
                nilaiBuku.val(currencyIdr(barangx.nilai_saat_ini, "Rp"));
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
                const tgl_beli = jnBk === "barang baru" ? tglBeliBaru.val() : tglBeli.val();
                const id_satuan = jnBk === "barang baru" ? idSatuanBaru.val() : "";
                const id_unit = jnBk === "barang baru" ? idUnitBaru.val() : "";
                const satuan = jnBk === "barang baru" ? namaSatuanBaru.val() : namaSatuan.val();
                const umur_ekonomis = jnBk === "barang baru" ? umurEkonomisBaru.val() : umurEkonomis.val();
                const getharga = hargaBeli.val();
                const getNilaiBuku = nilaiBuku.val();
                const hargax = getharga.split(".").join("").replace("Rp", "");
                const nilaix = getNilaiBuku.split(".").join("").replace("Rp", "");
                const qty = parseFloat(stokBarang.val());
                const harga = parseFloat(hargax);
                const nilai = parseFloat(nilaix);
                const subtotal = qty * nilai;
                const jenis = jnBk;
                const jenis_barang = jnBk === "barang baru" ? jenisBarangBaru.val() : jenisBarang.val();

                let data = {
                    nama: nama,
                    jenis_barang: jenis_barang,
                    tgl_beli: tgl_beli,
                    qty: qty + ' ' + satuan,
                    nilai_buku: currencyIdr(nilai, 'Rp '),
                    subtotal: currencyIdr(subtotal, 'Rp '),
                    aksi: btAksi,
                };

                let dataToRequest = {
                    jenis: jenis,
                    id_barang: id_barang,
                    nama: nama,
                    tgl_beli: tgl_beli,
                    umur_ekonomis: umur_ekonomis,
                    id_satuan: id_satuan,
                    id_unit: id_unit,
                    jenis_barang: jenis_barang,
                    qty: qty,
                    harga: harga,
                    nilai_buku: nilai,
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
                    tglBeliBaru.val("");
                } else {
                    idBarang.val("");
                    namaBarang.val("");
                    namaSatuan.val("");
                    jenisBarang.val("");
                    namaUnit.val("");
                    umurEkonomis.val("");
                    tglBeli.val("");
                }

                stokBarang.val("");
                hargaBeli.val("");
                nilaiBuku.val("");

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
                    const isTglBeliBaruEmpty = tglBeliBaru.val().trim() === "";
                    const isIdSatuanBaruEmpty = idSatuanBaru.val() ? idSatuanBaru.val().trim() === "" : true;
                    const isIdUnitBaruEmpty = idUnitBaru.val().trim() === "";
                    const isStokBarangEmpty = stokBarang.val().trim() === "";
                    const isHargaBeliEmpty = hargaBeli.val().trim() === "";
                    const isNilaiBukuEmpty = nilaiBuku.val().trim() === "";

                    const isAnyFieldEmpty =
                        isNamaBarangBaruEmpty ||
                        isJenisBarangBaruEmpty ||
                        isTglBeliBaruEmpty ||
                        isUmurEkonomisBaruEmpty ||
                        isIdSatuanBaruEmpty ||
                        isIdUnitBaruEmpty ||
                        isStokBarangEmpty ||
                        isHargaBeliEmpty ||
                        isNilaiBukuEmpty;

                    if (isAnyFieldEmpty) {
                        toastError.showToast();
                    } else {
                        storeKeranjang()
                    }
                } else {
                    // Validasi input untuk "Dari Database"
                    const isIdBarangEmpty = idBarang.val() ? idBarang.val().trim() === "" : true;
                    const isHargaBeliEmpty = hargaBeli.val().trim() === "";
                    const isTglBeliEmpty = tglBeli.val().trim() === "";
                    const isStokBarangEmpty = stokBarang.val().trim() === "";
                    const isNilaiBukuEmpty = nilaiBuku.val().trim() === "";

                    const isAnyFieldEmpty =
                        isIdBarangEmpty ||
                        isTglBeliEmpty ||
                        isStokBarangEmpty ||
                        isHargaBeliEmpty ||
                        isNilaiBukuEmpty;

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