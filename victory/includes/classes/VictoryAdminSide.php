<?php

class VictoryAdminSide {
    function __construct()
    {
        //Добавление мтраниц плагина в админку
        add_action( 'admin_menu', array($this,'admin_page_init') );
    }
    public function admin_page_init(){
        add_menu_page( __( 'Victory' ), __( 'Victory' ), 'manage_options', 'victory_main_page', array($this,'get_plugin_page'),  'dashicons-awards', 81);
        add_submenu_page( 'victory_main_page', 'Типы записей', 'Типы записей', 'manage_options', 'post_type_page', array($this,'get_post_type_page'));
        add_submenu_page( 'victory_main_page', 'Таксономии', 'Таксономии', 'manage_options', 'victory_taxonomy_page', array($this,'get_taxonomy_page'));
        add_submenu_page( 'victory_main_page', 'Блоки', 'Блоки', 'manage_options', 'victory_meta_box_page', array($this,'get_meta_box_page'));
    }
    public function get_plugin_page()   {require_once VICTORY_DIR.'/includes/admin/templates/main_setting_page.php';}
    public function get_post_type_page(){require_once VICTORY_DIR.'/includes/admin/templates/post_type_page.php';}
    public function get_taxonomy_page() {require_once VICTORY_DIR.'/includes/admin/templates/taxonomy_page.php';}
    public function get_meta_box_page() {require_once VICTORY_DIR.'/includes/admin/templates/meta_box_page.php';}
}