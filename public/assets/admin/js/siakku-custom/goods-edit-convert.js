  'use-strict';
  //---input otomatis dengan perhitungan---//
  function hitungUpdate() {
      var getstoksebelum = document.getElementById('stok_sebelum').value;
      var getstokksebelum = document.getElementById('stokk_sebelum').value;
      var gettambahstok = document.getElementById('tambah_stok').value;
      var standarnilaiup = document.getElementById('standar_nilai').value;
      //hitung konvert satuan
      var total5 = parseFloat(standarnilaiup) * parseFloat(gettambahstok);
      var total6 = parseFloat(getstoksebelum) - parseFloat(gettambahstok);
      var total7 = parseFloat(getstokksebelum) + parseFloat(total5);
      //panggil id yang sudah dihitung
      document.getElementById('hasil_tambah').value = total5;
      document.getElementById('sisa_stok_update').value = total6;
      document.getElementById('sisa_stokkon_update').value = total7;
  }
  //---end input otomatis dengan perhitungan---//