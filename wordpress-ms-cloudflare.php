<?php
/**
 * Plugin Name: Multisite Cloudflare domain add
 * Plugin URI: http://
 * Description: Plugin to auto add cloudflare stuff
 * Version: 1.0.0
 * Author: Riley Childs
 * Author URI: http://rileychilds.me
 * Network: true
 * License: GPL3
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function add_cloudflare( $blog_id, $user_id, $domain, $path, $site_id, $meta) {
    //extract data from the post
    extract($_POST);

//set POST variables
    $url = 'https://www.cloudflare.com/api_json.html';
    $fields = array(
						'a' => urlencode("rec_new"),
						'tkn' => urlencode(CLOUDFLARE_API_KEY),
						'email' => urlencode(CLOUDFLARE_EMAIL),
						'z' => urlencode(DOMAIN_CURRENT_SITE),
						'type' => urlencode("CNAME"),
						'name' => urlencode($domain),
						'content' => urlencode(CLOUDFLARE_CNAME)
				);

    //url-ify the data for the POST
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

//set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
        $result = curl_exec($ch);

//close connection
        curl_close($ch);
    }
    function wordpress_ms_cloudflare_activate() {

    // Activation code here...
    add_action( 'wpmu_new_blog', 'add_cloudflare', 10, 6 );
}
register_activation_hook( __FILE__, 'wordpress_ms_cloudflare_activate' );








