(function ($) {
	'use strict';

	function resizeBoxes(container){
		var boxArray = [];
		$( container+".equal-height" ).each(function( index ) {
			$(this).height('auto');
			boxArray.push($(this).height());
		});
		var windowWidth = $(window).width();
		if(windowWidth >=768) {
			var largest = Math.max.apply(Math, boxArray);
			for (var i = 0; i < boxArray.length; i++) {
				$(container + ".equal-height").height(largest);
			}
			var pushDown = $('.typical-day > h2').outerHeight();
			$('.typical-day > h2.large-only').height(pushDown);
		}

	}

	$( window ).load(function(){
			resizeBoxes('.box-callout');
			resizeBoxes('.box-callout-2');
	});

	$(function() {

		function programs_patch(){
			if ( $( 'div' ).hasClass( "custom-tabs-container" ) ) {
				//// on a click we send the values to add to a function
				$( ".custom-tabs-tab" ).click(function() {
					var thisGroup = $(this).parent().parent().attr('id'); //// get the group to keep variables in this tabset
					var thisID = $(this).attr('id');
					var dash = thisID.indexOf("-");
					var tabNum = thisID.substring(dash, thisID.length);
					var addClassTargetContent = '#content' + tabNum;
					var addClassTargetTab = '#tab' + tabNum;
					var addClassGroup = '#' + thisGroup;
					//// first we need to add inactive to our current selection, then remove its active class
					$(addClassGroup).find('.active').addClass('inactive');
					$(addClassGroup).find('.active').removeClass('active');
					//// now we add the active class to what we want to show and remove their inactives
					$(addClassGroup).find(addClassTargetTab).addClass('active');
					$(addClassGroup).find(addClassTargetTab).removeClass('inactive');
					$(addClassGroup).find(addClassTargetContent).addClass('active');
					$(addClassGroup).find(addClassTargetContent).removeClass('inactive');

					$(addClassGroup).find(addClassTargetContent).css("opacity", 0);
					$(addClassGroup).find(addClassTargetContent).animate({
						opacity: 1
					}, 1500, function() {
						// Animation complete.
					});
				});
			}else{
				
			}
		}

		programs_patch();

		function setTabsWidth(){
			//// get the width of the first set - the 'master'
			if ( $( 'div' ).hasClass( 'custom-tabs-master' ) ) {
				var tabsWidth = $( '.custom-tabs-container' ).width();
			}
			var count = $('.custom-tabs-master > .custom-tabs-tab').length; //// the number of buttons in the MASTER set
			var buttonWidth = $('.custom-tabs-master > .custom-tabs-tab').width(); //// width of our buttons
			var buttonArea = buttonWidth * count; //// how much area do the buttons take up?
			var buttonSpace = tabsWidth - buttonArea; //// subtract to see how much open space between buttons
			var moveLeft = buttonSpace / (count-1); ////
			var counter = 0;
			$( '.custom-tabs-tabs').each(function( index ) {
				var setID = $(this).attr('id');
				$('#' + setID + ' > .custom-tabs-tab').each(function( index ) {
					var setLeft = counter * moveLeft;
					var timeLeft = counter * 100 + 500;
					$( this ).animate({
						left: setLeft
					}, timeLeft, "easeInQuad", function() {
						// Animation complete.
					});
					var expandLine = setLeft + (counter * buttonWidth);
					$('#' + setID + ' > .custom-tabs-tabs-line').animate({
						width: expandLine
					}, 140, "easeOutQuad", function() {
						// Animation complete.
					});
					counter++; //// count off - if we hit the amount of MASTER then we reset
					if(counter >= count){
						counter = 0;
					}
				});
			});
		} //// end setTabsWidth()

		var fireOnce = false;
		//// this fires our check 1/4 second after scrolling is done
		$(window).scroll(function() {
			clearTimeout(jQuery.data(this, 'scrollTimer'));
			$.data(this, 'scrollTimer', setTimeout(function() {
				var windowHeight = $(window).height();
				var iAmHere = $(window).scrollTop();
				var offset = $('.custom-tabs-master').offset();
				var halfOfHeight = windowHeight / 2;
				var fireHere = offset.top - halfOfHeight;
				if(iAmHere >= fireHere){
					if(!fireOnce){
						setTabsWidth();
					}
					fireOnce = true;
				}
			}, 250));
		});

		$( window ).resize(function() {
			clearTimeout(jQuery.data(this, 'resizeTimer'));
			$.data(this, 'resizeTimer', setTimeout(function() {
					setTabsWidth();
					resizeBoxes('.box-callout');
					resizeBoxes('.box-callout-2');
			}, 250));
		});

	});

})(jQuery);