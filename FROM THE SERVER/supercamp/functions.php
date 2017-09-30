<?php


// enqueue the child theme stylesheet

Function wp_schools_enqueue_scripts()
{
    wp_register_style('childstyle', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('childstyle');

    if (is_page_template('page-lp.php') || is_page_template('page-lp-st-filling-fast.php')  || is_page_template('page-lp-san-marcos-filling-fast.php')  || is_page_template('page-lp-villanova-filling-fast.php')) {
        wp_register_style('lp-style', get_stylesheet_directory_uri() . '/assets/css/landing-style.min.css', array(),
            '1');
        wp_enqueue_style('lp-style');
        wp_enqueue_script('lp-scripts', get_stylesheet_directory_uri() . '/assets/js/lp-scripts.js');
    }

	if(is_page_template('blog-large-image.php') || is_category() || is_single()) {
		wp_register_style('bloggie-style', get_stylesheet_directory_uri() . '/assets/css/blog-patch.css', array(), '1');
		wp_enqueue_style('bloggie-style');
	}
	global $post_type;
	if( 'supercamp-landing' == $post_type ){
		wp_register_style('superlanding-style', get_stylesheet_directory_uri() . '/assets/css/supercamp-landing.css', array(), '1');
		wp_enqueue_style('superlanding-style');
		wp_enqueue_script('web-fonts', '//ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js', array(), true);
		wp_enqueue_script('web-font-loader', get_stylesheet_directory_uri() . '/assets/js/web-fonts-loader.js');
	}

	if(is_search()){
		wp_register_style('search-style', get_stylesheet_directory_uri() . '/assets/css/search-patch.css', array(), '1');
		wp_enqueue_style('search-style');
		wp_enqueue_script('search-scripts', get_stylesheet_directory_uri() . '/assets/js/search-patch-scripts.js');
	}

	//if(is_page_template('single-skills-refresher.php')) {
		wp_register_style( 'cpt-style', get_stylesheet_directory_uri() . '/assets/css/cpt-refresher.css', array(), '1' );
		wp_enqueue_style( 'cpt-style' );
	//}

	///// all-patch-style is used in site-wide elements
	wp_register_style('all-patch-style', get_stylesheet_directory_uri() . '/assets/css/all-patch.css', array(), '1');
	wp_enqueue_style('all-patch-style');
	///// location-patch is not restricted as it is used in regular pages that have the generic template assigned - the styles have specificity to .location-xxxx elements and shouldn't casue conflicts
	wp_register_style('location-patch-style', get_stylesheet_directory_uri() . '/assets/css/location-patch.css', array(), '1.1');
	wp_enqueue_style('location-patch-style');
	wp_enqueue_script('location-scripts', get_stylesheet_directory_uri() . '/assets/js/location-patch-scripts.js');

	if ( is_page( '839' ) || is_page( '64052' ) ) {
		wp_enqueue_style( 'pricing-patch', get_stylesheet_directory_uri() . '/assets/css/pricing-patch.css' );
	}

	if(is_page_template('full_width_programs.php')) {
		wp_register_style('programs-style', get_stylesheet_directory_uri() . '/assets/css/program-patch.css', array(), '1');
		wp_enqueue_style('programs-style');
		wp_enqueue_script('programs-scripts', get_stylesheet_directory_uri() . '/assets/js/programs-patch-scripts.js');
	}

}

add_action('wp_enqueue_scripts', 'wp_schools_enqueue_scripts', 11);

/**
 * Calculation Subtotal Merge Tag
 *
 * Adds a {subtotal} merge tag which calculates the subtotal of the form. This merge tag can only be used
 * within the "Formula" setting of Calculation-enabled fields (i.e. Number, Calculated Product).
 *
 * @author    David Smith <david@gravitywiz.com>
 * @license   GPL-2.0+
 * @link      http://gravitywiz.com/subtotal-merge-tag-for-calculations/
 * @copyright 2013 Gravity Wiz
 */
class GWCalcSubtotal
{

    public static $merge_tag = '{subtotal}';

    function __construct()
    {

        // front-end
        add_filter('gform_pre_render', array($this, 'maybe_replace_subtotal_merge_tag'));
        add_filter('gform_pre_validation', array($this, 'maybe_replace_subtotal_merge_tag_submission'));

        // back-end
        add_filter('gform_admin_pre_render', array($this, 'add_merge_tags'));

    }

    /**
     * Look for {subtotal} merge tag in form fields 'calculationFormula' property. If found, replace with the
     * aggregated subtotal merge tag string.
     *
     * @param mixed $form
     */


    function maybe_replace_subtotal_merge_tag($form, $filter_tags = false)
    {

        foreach ($form['fields'] as &$field) {

            if (current_filter() == 'gform_pre_render' && rgar($field, 'origCalculationFormula')) {
                $field['calculationFormula'] = $field['origCalculationFormula'];
            }

            if ( ! self::has_subtotal_merge_tag($field)) {
                continue;
            }

            $subtotal_merge_tags             = self::get_subtotal_merge_tag_string($form, $field, $filter_tags);
            $field['origCalculationFormula'] = $field['calculationFormula'];
            $field['calculationFormula']     = str_replace(self::$merge_tag, $subtotal_merge_tags,
                $field['calculationFormula']);

        }

        return $form;
    }

    function maybe_replace_subtotal_merge_tag_submission($form)
    {
        return $this->maybe_replace_subtotal_merge_tag($form, true);
    }
    /**
     * Get all the pricing fields on the form, get their corresponding merge tags and aggregate them into a formula that
     * will yeild the form's subtotal.
     *
     * @param mixed $form
     */

    static function get_subtotal_merge_tag_string($form, $current_field, $filter_tags = false)
    {

        $pricing_fields     = self::get_pricing_fields($form);
        $product_tag_groups = array();

        foreach ($pricing_fields['products'] as $product) {

            $product_field  = rgar($product, 'product');
            $option_fields  = rgar($product, 'options');
            $quantity_field = rgar($product, 'quantity');

            // do not include current field in subtotal
            if ($product_field['id'] == $current_field['id']) {
                continue;
            }

            $product_tags = GFCommon::get_field_merge_tags($product_field);
            $quantity_tag = 1;

            // if a single product type, only get the "price" merge tag
            if (in_array(GFFormsModel::get_input_type($product_field), array(
                'singleproduct',
                'calculation',
                'hiddenproduct'
            ))) {

                // single products provide quantity merge tag
                if (empty($quantity_field) && ! rgar($product_field, 'disableQuantity')) {
                    $quantity_tag = $product_tags[2]['tag'];
                }

                $product_tags = array($product_tags[1]);
            }

            // if quantity field is provided for product, get merge tag
            if ( ! empty($quantity_field)) {
                $quantity_tag = GFCommon::get_field_merge_tags($quantity_field);
                $quantity_tag = $quantity_tag[0]['tag'];
            }

            if ($filter_tags && ! self::has_valid_quantity($quantity_tag)) {
                continue;
            }

            $product_tags = wp_list_pluck($product_tags, 'tag');
            $option_tags  = array();

            foreach ($option_fields as $option_field) {

                if (is_array($option_field['inputs'])) {

                    $choice_number = 1;

                    foreach ($option_field['inputs'] as &$input) {

                        //hack to skip numbers ending in 0. so that 5.1 doesn't conflict with 5.10
                        if ($choice_number % 10 == 0) {
                            $choice_number++;
                        }

                        $input['id'] = $option_field['id'] . '.' . $choice_number++;

                    }
                }

                $new_options_tags = GFCommon::get_field_merge_tags($option_field);
                if ( ! is_array($new_options_tags)) {
                    continue;
                }

                if (GFFormsModel::get_input_type($option_field) == 'checkbox') {
                    array_shift($new_options_tags);
                }

                $option_tags = array_merge($option_tags, $new_options_tags);
            }

            $option_tags = wp_list_pluck($option_tags, 'tag');

            $product_tag_groups[] = '( ( ' . implode(' + ',
                    array_merge($product_tags, $option_tags)) . ' ) * ' . $quantity_tag . ' )';

        }

        $shipping_tag = 0;
        //// Shipping should not be included in subtotal, correct?
        ////if( rgar( $pricing_fields, 'shipping' ) ) {
           //// $shipping_tag = GFCommon::get_field_merge_tags( rgars( $pricing_fields, 'shipping/0' ) );
           //// $shipping_tag = $shipping_tag[0]['tag'];
        ////}

        $pricing_tag_string = '( ( ' . implode(' + ', $product_tag_groups) . ' ) + ' . $shipping_tag . ' )';

        return $pricing_tag_string;
    }

    /**
     * Get all pricing fields from a given form object grouped by product and shipping with options nested under their
     * respective products.
     *
     * @param mixed $form
     */

    static function get_pricing_fields($form)
    {

        $product_fields = array();

        foreach ($form["fields"] as $field) {

            if ($field["type"] != 'product') {
                continue;
            }

            $option_fields = GFCommon::get_product_fields_by_type($form, array("option"), $field['id']);

            // can only have 1 quantity field
            $quantity_field = GFCommon::get_product_fields_by_type($form, array("quantity"), $field['id']);
            $quantity_field = rgar($quantity_field, 0);

            $product_fields[] = array(
                'product'  => $field,
                'options'  => $option_fields,
                'quantity' => $quantity_field
            );

        }

        $shipping_field = GFCommon::get_fields_by_type($form, array("shipping"));

        return array("products" => $product_fields, "shipping" => $shipping_field);
    }

    static function has_valid_quantity($quantity_tag)
    {

        if (is_numeric($quantity_tag)) {

            $qty_value = $quantity_tag;

        } else {

            // extract qty input ID from the merge tag
            preg_match_all('/{[^{]*?:(\d+(\.\d+)?)(:(.*?))?}/mi', $quantity_tag, $matches, PREG_SET_ORDER);
            $qty_input_id = rgars($matches, '0/1');
            $qty_value    = rgpost('input_' . str_replace('.', '_', $qty_input_id));

        }

        return floatval($qty_value) > 0;
    }

    function add_merge_tags($form)
    {

        $label = __('Subtotal', 'gravityforms');

        ?>

        <script type="text/javascript">

            // for the future (not yet supported for calc field)
            gform.addFilter("gform_merge_tags", "gwcs_add_merge_tags");
            function gwcs_add_merge_tags(mergeTags, elementId, hideAllFields, excludeFieldTypes, isPrepop, option) {
                mergeTags["pricing"].tags.push({
                    tag: '<?php echo self::$merge_tag; ?>',
                    label: '<?php echo $label; ?>'
                });
                return mergeTags;
            }

            // hacky, but only temporary
            jQuery(document).ready(function ($) {

                var calcMergeTagSelect = $('#field_calculation_formula_variable_select');
                calcMergeTagSelect.find('optgroup').eq(0).append('<option value="<?php echo self::$merge_tag; ?>"><?php echo $label; ?></option>');

            });

        </script>

        <?php
        //return the form object from the php hook
        return $form;
    }

    static function has_subtotal_merge_tag($field)
    {

        // check if form is passed
        if (isset($field['fields'])) {

            $form = $field;
            foreach ($form['fields'] as $field) {
                if (self::has_subtotal_merge_tag($field)) {
                    return true;
                }
            }

        } else {

            if (isset($field['calculationFormula']) && strpos($field['calculationFormula'],
                    self::$merge_tag) !== false
            ) {
                return true;
            }

        }

        return false;
    }


}

//new GWCalcSubtotal();


//Only used for learning Gravity forms field index's
/*
add_action('gform_after_submission', 'after_submission', 10, 2);
 function after_submission($entry, $form){
 //Gravity Forms has validated the data
 //Our Custom Form Submitted via PHP will go here
 // Lets get the IDs of the relevant fields and prepare an email message - You can get the ID's in the form designer now for user created fields so this step is kind of unnecessary
 $message = print_r($entry, true);
 // In case any of our lines are larger than 70 characters, we should use wordwrap()
 $message = wordwrap($message, 70);
 // Send
 wp_mail('krice@qln.com', 'Getting the Gravity Form Field IDs', $message);
 }
*/

//Send to service for CRM integration
add_action("gform_post_submission", "set_post_content", 10, 2);
function set_post_content($entry, $form)
{
    // You can get the ID's for user created fields in the form designer
    //built in field id's
    //[id] => 41 (Id of the record)
    //[form_id] => 1
    //[date_created] => 2016-03-03 19:32:14
    //[is_starred] => 0
    //[is_read] => 0
    //[ip] => 209.242.175.130
    //[source_url] => http://scwp.supercamp.com/?page_id=2
    //[post_id] =>
    //[currency] => USD
    //[payment_status] =>
    //[payment_date] =>
    //[transaction_id] =>
    //[payment_amount] =>
    //[payment_method] =>
    //[is_fulfilled] =>
    //[created_by] => 1
    //[transaction_type] =>
    //[user_agent] => Mozilla/5.0 (Windows NT 6.1; WOW64)
    //[status] => active


    //$client = new SoapClient("http://requiredforms.supercamp.com/formEntry/formentry.asmx?wsdl");//dev
    $client = new SoapClient("http://epack.qln.local/formEntry/formentry.asmx?wsdl");//production

    //Array index is form specific so multiple variations will need to be handled here
  if (($form['id'] == 19) || ($form['id'] == 21)) {

        $params = array(
            "ipAddress"         => $entry["ip"],
            "pageURL"           => $entry["-1"],
            "referringURL"      => $entry["-2"],
            "firstName"         => $entry["1"],
            "lastName"          => $entry["2"],            
            "phone"             => $entry["3"],
            "email"             => $entry["4"],
            "utm_source"        => $entry["5"],
            "utm_campaign"      => $entry["6"],
            "utm_medium"        => $entry["7"],
            "utm_keyword"       => $entry["8"],
            "source"            => $entry["9"],
            "src"               => $entry["10"],
            "spec"              => $entry["11"],
            "cmps"              => $entry["12"],
            "kw"                => $entry["13"],
            "autoResponder"     => $entry["14"],
            "requestType"       => $entry["15"],
            "requestDate"       => $entry["date_created"],
            "OptIn"             => 1,
            "requestedBy"       => "",// $entry["6"],
            "questionOrComment" => ""
        );
    }    

else if ($form['id'] == 11) //form 11 only has one field for name and it's a different id
    {

        //Split up name since there is only one field
        $full  = $entry["18"];
        $full1 = explode(' ', $full);
        $first = $full1[0];
        $rest  = ltrim($full, $first . ' ');


        $params = array(
            "ipAddress"         => $entry["ip"],
            "pageURL"           => $entry["-1"],
            "referringURL"      => $entry["-2"],
            //"firstName" =>     $entry["18"],
            //"lastName" =>     "",
            "firstName"         => $first,
            "lastName"          => $rest,
            "email"             => $entry["3"],
            "phone"             => $entry["4"],
            "utm_source"        => $entry["7"],
            "utm_campaign"      => $entry["8"],
            "utm_medium"        => $entry["9"],
            "utm_keyword"       => $entry["10"],
            "source"            => $entry["11"],
            "src"               => $entry["12"],
            "spec"              => $entry["13"],
            "cmps"              => $entry["14"],
            "kw"                => $entry["15"],
            "autoResponder"     => $entry["16"],
            "requestType"       => $entry["17"],
            "requestDate"       => $entry["date_created"],
            "OptIn"             => 1,
            "requestedBy"       => "",// $entry["6"],
            "questionOrComment" => ""
        );
    }
else if (($form['id'] != 22) && ($form['id'] != 23)) {

        $params = array(
            "ipAddress"         => $entry["ip"],
            "pageURL"           => $entry["-1"],
            "referringURL"      => $entry["-2"],
            "firstName"         => $entry["1"],
            "lastName"          => $entry["2"],
            "email"             => $entry["3"],
            "phone"             => $entry["4"],
            "utm_source"        => $entry["7"],
            "utm_campaign"      => $entry["8"],
            "utm_medium"        => $entry["9"],
            "utm_keyword"       => $entry["10"],
            "source"            => $entry["11"],
            "src"               => $entry["12"],
            "spec"              => $entry["13"],
            "cmps"              => $entry["14"],
            "kw"                => $entry["15"],
            "autoResponder"     => $entry["16"],
            "requestType"       => $entry["17"],
            "requestDate"       => $entry["date_created"],
            "OptIn"             => 1,
            "requestedBy"       => "",// $entry["6"],
            "questionOrComment" => ""
        );
    } 

    //Submit the info to the custom service
    $objectresult = $client->AddSCInfoReq($params);

    //$objectresult = $client->AddSCInfoReqNameOnly(array("lastName" => "Rice", "firstName" => "Kevin",  "email" => "krice@qln.com"));

    //Act-On integration URL needs to be updated for production

    if ($entry["17"] == "Newsletter")  // newsletter submit to regular newsletter form in Act-On Act-On
    {
        $acton_post = new ActonConnection;
        $acton_post->setPostItems('First Name',
            ""); // HTML input name attribute is "First Name", Act-On data field name should match that
        $acton_post->setPostItems('Last Name',
            ""); // please note that Act-On does not accept filed names with punctuation marks in them, so rename as necessary
        $acton_post->setPostItems('E-mail', $entry["3"]);
        $acton_post->processConnection('http://marketing.quantumlearning.com/acton/eform/16721/0007/d-ext-0001'); // your external post URL ("Proxy Form URL")
    } else if ($entry["17"] == "Video") {
        $acton_post = new ActonConnection;
        $acton_post->setPostItems('First Name',
            $entry["1"]); // HTML input name attribute is "First Name", Act-On data field name should match that
        $acton_post->setPostItems('Last Name',
            $entry["2"]); // please note that Act-On does not accept filed names with punctuation marks in them, so rename as necessary
        $acton_post->setPostItems('E-mail', $entry["3"]);
        $acton_post->processConnection('http://marketing.quantumlearning.com/acton/eform/16721/0005/d-ext-0001'); // your external post URL ("Proxy Form URL")

    } else // not newsletter submit to regular info request form in

    {
        $acton_post = new ActonConnection;
        // $acton_post->setPostItems('First Name',$entry["1"]); // HTML input name attribute is "First Name", Act-On data field name should match that
        // $acton_post->setPostItems('Last Name',$entry["2"]); // please note that Act-On does not accept filed names with punctuation marks in them, so rename as necessary
        //$acton_post->setPostItems('E-mail',$entry["3"]);
        //$acton_post->setPostItems('Home Phone',$entry["4"]);
        //$acton_post->setPostItems('Request by',$entry["6"]);
        //$acton_post->setPostItems('question or comment', "");


        $acton_post->setPostItems('First Name',
            $params["firstName"]); // HTML input name attribute is "First Name", Act-On data field name should match that
        $acton_post->setPostItems('Last Name',
            $params["lastName"]); // please note that Act-On does not accept filed names with punctuation marks in them, so rename as necessary
        $acton_post->setPostItems('E-mail', $params["email"]);
        $acton_post->setPostItems('Home Phone', $params["phone"]);
        $acton_post->setPostItems('Request by', $params["requestedBy"]);
        $acton_post->setPostItems('question or comment', $params["questionOrComment"]);

        $acton_post->processConnection('http://marketing.quantumlearning.com/acton/eform/16721/0006/d-ext-0001'); // your external post URL ("Proxy Form URL")
    }

}


/**
 * Post form submission data to Act-On and convert visitors to known via cURL, allowing no direct touch
 * between Act-On and your website vistitor's browser to be necessary
 */
class ActonConnection
{

    protected $_postItems = array();

    protected function getPostItems()
    {
        return $this->_postItems;
    }

    /**
     * for setting your form's POST items (key is your form input's name, value is the input value)
     *
     * @param string $key first part of key=value for form field submission (name in name=John)
     * @param string $value latter part of key=value for form field submission (John in name=John)
     */
    public function setPostItems($key, $value)
    {
        $this->_postItems[$key] = (string)$value;
    }

    protected function getDomain($address)
    {
        $pieces = parse_url($address);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }

        return false;
    }

    protected function getUserIP()
    {
        //check proxy
        if ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * process form data for submission to your Act-On external form URL
     *
     * @param string $extPostUrl your external post (Proxy URL) for your Act-On "proxy" form
     */
    public function processConnection($extPostUrl)
    {

        $this->setPostItems('_ipaddr',
            $this->getUserIP()); // Act-On accepts manually defined IPs if using field name '_ipaddr'

        $fields = http_build_query($this->getPostItems()); // encode post items into query-string

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_URL, "$extPostUrl");
        curl_setopt($handle, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($handle, CURLOPT_HEADER, 1);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $fields);

        $response = curl_exec($handle);

        if ($response === false) {
            $response = "cURL Error: " . curl_error($handle);
        } else {
            preg_match_all('/^Set-Cookie:\040wp\s*([^;]*)/mi', $response,
                $ra); // pull response "set-cookie" values from cURL response header
            parse_str($ra[1][0], $cookie); // select the "set-cookie" for visitor conversion and store to array $cookie

            // set updated website visitor tracking cookie with processed "set-cookie" content from curl
            setrawcookie('wp' . key($cookie), implode(",", $cookie), time() + 86400 * 365, "/",
                $this->getDomain($extPostUrl)); //       set cookie expiry date to 1 year
        }

        curl_close($handle);
    }
}

