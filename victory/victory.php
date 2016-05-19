<?php
/*
Plugin Name: Victory - my WordPress solution
Description: Проэкт предназначен для автоматизации создания произвольных типов поста, таксономий, дополнительных блоков
Version: 0.0.1.1
Author: Rudenko Maksim
Author URI: https://github.com/rudenko-programmer
Plugin URI: https://github.com/rudenko-programmer/victory
*/
?>
<?php
/**
 * Инициализация основных глобальных констант
 */
define('VICTORY_DIR', plugin_dir_path(__FILE__));
define('VICTORY_URL', plugin_dir_url(__FILE__));
define('WP_POST_REVISIONS', false);
/**
 * Инициализация основных стилей и скриптов
 */
function victory_load_style(){ wp_enqueue_style( 'victory_style', VICTORY_URL.'/assets/css/style.css' );}
function victory_load_script() {
    if ( ! did_action( 'wp_enqueue_media' ) ){ wp_enqueue_media(); }
    wp_enqueue_script( 'victory_script', VICTORY_URL.'/assets/js/script.js', array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'victory_load_style' );
add_action( 'admin_enqueue_scripts', 'victory_load_script' );

/**
 * Инициализация файлов директории INCLUDES
 */
//require VICTORY_DIR.'/includes/includes.php';

require_once VICTORY_DIR.'/includes/classes/VictoryAdminSide.php';
require_once VICTORY_DIR.'/includes/classes/CustomPostTypeInit.php';
require_once VICTORY_DIR.'/includes/classes/CustomBlockInit.php';
require_once VICTORY_DIR.'/includes/VictoryFunction.php';

$GLOBALS['VICTORY_ADMIN_SIDE']       = new VictoryAdminSide();
$GLOBALS['VICTORY_CUSTOM_POST_TYPE'] = new CustomPostTypeInit();
$GLOBALS['VICTORY_META_BOX_TYPE']    = new CustomBlockInit();
