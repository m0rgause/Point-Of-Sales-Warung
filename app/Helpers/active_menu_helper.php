<?php

/* This helper for help automatic generate active menu class, ex. for navbar menu have .navbar__link--active class
 * first parameter is user accessed page now, it get from uri segment
 * second parameter is active menu class
 * third parameter is array of menu name.
 */

function active_menu(string $page, string $active_menu_class, string ...$menu_names): ? string
{
    // if page found in menu names array
    if(in_array($page, $menu_names)) {
        return $active_menu_class;
    }
    return null;
}
