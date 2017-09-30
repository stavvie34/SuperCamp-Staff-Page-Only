<?php global $qode_options_proya, $wp_query, $qode_toolbar, $qodeIconCollections; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <?php
    if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
        echo('<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">');
    } ?>

    <title><?php wp_title(''); ?></title>

    <?php
    /**
     * qode_header_meta hook
     *
     * @see qode_header_meta() - hooked with 10
     * @see qode_user_scalable_meta() - hooked with 10
     */
    do_action('qode_header_meta');
    ?>

    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url($qode_options_proya['favicon_image']); ?>">
    <link rel="apple-touch-icon" href="<?php echo esc_url($qode_options_proya['favicon_image']); ?>"/>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Google Analytics start -->
<?php if (isset($qode_options_proya['google_analytics_code'])) {
    if ($qode_options_proya['google_analytics_code'] != "") {
        ?>
        <script>
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo $qode_options_proya['google_analytics_code']; ?>']);
            _gaq.push(['_trackPageview']);

            (function () {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
    <?php }
}
?>
<!-- Google Analytics end -->

<div class="wrapper">
    <div class="wrapper_inner">
        <header class="page_header">
            <div class="header_inner clearfix logo-wrap">
                <a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('url');?>/wp-content/uploads/2016/08/SC_logo_White.png"></a>
            </div>
        </header>
    </div>
</div>
