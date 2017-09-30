<?php

$id = get_the_ID();

$chosen_sidebar = get_post_meta(get_the_ID(), "qode_show-sidebar", true);
$default_array = array('default', '');

if(!in_array($chosen_sidebar, $default_array)){
	$sidebar = get_post_meta(get_the_ID(), "qode_show-sidebar", true);
}else{
	$sidebar = $qode_options_proya['blog_single_sidebar'];
}

$blog_hide_comments = "";
if (isset($qode_options_proya['blog_hide_comments']))
	$blog_hide_comments = $qode_options_proya['blog_hide_comments'];

if(get_post_meta($id, "qode_page_background_color", true) != ""){
	$background_color = get_post_meta($id, "qode_page_background_color", true);
}else{
	$background_color = "";
}

$content_style_spacing = "";
if(get_post_meta($id, "qode_margin_after_title", true) != ""){
	if(get_post_meta($id, "qode_margin_after_title_mobile", true) == 'yes'){
		$content_style_spacing = "padding-top:".esc_attr(get_post_meta($id, "qode_margin_after_title", true))."px !important";
	}else{
		$content_style_spacing = "padding-top:".esc_attr(get_post_meta($id, "qode_margin_after_title", true))."px";
	}
}

?>
<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
				<?php if(get_post_meta($id, "qode_page_scroll_amount_for_sticky", true)) { ?>
					<script>
					var page_scroll_amount_for_sticky = <?php echo get_post_meta($id, "qode_page_scroll_amount_for_sticky", true); ?>;
					</script>
				<?php } ?>
					<?php get_template_part( 'title' ); ?>
				<?php
				$revslider = get_post_meta($id, "qode_revolution-slider", true);
				if (!empty($revslider)){ ?>
					<div class="q_slider"><div class="q_slider_inner">
					<?php echo do_shortcode($revslider); ?>
					</div></div>
				<?php
				}
				?>
				<div class="container">
					<div class="container_inner default_template_holder">
						

						<div class="blog_holder blog_single patch_blog_single">
							<?php
								get_template_part('templates/blog_single', 'loop');
							?>
							<?php
								if($blog_hide_comments != "yes"){
									comments_template('', true);
								}else{
									echo "<br/><br/>";
								}
							?>
                        </div>



					</div>
				</div>
		<div class="patch_enroll_now_callout">
			<div class="patch_enroll_now_callout_inner">
			Since 1982 SuperCamp has increased the academic and personal success of 73,000 students. Participants experience breakthrough learning, the 8 Keys of Excellence principles to live by, self-discovery, deep friendships, and fun! They learn valuable collaboration, communication, critical thinking, and creativity strategies, and how to apply their SuperCamp experiences and skills to school, college, career, and life.
			<a href="http://www.supercamp.com/enroll"><div class="patch_enroll_now_btn">ENROLL NOW</div></a>
			</div>
		</div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>	