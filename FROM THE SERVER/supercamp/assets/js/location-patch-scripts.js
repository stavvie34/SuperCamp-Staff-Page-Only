(function ($) {
	'use strict';

	$(function() {

		function location_patch(){

			if ( $( 'div' ).hasClass( "location-details-grid-child" ) ) {
				var varWidth = $(window).width();
				if(varWidth > 767){
					var highestBox = 0;
					$('.location-details-grid-child').each(function(){
						if($(this).height() > highestBox){
							highestBox = $(this).height();
						}
					});
					$('.location-details-grid-child').height(highestBox);

				}

			}else{
				//
			}
			/*
			var screenWidth = $(window).width();
			var fixRight = 200;
			var fixAgent = navigator.userAgent;
			var needsFix1 = fixAgent.indexOf('Firefox');
			var needsFix2 = fixAgent.indexOf('Edge');
			var needsFix3 = fixAgent.indexOf('MSIE');

			function fixRNav(){
				$('.header_inner_right').css("left", fixRight+"px");
				console.log('fixRNav 10.11.17 - 3:10PM');
			}
			if((needsFix1 !== -1) || (needsFix2 !== -1) || (needsFix3 !== -1)){
				if(screenWidth > 1149){
					fixRNav();
					setTimeout(function(){ fixRNav(); }, 1000);
				}else{
					$('.header_inner_right').css("left", "0px");
				}
			}
			*/
		}

		location_patch();

		$( window ).resize(function() {
			location_patch();
		});
	});

})(jQuery);