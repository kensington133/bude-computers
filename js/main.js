$(function() {
	weeklyGraph();
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