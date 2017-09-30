<?php 
	global $wp_query;
	global $qode_options_proya;
    global $qode_template_name;
	$id = $wp_query->get_queried_object_id();

	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
	else { $paged = 1; }

	if(isset($qode_options_proya['blog_page_range']) && $qode_options_proya['blog_page_range'] != ""){
		$blog_page_range = $qode_options_proya['blog_page_range'];
	} else{
		$blog_page_range = $wp_query->max_num_pages;
	}

	$category = qode_get_title_text();
	//echo "BLOG PAGE RANGE IS " . $blog_page_range . "<br />";
?>

<div class="patch_blog_holder <?php echo $blog_list_class; ?>">
			<?php global $whichColumn; $whichColumn = 1; global $title_short; global $excerpt_short;
			if(have_posts()) : while ( have_posts() ) : the_post(); ?>
				<?php
				/* code to trim title and excerpt */
				/*
				if (strlen(the_title('','',FALSE)) > 70) { //Character length
					$title_short = substr(the_title('','',FALSE), 0, 70); // Character length
					preg_match('/^(.*)\s/s', $title_short, $matches);
					if ($matches[1]) $title_short = $matches[1];
					$title_short = $title_short.' ...'; // Ellipsis
				} else {
					$title_short = the_title('','',FALSE);
				}
				*/
				$title_short = the_title('','',FALSE);
				//$excerpt_short = wp_trim_excerpt( get_the_excerpt() );

				$excerpt_short = get_the_excerpt();
				//$excerpt_short = preg_replace(" ([.*?])",'',$excerpt_short);
				$excerpt_short = strip_shortcodes($excerpt_short);
				$excerpt_short = strip_tags($excerpt_short);
				$excerpt_short = substr($excerpt_short, 0, 180);
				$excerpt_short = substr($excerpt_short, 0, strripos($excerpt_short, " "));
				//$excerpt_short = trim(preg_replace( '/s+/', ' ', $excerpt_short));
				$excerpt_short = $excerpt_short.' ... ';
				/*if (strlen(get_the_excerpt('','',FALSE)) > 170) { //Character length
					$excerpt_short = substr(get_the_excerpt('','',FALSE), 0, 70); // Character length
					preg_match('/^(.*)\s/s', $excerpt_short, $matches);
					if ($matches[1]) $excerpt_short = $matches[1];
					$excerpt_short = $excerpt_short .' ...'; // Ellipsis
				} else {
					$excerpt_short = $excerpt_short('','',FALSE);
				}*/



					get_template_part('templates/blog_patch-loop');
					$whichColumn++;
					if($whichColumn==4){
						$whichColumn = 1;
					}

				?>
			<?php endwhile; ?>

					<?php pagination($wp_query->max_num_pages, $blog_page_range, $paged); ?>

			<?php else: //If no posts are present ?>
			<div class="entry">
					<p><?php _e('No posts were found.', 'qode'); ?></p>
			</div>
			<?php endif; ?>
</div><!-- end patch_blog_holder -->