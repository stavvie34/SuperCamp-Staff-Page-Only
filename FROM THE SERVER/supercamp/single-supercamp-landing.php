<?php

$id = get_the_ID();
get_header('landing-page'); //// the header file only contains Qcode and WordPress required stuff - moved content to here

///// Get ACF values
$logoGraphic = get_field('landing_page_logo');
$logo_url = '';
if( !empty($logoGraphic) ) {
	$logo_url = $logoGraphic['url'];
}else{
	$logo_url = 'http://www.supercamp.com/wp-content/uploads/2016/08/SC_logo_White.png';
}
$logoHolderColor = get_field('landing_page_header_logo_holder_color');

//// these are all the Google Font & weight values
$headerH1Font = get_field('landing_page_header_h1_font');
$headerH1FontWeight = get_field('landing_page_header_h1_font_weight');
$headerH1FontStyle = get_field('landing_page_header_font_italic');
$headerH1GFFW = ''; //// GFFW = Google Fonts Font Weight
if($headerH1FontStyle){ //// if the user has set 'italic= yes'
	//// these conditionals are about allowing the forced italic of a font that has no italic option
	if($headerH1FontWeight !== "regular"){
		$headerH1GFFW = $headerH1FontWeight . "i"; //// if the user has selected other than regular then append an 'i' for the Google Fonts call
	}else{
		$headerH1GFFW = "regular"; //// if it's regular set that value - our JQuery will clean up later
	}
	$headerH1FontStyle = "italic";
}else{
	$headerH1GFFW = $headerH1FontWeight;
	$headerH1FontStyle = "normal";
}
$headerTextFont = get_field('landing_page_header_text_font');
$headerTextFontWeight = get_field('landing_page_header_text_font_weight');
$phoneNumberFont = get_field('landing_page_phone_number_font');
$phoneNumberFontWeight = get_field('landing_page_phone_number_font_weight');
$formH2Font = get_field('landing_page_form_h2_font');
$formH2FontWeight = get_field('landing_page_form_H2_font_weight');
$formH2FontStyle = get_field('landing_page_form_h2_font_italic');
$formF2GFFW = '';
if($formH2FontStyle){
	if($formH2FontWeight !== "regular"){
		$formH2GFFW = $formH2FontWeight . "i";
	}else{
		$formH2GFFW = "regular";
	}
	$formF2FontStyle = "italic";
}else{
	$formH2GFFW = $formH2FontWeight;
	$formF2FontStyle = "normal";
}

$formTextFont = get_field('landing_page_form_text_font');
$formTextFontWeight = get_field('landing_page_form_text_font_weight');
$formButtonFont = get_field('landing_page_form_button_text_font');
$formButtonFontWeight = get_field('landing_page_form_button_text_font_weight');
$bodyFont = get_field('landing_page_body_font');
$bodyFontWeight = get_field('landing_page_body_text_font_weight');
$footerFont = get_field('landing_page_footer_text_font');
$footerFontWeight = get_field('landing_page_footer_text_font_weight');
$footerPhoneFont = get_field('landing_page_footer_phone_font');
$footerPhoneFontWeight = get_field('landing_page_footer_phone_font_weight');
$bottomFooterFont = get_field('landing_page_bottom_footer_text_font');
$bottomFooterFontWeight = get_field('landing_page_bottom_footer_text_font_weight');
//// end Google Fonts variables


 $headerH1Text = get_field('landing_page_header_h1');
 $headerH1Color = get_field('landing_page_header_h1_color');

 $headerText = get_field('landing_page_header_text');
 $headerTextColor = get_field('landing_page_header_text_color');

 $phoneNumber = get_field('landing_page_phone_number'); /// need to clean a version for linking
 $cleanPhoneNumber = preg_replace('/[^A-Za-z0-9\-]/', '', $phoneNumber);
 $cleanPhoneNumber = str_replace("-","",$cleanPhoneNumber);


 $headerLinkColor = get_field('landing_page_header_link_color');
 $headerBackgroundImage = get_field('landing_page_header_background_image');
 $headerBackgroundURL = $headerBackgroundImage['url'];

 $headerBackgroundColor = get_field('landing_page_header_background_color');
 $headerColorBarColor = get_field('landing_page_header_color_bar');

