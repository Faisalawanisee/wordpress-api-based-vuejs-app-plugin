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
if (!defined('WPINC')) die;

if (!defined('WABVAP_VER'))	define('WABVAP_VER', '1.0');

if (!defined('WABVAP_PHP_VER'))	define('WABVAP_PHP_VER', '5.6.20');

if (!defined('WABVAP_PLUGIN_FILE')) define('WABVAP_PLUGIN_FILE', __FILE__);

if (!defined('WABVAP_PATH')) define('WABVAP_PATH', plugin_dir_path(__FILE__));

if (!defined('WABVAP_URL')) define('WABVAP_URL', plugin_dir_url(__FILE__));

if (!defined('WABVAP_OPTION_NAME')) define('WABVAP_OPTION_NAME', "test_project_option");

if (!defined('WABVAP_DEV_MODE')) define('WABVAP_DEV_MODE', "yes");

if (!defined('WABVAP_DATA_URL')) define('WABVAP_DATA_URL', "https://miusage.com/v1/challenge/2/static/");


// Include style.css
add_action('admin_enqueue_scripts', 'WABVAP_setting_up_scripts');
function WABVAP_setting_up_scripts()
{

	$dir = plugin_dir_url(__FILE__);

	wp_enqueue_style(
		'main-style',
		$dir . 'src/assets/style.css',
		array(),
		'1.0'
	);
}

function WABVAP_get_data($force_refresh)
{

	$transient_key = WABVAP_OPTION_NAME . '_data';
	$data = get_transient($transient_key);

	if ((false === $data) || $force_refresh) {
		$response = wp_remote_get(WABVAP_DATA_URL);

		if ($response['response']['code'] == 200) {
			$data = $response['body'];
			set_transient($transient_key, $data, HOUR_IN_SECONDS);
		}
	}

	return $data;
}

function WABVAP_autoloader($class)
{
	list($plugin_space) = explode('\\', $class);
	if ($plugin_space !== 'WABVAP') {
		return;
	}
	$relative_class = substr($class, strlen($plugin_space) + 1);
	include WABVAP_PATH . '/src/class-' . $relative_class . '.php';
}

spl_autoload_register('WABVAP_autoloader');

new WABVAP\Base();
