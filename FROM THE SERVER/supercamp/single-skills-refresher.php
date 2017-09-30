<?php

$id = get_the_ID();

get_header('skills');

if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="column_inner">
            <div class="blog_holder blog_single">
                <?php
                // Content in the template part
                get_template_part('templates/content-single', 'skills');
                ?>
            </div>
        </div>
    </div>
    <?php
endwhile;
endif;
get_footer('skills');