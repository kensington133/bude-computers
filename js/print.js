$(document).ready(function(){
	callCloudPrint();
});

function cloudPrint() {
	var gadget = new cloudprint.Gadget();
	//add the printing parameter to the url string to avoid printing issues
	var url = window.location.href;
	var urlParts = url.split('/');
	if(urlParts[urlParts.length - 1] === ""){
		url += '?g=1';
	} else {
		url += '&g=1';
	}
	//send the current page to be printed
	gadget.setPrintDocument("url","Job Receipt", url);
	gadget.openPrintDialog();
}

//custom Cloud Print button handler
function callCloudPrint() {
	$('#print_button, .print_button').click(function(){
		cloudPrint();
	});
}