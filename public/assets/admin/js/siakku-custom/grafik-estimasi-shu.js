'use strict';

$(document).ready(function () {
      var chartUrl = $('#chart-route').data('route');
      var unit = $('#unit').data('unit');
      var series = [];
      var labels = [];
      var csrf_token = $('meta[name="csrf-token"]').attr('content');
      $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': csrf_token
            }
      })

      $.ajax({
            url: chartUrl,
            method: "GET",
            data: {
                  unit: unit
            },
            success: function (result) {
                  result.estimasi.forEach(function (dana) {
                        series.push(dana.alokasi);
                        labels.push(dana.nama);
                  });
            },
            error: function (xhr, status, error) {
                  var errorMessage = xhr.status + ': ' + xhr.statusText;
                  const toastInfo = toastInfoTopRight(errorMessage, "#ed2710");
                  toastInfo.showToast();
                  sf.fadeOut();

            }
      });

      let optionsEstimasi = {
            series: series,
            labels: labels,
            colors: ['#55c6e8', '#435ebe', '#ed2710', "#FFCF96", '#6A9C89', '#B5CB99', '#B2533E', '#D988B9', '#F4E869'],
            chart: {
                  type: 'donut',
                  width: '100%',
                  height: '350px'
            },
            legend: {
                  position: 'bottom'
            },
            plotOptions: {
                  pie: {
                        donut: {
                              size: '50%'
                        }
                  }
            }
      }
      var chartEstimasi = new ApexCharts(document.getElementById('chart-estimasi'), optionsEstimasi);
      chartEstimasi.render()
})