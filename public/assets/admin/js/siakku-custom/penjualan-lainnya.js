"use-strict";
$(document).ready(function () {
    var myElement = $(".detail-penyesuaian-penjualan");
    myElement.hide();
    document.querySelectorAll('input[name="cek_penjualan"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value === 'penyesuaian') {
                myElement.fadeIn(); // Efek fadeIn
            } else {
                myElement.fadeOut(); // Efek fadeOut
            }
        });
    });

    var i = 1;
    var satuans = satuanJson;

    $('#add-row').click(function () {
        var select = '<select id="satuan' + i + '" name="data[' + i +
            '][satuan]" class="form-select" required>' +
            '<option value="" selected>Pilih</option>';

        $.each(satuans, function (index, value) {
            select += '<option value="' + value.id_satuan + '">' + value.nama_satuan +
                '</option>';
        });
        select += '</select>';
        $('#table-data tbody').append(`
        <tr class="row-multi-insert">
          <td><input class="form-control" type="text" name="data[${i}][nama]" required></td>
          <td>
                <select name="data[${i}][jenis]" class="form-select">
                <option value="" selected>Pilih</option>
                <option value="Hasil">Hasil</option>
                <option value="Jasa">Jasa</option>
                </select>
          </td>
          <td><input class="form-control" type="number" step="0.25" id="qty` + i + `" onKeyUp="hitung(` + i + `)"  name="data[${i}][kuantitas]" required></td>
          <td>` + select + `</td>
          <td><input class="form-control format-rupiah" type="text" id="harga` + i + `" onKeyUp="hitung(` + i + `)" name="data[${i}][harga]" style="text-align: right;" required></td>
          <td><input class="form-control" type="text" id="total` + i + `" name="data[${i}][total]" style="text-align: right;" readonly></td>
          <td><button type="button" class="btn btn-sm btn-outline-danger remove-row"><span class="bi bi-trash"></span></button></td>
        </tr>
      `);

        let choices = document.getElementById('satuan' + i)
        let initChoice
        if (choices.classList.contains("multiple-remove")) {
            initChoice = new Choices(choices, {
                delimiter: ",",
                editItems: true,
                maxItemCount: -1,
                removeItemButton: true,
            })
        } else {
            initChoice = new Choices(choices)
        }
        const harga = document.getElementById('harga' + i);
        harga.addEventListener('keyup', function (e) {
            harga.value = currencyIdr(this.value, 'Rp ');
        });
        i++;
    });

    $('#table-data').on('click', '.remove-row', function () {
        $(this).parent().parent().remove();
    });

    // var jenisPembeli = $(".jns-pembeli");
    // jenisPembeli.hide();
    // $("#metode_transaksi").on("change", function () {
    //     let jenis = this.value;
    //     if (jenis == 'Kas') {
    //         jenisPembeli.fadeOut();
    //     } else if (jenis == 'Bank') {
    //         jenisPembeli.fadeOut();
    //     } else {
    //         jenisPembeli.fadeIn();
    //     }
    // });

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
});

//--hitung total--//
function hitung(i) {
    //ambil data id
    var getqty = document.getElementById('qty' + i).value;
    var getharga = document.getElementById('harga' + i).value;

    //cek apabila input kuantitas atau harga masih kosong, maka total = 0
    if (getqty == "" || getharga == "") {
        document.getElementById('total' + i).value = 0;
    } else {
        //konvert rp ke angka
        var harga = getharga.split(".").join("").split("Rp").join("");
        var hasil = parseInt(harga) * parseFloat(getqty);
        var currencyhasil = currencyIdr(hasil, '');
        document.getElementById('total' + i).value = currencyhasil;
    }

    var total = 0;
    //looping setiap baris
    $('.row-multi-insert').each(function (index) {
        //ambil data total setiap baris
        var subtotal = $(this).find('input[id^="total"]').val();
        //konvert subtotal ke angka
        subtotal = subtotal.split(".").join("").split("Rp").join("");
        total += parseInt(subtotal);
    });

    //konvert hasil ke rupiah
    var currencytotal = currencyIdr(total, '');
    //panggil id yang sudah dihitung
    document.getElementById('total_semua').innerHTML = currencytotal;
    document.getElementById('total_transaksi').value = currencytotal;
}

//--end hitung total--//