<?php

namespace WABVAP;

class Page
{

	public function __construct()
	{
		$this->wp_hooks();
	}

	public function wp_hooks()
	{
		add_action('admin_menu', [$this, 'admin_menu']);
	}

	public function admin_menu()
	{
		$capability = 'manage_options';

		$this->hook = add_menu_page(
			esc_html__('WABVAP', 'wordpress-api-based-vuejs-app-plugin'),
			esc_html__('WABVAP', 'wordpress-api-based-vuejs-app-plugin'),
			$capability,
			'WABVAP',
			[$this, 'html'],
			'dashicons-heart'
		);
	}

	public function html()
	{
		echo '<div class="wrap" id="WABVAP-PAGE">a</div>';
	}

	public function enqueue_styles()
	{
	}

	public function enqueue_scripts()
	{
	}
}
