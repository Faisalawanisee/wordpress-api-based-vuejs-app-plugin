<?php

namespace WABVAP;


class Page
{

	public function __construct()
	{
		if (is_admin()) {
			$this->wp_hooks();
		}
	}

	public function wp_hooks()
	{
		add_action('admin_menu', [$this, 'admin_menu']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
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
		echo '<div class="wrap" id="WABVAP-PAGE"></div>';
	}

	public function enqueue_scripts()
	{

		wp_enqueue_script(
			'wabvap_script',
			WABVAP_URL . '/src/assets/bundle.js',
			array(),
			WABVAP_DEV_MODE ? time() : WABVAP_VER,
			true
		);

		wp_enqueue_style(
			'main-style',
			WABVAP_URL . '/src/assets/style.css',
			array(),
			WABVAP_DEV_MODE ? time() : WABVAP_VER,
		);

		$i18n_data = [
			'page_title_settings' => __('Settings', 'wordpress-api-based-vuejs-app-plugin'),
			'page_title_table' => __('Table', 'wordpress-api-based-vuejs-app-plugin'),
			'page_title_graph' => __('Graph', 'wordpress-api-based-vuejs-app-plugin'),
			'num_of_rows' => __('Number of Rows', 'wordpress-api-based-vuejs-app-plugin'),
			'human_date' => __('Human date', 'wordpress-api-based-vuejs-app-plugin'),
			'emails' => __('Emails', 'wordpress-api-based-vuejs-app-plugin'),
			'add_valid_email_address' => __('Please Add Valid Email Address.', 'wordpress-api-based-vuejs-app-plugin'),
			'human_date_accept_boolean' => __('Human Date Only Accept Boolean(true, false) value.', 'wordpress-api-based-vuejs-app-plugin'),
			'server_error' => __('Internal Server Error.', 'wordpress-api-based-vuejs-app-plugin'),
			'refresh_data' => __('Refresh Data', 'wordpress-api-based-vuejs-app-plugin'),
			'emails_list' => __('Emails List', 'wordpress-api-based-vuejs-app-plugin'),
		];

		wp_localize_script(
			'wabvap_script',
			'wabvap_vue',
			[
				'nonce' => wp_create_nonce('wp_rest'),
				'endpoints' => [
					'data_url' => home_url('wp-json/wabvap/data'),
					'setting_url' => home_url('wp-json/wabvap/settings'),
				],
				'i18n_data' => $i18n_data
			]
		);
	}
}
