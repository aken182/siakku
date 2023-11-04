var optionLabaRugiToko = {
	annotations: {
		position: 'back'
	},
	dataLabels: {
		enabled: false
	},
	chart: {
		type: 'bar',
		height: 300
	},
	fill: {
		opacity: 1
	},
	plotOptions: {
	},
	series: [{
		name: 'SHU',
		data: labaRugiToko
	}],
	colors: '#d93891',
	xaxis: {
		categories: bulanLrToko,
	},
}

let optionPersediaanToko = {
	series: persediaanSaldo,
	labels: persediaanNama,
	colors: ['#435ebe', '#55c6e8', '#75e65e', '#ea40ed', '#7516a8', '#3be3a0'],
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

var chartLabaRugiToko = new ApexCharts(document.querySelector("#chart-laba-rugi-toko"), optionLabaRugiToko);
var chartPersediaanToko = new ApexCharts(document.getElementById('chart-persediaan-toko'), optionPersediaanToko)

chartLabaRugiToko.render();
chartPersediaanToko.render();