//enable hiding labels in gravity forms
add_filter('gform_enable_field_label_visibility_settings', '__return_true');

//insert conversion code when the email only newsletter form is filled out

add_action("gform_post_submission", "gf_ga_tracking", 10, 2);
function gf_ga_tracking($entry, $form)
{

    if ($form['id'] != 7) {
        return;
    } ?>

    <!-- Google Code for Email Capture Conversion Page -->
    <script type="text/javascript">
        // <![CDATA[
        var google_conversion_id = 937954316;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "IFb0CJOf5WQQjJigvwM";
        var google_remarketing_only = false;
        // ]]>
    </script>
    <script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="https://www.googleadservices.com/pagead/conversion/937954316/?label=IFb0CJOf5WQQjJigvwM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
<script type="text/javascript"> new Image().src = '//clickserv.pixel.ad/conv/62bc2065374b9966'; </script>
<?php }





//insert conversion code on the enrollment thank you page

function enrollment_page()
{
    if (get_the_ID() != 589) {
        return;
    } ?>
    <!-- Facebook Code for Enroll  Page -->
<script>
fbq('track', 'InitiateCheckout');
</script>    

<?php }

add_action('wp_footer', 'enrollment_page');







//insert conversion code on the enrollment thank you page

function enrollment_conversion()
{
    if (get_the_ID() != 1428) {
        return;
    } ?>
    <!-- Google Code for Enroll Conversion Page -->
    <script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 937954316;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "s9-_CPeM92QQjJigvwM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/937954316/?label=s9-_CPeM92QQjJigvwM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<script>
    
 function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}   
    
 var prc = getParameterByName('prc');
