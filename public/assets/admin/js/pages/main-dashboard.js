let optionAnggota = {
	series: anggota,
	labels: ['Pria', 'Wanita'],
	colors: ['#435ebe', '#55c6e8'],
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
				size: '30%'
			}
		}
	}
}

var chartAnggota = new ApexCharts(document.getElementById('chart-anggota'), optionAnggota)
chartAnggota.render();