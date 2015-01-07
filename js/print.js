$(document).ready(function(){

	callCloudPrint();
});

function cloudPrint()
{
	var gadget = new cloudprint.Gadget();
	gadget.setPrintDocument("url","Job Receipt", window.location.href);
	gadget.openPrintDialog();
}
function callCloudPrint()
{
	$('#print_button, .print_button').click(function(){
		cloudPrint();
	});
}