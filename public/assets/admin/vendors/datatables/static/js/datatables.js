/* DataTable*/

$(document).ready(function () {
      let jquery_datatable = $(".dataTable");
      let customized_datatable = $(".dataTable2");
      let tabelLaporan = $(".tabelLaporan");

      tabelLaporan.DataTable({
            "ordering": false
      });
      // Fungsi untuk mengatur warna pagination
      const setTableColor = () => {
            document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                  dt.classList.add('pagination-primary');
            });
      }

      // Inisialisasi DataTables untuk elemen dengan kelas "dataTable"
      jquery_datatable.each(function () {
            const table = $(this);
            const emptyRow = table.find('tbody tr:has(td[colspan])');
            const pagingEnabled = table.find('tbody tr').length > 10;

            if (emptyRow.length === 0) {
                  table.DataTable({
                        responsive: true,
                        paging: pagingEnabled,
                        drawCallback: function () {
                              setTableColor();
                        }
                  });
            }
      });

      // Inisialisasi DataTables untuk elemen dengan kelas "dataTable2"
      customized_datatable.DataTable({
            responsive: true,
            paging: customized_datatable.find('tbody tr').length > 10,
            pagingType: 'simple',
            dom:
                  "<'row'<'col-3'l><'col-9'f>>" +
                  "<'row dt-row'<'col-sm-12'tr>>" +
                  "<'row'<'col-4'i><'col-8'p>>",
            "language": {
                  "info": "Page _PAGE_ of _PAGES_",
                  "lengthMenu": "_MENU_ ",
                  "search": "",
                  "searchPlaceholder": "Search.."
            },
            drawCallback: function () {
                  setTableColor();
            }
      });
});


