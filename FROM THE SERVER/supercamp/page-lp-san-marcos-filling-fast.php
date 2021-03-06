<?php
/*
 * Template Name: LP - #1 Teen Camp - San Marcos Filling
 */

// condition to evaluate ? is it's true : if it's not

is_page('number-1-teen-summer-camp') ? $class = 'screen-reader-text' : $class = false;

//wp_head();
get_header('tracking-only');
?>

<div id="container" class="ain-landing-page-template">
    <div id="content" class="wrap">
        <div class="wrap clearfix">
            <div class="grid_section header">
                <div class="section_inner">
                    <div class="logo"><a href="http://www.supercamp.com"><img src="https://www.supercamp.com/wp-content/uploads/2016/04/SuperCamp-50h-2.png" alt="SuperCamp Logo"></a></div>
                    <div class="phone">Call:<a class="sc800number" href="tel:8002285327"> (800) 228-5327</a></div>
                    <div class="clearfix cf"></div>
                </div>
            </div><!--header logo and phone -->
            <div class="copy-form-wrapper grid_section">
                <div class="section_inner">
                    <div class="list-wrap">
<div>
<h1 style="color: white; font-weight: bold; text-align: center; padding:8px;">CSU San Marcos</h1>
<h1 style="color: white; font-weight: bold; text-align: center; padding:8px;">Attention: Camps are filling fast, some already have wait lists.  Call us now at (800) 228-5327 to secure your child’s spot.</h1>
</div>
                        <?php the_content(); ?>
                    </div>
                    <div class="form-copy-wrapper">
                        <div class="inner-form">
                            <h3>SEND ME A FREE SUPERCAMP GUIDE</h3>
                            <div class="form-container">
                                <?php
                                echo do_shortcode('[gravityforms id=15 title=false description=false]');
                                ?>
                            </div>
                            <div class="camp-book">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/camp-book.jpg" alt="Get your free camp guide"/>
                            </div>
                        </div>
						
						
                    </div>
					
					
					
                </div>
                <div class="clearfix cf"></div>
            </div><!-- /.copy-form-wrapper -->
            <div class="video-outer-wrap grid_section">
                <div class="section_inner video-wrap">
                    <div id="why-parents">
                        <a><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/why-parents.jpg" alt="Why parents love SuperCamp"></a>
                    </div>
                    <div id="why-campers">
                        <a><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/why-campers.jpg" alt="Why campers love SuperCamp"></a>
                    </div>
                </div>
            </div><!--videos -->
            <div class="counter-wrapper grid_section">
                <div class="section_report">
                    <div class="top-row">
                        <div class="section_inner">
                            <div class="report black">
                                <div class="inner-report">
                                    <div class="counter">73<span>%</span></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <p style="color: black">Report Noticeably Better Grades</p>
                                </div>
                            </div>
                            <div class="report white">
                                <div class="inner-report">
                                    <div class="counter">99<span>%</span></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <p style="color: white">CONTINUE TO USE SKILLS THEY LEARNED</p>
                                </div>
                            </div>
                            <div class="report black">
                                <div class="inner-report">
                                    <div class="counter">77<span>%</span></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <p style="color: black">Campers go on to a 4&#8209;year college after High School</p>
                                </div>
                            </div>
                        </div><!-- /.section_inner -->
                    </div><!-- /.top-row -->

                    <div class="bottom-row">
                        <div class="section_inner">
                            <div class="report white">
                                <div class="inner-report">
                                    <div class="counter">77<span>%</span></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <p style="color: white">Report Improved Family Relationships</p>
                                </div>
                            </div>
                            <div class="report black">
                                <div class="inner-report">
                                    <div class="counter">93<span>%</span></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <p style="color: black">Report Improved Peer Relationships</p>
                                </div>
                            </div>

                            <div class="report white">
                                <div class="inner-report">
                                    <div class="counter">81<span>%</span></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <p style="color: white">Feel More Confident in their Daily Lives</p>
                                </div>
                            </div>
                        </div><!-- /.section_inner -->
                    </div><!-- /.bottom-row -->
                </div>
                <!-- section_inner -->
            </div
        </div><!-- counter copy -->
        <div class="form-wrapper grid_section">
            <div class="section_inner">
                <div class="form-copy">
                    <h3>Request A Call</h3>
                    <hr>
                    <p>Our camp consultants are available to answer all of your questions. Some camps are already full, act now to secure your spot.</p>
                </div>
                <div class="form-container">
                    <?php
                    echo do_shortcode('[gravityforms id=16 title=false description=false]');
                    ?>
                </div> 
                <div class="form-copy">
                    <p>&nbsp;</p>
                    <p><a href="http://www.supercamp.com">Click here to continue to our website</a></p>
                </div>
                <!-- /.form-container -->
            </div><!-- /.section_inner -->
        </div><!-- /.form-wrapper -->
        <div class="footer_bottom_holder">
            <div class="footer_bottom">
                <div class="textwidget">Copyright © 2016 SuperCamp •  <a href="https://www.supercamp.com/privacy-policy/">Privacy
                        Policy</a> • <a href="https://www.supercamp.com/terms-and-conditions">Terms and Conditions</a>
                </div>
            </div>
        </div>
    </div>

</div><!-- / .wrap -->

</div><!-- / #content -->
</div><!-- / #container -->

    <div class="sc-modal">
        <input class="sc-modal-state" id="supercamp-modal" type="checkbox" />
        <div class="sc-modal-fade-screen">
            <div class="sc-modal-inner">
                <div class="sc-modal-close" for="supercamp-modal"></div>
                <div class="modal-content">
                    <div class="sc-video-wrapper">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/PHkURpWIYC4" frameborder="0" allowfullscreen></iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sc-modal">
        <input class="sc-modal-state" id="supercamp-modal-campers" type="checkbox" />
        <div class="sc-modal-fade-screen">
            <div class="sc-modal-inner">
                <div class="sc-modal-close" for="supercamp-modal-campers"></div>
                <div class="modal-content">
                    <div class="sc-video-wrapper">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/RNpljqmIBac" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php 
wp_footer();
get_footer('tracking-only');


?>
