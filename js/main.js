$(function() {
	if(window.location.pathname == '/home/job-stats/index.php' || window.location.pathname == '/home/job-stats/'){
		weeklyGraph();
		monthlyGraph();
		yearlyGraph();
	}
	submitForm();
});

function weeklyGraph(){
	$.ajax({
		url: "../../ajax/weeklyGraph.php",
		contentType: 'application/json;',
		dataType: 'json',
		success: function(data) {
			if(data !== 'error') {
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
			} else {
				$('#weeklyGraph').html('<p>No data found for this week!<p>');
			}
		},
		error: function(xhr, error, third){
			console.log(error);
			console.log(third);
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
		},
		error: function(xhr, error, third){
			console.log(error);
			console.log(third);
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

function submitForm(){
	$('select[name="display"]').change( function(){
		$(this).parent().submit();
	});
}