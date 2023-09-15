"use-strict";

$(document).ready(function () {
    !(function tipeTrx() {
        var myElement = $(".detail-penyesuaian-penjualan");
        myElement.hide();
        document
            .querySelectorAll('input[name="cek_penjualan"]')
            .forEach(function (radio) {
                radio.addEventListener("change", function () {
                    if (this.value === "penyesuaian") {
                        myElement.fadeIn(); // Efek fadeIn
                    } else {
                        myElement.fadeOut(); // Efek fadeOut
                    }
                });
            });
    })();

    !(function pilihGrossEceran() {
        var myElement = $(".field-grosir");
        var myElementTwo = $(".field-eceran");
        myElement.hide();
        myElementTwo.hide();
        document
            .querySelectorAll('input[name="cek_barang"]')
            .forEach(function (radio) {
                radio.addEventListener("change", function () {
                    if (this.value === "barang grosir") {
                        myElement.fadeIn();
                        myElementTwo.fadeOut();
                    } else {
                        myElement.fadeOut();
                        myElementTwo.fadeIn();
                    }
                });
            });
    })();

    !(function tipePmb() {
        var ec = document.querySelectorAll('input[name="pembeli"]');
        var ep = $(".hide-pegawai");
        var enp = $(".hide-nonpegawai");
        ep.hide();
        enp.hide();
        ec.forEach(function (radio) {
            radio.addEventListener("change", function () {
                if (this.value === "pegawai") {
                    ep.fadeIn();
                    enp.fadeOut();
                } else {
                    ep.fadeOut();
                    enp.fadeIn();
                }
            });
        });
    })();

    !(function () {
        var btAksi = `<button class="btn btn-xs btn-danger btn-flat remove-row"><i class="bi bi-trash"></i></button>`;
        var table = $("#keranjangTabel").DataTable({
            columns: [
                { title: "Nama", data: "nama" },
                { title: "Qty", data: "qty" },
                { title: "Harga", data: "harga" },
                { title: "Subtotal", data: "subtotal" },
                { title: "Aksi", data: "aksi" },
            ]
        });

        var jsonToTable = [];
        var jsonToRequest = [];
        var jnP = $('input[name="cek_penjualan"]');
        var stokBarang = $("#stokBarang");
        var satuanBarang = $("#satuanBarang");
        var namaBarang = $("#namaBarang");
        var idGrosir = $("#id_grosir");
        var idEceran = $("#id_eceran");
        var tambahKeranjang = $(".addToChartBtn");
        var hargaBarang = $("#hargaBarang");
        var hargaJual = $("#hargaJual");
        var kuantitasBarang = $("#kuantitas");

        var toastSuccess = toastInfoTopRight("Data berhasil ditambahkan ke keranjang !", "#4fbe87");
        var toastSuccessDestroy = toastInfoTopRight("Data berhasil dihapus dari keranjang !", "#4fbe87");
        var toastError = toastInfoTopRight("Data tidak dimasukkan dengan benar !", "#ed2710");

        idGrosir.on("change", function () {
            let id_barang = $(this).val();
            let barang = barangs;
            let barangx = barang.find(p => p.id_barang == id_barang);
            if (barangx) {
                satuanBarang.html(barangx.satuan.nama_satuan);
                namaBarang.html(barangx.nama_barang);
                const hargaBarangString = barangx.harga_barang;
                const hargaBarangAngka = parseFloat(hargaBarangString);
                const hargaBarangTanpaDesimal = hargaBarangAngka.toString();
                const hargaJualString = barangx.harga_jual;
                const hargaJualAngka = parseFloat(hargaJualString);
                const hargaJualTanpaDesimal = hargaJualAngka.toString();
                hargaBarang.val(currencyIdr(hargaBarangTanpaDesimal, 'Rp '));
                hargaJual.val(currencyIdr(hargaJualTanpaDesimal, 'Rp '));
                if (jnP.is(':checked')) {
                    let jnPk = $('input[name="cek_penjualan"]:checked').val();
                    if (jnPk == "penyesuaian") {
                        stokBarang.val("Disesuaikan setelah disimpan.");
                        stokBarang.removeClass("text-danger");
                        stokBarang.addClass("text-info");
                        tambahKeranjang.prop("disabled", false);
                    } else {
                        let grosirJson = jsonToRequest.find(g => g.id_barang == id_barang);
                        if (grosirJson) {
                            if (grosirJson.stok == 0) {
                                stokBarang.val("Stok habis!");
                                stokBarang.removeClass("text-info");
                                stokBarang.addClass("text-danger");
                                tambahKeranjang.prop("disabled", true);
                            } else {
                                stokBarang.val(grosirJson.stok);
                                stokBarang.removeClass("text-info");
                                stokBarang.removeClass("text-danger");
                                tambahKeranjang.prop("disabled", false);
                            }
                        } else {
                            if (barangx.stok == 0) {
                                stokBarang.val("Stok habis!");
                                stokBarang.removeClass("text-info");
                                stokBarang.addClass("text-danger");
                                tambahKeranjang.prop("disabled", true);
                            } else {
                                stokBarang.val(barangx.stok);
                                stokBarang.removeClass("text-info");
                                stokBarang.removeClass("text-danger");
                                tambahKeranjang.prop("disabled", false);
                            }
                        }
                    }
                } else {
                    stokBarang.val("Jenis penjualan wajib dipilih !");
                    stokBarang.removeClass("text-danger");
                    stokBarang.addClass("text-info");
                    tambahKeranjang.prop("disabled", true);
                }
            }
        });

        idEceran.on("change", function () {
            let id_eceran = $(this).val();
            let konv = konversis;
            let konvx = konv.find(p => p.id_eceran == id_eceran);
            if (konvx) {
                satuanBarang.text(konvx.satuan.nama_satuan);
                namaBarang.html(konvx.barang.nama_barang);
                const hargaBarangString = konvx.harga_barang;
                const hargaBarangAngka = parseFloat(hargaBarangString);
                const hargaBarangTanpaDesimal = hargaBarangAngka.toString();
                const hargaJualString = konvx.harga_jual;
                const hargaJualAngka = parseFloat(hargaJualString);
                const hargaJualTanpaDesimal = hargaJualAngka.toString();
                hargaBarang.val(currencyIdr(hargaBarangTanpaDesimal, 'Rp '));
                hargaJual.val(currencyIdr(hargaJualTanpaDesimal, 'Rp '));
                if (jnP.is(':checked')) {
                    let jnPk = $('input[name="cek_penjualan"]:checked').val();
                    if (jnPk == "penyesuaian") {
                        stokBarang.val("Disesuaikan setelah disimpan.");
                        stokBarang.removeClass("text-danger");
                        stokBarang.addClass("text-info");
                        tambahKeranjang.prop("disabled", false);
                    } else {
                        let eceranJson = jsonToRequest.find(g => g.id_eceran == id_eceran);
                        if (eceranJson) {
                            if (eceranJson.stok == 0) {
                                stokBarang.val("Stok habis!");
                                stokBarang.removeClass("text-info");
                                stokBarang.addClass("text-danger");
                                tambahKeranjang.prop("disabled", true);
                            } else {
                                stokBarang.val(eceranJson.stok);
                                stokBarang.removeClass("text-info");
                                stokBarang.removeClass("text-danger");
                                tambahKeranjang.prop("disabled", false);
                            }
                        } else {
                            if (konvx.stok == 0) {
                                stokBarang.val("Stok habis!");
                                stokBarang.removeClass("text-info");
                                stokBarang.addClass("text-danger");
                                tambahKeranjang.prop("disabled", true);
                            } else {
                                stokBarang.val(konvx.stok);
                                stokBarang.removeClass("text-info");
                                stokBarang.removeClass("text-danger");
                                tambahKeranjang.prop("disabled", false);
                            }
                        }
                    }

                } else {
                    stokBarang.val("Jenis penjualan wajib dipilih !");
                    stokBarang.removeClass("text-danger");
                    stokBarang.addClass("text-info");
                    tambahKeranjang.prop("disabled", true);
                }
            }
        });

        kuantitasBarang.on("change", function () {
            let inptQty = parseFloat($(this).val());
            if (jnP.is(':checked')) {
                let jnPk = $('input[name="cek_penjualan"]:checked').val();
                if (jnPk == "penyesuaian") {
                    $("#validasiQty").html("");
                    tambahKeranjang.prop("disabled", false);
                } else {
                    let inptStok = parseFloat(stokBarang.val());
                    if (inptQty <= inptStok) {
                        $("#validasiQty").html("");
                        tambahKeranjang.prop("disabled", false);
                    } else {
                        if (inptQty > inptStok) {
                            $("#validasiQty").html("Stok barang tidak cukup !");
                            tambahKeranjang.prop("disabled", true);
                        } else {
                            $("#validasiQty").html("Kuantitas barang wajib diisi !");
                            tambahKeranjang.prop("disabled", true);
                        }
                    }
                }
            } else {
                $("#validasiQty").html("Jenis Penjualan Wajib dipilih !");
                tambahKeranjang.prop("disabled", true);
            }
        });

        tambahKeranjang.click(function () {

            if (hargaJual.val() != "") {
                if (kuantitasBarang.val() != "") {
                    var qty = parseFloat($("#kuantitas").val());
                    var stok = parseFloat($("#stokBarang").val());
                    var sisa_stok = stok - qty;
                    var getharga = $("#hargaJual").val();
                    var nama = $("#namaBarang").html();
                    var idBarang = $("#id_grosir").val();
                    var idKonversi = $("#id_eceran").val();
                    var satuan = $("#satuanBarang").html();
                    var hargax = getharga.split(".").join("").replace("Rp", "");
                    var harga = parseFloat(hargax);
                    var subtotal = qty * harga;
                    var data = {
                        nama: nama,
                        qty: qty + ' ' + satuan,
                        harga: currencyIdr(harga, 'Rp '),
                        subtotal: currencyIdr(subtotal, 'Rp '),
                        aksi: btAksi,
                    };
                    var dataToRequest = {
                        id_barang: idBarang,
                        id_eceran: idKonversi,
                        qty: qty,
                        harga: harga,
                        stok: sisa_stok,
                        subtotal: subtotal,
                    };
                    // console.log(dataToRequest);
                    jsonToTable.push(data);
                    jsonToRequest.push(dataToRequest);
                    table.clear().draw();
                    table.rows.add(jsonToTable).draw();
                    const dataBarang = JSON.stringify(jsonToRequest);
                    $("#dataBarang").val(dataBarang);

                    let totalSubtotal = 0;
                    $.each(jsonToRequest, function (index, item) {
                        totalSubtotal += item.subtotal;
                    });
                    $("#total_transaksi").val(currencyIdr(totalSubtotal, 'Rp '));

                    $("#id_grosir").val("");
                    $("#id_eceran").val("");
                    $("#namaBarang").html("");
                    $("#kuantitas").val("");
                    $("#hargaJual").val("");
                    $("#hargaBarang").val("");
                    $("#stokBarang").val("");
                    $("#satuanBarang").html("");
                    toastSuccess.showToast();
                } else {
                    toastError.showToast();
                }
            } else {
                toastError.showToast();
            }

        });

        $("#keranjangTabel").on("click", ".remove-row", function () {
            var rowIndex = $(this).closest("tr").index();
            table.row(rowIndex).remove().draw();
            jsonToTable.splice(rowIndex, 1);
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
