
$(function () {
      var table = $('.trs-table');
      var routeUrl = $('#routeUrl').data('route');
      table.DataTable({
            processing: true,
            serverSide: true,
            ajax: routeUrl,
            columns: [
                  {
                        data: 'kode',
                        name: 'kode'
                  },
                  {
                        data: 'tgl_transaksi',
                        name: 'tgl_transaksi'
                  },
                  {
                        data: 'keterangan',
                        name: 'keterangan'
                  },
                  {
                        data: 'total',
                        name: 'total'
                  }
            ]
      });

});