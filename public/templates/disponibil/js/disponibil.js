(function($){
	$(document).ready(function(){

		$('#main-alert').click(function(){

		  $('#alerts-popup').show(10, function(){
		    document.body.addEventListener('click', boxCloser, false);
		  });

		});

		function boxCloser(e){
		  if(e.target.id != 'alerts-popup'){
		     document.body.removeEventListener('click', boxCloser, false);
		     $('#alerts-popup').hide();
		  }
		}
	});
})(jQuery);