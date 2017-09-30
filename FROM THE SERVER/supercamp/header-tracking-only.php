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

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url($qode_options_proya['favicon_image']); ?>">
    <link rel="apple-touch-icon" href="<?php echo esc_url($qode_options_proya['favicon_image']); ?>"/>
    
    
        <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '244228552647528'); // Insert your pixel ID here.
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=244228552647528&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Google Analytics start -->
<?php include_once("analyticstracking.php") ?>
<!-- Google Analytics end -->