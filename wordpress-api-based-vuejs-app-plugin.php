<?php

/**
 * Plugin Name:       Wordpress Api Based Vuejs App Plugin
 * Plugin URI:        https://github.com/Faisalawanisee/wordpress-api-based-vuejs-app-plugin
 * Description:       A Wordpress Plugin for create dashboard page based on Vuejs.
 * Version:           1.0.0
 * Author:            Faisal Khalid
 * Author URI:        https://iamfaysal.com
 * License:           None
 * Text Domain:       wordpress-api-based-vuejs-app-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Currently plugin version.
define( 'WORDPRESS_API_BASED_VUEJS_APP_PLUGIN_VERSION', '1.0.0' );
define( 'WABVAP_PATH', plugin_dir_path( __FILE__ ) );
define( 'WABVAP_URL', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_wordpress_api_based_vuejs_app_plugin() {
	require_once WABVAP_PATH . 'includes/class-wordpress-api-based-vuejs-app-plugin-activator.php';
	Wordpress_Api_Based_Vuejs_App_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_wordpress_api_based_vuejs_app_plugin() {
	require_once WABVAP_PATH . 'includes/class-wordpress-api-based-vuejs-app-plugin-deactivator.php';
	Wordpress_Api_Based_Vuejs_App_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wordpress_api_based_vuejs_app_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_wordpress_api_based_vuejs_app_plugin' );
