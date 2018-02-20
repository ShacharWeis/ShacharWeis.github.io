<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-09
 */


/**
 * Register main menu.
 */
function register_menus()
{
    register_nav_menus(
        array(
            'main_nav' => __('Main Navigation')
        )
    );
}

//add_action('init', 'register_menus');
