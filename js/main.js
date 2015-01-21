$(function() {
	if(window.location.pathname == '/home/job-stats/index.php' || window.location.pathname == '/home/job-stats/'){
		weeklyGraph();
		monthlyGraph();
		yearlyGraph();
	}
	submitForm();
	handleRegistrationForm();
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

function handleRegistrationForm(){
	$('#register')
	.on('invalid', function () {
		var invalid_fields = $(this).find('[data-invalid]');
		console.log(invalid_fields);
	})
	.on('valid', function () {
		console.log('valid!');
		Stripe.card.createToken({
			number: $('#number').val(),
			exp_month: $('#exp_month').val(),
			exp_year: $('#exp_year').val(),
			cvc: $('#cvc').val(),
			name: $('#register input[name="name"]').val(),
			address_line1: $('#register input[name="address_line1"]').val(),
			address_city: $('#register input[name="address_city"]').val(),
			address_state: $('#register input[name="address_state"]').val(),
			address_zip: $('#register input[name="address_zip"]').val(),
			address_country: 'GB'
		}, stripeResponseHandler);
	});
}

function stripeResponseHandler(status, response){
	var $form = $('#register');

	if (response.error) {
		// Show the errors on the form
		// $form.find('.payment-errors').text(response.error.message);
		$('.err-text').text(response.error.message);
		$('.js-err').fadeIn( function(){
			// $("html, body").animate({ scrollTop: 0 }, "slow");
		});

		console.log(response.error.message);

	} else {
		// response contains id and card, which contains additional card details
		var token = response.id;
		// Insert the token into the form so it gets submitted to the server
		$form.append($('<input type="hidden" name="stripeToken" />').val(token));
		// and submit
		$form.get(0).submit();
	}
}