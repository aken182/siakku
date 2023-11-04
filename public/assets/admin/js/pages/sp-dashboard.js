var optionLabaRugiSp = {
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
		data: labaRugiSp
	}],
	colors: '#435ebe',
	xaxis: {
		categories: bulanLrSp,
	},
}

let optionSimpananSp = {
	series: valuesSimpananSp,
	labels: keysSimpananSp,
	colors: ['#435ebe', '#a163ab', '#75e65e', '#ea40ed', '#7516a8', '#3be3a0', '#dfe65e'],
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

var chartLabaRugiSp = new ApexCharts(document.querySelector("#chart-laba-rugi-sp"), optionLabaRugiSp);
var chartSimpananSp = new ApexCharts(document.getElementById('chart-simpanan-sp'), optionSimpananSp)

chartLabaRugiSp.render();
chartSimpananSp.render();