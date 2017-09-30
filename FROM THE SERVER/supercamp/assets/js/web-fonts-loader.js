/**
 * Created by Ainsley & Co on 11/12/16.
 */

jQuery( document ).ready(function() {

	var tempFontArray = [];
	var tempFontSizeArray = [];
	var tempHolderArray = [];
	var fontArray = [];

	jQuery( '.ainsley-font-loader > div' ).each(function( index ) {
		//console.log( index + ": " + jQuery( this ).text() );
		var pushThis = jQuery( this ).text();
		//// split font family & weight
		var trimWeight = pushThis.indexOf(":");
		//// if there is a colon there is a weight - split and handle - if not, just check
		var varFont = '';
		var varWeight = '';
		if(trimWeight != -1){
			varFont  = pushThis.substring(0 , trimWeight);
			varWeight = pushThis.substring(trimWeight+1, pushThis.length);
			//// push ALL values - we will cut dupes later
			tempFontArray.push( varFont );
			tempFontSizeArray.push( varWeight );
		}
	});

	//// we want tempHolderArray to carry only unique font families
	for (var i = 0; i < tempFontArray.length; i++) {
		if(tempHolderArray.length == 0){
			tempHolderArray.push(tempFontArray[i]);
		}
		var oktopush = true;
		for (var j = 0; j < tempFontArray.length; j++){
			if(tempHolderArray[j] == tempFontArray[i]) {
				oktopush = false;
			}
		}
		if(oktopush){
			tempHolderArray.push(tempFontArray[i]);
		}
	}
	//console.log("final holder font array is " + tempHolderArray);

	//// at this point we have one array of fonts, one of sizes, and one just containing uniques
	//// loop through the uniques, check against the font array, and pull matching sizes
	var temptempArray = [];
	var tempSizeArray = [];
	var tempSizeGroup = '';
	for(var k = 0; k < tempHolderArray.length; k++){
		tempSizeGroup = '';
		for(var l = 0; l < tempFontArray.length; l++){
			if(tempHolderArray[k] == tempFontArray[l]){
				//console.log('match at ' + tempHolderArray[k] + ' vs ' + tempFontArray[l] + ' size ' + tempFontSizeArray[l]);
				//// let's not send dupes of 'regular'
				var str = tempSizeGroup;
				var res = str.split(",");
				var addRegular = true;
				for(var p = 0; p < res.length; p++){
					if(res[p] == 'regular'){
						addRegular = false;
					}
				}
				if(addRegular){
					tempSizeGroup = tempSizeGroup + tempFontSizeArray[l] + ',';
				}else{
					if(tempFontSizeArray[l] !== 'regular'){
						tempSizeGroup = tempSizeGroup + tempFontSizeArray[l] + ',';
					}
				}
			}
		}
		//// trim the trailing comma
		var trimmedGroup = tempSizeGroup.substring(0, tempSizeGroup.length - 1);
		tempSizeArray.push(trimmedGroup);
	}
	//// match up sizes to fonts & push the groups
	for( var q = 0; q < tempHolderArray.length; q++){
		if(tempSizeArray[q] !== 'regular'){
			fontArray.push(tempHolderArray[q] + ":" + tempSizeArray[q]);
		}else{
			fontArray.push(tempHolderArray[q]);
		}
	}

	var fadeOnce = true;
	var needFailsafe = true;


	/* this is a failsafe incase Google Fonts can't load or take more than 10 seconds */
	setTimeout(function(){
		if(needFailsafe == true){
			jQuery( '.ainsley-font-loader-styled' ).css({"visibility":"visible", "opacity":"1"});
		}else{
			//console.log('failsafe not needed');
		}
	}, 10000);

	var activeCallback = jQuery.Callbacks();
	WebFontConfig = {
		loading: function () {},
		active: function () {},
		inactive: function () {}
	};

	WebFont.load({
		google: {
			families: fontArray
		},
		loading: loadingFoo(),
		active:	foo()
	});

	function foo(){
		if(fadeOnce){
			jQuery( '.ainsley-font-loader-styled' ).css("visibility" ,  "visible");
			jQuery( '.ainsley-font-loader-styled' ).animate({
				opacity: 1
			}, 3000, function() {
				// Animation complete.
			});
			fadeOnce = false;
			needFailsafe = false;
		}
	}

	function loadingFoo(){
		//console.log('loadingfoo = ' + fontArray);
	}

	//// hijacked this file to add functionality to the page - sorry

	//.modal-content

	// Get the modal
	var modal = document.getElementById("myModal");
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];
	var varWidth = jQuery(window).width();
	var varHeight = jQuery(window).height();
	// When the user clicks on the button, open the modal
	jQuery(".sl-thumb").click(function() {
		varWidth = jQuery(window).width();
		varHeight = jQuery(window).height();
		var videoOrImage = jQuery( this ).data( "videoorimage" );
		var showThis = jQuery( this ).data( "link" );
		modal.style.display = "block";
		var vidWidth = "300";
		var vidHeight = "169";
		if(varWidth > 700){
			vidWidth = "560";
			vidHeight = "315";
		}
		if(varWidth > 1000){
			vidWidth = "750";
			vidHeight = "422";
		}
		if(varWidth > 1199){
			vidWidth = "940";
			vidHeight = "528";
		}
		if(varWidth > 1399){
			vidWidth = "1120";
			vidHeight = "630";
		}
		if(videoOrImage == "video"){
			jQuery( ".video-container" ).html( "<iframe width='" + vidWidth + "' height='" + vidHeight + "' src='' frameborder='0' allowfullscreen></iframe>" );
			jQuery(".video-container iframe").attr("src", showThis);
		}else{
			jQuery( ".video-container" ).html( "<div class='pic'></div>" );
			jQuery(".video-container .pic").html("<img src=" +  showThis + " />");
		}

		if(varWidth > 1200 && varHeight < 820){
			jQuery(".modal-content").css("margin-top", "50px");
			//jQuery(".modal-content").css("width", ("950px"));
		}else{
			jQuery(".modal-content").css("margin-top", "5%");
		}
	});

	jQuery(".sl-thumb").css( "cursor", "pointer" );

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	};

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
			jQuery( ".video-container" ).html("");
		}
	};

	jQuery(".modal").on('click', function (e) {

		var id = jQuery(this).attr('id');
		var target = "#" + id + ".modal iframe";

		jQuery(target).attr("src", jQuery(target).attr("src"));

		jQuery(".video-container iframe").attr("src", null);
		jQuery( ".video-container" ).html("");
	});
	///// end modal stuff ////



});

