<?php 
/*
Template Name: Blog Large Image
*/ 
?>
<?php get_header(); ?>
<?php 
global $wp_query;
global $qode_template_name;
$id = $wp_query->get_queried_object_id();
$qode_template_name = get_page_template_slug($id);
$category = get_post_meta($id, "qode_choose-blog-category", true);
//$post_number = get_post_meta($id, "qode_show-posts-per-page", true);
$post_number = 12;
$page_object = get_post( $id );
$content = $page_object->post_content;
$content = apply_filters( 'the_content', $content );
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

//$sidebar = get_post_meta($id, "qode_show-sidebar", true);


?>
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
	<?php 
		query_posts('post_type=post&paged='. $paged . '&cat=' . $category .'&posts_per_page=' . $post_number );
	?>
	<div class="container">
			<div class="patch_tools_area">
					<div class="container_inner patch_container_inner">
							<div class="patch_category_select patch_column_1">
								<?php wp_dropdown_categories( 'show_option_none=Category Filters' ); ?>
								<script type="text/javascript">
									var dropdown = document.getElementById("cat");
									function onCatChange() {
										if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
											location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?cat="+dropdown.options[dropdown.selectedIndex].value;
										}
									}
									dropdown.onchange = onCatChange;
								</script>
							</div>

							<div class="patch_searchbox patch_column_2">
								<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
									<div class="box">
										<div class="container-1">
											<input type="search" id="search" placeholder="SEARCH THE BLOG" name="s" id="s" />
											<span class="icon"><i class="fa fa-search"></i></span>
											<input type="hidden" value="post" name="post_type" />
										</div>
									</div>
								</form>
							</div>

							<div class="patch_joinform patch_column_3">
								<?php //do_shortcode('[gravityforms id="7" title="false" description="false" ajax="true"]');
								gravity_form( 18, $display_title = false, $display_description = false, $display_inactive = false, $field_values = null, $ajax = false, $tabindex, $echo = true );
								?>
							</div>
					</div>
			</div>
			<div class="container_inner default_template_holder" >

				<!-- <div class="three_columns_33_33_33 clearfix"> -->
				<div class="one_column clearfix">
					<div class="column1">
						<div class="column_inner">
							<?php get_template_part('templates/blog', 'structure'); ?>
						</div>
					</div>
				</div>

			</div><!-- end container_inner -->
	</div><!-- end container -->
<?php wp_reset_query(); ?>
<?php get_footer(); ?>