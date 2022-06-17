<?php

namespace WABVAP;

use WP_REST_Server;
use WP_REST_Request;
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
		register_rest_route($namespace, '/setting/(?P<name>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array($this, 'get_item'),
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

	public function get_data(WP_REST_Request $request)
	{
		$is_refresh = $request->get_params('refresh');

		$transient_key = WABVAP_OPTION_NAME . '_data';
		$data = get_transient($transient_key);

		if ((false === $data) || $is_refresh) {
			$response = wp_remote_get(WABVAP_DATA_URL);

			if ($response['response']['code'] == 200) {
				$data = $response['body'];
				set_transient($transient_key, $data, HOUR_IN_SECONDS);
			}
		}

		return $data;
	}


	public function get_settings()
	{
		return (new Settings())->get();
	}
}
