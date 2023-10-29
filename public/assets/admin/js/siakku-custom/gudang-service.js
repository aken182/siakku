'use strict';

$(document).ready(function () {
      var table = $('#gudang-table-lrtk'),
            table2 = $('#gudang-table-psr'),
            table3 = $('#gudang-table-wrg'),
            grLrtk = $('#route-gudang-lrtk').data('route'),
            grPsr = $('#route-gudang-psr').data('route'),
            grWrg = $('#route-gudang-wrg').data('route');

      getTableGudang(table, grLrtk);
      getTableGudang(table2, grPsr);
      getTableGudang(table3, grWrg);
});
