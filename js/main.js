$(function() {
	weeklyGraph()
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