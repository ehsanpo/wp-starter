(function($) { 
	$(function() {
		$(document)
        .on('click','.button__navigation',function(e){
        	$('.header__navigation').toggleClass('open');
        });

	});
})(jQuery);