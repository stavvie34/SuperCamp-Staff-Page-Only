<?php
$formH2Text = get_field('landing_page_form_h2');
$formID = get_field('landing_page_form_id');
$formTextColor = get_field('landing_page_form_text_color');
$formButtonColor = get_field('landing_page_form_button_color');
$formButtonTextColor = get_field('landing_page_form_button_text_color');
$formBackgroundColor = get_field('landing_page_form_background_color');

$needBodyLeadIn = get_field('landing_page_need_lead-in');
$bodyLeadIn = get_field('landing_page_body_lead-in_catchall');
$bodyTextColor = get_field('landing_page_body_text_color');
$bodyBackgroundColor = get_field('landing_page_body_background_color');

$thumbOne = get_field('landing_page_three_thumbs_image_one');
if( !empty($thumbOne) ):
	$thumb1_url = $thumbOne['url'];
	$thumb1_title = $thumbOne['title'];
	$thumb1_alt = $thumbOne['alt'];
endif;
$thumbOneModal  = get_field('landing_page_three_thumbs_thumb_one_modal');

$thumbTwo = get_field('landing_page_three_thumbs_image_two');
if( !empty($thumbTwo) ):
	$thumb2_url = $thumbTwo['url'];
	$thumb2_title = $thumbTwo['title'];
	$thumb2_alt = $thumbTwo['alt'];
endif;
$thumbTwoModal = get_field('landing_page_three_thumbs_thumb_two_modal');

$thumbThree = get_field('landing_page_three_thumbs_image_three');
if( !empty($thumbThree) ):
	$thumb3_url = $thumbThree['url'];
	$thumb3_title = $thumbThree['title'];
	$thumb3_alt = $thumbThree['alt'];
endif;
$thumbThreeModal = get_field('landing_page_three_thumbs_thumb_three_modal');

$thumbsBackgroundColor = get_field('landing_page_three_thumbs_background_color');

$footerText = get_field('landing_page_footer_text');
$footerSecondText = get_field('landing_page_footer_second_text');
$footerTextColor = get_field('landing_page_footer_text_color');
$footerImage = get_field('landing_page_footer_image');
if( !empty($footerImage) ):
	$footerImage_url = $footerImage['url'];
	$footerImage_title = $footerImage['title'];
	$footerImage_alt = $footerImage['alt'];
endif;
$footerBackgroundColor = get_field('landing_page_footer_background_color');
$footerLinkColor = get_field('landing_page_footer_link_color');
$footerFormID = get_field('landing_page_footer_form_id');
$footerFormTextColor = get_field('landing_page_footer_form_text_color');
$footerFormButtonColor = get_field('landing_page_footer_form_button_color');
$footerFormButtonTextColor = get_field('landing_page_footer_form_button_text_color');

GLOBAL $formH2Font, $formH2FontWeight, $formTextFont, $formTextFontWeight, $formButtonFont, $formButtonFontWeight; //// these were captured in the parent file
GLOBAL $bodyFont, $bodyFontWeight, $footerFont, $footerFontWeight, $footerPhoneFont, $footerPhoneFontWeight, $bottomFooterFont, $bottomFooterFontWeight, $phoneNumber, $cleanPhoneNumber, $formH2FontStyle;
?>

<!-- styles dynamically set by Landing Page content type -->
<style media="screen" type="text/css">
	.sl-form{
		color: <?php echo $formTextColor; ?>;
	}
	label{
		color: <?php echo $formTextColor; ?>;
		font-family: <?php echo $formTextFont; ?>;
	}

	.single-supercamp-landing .gform_wrapper .gfield_description{
		font-family: <?php echo $formTextFont; ?> !important;
	}
	.single-supercamp-landing .gform_wrapper input[type=submit] {
		color: <?php echo $formButtonTextColor; ?> !important;
		background-color: <?php echo $formButtonColor; ?> !important;
		font-family: <?php echo $formButtonFont; ?> !important;
		font-weight:  <?php echo $formButtonFontWeight; ?> !important;
	}
	.single-supercamp-landing .gform_wrapper input[type="submit"]:hover{
		background-color: <?php echo $formButtonTextColor; ?> !important;
		color: <?php echo $formButtonColor; ?> !important;
	}
</style>

<div class="sl-form" style="background-color: <?php echo $formBackgroundColor; ?>">
	<div class="core-wrap">
		<div class="sl-header-h2"><h2 class="ainsley-font-loader-styled" style="font-family: <?php echo $formH2Font; ?>; color: <?php echo $formTextColor; ?>; font-style: <?php echo $formH2FontStyle; ?>;"><?php echo $formH2Text; ?></h2></div>
		<?php echo do_shortcode('[gravityform id=' . $formID . ' title=false description=false ajax=false]'); ?>
	</div>
</div>

