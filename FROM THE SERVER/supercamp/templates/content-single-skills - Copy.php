<?php
$mainImage = get_field('refresher_main_graphic');
?>
<div class="refresher-content">
    <div class="title-image clearfix">
        <div class="refresher-title">
            <div class="title-border">
                <div class="title-wrap">
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="title-image clearfix">
        <img src="<?php echo $mainImage['url']; ?>" alt="<?php echo $mainImage['alt']; ?>">
    </div>
    <div class="top-of-the-refresher">
        <div class="container_inner">
            <div class="refreshing-refresher-nav">
                <?php dynamic_sidebar('skills-refresher-sidebar'); ?>
            </div>
            <div class="refresher-intro">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
    <?php if (have_rows('refresher')): // refresher loop 1      ?>

    <div class="container contain-the-refresher">
        <div class="container_inner">

            <?php while (have_rows('refresher')): the_row();
                //icon vars
                $hide_image = get_sub_field('refresher_hide_image');
                $icon       = get_sub_field('refresher_icon');
                $title      = get_sub_field('icon_title');
                ?>
                <div class="refresher-container">
                    <div class="refresher-icon">
                        <img src="<?= $icon['url']; ?>" alt="<?= $icon['alt']; ?>">
                    </div>
                    <div class="refresher-copy">
                        <div class="refresher-copy-inner">
                            <h3><?= $title; ?></h3>
                            <?php if (have_rows('icon_links')) : while (have_rows('icon_links')) : the_row();

                                $copy     = get_sub_field('icon_copy');
                                $radio    = get_sub_field('radio_button');
                                $pdf      = 'pdf';
                                $link_pdf = get_sub_field('icon_link_pdf');
                                $link_url = get_sub_field('icon_link_url');
                                ?>
                                <a target="_blank" href="<?php if ($radio == $pdf) {
                                    echo $link_pdf;
                                } else {
                                    echo $link_url;
                                } ?>">
                                    <?= $copy; ?>
                                </a>
                            <?php endwhile; // end while links (nested repeater)
                            endif; // end if links ?>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            endif; // end refresher loop 1 ?>
        </div>
        <?php if (have_rows('video_set_one')): ?>
        <div class="refresher-video-container">
            <?php
            $count = 1;
            $class = " second";

            while (have_rows('video_set_one')): the_row();
                //video vars
                $thumbnail  = get_sub_field('video_thumbnail');
                $video      = get_sub_field('refresher_video');
                $video_copy = get_sub_field('video_copy');
                ?>
                <div class="refresher-video<?php if ($count === 2) {
                    echo $class;
                } ?>">

                    <a class="refresher-link" target="_blank" href="<?= $video; ?>">
                        <img src="<?= $thumbnail['url']; ?>">
                    </a>

                    <div class="refresher-video-copy">
                        <div class="video-copy">
                            <?= $video_copy; ?>
                        </div>
                    </div>
                </div>
                <?php
                $count++;
            endwhile; ?>
            <?php endif; ?>
        </div>

        <?php
        $favorites_copy  = get_field('favorites_copy');
        $favorites_title = get_field('favorites_title');
        ?>
        <div class="refresher-favorites clearfix">
            <div class="favorites-title">
                <h2><?= $favorites_title; ?></h2>
            </div>
            <div class="favorite-copy">
                <?= $favorites_copy; ?>
            </div>

            <div class="favorite-links">
                <?php if (have_rows('favorites_links')) : ?>
                    <?php
                    while (have_rows('favorites_links')) : the_row();
                        $link_title = get_sub_field('link_title');
                        $title_link = get_sub_field('title_link');
                        ?>
                        <a target="_blank" href="<?= $title_link ?>">
                            <h3><?= $link_title ?></h3>
                        </a>
                    <?php endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</div>