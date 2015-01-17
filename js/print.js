$(document).ready(function(){

	callCloudPrint();
});

function cloudPrint()
{
	var gadget = new cloudprint.Gadget();
	var url = window.location.href;
	var urlParts = url.split('/');
	if(urlParts[urlParts.length - 1] === ""){
		url += '?g=1';
	} else {
		url += '&g=1';
	}
	gadget.setPrintDocument("url","Job Receipt", url);
	gadget.openPrintDialog();
}
function callCloudPrint()
{
	$('#print_button, .print_button').click(function(){
		cloudPrint();
	});
}