<div class="sl-body ainsley-font-loader-styled" style="font-family: <?php echo $bodyFont; ?>; font-weight: <?php echo $bodyFontWeight; ?>; color: <?php echo $bodyTextColor; ?>; background-color: <?php echo $bodyBackgroundColor; ?>;">
	<div class="core-wrap">
		<?php if($needBodyLeadIn){
			echo "<div class='sl-lead-in'>"  . $bodyLeadIn . "</div>";
		}?>
		<?php if(have_rows('landing_page_body')) : ?>
			<ul class="sl-list-unstyled sl-body-list">
				<?php while (have_rows('landing_page_body')) : the_row();
					$bullet = get_sub_field('landing_page_body_item_text');
					$icon = get_sub_field('landing_page_body_icon_image');
					?>
					<li><div class="sl-pair"><div class="sl-body-icon"><img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>"></div><div class="sl-body-text"><?php echo $bullet; ?></div></div></li>
				<?php endwhile; ?>
			</ul>
		<?php endif; ?>
	</div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-content">
		<span class="close">x</span>
		<div class="video-container"></div>
	</div>
</div>

<div class="sl-three-thumbs" style="background-color: <?php echo $thumbsBackgroundColor; ?>;">
	<div class="core-wrap">
			<ul class="sl-list-unstyled">
				<?php
					$imageOrVideo = "video";
					if($thumbOneModal == "image"){
						$thumbOneModal = $thumb1_url;
						$imageOrVideo = "image";
					}
				?>
					<li><div class="sl-thumb" data-videoOrImage="<?php echo $imageOrVideo; ?>" data-link="<?php echo $thumbOneModal; ?>"><img src="<?php echo $thumb1_url; ?>" alt="<?php echo $thumb1_alt; ?>"></div></li>
				<?php
					$imageOrVideo = "video";
					if($thumbTwoModal == "image"){
						$thumbTwoModal = $thumb2_url;
						$imageOrVideo = "image";
					}
				?>
					<li><div class="sl-thumb" data-videoOrImage="<?php echo $imageOrVideo; ?>" data-link="<?php echo $thumbTwoModal; ?>"><img src="<?php echo $thumb2_url; ?>" alt="<?php echo $thumb2_alt; ?>"></div></li>
				<?php
					$imageOrVideo = "video";
					if($thumbThreeModal == "image"){
						$thumbThreeModal = $thumb3_url;
						$imageOrVideo = "image";
					}
				?>
					<li><div class="sl-thumb" data-videoOrImage="<?php echo $imageOrVideo; ?>" data-link="<?php echo $thumbThreeModal; ?>"><img src="<?php echo $thumb3_url; ?>" alt="<?php echo $thumb3_alt; ?>"></div></li>
			</ul>
	</div>
</div>

<style media="screen" type="text/css">
	.sl-footer .sl-form{
		color: <?php echo $footerFormTextColor; ?>;
	}
	.sl-footer label{
		color: <?php echo $footerFormTextColor; ?>;
		font-family: <?php echo $formTextFont; ?>;
	}

	.single-supercamp-landing .sl-footer .gform_wrapper .gfield_description{
		font-family: <?php echo $formTextFont; ?> !important;
	}

	.single-supercamp-landing .sl-footer .gform_wrapper input[type=submit] {
		color: <?php echo $footerFormButtonTextColor; ?> !important;
		background-color: <?php echo $footerFormButtonColor; ?> !important;
		font-family: <?php echo $formButtonFont; ?> !important;
		font-weight:  <?php echo $formButtonFontWeight; ?> !important;
	}
	.single-supercamp-landing .sl-footer .gform_wrapper input[type="submit"]:hover{
		background-color: <?php echo $footerFormButtonTextColor; ?> !important;
		color: <?php echo $footerFormButtonColor; ?> !important;
	}
</style>

<div class="sl-footer" style="background-color: <?php echo $footerBackgroundColor; ?>;">
	<div class="sl-form" >
		<div class="core-wrap">
			<div class="sl-footer-text ainsley-font-loader-styled" style="font-family: <?php echo $footerFont; ?>; color: <?php echo $footerTextColor; ?>; font-weight: <?php echo $footerFontWeight; ?>;">
				<?php echo $footerText; ?>
			</div>
			<div class="sl-footer-phone ainsley-font-loader-styled" style="font-family: <?php echo $footerPhoneFont; ?>; font-weight: <?php echo $footerPhoneFontWeight; ?>;"><a href="tel:<?php echo $cleanPhoneNumber; ?>" style="color: <?php echo $footerLinkColor; ?> !important;"><?php echo $phoneNumber; ?></a></div>
			<div class="sl-footer-text ainsley-font-loader-styled" style="font-family: <?php echo $footerFont; ?>; color: <?php echo $footerTextColor; ?>; font-weight: <?php echo $footerFontWeight; ?>;">
				<?php echo $footerSecondText; ?>
			</div>
			<?php echo do_shortcode('[gravityform id=' . $footerFormID . ' title=false description=false ajax=false]'); ?>
		</div>
	</div>
</div>