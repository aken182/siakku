
$(function () {
      var table = $('#yajra-datatable');
      var routeUrl = $('#routeUrl').data('route');
      table.DataTable({
            processing: true,
            serverSide: true,
            ajax: routeUrl,
            columns: [
                  {
                        data: 'kode_barang',
                        name: 'kode_barang'
                  },
                  {
                        data: 'nama_barang',
                        name: 'nama_barang'
                  },
                  {
                        data: 'jenis_barang',
                        name: 'jenis_barang'
                  },
                  {
                        data: 'tpk',
                        name: 'tpk'
                  },
                  {
                        data: 'stok',
                        name: 'stok'
                  },
                  {
                        data: 'harga_barang',
                        name: 'harga_barang'
                  },
                  {
                        data: 'nilai_saat_ini',
                        name: 'nilai_saat_ini'
                  },
                  {
                        data: 'umur_ekonomis',
                        name: 'umur_ekonomis'
                  },
                  {
                        data: 'harga_jual',
                        name: 'harga_jual'
                  },
                  {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: true,
                        searchable: true
                  },
            ]
      });

});