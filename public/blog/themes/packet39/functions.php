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
    return sprintf( ' ... <br><a class="read-more" href="%1$s" title="%3$s Read More">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( 'Continue Reading'),
        get_the_title( get_the_ID() )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

// Register Sidebars
function custom_sidebars() {

    $args = array(
        'id'            => 'article-sidebar',
        'name'          => __( 'Article Sidebar', 'text_domain' ),
        'description'   => __( 'Sidebar for the Article List Page', 'text_domain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
    );
    register_sidebar( $args );

}
add_action( 'widgets_init', 'custom_sidebars' );

add_theme_support( 'title-tag' );
