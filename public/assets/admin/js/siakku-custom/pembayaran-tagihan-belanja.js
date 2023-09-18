"use-strict";
$(document).ready(function () {

      var toastErrorBelanja = toastInfoTopRight("Jumlah pembayaran melebihi total tagihan !", "#ed2710");
      !(function jenisTrans() {
            var k = $("#rekening_kas");
            var b = $("#rekening_bank");
            var j = $("#metode_transaksi");
            k.hide();
            b.hide();
            j.on("change", function () {
                  let jt = $(this).val();
                  if (jt === 'Kas') {
                        k.fadeIn();
                        b.fadeOut();
                  } else {
                        b.fadeIn();
                        k.fadeOut();
                  }
            });
      })();

      !(function () {
            var jnP = $('input[name="cek_pembayaran"]');
            var i = $("#id_belanja");
            var it = $("#invoiceTagihan");
            var n = $("#penyedia");
            var tb = $("#tanggal_beli");
            var jp = $("#jumlah_beli");
            var jb = $("#jumlah_bayar");
            var tt = $("#total_tagihan");
            var st = $("#sisa_tagihan");
            var s = $("#status");
            var tii = $(".table-info");
            var myElement = $(".detail-penyesuaian-pembayaran");
            var saveBtn = $(".simpanBtn");

            myElement.hide();

            jnP.each(function () {
                  $(this).on("change", function () {
                        let q = $(this).val();
                        if (q === "penyesuaian") {
                              myElement.fadeIn(); // Efek fadeIn
                        } else {
                              myElement.fadeOut(); // Efek fadeOut
                        }
                  });
            });

            tii.hide();

            i.on("change", function () {
                  let id = $(this).val();
                  let t = tg;
                  let tx = t.find(p => p.id_belanja == id);
                  if (tx) {
                        tii.fadeIn();
                        it.html(tx.kode);
                        n.html(tx.penyedia);
                        tb.html(tx.tgl_beli);
                        jp.html(currencyIdr(tx.jumlah_belanja, 'Rp '));
                        tt.html(currencyIdr(tx.saldo_hutang, 'Rp '));
                        s.html(tx.status_belanja);
                  }
            });

            jb.on('keyup', function () {
                  let getJumlah = $(this).val();
                  let getTotalTagihan = tt.html();
                  let total = getTotalTagihan.split(".").join("").split("Rp").join("");
                  let jumlah = getJumlah.split(".").join("").split("Rp").join("");
                  let jf = parseInt(jumlah);
                  let tf = parseInt(total);
                  if (jf === 0) {
                        st.val("");
                        st.removeClass("text-info");
                        saveBtn.prop("disabled", true);
                  } else if (jf > tf) {
                        if (jnP.is(':checked')) {
                              let jnPk = $('input[name="cek_pembayaran"]:checked').val();
                              if (jnPk === "penyesuaian") {
                                    st.val("Disesuaikan setelah disimpan !");
                                    st.addClass("text-info");
                                    saveBtn.prop("disabled", false);
                              } else {
                                    st.val("");
                                    st.removeClass("text-info");
                                    toastErrorBelanja.showToast();
                                    saveBtn.prop("disabled", true);
                              }
                        }
                  } else {
                        if (jnP.is(':checked')) {
                              let jnPk = $('input[name="cek_pembayaran"]:checked').val();
                              if (jnPk === "penyesuaian") {
                                    st.val("Disesuaikan setelah disimpan !");
                                    st.addClass("text-info");
                                    saveBtn.prop("disabled", false);
                              } else {
                                    const getsaldo = tt.text();
                                    const saldo = getsaldo.split(".").join("").split("Rp").join("");
                                    const hasil = parseInt(saldo) - jf;
                                    const currencyhasil = currencyIdr(hasil, 'Rp ');
                                    st.val(currencyhasil);
                                    st.removeClass("text-info");
                                    saveBtn.prop("disabled", false);
                              }
                        }
                  }
            });

      })();

});
