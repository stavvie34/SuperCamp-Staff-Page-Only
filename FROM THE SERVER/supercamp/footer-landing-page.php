<?php
	$bottomFooterText = get_field('landing_page_bottom_footer_text');
	$bottomFooterTextColor = get_field('landing_page_bottom_footer_text_color');
	$bottomFooterBackgroundColor = get_field('landing_page_bottom_footer_background_color');
?>

<div class="sl-bottom-footer wrap" style="background-color: <?php echo $bottomFooterBackgroundColor; ?>; color: <?php echo $bottomFooterTextColor; ?>">
	<div class="inner-wrap">
		<div class="core-wrap">
			<div class="sl-bottom-footer-text ainsley-font-loader-styled <?php if(!have_rows('landing_page_bottom_footer_social')) : echo 'center-text go100'; endif; ?>" style="font-family: <?php echo $bottomFooterFont; ?>; color: <?php echo $bottomFooterTextColor; ?>; font-weight: <?php echo $bottomFooterFontWeight; ?>;"><?php echo $bottomFooterText; ?></div>
			<div class="sl-social-container">
				<?php if(have_rows('landing_page_bottom_footer_social')) : ?>

					<?php while (have_rows('landing_page_bottom_footer_social')) : the_row();
						$socialLink = get_sub_field('landing_page_bottom_footer_social_link');
						$socialIcon = get_sub_field('landing_page_bottom_footer_social_icon');
						?>
						<div class="sl-footer-social-icon"><a href="<?php echo $socialLink; ?>"><img src="<?php echo $socialIcon['url']; ?>" alt="<?php echo $socialIcon['alt']; ?>"></a></div>
					<?php endwhile; ?>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>



<?php
// there were extra scripts loaded in here, splitting them out to a template to reduce clutter - JS
get_template_part('templates/footer', 'scripts');

wp_footer();
?>
</body>
</html>