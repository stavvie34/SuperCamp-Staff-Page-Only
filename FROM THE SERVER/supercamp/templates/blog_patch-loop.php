<?php 
global $qode_options_proya;
$blog_hide_comments = "";
if (isset($qode_options_proya['blog_hide_comments'])) {
	$blog_hide_comments = $qode_options_proya['blog_hide_comments'];
}

$blog_hide_author = "";
if (isset($qode_options_proya['blog_hide_author'])) {
    $blog_hide_author = $qode_options_proya['blog_hide_author'];
}

$qode_like = "on";
if (isset($qode_options_proya['qode_like'])) {
	$qode_like = $qode_options_proya['qode_like'];
}
?>
<?php
$_post_format = get_post_format();
global $whichColumn;
global $title_short;
global $excerpt_short;
?>
<?php
//echo "<br />/blog_patch-loop/<br />" . $_post_format . "<br />/blog_patch-loop/<br />";?>
<div class="patch_post_content_holder patch_column_<?php echo $whichColumn; ?>">
		<article id="post-<?php the_ID(); ?>" >


				<?php if ( has_post_thumbnail() ) { ?>
					<div class="post_image">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('full'); ?>
						</a>
					</div>
					<div class="patch_color_band"></div>
				<?php } ?>

				<div class="post_text">
					<div class="post_text_inner">

								<div class="patch_post_categories"><?php the_category(' / '); ?></div>
								<div class="patch_post_title">
									<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $title_short; //the_title(); ?></a></h2>
								</div>
								<div class="patch_post_excerpt">
									<?php echo $excerpt_short; //qode_excerpt(); ?>
								</div>
											<div class="post_info">

											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><div class="patch_read_more">Read More</div></a>
											<div class="patch_date">
												<span class="date_month"><?php the_time('m'); ?></span> /
												<span class="date_day"><?php the_time('d'); ?></span> /
												<span class="date_year"><?php the_time('y'); ?></span>
											</div>

										</div><!-- post_info -->
					</div><!-- post text inner -->
				</div> <!-- post text -->


		</article>
</div>

