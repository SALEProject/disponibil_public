$(document).ready(function() {
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	var after_two_months = '';
	
	function zeroFill(n){
		return (n < 10 ? '0' : '') + n;
	}
	
	last_month = zeroFill(dd) + '-' + zeroFill(today.getMonth()) + '-' + yyyy;
	after_two_months = zeroFill(dd) + '-' + zeroFill(today.getMonth() + 2) + '-' + yyyy;
	today = zeroFill(dd) + '-' + zeroFill(mm) + '-' + yyyy;
	
	$('#reservation').daterangepicker(
			{
				format: 'DD-MM-YYYY',
				startDate: last_month,
				endDate: today
			}, 
			function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), 'success');
            });
     });