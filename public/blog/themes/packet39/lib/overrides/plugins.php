<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-09
 */


/**
 * Prevents loading of Contact Form 7 styles and scripts when not needed.
 */
add_filter('wpcf7_load_js', '__return_false');
add_filter('wpcf7_load_css', '__return_false');


/**
 * If Yoast SEO is installed, remove html comments that expose version information.
 * Remove function is courtesy of https://github.com/trajche
 */
if (defined('WPSEO_VERSION')) {

    add_action('get_header', function () {
        ob_start('remove_yoast_comments');
    });
    add_action('wp_head', function () {
        ob_end_flush();
    }, 999);

}

function remove_yoast_comments($output)
{
    $targets = array(
        '<!-- This site is optimized with the Yoast WordPress SEO plugin v' . WPSEO_VERSION . ' - https://yoast.com/wordpress/plugins/seo/ -->',
        '<!-- / Yoast WordPress SEO plugin. -->',
        '<!-- This site uses the Google Analytics by Yoast plugin v' . GAWP_VERSION . ' - https://yoast.com/wordpress/plugins/google-analytics/ -->',
        '<!-- / Google Analytics by Yoast -->'
    );

    $output = str_ireplace($targets, '', $output);
    $output = trim($output);
    $output = preg_replace('/\n?<.*?yoast.*?>/mi', '', $output);

    return $output;
}