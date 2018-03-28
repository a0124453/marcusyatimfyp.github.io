$(document).ready(function() {
	$.ajax({
		url: "http://localhost/fypwebsite/chartjs/graph_upload.php",
		type: "GET",
		success: function(data){
			console.log(data);

			data = JSON.parse(data);

			var magnitude = [];
			var phase = [];
			var time = [];

			for (var i in data) {
				magnitude.push(data[i].magnitude);
				phase.push(data[i].phase);
				time.push(data[i].time);
			}

			var chartdata1 = {
				labels: time,
				datasets: [
				{
					label: 'Magnitude',
					fill: false,
					lineTension: 0.1,
					backgroundColor: "rgba(59, 89, 152, 0.75)",
					borderColor: "rgba(59, 89, 152, 1)",
					pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
					pointHoverBorderColor: "rgba(59, 89, 152, 1)",
					data: magnitude
				}
				]
			};

			var chartdata2 = {
				labels: time,
				datasets: [
				{
					label: 'Phase',
					fill: false,
					lineTension: 0.1,
					backgroundColor: "rgba(29, 202, 255, 0.75)",
					borderColor: "rgba(29, 202, 255, 1)",
					pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
					pointHoverBorderColor: "rgba(29, 202, 255, 1)",
					data: phase
					
				}
				]

			};

			var ctx1 = $("#mynewcanvas1");
			var ctx2 = $("#mynewcanvas2");

			var LineGraph1 = new Chart(ctx1, {
				type: 'line',
				data: chartdata1,
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: false
							},
							scaleLabel: {
								display: true,
								labelString: 'Magnitude / V'
							}
						}],
						xAxes: [{
							ticks: {
								beginAtZero: false
							},
							scaleLabel: {
								display: true,
								labelString: 'Time / hour:min:sec'
							}
						}]
					}
				}
			}
			);
			var LineGraph2 = new Chart(ctx2, {
				type: 'line',
				data: chartdata2,
				responsive: false,
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: false
							},
							scaleLabel: {
								display: true,
								labelString: 'Phase / degree'
							}
						}],
						xAxes: [{
							ticks: {
								beginAtZero: false
							},
							scaleLabel: {
								display: true,
								labelString: 'Time / hour:min:sec'
							}
						}]
					}
				}
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});