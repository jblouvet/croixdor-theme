<?php

// Disable the toolbar completely for all users
add_filter('show_admin_bar', '__return_false');

function starter_reorder_admin_menu_for_all()
{
  remove_menu_page('tools.php');
  remove_menu_page('edit-comments.php');
}

add_action('admin_menu', function () {
  global $menu;
  $menu[21] = ['', 'read', 'separator25', '', 'wp-menu-separator'];
  // 22 = Pharmacies
  // 23 = Acquéreurs
  // 23 = Experts
  $menu[25] = ['', 'read', 'separator25', '', 'wp-menu-separator'];
  // 26 = Appels d'offre
  // 26 = Matchs Acquéreurs
  // 26 = Matchs Vendeurs
  // 26 = Pharmaplace
  $menu[30] = ['', 'read', 'separator25', '', 'wp-menu-separator'];
});

function starter_reorder_admin_menu()
{
  remove_menu_page('options-general.php');
  remove_menu_page('plugins.php');
  remove_menu_page('upload.php');
  remove_menu_page('themes.php');
  remove_menu_page('formidable');
  remove_submenu_page('index.php', 'update-core.php');
}

if (get_current_user_id() !== 1) {
  add_action('admin_menu', 'starter_reorder_admin_menu_for_all', 999999999999);
  add_action('admin_menu', 'starter_reorder_admin_menu', 999999999999);
  add_filter('acf/settings/show_admin', '__return_false');
} else {
  add_action('admin_menu', 'starter_reorder_admin_menu_for_all', 999999999999);
}
