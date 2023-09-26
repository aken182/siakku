/*belanja barang adjustment*/
$(document).ready(function () {
      var idAnggota = $('#id-anggota');
      var jumlahSimpanan = $('#jumlah-simpanan');
      var persenBunga = $('#persen-bunga');
      var bunga = $('#bunga');
      var totalSimpanan = $('#total-simpanan');
      var hitungBunga = $('#hitung-bunga');
      var i = $('.invoicePenyesuaian');
      var myElement = $(".detail-penyesuaian-simpanan");
      var jnS = $('input[name="cek_simpanan"]');
      myElement.hide();
      document.querySelectorAll('input[name="cek_simpanan"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                  if (this.value === 'penyesuaian') {
                        myElement.fadeIn(); // Efek fadeIn
                  } else {
                        myElement.fadeOut(); // Efek fadeOut
                  }
                  bunga.val("");
                  totalSimpanan.val("");
                  persenBunga.val("");
                  jumlahSimpanan.val("");
                  idAnggota.val("");
            });
      });
      $(function () {
            hitungBunga.click(function () {
                  var persen_bunga = persenBunga.val();
                  let id_anggota = idAnggota.val();
                  let jumlah_simpanan = jumlahSimpanan.val();
                  let id_penyesuaian = i.val();
                  if (id_anggota != '' && persen_bunga != '' && jumlah_simpanan != '') {

                        if (jnS.is(':checked')) {
                              let jnSv = $('input[name="cek_simpanan"]:checked').val();
                              if (jnSv === 'penyesuaian') {
                                    var request = {
                                          id_anggota: id_anggota,
                                          id_penyesuaian: id_penyesuaian,
                                          persen_bunga: persen_bunga,
                                          jumlah_simpanan: jumlah_simpanan
                                    }
                              } else {
                                    var request = {
                                          id_anggota: id_anggota,
                                          persen_bunga: persen_bunga,
                                          jumlah_simpanan: jumlah_simpanan
                                    }

                              }
                              var csrf_token = $('meta[name="csrf-token"]').attr('content');
                              $.ajaxSetup({
                                    headers: {
                                          'X-CSRF-TOKEN': csrf_token
                                    }
                              })
                              $.ajax({
                                    url: '/simpanan/unit-sp/get-srb',
                                    method: "GET",
                                    data: request,
                                    success: function (result) {
                                          bunga.val(currencyIdr(result.bunga, 'Rp '));
                                          totalSimpanan.val(currencyIdr(result.totalSimpanan, 'Rp '));
                                    },
                                    error: function (xhr, status, error) {
                                          var errorMessage = xhr.status + ': ' + xhr.statusText;
                                          const toastInfo = toastInfoTopRight(errorMessage, "#ed2710");
                                          toastInfo.showToast();

                                    }
                              });
                        } else {
                              const toastError = toastInfoTopRight("Anda belum memilih jenis simpanan !", "#ed2710");
                              toastError.showToast();
                        }
                  } else {
                        const toastError = toastInfoTopRight("Anda harus memasukkan data anggota, jumlah simpanan, dan persen bunga dengan benar !", "#ed2710");
                        toastError.showToast();
                  }
            });
      });
})