if(prc === null)
    prc = 0;
    
fbq('track', 'CompleteRegistration', {
value: prc,
currency: 'USD'
});
</script>
<?php }

add_action('wp_footer', 'enrollment_conversion');


//insert conversion code on info request thank you page

function main_info_conversion()
{
    if (get_the_ID() != 1317 && get_the_ID() != 63941) {
        return;
    } ?>
    <!-- Google Code for Request Info Conversion Page -->
    <script type="text/javascript">// <![CDATA[
        var google_conversion_id = 937954316;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "H5MFCOqe8WEQjJigvwM";
        var google_remarketing_only = false;
        // ]]></script>
    <script src="//www.googleadservices.com/pagead/conversion.js" type="text/javascript">// <![CDATA[

        // ]]></script>

    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="//www.googleadservices.com/pagead/conversion/937954316/?label=H5MFCOqe8WEQjJigvwM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
<script type="text/javascript"> new Image().src = '//clickserv.pixel.ad/conv/95c92d97218cd19e'; </script>
<!-- Facebook Code for Request Info Conversion Page -->
<script>
fbq('track', 'Lead');
</script>
<?php }

add_action('wp_footer', 'main_info_conversion');


//insert conversion code on landing page request thank you page

function landing_page_info_conversion()
{
    if (get_the_ID() != 1647 && get_the_ID() != 63869) {
        return;
    } ?>
    <!-- Google Code for LP Form Conversion Page -->
    <script type="text/javascript">
        /// <![CDATA[
        var google_conversion_id = 937954316;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "-bPhCOuW_mEQjJigvwM";
        var google_remarketing_only = false;
        /// ]]>
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="//www.googleadservices.com/pagead/conversion/937954316/?label=-bPhCOuW_mEQjJigvwM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
<script type="text/javascript"> new Image().src = '//clickserv.pixel.ad/conv/95c92d97218cd19e'; </script>

<!-- Facebook Code for LP Request Info Conversion Page -->
<script>
fbq('track', 'Lead');
</script>
<?php }

