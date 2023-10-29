'use strict';
function getTableGudang(table, route) {
      return table.DataTable({
            processing: true,
            serverSide: true,
            ajax: route,
            columns: [
                  {
                        data: null, // Tidak ada kolom data yang terkait, gunakan null
                        name: 'no', // Nama kolom
                        orderable: false, // Agar kolom ini tidak dapat diurutkan
                        searchable: false, // Agar kolom ini tidak dapat dicari
                        render: function (data, type, row, meta) {
                              return meta.row + 1 + '.'; // Menggunakan indeks baris DataTable (dimulai dari 0)
                        }
                  },
                  {
                        data: 'nama',
                        name: 'nama'
                  },
                  {
                        data: 'jenis',
                        name: 'jenis'
                  },
                  {
                        data: 'stok',
                        name: 'stok'
                  },
                  {
                        data: 'harga',
                        name: 'harga'
                  },
                  {
                        data: 'jumlah',
                        name: 'jumlah'
                  }
            ]
      });
}

