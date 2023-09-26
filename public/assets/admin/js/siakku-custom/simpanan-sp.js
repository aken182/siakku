"use-strict";

$(document).ready(function () {
      !(function () {
            var btAksi = `<button class="btn btn-xs btn-danger btn-flat remove-row"><i class="bi bi-trash"></i></button>`;
            var table = $("#keranjangTabel").DataTable({
                  columns: [
                        { title: "No", data: "no" },
                        { title: "Nama", data: "nama" },
                        { title: "Jumlah", data: "jumlah" },
                        { title: "Aksi", data: "aksi" },
                  ],
            });

            var jsonToTable = [];
            var jsonToRequest = [];
            var idSimpanan = $("#id_simpanan");
            var jumlahPerBulan = $("#jumlahPerBulan");
            var jumlahSimpanan = $("#jumlahSimpan");
            var namaSimpanan = $("#namaSimpanan");
            var tambahKeranjang = $(".addToChartBtn");
            var nomorTerakhir = 0; // Inisialisasi nomor terakhir

            var toastSuccess = toastInfoTopRight("Data berhasil ditambahkan ke keranjang !", "#4fbe87");
            var toastSuccessDestroy = toastInfoTopRight("Data berhasil dihapus dari keranjang !", "#4fbe87");
            var toastError = toastInfoTopRight("Data tidak dimasukkan dengan benar !", "#ed2710");

            idSimpanan.on("change", function () {
                  let id_simpanan = $(this).val();
                  let simpanan = mS;
                  let simpananx = simpanan.find(p => p.id_simpanan == id_simpanan);
                  if (simpananx) {
                        jumlahPerBulan.val(currencyIdr(simpananx.jumlah, 'Rp '));
                        namaSimpanan.val(simpananx.nama);
                  }
            });

            tambahKeranjang.click(function () {
                  if (jumlahSimpanan.val() != "") {
                        if (jumlahPerBulan.val() != "") {
                              // Menambahkan 1 ke nomor terakhir setiap kali Anda menambahkan data
                              nomorTerakhir++;

                              const getJumlah = jumlahSimpanan.val();
                              const jumlahx = getJumlah.split(".").join("").replace("Rp", "");
                              const jumlah = parseFloat(jumlahx);
                              const getPerbulan = jumlahPerBulan.val();
                              const perbulanx = getPerbulan.split(".").join("").replace("Rp", "");
                              const perbulan = parseFloat(perbulanx);
                              var data = {
                                    no: nomorTerakhir, // Menggunakan nomor terakhir
                                    nama: namaSimpanan.val(),
                                    jumlah: jumlahSimpanan.val(),
                                    aksi: btAksi,
                              };
                              var dataToRequest = {
                                    id_simpanan: idSimpanan.val(),
                                    nama: namaSimpanan.val(),
                                    jumlah_perbulan: perbulan,
                                    jumlah: jumlah,
                              };
                              jsonToTable.push(data);
                              jsonToRequest.push(dataToRequest);
                              console.log(jsonToRequest);
                              table.clear().draw();
                              table.rows.add(jsonToTable).draw();
                              const dataSimpanan = JSON.stringify(jsonToRequest);
                              $("#dataSimpanan").val(dataSimpanan);

                              let totalSubtotal = 0;
                              $.each(jsonToRequest, function (index, item) {
                                    totalSubtotal += item.jumlah;
                              });
                              $("#total_transaksi").val(currencyIdr(totalSubtotal, 'Rp '));

                              idSimpanan.val("");
                              namaSimpanan.val("");
                              jumlahPerBulan.val("");
                              jumlahSimpanan.val("");
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

                  // Memperbarui nomor pada objek data setelah menghapus
                  for (var i = 0; i < jsonToTable.length; i++) {
                        jsonToTable[i].no = i + 1;
                  }

                  const dataSimpanan = JSON.stringify(jsonToRequest);
                  $("#dataSimpanan").val(dataSimpanan);

                  let totalSubtotal = 0;
                  $.each(jsonToRequest, function (index, item) {
                        totalSubtotal += item.jumlah;
                  });
                  $("#total_transaksi").val(currencyIdr(totalSubtotal, 'Rp '));

                  toastSuccessDestroy.showToast();
            });
      })();
});

