(function ($) {
	'use strict';

	$(function() {

		function search_patch(){
			var varWidth = $(window).width();

			if(varWidth > 767) {

				var highestBox = 0;
				$('.post_text_inner').each(function () {
					if ($(this).height() > highestBox) {
						highestBox = $(this).height();
					}
				});
				$('.post_text_inner').height(highestBox);
				$('article').css('margin', '5px');
				$('article').css('display', 'block');
				$('article').css('float', 'left');
			}else{
				$('article').css('margin', '');
				$('article').css('display', '');
				$('article').css('float', '');
			}
			console.log('sp');
		}
		search_patch();

		$( window ).on( "orientationchange", function( event ) {
			search_patch();
		});


	});

})(jQuery);