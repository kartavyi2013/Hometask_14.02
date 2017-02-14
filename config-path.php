<?php


define("HOMETASKSHORTCODE_PlUGIN_DIR", plugin_dir_path(__FILE__));
define("HOMETASKSHORTCODE_PlUGIN_URL", plugin_dir_url( __FILE__ ));
define("HOMETASKSHORTCODE_PlUGIN_SLUG", preg_replace( '/[^\da-zA-Z]/i', '_',  basename(HOMETASKSHORTCODE_PlUGIN_DIR)));
define("HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN", str_replace( '_', '-', HOMETASKSHORTCODE_PlUGIN_SLUG ));
define("HOMETASKSHORTCODE_PlUGIN_OPTION_VERSION", HOMETASKSHORTCODE_PlUGIN_SLUG.'_version');
define("HOMETASKSHORTCODE_PlUGIN_OPTION_NAME", HOMETASKSHORTCODE_PlUGIN_SLUG.'_options');
define("HOMETASKSHORTCODE_PlUGIN_AJAX_URL", admin_url('admin-ajax.php'));

if ( ! function_exists( 'get_plugins' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
$TPOPlUGINs = get_plugin_data(HOMETASKSHORTCODE_PlUGIN_DIR.'/'.basename(HOMETASKSHORTCODE_PlUGIN_DIR).'.php', false, false);

define("HOMETASKSHORTCODE_PlUGIN_VERSION", $TPOPlUGINs['Version']);
define("HOMETASKSHORTCODE_PlUGIN_NAME", $TPOPlUGINs['Name']);

define("HOMETASKSHORTCODE_PlUGIN_DIR_LOCALIZATION", plugin_basename(HOMETASKSHORTCODE_PlUGIN_DIR.'/languages/'));

