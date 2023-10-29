
$(function () {
      var table = $('#aktiva-table');
      var routeUrl = $('#route-list').data('route');
      table.DataTable({
            processing: true,
            serverSide: true,
            ajax: routeUrl,
            columns: [
                  {
                        data: 'no',
                        name: 'no'
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
                        data: 'qty',
                        name: 'qty'
                  },
                  {
                        data: 'tahun_beli',
                        name: 'tahun_beli'
                  },
                  {
                        data: 'harga_sblm',
                        name: 'harga_sblm'
                  },
                  {
                        data: 'harga_bjln',
                        name: 'harga_bjln'
                  },
                  {
                        data: 'harga_perolehan',
                        name: 'harga_perolehan'
                  },
                  {
                        data: 'pny_sblm',
                        name: 'pny_sblm'
                  },
                  {
                        data: 'pny_bjln',
                        name: 'pny_bjln'
                  },
                  {
                        data: 'penyusutan',
                        name: 'penyusutan'
                  },
                  {
                        data: 'nilai_buku',
                        name: 'nilai_buku'
                  },
                  {
                        data: 'masa_manfaat',
                        name: 'masa_manfaat'
                  }
            ]
      });

});