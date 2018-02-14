<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-09
 */

//remove options from admin menu
function remove_menu_entries()
{
    // with WP 3.1 and higher
    if (function_exists('remove_menu_page')) {
        remove_menu_page('edit-comments.php');
        remove_menu_page('link-manager.php');
//        remove_menu_page('tools.php');
    } else {

    }
}

add_action('admin_menu', 'remove_menu_entries');