add_action('wp_footer', 'landing_page_info_conversion');


//insert conversion code on the blog thank you page

function blog_signup()
{
    if (get_the_ID() != 62174) {
        return;
    } ?>
    <!-- Facebook Code for Enroll  Page -->
<script>
fbq('track', 'Lead');
</script>   

<?php }

add_action('wp_footer', 'blog_signup');



function bing_conversion()
{
    ?>

<script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"5152936"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");</script><noscript><img src="//bat.bing.com/action/0?ti=5152936&Ver=2" height="0" width="0" style="display:none; visibility: hidden;" /></noscript>


<?php }

add_action('wp_footer', 'bing_conversion');


//Wordpress strips cdata comments, re-add the closing tag so google tracking works properly again

function cdata_fix($content)
{
    $content = str_replace("]]&gt;", "]]>", $content);

    return $content;
}

function cdata_template_redirect($content)
{
    ob_start('cdata_fix');
}

add_action('template_redirect', 'cdata_template_redirect', -1);

//Wordpress bug causes images with srcset to user wrong protocol
function ssl_srcset($sources)
{
    if (is_ssl()) {
        foreach ($sources as &$source) {
            $source['url'] = set_url_scheme($source['url'], 'https');
        }
    }

    return $sources;
}

add_filter('wp_calculate_image_srcset', 'ssl_srcset');

