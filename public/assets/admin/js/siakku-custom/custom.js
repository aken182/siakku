/* Kafta Custom */
'use-strict';

$(document).ready(function () {
      /* Simple DataTable*/
      $('.dataTable').each(function () {
            new simpleDatatables.DataTable(this);
      });

      /* Tooltip*/
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
      })

      tinymce.init({
            selector: '#defaultNews'
      });
      tinymce.init({
            selector: '#dark',
            toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
            plugins: 'code'
      });
});
