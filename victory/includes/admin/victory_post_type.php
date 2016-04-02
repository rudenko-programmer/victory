<?php
/**
 * Определение типов записей для хранения пользовательских типов записей,
 * пользовательских таксономий, дополнительных блоков с полями
 */
function victory_page_menu() {
    add_menu_page( __( 'Victory' ), __( 'Victory' ), 'manage_options', 'victory_main_page', 'victory_page',  'dashicons-awards', 81);
    add_submenu_page( 'victory_main_page', 'Типы записей', 'Типы записей', 'manage_options', 'post_type_page', 'post_type_page');
    add_submenu_page( 'victory_main_page', 'Таксономии', 'Таксономии', 'manage_options', 'victory_taxonomy_page', 'taxonomy_page');
    add_submenu_page( 'victory_main_page', 'Блоки', 'Блоки', 'manage_options', 'victory_meta_box_page', 'meta_box_page');
}
add_action( 'admin_menu', 'victory_page_menu' );
function victory_page()  {require VICTORY_DIR.'/includes/admin/templates/main_setting_page.php';}
function post_type_page(){require VICTORY_DIR.'/includes/admin/templates/post_type_page.php';}
function taxonomy_page() {require VICTORY_DIR.'/includes/admin/templates/taxonomy_page.php';}
function meta_box_page() {require VICTORY_DIR.'/includes/admin/templates/meta_box_page.php';}

function victory_post_type() {

    $args = array(
        'public' => true,
        'show_ui' => true, // показывать интерфейс в админке
        'show_in_menu' => 0,
        'has_archive' => false,
        'menu_icon' => 'dashicons-businessman', // иконка в меню
        'menu_position' => 82, // порядок в меню
        'supports' => array('title')
    );
    register_post_type('victory_post_type', $args);
}
add_action( 'init', 'victory_post_type' );


