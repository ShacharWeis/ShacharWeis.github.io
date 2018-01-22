<?php
/**
 * Remove default Wordpress head tag clutter
 */
require_once 'lib/overrides/header.php';
/**
 * Remove default Wordpress footer clutter
 */
require_once 'lib/overrides/footer.php';
/**
 * Override Wordpress image defaults
 */
require_once 'lib/overrides/images.php';
/**
 * Custom Wordpress Login
 */
require_once 'lib/overrides/login.php';
/**
 * Restricts dashboard options to only needed items.
 */
require_once 'lib/overrides/dashboard.php';
/**
 * Alters plugin functionality for SEO optimization
 */
include 'lib/overrides/plugins.php';
/**
 * Registers image related support
 */
include 'lib/additions/images.php';
/**
 * Registers navigation menus.
 */
include 'lib/additions/menus.php';
/**
 * Enqueues styles and scripts.
 */
include 'lib/additions/assets.php';



function wpdocs_excerpt_more( $more ) {
    return sprintf( '<a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( ' ... Continue Reading' )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );
