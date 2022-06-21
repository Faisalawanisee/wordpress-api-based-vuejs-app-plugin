<?php

namespace WABVAP;

use WP_REST_Server;
use WP_REST_Request;
use WP_Error;
use WABVAP\Settings;

class Endpoints
{

	public function __construct()
	{
		$this->wp_hooks();
	}

	public function wp_hooks()
	{
		add_action('rest_api_init', [$this, 'register_routes']);
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes()
	{
		$namespace = 'wabvap';

		register_rest_route($namespace, '/data', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'get_data'),
				'permission_callback' => array($this, 'permissions_check'),
			),
		));
		register_rest_route($namespace, '/settings/(?P<name>[a-zA-Z0-9-]+)', array(
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array($this, 'get_single_setting'),
				'permission_callback' => array($this, 'permissions_check'),
			),
		));
		register_rest_route($namespace, '/settings', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'get_settings'),
				'permission_callback' => array($this, 'permissions_check'),
			),
		));
	}


	public function permissions_check()
	{
		return current_user_can('manage_options');
	}
	public function permissions_checka()
	{
		return current_user_can('manage_options_');
	}

	public function get_data(WP_REST_Request $request)
	{
		$is_refresh = $request->get_params('refresh');

		return WABVAP_get_data($is_refresh);
	}

	public function get_settings()
	{
		return (new Settings())->get();
	}

	public function get_single_setting(WP_REST_Request $request)
	{
		$name = $request->get_param('name');
		$value = $request->get_param('value');

		$settings = new Settings();
		$settings_get = $settings->get();

		if (in_array($name, ['numrows', 'humandate', 'emails'])) {
			$old_value = $settings_get[$name];
			$value = sanitize_text_field($value);
			switch ($name) {
				case 'numrows':
					$value = (int)$value;
					if ($value <= 5 && $value >= 1) {
					} else {
						return ['success' => false, 'message' => 'Number of Rows should between 1-5.'];
					}
					break;

				case 'humandate':
					if ($value == 'true' || $value == 'false') {
					} else {
						return ['success' => false, 'message' => 'Human Date Only Accept Boolean(true, false) value.'];
					}
					break;

				case 'emails':
					$emails = json_decode($value);
					$output = [];
					foreach ($emails as $email) {
						$output[] = sanitize_email($email);
					}

					$value = ($output);
					break;

				default:
					# code...
					break;
			}

			// print_r($value);
			// die();

			$settings_get[$name] = $value;

			if (
				$settings->set($settings_get) == false &&
				!($value === $old_value || maybe_serialize($value) === maybe_serialize($old_value))
			) {
				return ['success' => false, 'message' => 'Setting not save.'];
			} else {
				return ['success' => true, 'message' => 'Setting save.'];
			}
		}

		return ['success' => false, 'message' => 'Please enter a valid setting name.'];
	}
}
