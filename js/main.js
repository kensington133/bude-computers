$(function() {
	//only call the AJAX request on the correct pages
	if(window.location.pathname == '/home/job-stats/index.php' || window.location.pathname == '/home/job-stats/'){
		weeklyGraph();
		monthlyGraph();
		yearlyGraph();
	}
	submitForm();
	handleRegistrationForm();
	hideSaveIcon();
	if(window.location.pathname == '/home/user/index.php' || window.location.pathname == '/home/user/'){
		// generateUserMenu();
	}
});

$(window).resize( function(){
	hideSaveIcon();
});

//retrieve the weekly data for the graph
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

//retrieve the monthly data for the graph
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

//retrieve the yearly data for the graph
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

//when a user changes to amount of jobs to display, submit the form
function submitForm(){
	$('select[name="display"]').change( function(){
		$(this).parent().submit();
	});
}

//check if the registration form is valid, if it is send the card data to stripe
function handleRegistrationForm(){
	$('#register')
	.on('invalid', function () {
		var invalid_fields = $(this).find('[data-invalid]');
	})
	.on('valid', function () {
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

//callback used when submitting card data on the registration form
function stripeResponseHandler(status, response){
	var $form = $('#register');
	if (response.error) {
		// Show the errors on the form
		$('.err-text').text(response.error.message);
		$('.js-err').fadeIn();
	} else {
		// response contains id and card, which contains additional card details
		var token = response.id;
		// Insert the token into the form so it gets submitted to the server
		$form.append($('<input type="hidden" class="test" name="stripeToken" />').val(token));
		// and submit
		$form.get(0).submit();
	}
}

//at certain screen sizes, hide the save icon on buttons
function hideSaveIcon(){
	var icon = $('.fa-input');
	if (Modernizr.mq('only screen and (min-width: 642px)')){
		icon.val(String.fromCharCode(61639)+' Save');
	} else {
		icon.val('Save');
	}
}

function generateUserMenu(){
	$('nav section.top-bar-section li:not(.divider) a:not(.parent-link)').each( function(index, item){
		var item = $(item);
		var itemText = item.text();

		console.log(itemText);

		if(itemText !== 'Back'){
			console.log(itemText);
			var htmlString = "<div class='small-4 columns text-center end'><div class='switch large'><h6>"+itemText+"</h6><input id='menuItem"+index+"' name='menuItem"+index+"' type='checkbox'><label for='menuItem"+index+"'></label></div></div>";

			$('.menuOptions').append(htmlString);
		}
	});
}