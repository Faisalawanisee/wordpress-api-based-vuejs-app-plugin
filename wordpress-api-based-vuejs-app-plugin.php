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

if (!defined('WABVAP_OPTION_NAME')) define('WABVAP_OPTION_NAME', "test_project_option");


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




function json_basic_auth_handler($user)
{
	global $wp_json_basic_auth_error;

	$wp_json_basic_auth_error = null;

	// Don't authenticate twice
	if (!empty($user)) {
		return $user;
	}

	// Check that we're trying to authenticate
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		return $user;
	}

	print_r($_SERVER);
	die();

	$username = $_SERVER['PHP_AUTH_USER'];
	$password = $_SERVER['PHP_AUTH_PW'];

	/**
	 * In multi-site, wp_authenticate_spam_check filter is run on authentication. This filter calls
	 * get_currentuserinfo which in turn calls the determine_current_user filter. This leads to infinite
	 * recursion and a stack overflow unless the current function is removed from the determine_current_user
	 * filter during authentication.
	 */
	remove_filter('determine_current_user', 'json_basic_auth_handler', 20);

	$user = wp_authenticate($username, $password);

	add_filter('determine_current_user', 'json_basic_auth_handler', 20);

	if (is_wp_error($user)) {
		$wp_json_basic_auth_error = $user;
		return null;
	}

	$wp_json_basic_auth_error = true;

	return $user->ID;
}
add_filter('determine_current_user', 'json_basic_auth_handler', 20);

function json_basic_auth_error($error)
{
	// Passthrough other errors
	if (!empty($error)) {
		return $error;
	}

	global $wp_json_basic_auth_error;

	return $wp_json_basic_auth_error;
}
add_filter('rest_authentication_errors', 'json_basic_auth_error');

new WABVAP\Base();
