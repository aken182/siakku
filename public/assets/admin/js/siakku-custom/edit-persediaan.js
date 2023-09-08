'use-strict';
$(document).ready(function () {

    /*Variabel Barang Dari Database */
    var idBarang = $("#id_barang");
    var namaBarang = $("#nama_barang");
    var namaSatuan = $("#nama_satuan");
    var jenisBarang = $("#jenis_barang");
    var namaUnit = $("#nama_unit");

    /*Variabel Barang Baru */
    var namaBarangBaru = $("#nama_barang_baru");
    var idSatuanBaru = $("#id_satuan_baru");
    var namaSatuanBaru = $("#nama_satuan_baru");
    var jenisBarangBaru = $("#jenis_barang_baru");
    var idUnitBaru = $("#id_unit_baru");

    /*Variabel Lainnya */
    // console.log(detailData);
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
                    jenisBarang.val("");
                    namaUnit.val("");
                } else {
                    myElement.fadeOut();
                    myElementTwo.fadeIn();
                    namaBarangBaru.val("");
                    jenisBarangBaru.val("");
                    idSatuanBaru.val("");
                    namaSatuanBaru.val("");
                    idUnitBaru.val("");
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
                { title: "Stok", data: "qty" },
                { title: "Harga", data: "harga" },
                { title: "Subtotal", data: "subtotal" },
                { title: "Aksi", data: "aksi" },
            ]
        });

        detailTransaksi.forEach(function (detail) {
            const data = {
                nama: detail.barang.nama_barang,
                jenis_barang: detail.barang.jenis_barang,
                qty: detail.qty + ' ' + detail.barang.satuan.nama_satuan,
                harga: currencyIdr(detail.harga, 'Rp '),
                subtotal: currencyIdr(detail.subtotal, 'Rp '),
                aksi: btAksi,
            };
            const dataToRequest = {
                jenis: 'dari database',
                id_barang: detail.id_barang,
                nama: detail.barang.nama_barang,
                id_satuan: detail.barang.id_satuan,
                id_unit: detail.barang.id_unit,
                jenis_barang: detail.barang.jenis_barang,
                qty: detail.qty,
                harga: detail.harga,
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
                    id_satuan: id_satuan,
                    id_unit: id_unit,
                    jenis_barang: jenis_barang,
                    qty: qty,
                    harga: harga,
                    subtotal: subtotal,
                };

                jsonToView.push(data);
                console.log(jsonToView);
                jsonToRequest.push(dataToRequest);
                table.clear().draw();
                table.rows.add(jsonToView).draw();
                const dataBarang = JSON.stringify(jsonToRequest);
                $("#dataBarang").val(dataBarang);

                if (jnBk === "barang baru") {
                    namaBarangBaru.val("");
                    jenisBarangBaru.val("");
                    idSatuanBaru.val("");
                    namaSatuanBaru.val("");
                    idUnitBaru.val("");
                } else {
                    idBarang.val("");
                    namaBarang.val("");
                    namaSatuan.val("");
                    jenisBarang.val("");
                    namaUnit.val("");
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
                    const isIdSatuanBaruEmpty = idSatuanBaru.val() ? idSatuanBaru.val().trim() === "" : true;
                    const isIdUnitBaruEmpty = idUnitBaru.val().trim() === "";
                    const isStokBarangEmpty = stokBarang.val().trim() === "";
                    const isHargaBeliEmpty = hargaBeli.val().trim() === "";

                    const isAnyFieldEmpty =
                        isNamaBarangBaruEmpty ||
                        isJenisBarangBaruEmpty ||
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