<?php

namespace WABVAP;

use WP_REST_Server;
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
				// 'permission_callback' => array($this, 'permissions_check'),
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
				'callback'            => array($this, 'get_items'),
				'permission_callback' => array($this, 'permissions_check'),
			),
		));
	}


	public function permissions_check()
	{
		// return current_user_can('manage_options');
	}

	public function get_data()
	{
		return wp_get_current_user();
		// (new Settings())->get();
	}
}
