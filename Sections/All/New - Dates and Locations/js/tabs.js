// Rewritten from original version in JQuery


/* Fade out function
(function() {
    var FX = {
        easing: {
            linear: function(progress) {
                return progress;
            },
            quadratic: function(progress) {
                return Math.pow(progress, 2);
            },
            swing: function(progress) {
                return 0.5 - Math.cos(progress * Math.PI) / 2;
            },
            circ: function(progress) {
                return 1 - Math.sin(Math.acos(progress));
            },
            back: function(progress, x) {
                return Math.pow(progress, 2) * ((x + 1) * progress - x);
            },
            bounce: function(progress) {
                for (var a = 0, b = 1, result; 1; a += b, b /= 2) {
                    if (progress >= (7 - 4 * a) / 11) {
                        return -Math.pow((11 - 6 * a - 11 * progress) / 4, 2) + Math.pow(b, 2);
                    }
                }
            },
            elastic: function(progress, x) {
                return Math.pow(2, 10 * (progress - 1)) * Math.cos(20 * Math.PI * x / 3 * progress);
            }
        },
        animate: function(options) {
            var start = new Date;
            var id = setInterval(function() {
                var timePassed = new Date - start;
                var progress = timePassed / options.duration;
                if (progress > 1) {
                    progress = 1;
                }
                options.progress = progress;
                var delta = options.delta(progress);
                options.step(delta);
                if (progress == 1) {
                    clearInterval(id);
                    options.complete();
                }
            }, options.delay || 10);
        },
        fadeOut: function(element, options) {
            var to = 1;
            this.animate({
                duration: options.duration,
                delta: function(progress) {
                    progress = this.progress;
                    return FX.easing.swing(progress);
                },
                complete: options.complete,
                step: function(delta) {
                    element.style.opacity = to - delta;
                }
            });
        },
        fadeIn: function(element, options) {
            var to = 0;
            this.animate({
                duration: options.duration,
                delta: function(progress) {
                    progress = this.progress;
                    return FX.easing.swing(progress);
                },
                complete: options.complete,
                step: function(delta) {
                    element.style.opacity = to + delta;
                }
            });
        }
    };
    window.FX = FX;
})()


*/



















document.addEventListener('DOMContentLoaded', function() {
	// Variables
	var clickedTab = document.querySelector('.tabs > .active');	
	var tabWrapper = document.querySelector('.tab__content');	
	var activeTab = document.querySelector('.tab__content > .active');	
	var activeTabHeight = activeTab.offsetHeight;	
	var tabList = document.querySelector('.tabs > li');
	var allTabs = document.querySelector('.tab__content > li');
	
	// Show tab on page load
	activeTab.setAttribute('style', 'display: block');
	
	// Set height of wrapper on page load
	tabWrapper.setAttribute('style', 'height', activeTabHeight);
	
	tabList.addEventListener('click', function() {
		
		// Remove class from active tab
		tabList.classList.remove('active');
		
		// Add class active to clicked tab
		this.classList.add('active');
		
		// Update clickedTab variable
		clickedTab = ('.tabs .active');
		
		// fade out active tab
		activeTab.fadeOut(250, function() {
			
			// Remove active class all tabs
			allTabs.classList.remove('active');
			
			// Get index of clicked tab
			var clickedTabIndex = clickedTab.indexOf();
			
			// Add class active to corresponding tab
			allTabs[clickedTabIndex].classList.add('active');
			
			// update new active tab
			activeTab = ('.tab__content > .active');
			
			// Update variable
			activeTabHeight = activeTab.offsetHeight;
			
			// Animate height of wrapper to new tab height
			tabWrapper.stop().delay(50).animate({
				height: activeTabHeight
			}, 500, function() {
				
				// Fade in active tab
				activeTab.delay(50).fadeIn(250);
				
			});
		});
	});
});