<?php

/**
 * Register Navigation Menus
 */

function jbl_navigation_menus()
{
    $locations = [
        "header" => __("Menu Header", "rad"),
        "footer" => __("Menu footer", "rad"),
    ];
    register_nav_menus($locations);
}
add_action("init", "jbl_navigation_menus");
