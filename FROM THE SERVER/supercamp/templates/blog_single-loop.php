<?php 
global $qode_options_proya;
$blog_hide_comments = "";
if (isset($qode_options_proya['blog_hide_comments'])) {
	$blog_hide_comments = $qode_options_proya['blog_hide_comments'];
}
$blog_author_info="no";
if (isset($qode_options_proya['blog_author_info'])) {
	$blog_author_info = $qode_options_proya['blog_author_info'];
}
$qode_like = "on";
if (isset($qode_options_proya['qode_like'])) {
	$qode_like = $qode_options_proya['qode_like'];
}
?>
<?php
$_post_format = get_post_format();
?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post_content_holder">
				<?php if(get_post_meta(get_the_ID(), "qode_hide-featured-image", true) != "yes") {
					if ( has_post_thumbnail() ) { ?>
						<div class="post_image">
	                        <?php the_post_thumbnail('full'); ?>
						</div>
				<?php } } ?>
				<div class="post_text">
					<div class="post_text_inner">
						<div class="patch_blog_single_author_date">
							<span class="post_author patch_post_author">
									<?php _e('by','qode'); ?>
								<a class="post_author_link" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta('display_name'); ?></a>
							</span>
							<div class="patch_date_single">
								<span class="date_month"><?php the_time('m'); ?></span> /
								<span class="date_day"><?php the_time('d'); ?></span> /
								<span class="date_year"><?php the_time('y'); ?></span>
							</div>
						</div>


						<h2><?php the_title(); ?></h2>
						<hr class="patch_hr"/>
						<div class="post_info">
							<span class="time"><?php _e('Posted at','qode'); ?> <?php the_time('H:i'); ?><?php _e('h','qode'); ?></span>
							<?php _e('in','qode'); ?> <?php the_category(', '); ?>
							<span class="post_author">
								<?php _e('by','qode'); ?>
								<a class="post_author_link" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta('display_name'); ?></a>
							</span>
							<?php if($blog_hide_comments != "yes"){ ?>
								<span class="dots"><i class="fa fa-square"></i></span><a class="post_comments" href="<?php comments_link(); ?>" target="_self"><?php comments_number('0 ' . __('Comments','qode'), '1 '.__('Comment','qode'), '% '.__('Comments','qode') ); ?></a>
							<?php } ?>
							<?php if( $qode_like == "on" ) { ?>
									<span class="dots"><i class="fa fa-square"></i></span><div class="blog_like">
									<?php if( function_exists('qode_like') ) qode_like(); ?>
								</div>
							<?php } ?>
							<?php if(isset($qode_options_proya['enable_social_share'])  && $qode_options_proya['enable_social_share'] == "yes") { ?>
								<span class="dots"><i class="fa fa-square"></i></span><?php echo do_shortcode('[social_share]'); ?>	
							<?php } ?>
						</div>
						<?php the_content(); ?>
					</div>
				</div>
			</div>
	<?php if( has_tag()) { ?>
		<div class="single_tags clearfix">
            <div class="tags_text">
				<h5><?php _e('Tags:','qode'); ?></h5>
				<?php 
				if ((isset($qode_options_proya['tags_border_style']) && $qode_options_proya['tags_border_style'] !== '') || (isset($qode_options_proya['tags_background_color']) && $qode_options_proya['tags_background_color'] !== '')){
					the_tags('', ' ', '');
				}
				else{
					the_tags('', ', ', '');
				}
				?>
			</div>
		</div>
	<?php } ?>				
	<?php 
		$args_pages = array(
			'before'           => '<p class="single_links_pages">',
			'after'            => '</p>',
			'link_before'      => '<span>',
			'link_after'       => '</span>',
			'pagelink'         => '%'
		);

		wp_link_pages($args_pages);
	?>
<?php if($blog_author_info == "yes") { ?>
	<div class="author_description">
		<div class="author_description_inner">
			<div class="image">
				<?php echo get_avatar(get_the_author_meta( 'ID' ), 75); ?>
			</div>
			<div class="author_text_holder">
				<h5 class="author_name">
				<?php  
					if(get_the_author_meta('first_name') != "" || get_the_author_meta('last_name') != "") {
						echo get_the_author_meta('first_name') . " " . get_the_author_meta('last_name');
					} else {
						echo get_the_author_meta('display_name');
					}
				?>
				</h5>
				<span class="author_email"><?php echo get_the_author_meta('email'); ?></span>
				<?php if(get_the_author_meta('description') != "") { ?>
					<div class="author_text">
						<p><?php echo get_the_author_meta('description') ?></p>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
</article>