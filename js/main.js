$(function() {
	weeklyGraph();
	monthlyGraph();
	yearlyGraph();
});

function weeklyGraph(){
	$.ajax({
		url: "../../ajax/weeklyGraph.php",
		contentType: 'application/json;',
		dataType: 'json',
		success: function(data) {
			$.plot("#weeklyGraph", [ data ], {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center",
						lineWidth: 0,
						fillColor: 'rgba(0,219,213, 0.6)'
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0
				}
			});
		}
	});
}

function monthlyGraph(){
	$.ajax({
		url: "../../ajax/monthlyGraph.php",
		contentType: 'application/json;',
		dataType: 'json',
		success: function(data) {
			$.plot("#monthlyGraph", [ data ], {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center",
						lineWidth: 0,
						fillColor: 'rgba(0,219,213, 0.6)'
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0
				}
			});
		}
	});
}

function yearlyGraph(){
	$.ajax({
		url: "../../ajax/yearlyGraph.php",
		contentType: 'application/json;',
		dataType: 'json',
		success: function(data) {
			$.plot("#yearlyGraph", [ data ], {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center",
						lineWidth: 0,
						fillColor: 'rgba(0,219,213, 0.6)'
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0
				}
			});
		},
		error: function(xhr, error, third){
			console.log(error);
			console.log(third);
		}
	});
}