?>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<div class="ainsley-font-loader">
		<div><?= $headerH1Font; ?>:<?= $headerH1GFFW; ?></div>
		<div><?= $headerTextFont; ?>:<?= $headerTextFontWeight; ?></div>
		<div><?= $phoneNumberFont; ?>:<?= $phoneNumberFontWeight; ?></div>
		<div><?= $formH2Font; ?>:<?= $formH2GFFW; ?></div>
		<div><?= $formTextFont; ?>:<?= $formTextFontWeight; ?></div>
		<div><?= $formButtonFont; ?>:<?= $formButtonFontWeight; ?></div>
		<div><?= $bodyFont; ?>:<?= $bodyFontWeight; ?></div>
		<div><?= $footerFont; ?>:<?= $footerFontWeight; ?></div>
		<div><?= $footerPhoneFont; ?>:<?= $footerPhoneFontWeight; ?></div>
		<div><?= $bottomFooterFont; ?>:<?= $bottomFooterFontWeight; ?></div>
	</div>


<div class="wrapper">
    <div class="wrapper_inner">

	    <div id="lp-billboard" style="background: <?php echo $headerBackgroundColor; ?>;">
		    <div id="abs-cont">
			    <div class="lp-logo-holder" style="background-color: <?php echo $logoHolderColor; ?>;">
				    <a href="<?php bloginfo('url');?>"><img src="<?php echo $logo_url; ?>"></a>
			    </div>

			    <div class="cover-over">
				    <img src="<?php echo $headerBackgroundURL; ?>" alt="<?php echo $headerBackgroundImage['alt']; ?>">
			    </div>
			    <div class="cover" style="background-size: cover; background-image:url(<?php echo $headerBackgroundURL; ?>)">
				    <img src="<?php echo $headerBackgroundURL; ?>" alt="<?php echo $headerBackgroundImage['alt']; ?>">
			    </div>

			    <div class="wrap"><!-- bones style to regulate inside content -->
				     <div class="inner-wrap">
					    <div id="lp-billboard-textgroup">
						    <div id="lp-billboard-headline">
							    <h1 class="ainsley-font-loader-styled" style="font-family: <?php echo $headerH1Font; ?>; font-weight: <?php echo $headerH1FontWeight; ?> !important; color: <?php echo $headerH1Color; ?>; "><?php echo $headerH1Text; ?></h1>
						    </div>
						    <div id="lp-billboard-text">
							    <div class="ainsley-font-loader-styled" style="font-family: <?php echo $headerTextFont; ?>; font-weight: <?php echo $headerTextFontWeight; ?> !important; color: <?php echo $headerTextColor; ?>; "><?php echo $headerText; ?></div>
						    </div>
						    <div class="sl-header-phone ainsley-font-loader-styled"><a style="font-family: <?php echo $phoneNumberFont; ?> !important; color: <?php echo $headerLinkColor; ?> !important; font-weight: <?php echo $phoneNumberFontWeight; ?>;" href="tel:<?php echo $cleanPhoneNumber; ?>"><?php echo $phoneNumber; ?></a></div>
					    </div>
					 </div>
			    </div>

		    </div><!-- end abs-cont -->
	    </div><!--  end lp-billboard -->

    </div>
</div>

<?php
if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <!-- <div class="column_inner"> -->
            <div class="sl-main-holder wrap">
	            <div class="inner-wrap">
                <?php
                // Content in the template part
                get_template_part('templates/content-single', 'landing');
                ?>
	            </div>
            </div>
        <!-- </div> -->
    </div>
    <?php
endwhile;
endif;
get_footer('landing-page');