function skills_refresher_post_type()
{

    $labels  = array(
        'name'                  => _x('skills-refresher', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('skill-refresher', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Skills Refresher', 'text_domain'),
        'name_admin_bar'        => __('Skill Refresher Type', 'text_domain'),
        'archives'              => __('Skill Refresher Archives', 'text_domain'),
        'parent_item_colon'     => __('Parent Skill Refresher:', 'text_domain'),
        'all_items'             => __('All Skill Refreshers', 'text_domain'),
        'add_new_item'          => __('Add New Skill', 'text_domain'),
        'add_new'               => __('Add New Skill', 'text_domain'),
        'new_item'              => __('New Skill Refresher', 'text_domain'),
        'edit_item'             => __('Edit Skill Refresher', 'text_domain'),
        'update_item'           => __('Update Skill Refresher', 'text_domain'),
        'view_item'             => __('View Skill Refresher', 'text_domain'),
        'search_items'          => __('Search Skill Refresher', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image'    => __('Use as featured image', 'text_domain'),
        'insert_into_item'      => __('Insert into Skill Refresher', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this Skill Refresher', 'text_domain'),
        'items_list'            => __('Skill Refresher list', 'text_domain'),
        'items_list_navigation' => __('Skill Refresher list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter Skill Refresherlist', 'text_domain'),
    );
    $rewrite = array(
        'slug'       => 'refreshers',
        'with_front' => true,
        'pages'      => true,
        'feeds'      => true,
    );
    $args    = array(
        'label'               => __('skill-refresher', 'text_domain'),
        'description'         => __('post type for skills refresher course', 'text_domain'),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'thumbnail', 'content'),
        'taxonomies'          => array('category', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-clipboard',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'page',
    );
    register_post_type('skills-refresher', $args);

}

add_action('init', 'skills_refresher_post_type', 0);

/**
 * Register our sidebars and widgetized areas.
 *
 */
function superCampWidgets() {

    register_sidebar( array(
        'name'          => 'Skills Refresher Sidebar',
        'id'            => 'skills-refresher-sidebar',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>',
    ) );

}
add_action( 'widgets_init', 'superCampWidgets' );

// Register Custom Post Type - 2017 Landing Pages
function landing_page_post_type() {
	$labels = array(
		'name'                  => _x( 'Landing Pages', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Landing Page', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Landing Pages', 'text_domain' ),
		'name_admin_bar'        => __( 'Landing Pages', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Landing Pages', 'text_domain' ),
		'add_new_item'          => __( 'Add New Landing Page', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Landing Page', 'text_domain' ),
		'edit_item'             => __( 'Edit Landing Page', 'text_domain' ),
		'update_item'           => __( 'Update Landing Page', 'text_domain' ),
		'view_item'             => __( 'View Landing Page', 'text_domain' ),
		'search_items'          => __( 'Search Landing Page', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'campaigns',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Landing Page', 'text_domain' ),
		'description'           => __( '2017 Landing Page Template for Ease of Use', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( ),
		//'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false, //'campaigns',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
		'menu_icon'             => 'dashicons-carrot',
	);
	register_post_type( 'supercamp-landing', $args );

}
add_action( 'init', 'landing_page_post_type', 0 );

////  remove unused WP fields
//https://wordpress.org/support/topic/how-to-remove-title-and-content-boxes-from-a-custom-post-type
function mvandemar_remove_post_type_support() {
	remove_post_type_support( 'supercamp-landing', 'editor' );
}
add_action( 'init', 'mvandemar_remove_post_type_support' );

/**
 * Fix Gravity Form Tabindex Conflicts
 * http://gravitywiz.com/fix-gravity-form-tabindex-conflicts/
 */

function gform_tabindexer( $tab_index, $form = false ) {
	$starting_index = 10000; // if you need a higher tabindex, update this number
	if( $form )
		add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
	return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}
add_filter( 'gform_tabindex', 'gform_tabindexer', 10, 2 );

add_filter( 'gform_confirmation_anchor', '__return_true' );


